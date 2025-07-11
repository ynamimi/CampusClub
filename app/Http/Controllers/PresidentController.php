<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Activity;
use App\Models\Registration;
use App\Models\President;
use App\Models\PerformanceMetric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PresidentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:president');
    }

    public function index(Request $request, $club_id)
    {
        $president = Auth::guard('president')->user();
        $club = Club::find($club_id);
        $club = Club::with('president')->findOrFail($club_id);

        if (!$club || $president->id !== $club->president_id) {
            abort(403, 'Unauthorized action or Club not found.');
        }

        $performanceMetrics = PerformanceMetric::firstOrCreate(
            ['club_id' => $club->id],
            [
                'total_points' => 0,
                'completed_percentage' => 0,
                'remaining_percentage' => 100,
            ]
        );

        $pastEventsCount = $club->activities()->where('event_date', '<', now())->count();
        $totalPoints = $pastEventsCount * 100;
        $targetPoints = ($club->target_points && $club->target_points > 0) ? $club->target_points : 1;
        $completed = ($totalPoints / $targetPoints) * 100;
        $remaining = 100 - $completed;

        $femaleCount = Registration::where('club_id', $club->id)
                                 ->where('gender', 'female')
                                 ->count();

        $maleCount = Registration::where('club_id', $club->id)
                                 ->where('gender', 'male')
                                 ->count();

        $membersCount = $femaleCount + $maleCount;

        return view('president.dashboard', [
            'club' => $club,
            'completed' => round($completed, 2),
            'remaining' => round($remaining, 2),
            'totalPoints' => (int)$totalPoints,
            'membersCount' => (int)$membersCount,
            'targetPoints' => (int)$targetPoints,
            'pastEventsCount' => (int)$pastEventsCount,
            'femaleCount' => (int)$femaleCount,
            'maleCount' => (int)$maleCount,
            'club_id' => $club->id,
            'performanceMetrics' => $performanceMetrics,
        ]);
    }

    public function setTarget(Request $request, Club $club)
    {
        $request->validate([
            'targetPoints' => 'required|numeric|min:0'
        ]);

        $club->target_points = $request->targetPoints;
        $club->save();

        return redirect()->back()->with('success', 'Target points updated successfully!');
    }

    public function updateDetails()
    {
        // Get the currently authenticated president
        $president = Auth::guard('president')->user();

        // Fetch the club that the president manages
        $club = Club::where('president_id', $president->id)->firstOrFail();

        // Pass both the president and club to the view
        return view('president.updateDetails', [
            'president' => $president,
            'club' => $club
        ]);
    }

    public function updateDetailsSubmit(Request $request)
    {
        // Get the authenticated president first
        $president = Auth::guard('president')->user();

        $president = $club->president;

        // Validate the request data
        $validatedData = $request->validate([
            // Club fields
            'club_name' => 'required|string|max:255',
            'club_acronym' => 'nullable|string|max:255',
            'club_description' => 'required|string',
            'club_type' => 'required|in:public,faculty',
            'contact_email' => 'nullable|email|max:255',
            'advisor_name' => 'required|string|max:255',
            'instagram_link' => 'nullable|url|max:255',
            'tiktok_link' => 'nullable|url|max:255',
            'x_link' => 'nullable|url|max:255',
            'club_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'org_chart' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);

        // Get the club associated with this president
        $club = Club::where('president_id', $president->id)->firstOrFail();

        // Update club details
        $club->update([
            'name' => $validatedData['club_name'],
            'acronym' => $validatedData['club_acronym'],
            'description' => $validatedData['club_description'],
            'type' => $validatedData['club_type'],
            'email' => $validatedData['contact_email'],
            'advisor_name' => $validatedData['advisor_name'],
            'instagram_link' => $validatedData['instagram_link'],
            'tiktok_link' => $validatedData['tiktok_link'],
            'x_link' => $validatedData['x_link'],
        ]);

        // Handle club image upload
        if ($request->hasFile('club_image')) {
            if ($club->image && Storage::exists($club->image)) {
                Storage::delete($club->image);
            }
            $club->image = $request->file('club_image')->store('public/club_images');
            $club->save();
        }

        // Handle org chart upload
        if ($request->hasFile('org_chart')) {
            if ($club->org_chart && Storage::exists($club->org_chart)) {
                Storage::delete($club->org_chart);
            }
            $club->org_chart = $request->file('org_chart')->store('public/org_charts');
            $club->save();
        }

        return redirect()->route('president.updateDetails')->with('success', 'Details updated successfully!');
    }

    public function activities()
    {
        $president = Auth::guard('president')->user();
        $club = Club::where('president_id', $president->id)->firstOrFail();

        $upcomingActivities = $club->activities()
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->get();

        $pastActivities = $club->activities()
            ->where('event_date', '<', now())
            ->orderBy('event_date', 'desc')
            ->get();

        return view('president.activities', compact('club', 'upcomingActivities', 'pastActivities'));
    }

    public function memberships($id, Request $request)
    {
        $president = Auth::guard('president')->user();
        $club = Club::where('president_id', $president->id)->firstOrFail();

        if ($club->id != $id) {
            abort(403, 'Unauthorized action.');
        }

        $query = Registration::where('club_id', $club->id);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('fullname', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('student_id', 'like', '%' . $search . '%');
            });
        }

        $members = $query->get();

        return view('president.memberships', compact('members', 'club'));
    }

    public function editMember($member_id)
    {
        $member = Registration::findOrFail($member_id);
        $president = Auth::guard('president')->user();
        $club = Club::where('president_id', $president->id)->firstOrFail();
        if ($member->club_id !== $club->id) {
            abort(403, 'Unauthorized action.');
        }
        return view('president.editMember', compact('member'));
    }

    public function updateMember(Request $request, $member_id)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'student_id' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'semester' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'gender' => 'required|in:male,female',
        ]);

        $member = Registration::findOrFail($member_id);
        $president = Auth::guard('president')->user();
        $club = Club::where('president_id', $president->id)->firstOrFail();
        if ($member->club_id !== $club->id) {
            abort(403, 'Unauthorized action.');
        }

        $member->update($validated);

        return redirect()->route('president.memberships', $member->club_id)
            ->with('success', 'Member updated successfully');
    }

    public function removeMember($member_id)
    {
        $member = Registration::findOrFail($member_id);
        $president = Auth::guard('president')->user();
        $club = Club::where('president_id', $president->id)->firstOrFail();
        if ($member->club_id !== $club->id) {
            abort(403, 'Unauthorized action.');
        }

        $club_id = $member->club_id;
        $member->delete();

        return redirect()->route('president.memberships', $club_id)
            ->with('success', 'Member removed successfully');
    }

    public function createActivity($club_id)
    {
        $president = Auth::guard('president')->user();
        $club = Club::where('president_id', $president->id)->firstOrFail();
        if ($club->id != $club_id) {
            abort(403, 'Unauthorized action.');
        }
        return view('president.create-activity', compact('club'));
    }

    public function storeActivity(Request $request, $club_id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'objectives' => 'required|string',
            'activities' => 'required|string',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'venue' => 'required|string|max:255',
        ]);

        $president = Auth::guard('president')->user();
        $club = Club::where('president_id', $president->id)->firstOrFail();
        if ($club->id != $club_id) {
            abort(403, 'Unauthorized action.');
        }

        $activityData = $request->except('poster');
        $activityData['club_id'] = $club_id;
        $activityData['venue'] = $request->venue;

        if ($request->hasFile('poster')) {
            $activityData['poster'] = $request->file('poster')->store('posters', 'public');
        }

        Activity::create($activityData);

        return redirect()->route('president.activities', $club_id)
            ->with('success', 'Activity created successfully!');
    }

    public function updateEventDetails($activity_id)
    {
        $activity = Activity::findOrFail($activity_id);
        $president = Auth::guard('president')->user();
        $club = Club::where('president_id', $president->id)->firstOrFail();
        if ($activity->club_id !== $club->id) {
            abort(403, 'Unauthorized action.');
        }
        return view('president.update-activity', compact('activity'));
    }

    public function storeUpdatedActivity(Request $request, $activity_id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'objectives' => 'required|string',
            'activities' => 'required|string',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'venue' => 'required|string|max:255',
        ]);

        $activity = Activity::findOrFail($activity_id);
        $president = Auth::guard('president')->user();
        $club = Club::where('president_id', $president->id)->firstOrFail();
        if ($activity->club_id !== $club->id) {
            abort(403, 'Unauthorized action.');
        }

        $updateData = $request->except('poster');
        $updateData['venue'] = $request->venue;

        if ($request->hasFile('poster')) {
            if ($activity->poster && Storage::exists('public/' . $activity->poster)) {
                Storage::delete('public/' . $activity->poster);
            }
            $updateData['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $activity->update($updateData);

        return redirect()->route('president.activities', $activity->club_id)
            ->with('success', 'Activity updated successfully!');
    }

    public function destroyActivity($club_id, $activity_id)
    {
        $activity = Activity::findOrFail($activity_id);
        $president = Auth::guard('president')->user();
        $club = Club::where('president_id', $president->id)->firstOrFail();
        if ($activity->club_id !== $club->id) {
            abort(403, 'Unauthorized action.');
        }

        if ($activity->poster && Storage::exists('public/' . $activity->poster)) {
            Storage::delete('public/' . $activity->poster);
        }

        $activity->delete();

        return redirect()->route('president.activities', $club_id)
            ->with('success', 'Activity deleted successfully!');
    }

    public function showProfile()
    {
        $presidentId = Auth::guard('president')->id();
        $user = President::with('club')->find($presidentId);

        if (!$user) {
            abort(404, 'President profile not found.');
        }

        $club = $user->club;

        return view('president.profile', compact('user', 'club'));
    }

    public function updateProfile(Request $request)
{
    $president = Auth::guard('president')->user();
    $club = Club::where('president_id', $president->id)->first();

    // Validate president data
    $presidentData = $request->validate([
        'name' => 'required|string|max:255',
        'president_student_id' => [
            'required',
            'string',
            'max:255',
            Rule::unique('presidents')->ignore($president->id)
        ],
        'president_course' => 'required|string|max:255',
        'president_semester' => 'required|integer|min:1|max:10',
        'contact_phone' => 'nullable|string|max:15',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Update president info
    $president->update([
        'name' => $presidentData['name'],
        'president_student_id' => $presidentData['president_student_id'],
        'president_course' => $presidentData['president_course'],
        'president_semester' => $presidentData['president_semester'],
        'contact_phone' => $presidentData['contact_phone'],
    ]);

    // Handle profile picture
    if ($request->hasFile('profile_picture')) {
        if ($president->profile_picture) {
            Storage::delete($president->profile_picture);
        }
        $president->profile_picture = $request->file('profile_picture')->store('profile_pictures', 'public');
        $president->save();
    }

    // Only update club if it exists
    if ($club) {
        $clubData = $request->validate([
            'club_name' => 'required|string|max:255',
            'advisor_name' => 'required|string|max:255',
            'club_email' => 'nullable|email|max:255',
        ]);

        $club->update([
            'name' => $clubData['club_name'],
            'advisor_name' => $clubData['advisor_name'],
            'email' => $clubData['club_email'],
        ]);
    }

        return back()->with('success', 'Profile updated successfully!');
    }

    public function generatePDF($activityId)
    {
        $activity = Activity::with(['registrations', 'club.president'])->findOrFail($activityId);
        $club = $activity->club;

        $presidentUser = Auth::guard('president')->user();
        $presidentsClub = Club::where('president_id', $presidentUser->id)->firstOrFail();
        if ($activity->club_id !== $presidentsClub->id) {
            abort(403, 'Unauthorized action.');
        }

        $presidentFullName = $club->president->name ?? 'Club President';

        $pdf = PDF::loadView('president.reportPDF', [
            'activity' => $activity,
            'club' => $club,
            'presidentFullName' => $presidentFullName,
        ]);

        return $pdf->download("{$club->name}_report_{$activity->id}.pdf");
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password changed successfully');
    }
}
