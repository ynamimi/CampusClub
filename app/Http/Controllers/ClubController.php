<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Activity;
use App\Models\Registration;
use App\Models\ActivityRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ClubController extends Controller
{
    // Show club details
    public function show($id)
    {
        $club = Club::with(['activities', 'registrations', 'performanceMetrics'])->findOrFail($id);

        // Calculate points if performance metrics don't exist
        if (!$club->performanceMetrics) {
            $pastEventsCount = $club->activities()->where('event_date', '<', now())->count();
            $totalPoints = $pastEventsCount * 100;

            PerformanceMetric::create([
                'club_id' => $club->id,
                'total_points' => $totalPoints,
                'completed_percentage' => 0,
                'remaining_percentage' => 100
            ]);

            // Refresh the club instance
            $club->load('performanceMetrics');
        }

        return view('club.show', compact('club'));
    }

    // Show registration form
    public function showRegisterForm($id)
    {
        $club = Club::findOrFail($id);
        $user = auth()->user();

        $latest = Registration::where('student_id', $user->student_id)
                            ->orderByDesc('created_at')
                            ->first();

        return view('club.register', compact('club', 'user', 'latest'));
    }

    // Handle registration form submission
    public function register(Request $request, $id)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'student_id' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'semester' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'phone' => 'required|string|max:15',
        ]);

        // Save to registrations
        Registration::create([
            'club_id' => $id,
            'user_id' => auth()->id(),
            'fullname' => $request->fullname,
            'student_id' => $request->student_id,
            'course' => $request->course,
            'semester' => $request->semester,
            'gender' => $request->gender,
            'phone' => $request->phone,
        ]);

        return redirect()->route('club.show', $id)->with('success', 'Registration successful!');
    }

    // Display list of members registered for a specific club (For President)
    public function showMembers(Request $request, $id)
    {
        // Fetch the club using the club ID
        $club = Club::findOrFail($id);  // Ensure that we are fetching the correct club

        // Get the search query from the request (if any)
        $search = $request->get('search');

        // Fetch the members who are associated with the specific club_id
        $members = $club->registrations()
                        ->where(function ($query) use ($search) {
                            // Search by fullname or email if provided
                            $query->where('fullname', 'like', "%{$search}%")
                                  ->orWhere('email', 'like', "%{$search}%");
                        })
                        ->get();  // Get the members for this specific club

        return view('president.memberships', compact('club', 'members'));  // Return the view with club and members data
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'acronym' => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'org_chart' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
            'president_id' => 'required|exists:presidents,id',
            'president_student_id' => 'required|string',
            'president_course' => 'required|string',
            'president_semester' => 'required|integer|min:1|max:10',
        ]);

        if ($request->hasFile('club_image')) {
            $imagePath = $request->file('club_image')->store('club_images', 'public');
            $club->image = $imagePath;
        }
        if ($request->hasFile('org_chart')) {
            $chartPath = $request->file('org_chart')->store('org_charts', 'public');
            $club->org_chart = $chartPath;
        }
        $club->save();

        // Create the club
        $club = Club::create($validated);
        // Assign president to club
        $president = President::find($validated['president_id']);
        $president->update([
            'club_id' => $club->id,'is_active' => true
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Club created successfully!');
    }

     // Show event details under the club context
    public function showEvent($activityId)
    {
        // Fetch the activity by ID
        $activity = Activity::findOrFail($activityId);

        // Get the club associated with this activity
        $club = $activity->club; // Assuming you have a relationship between Activity and Club

        // Return the view to display the event details and pass the club and activity
        return view('club.events.show', compact('activity', 'club'));
    }

    // Club category view
    public function category($type)
    {
        $clubs = Club::where('type', $type)->get();
        return view('student.category', compact('clubs', 'type'));
    }

    // Navigate back to top
    public function backToTop()
    {
        return redirect()->route('club.category');
    }

     public function showActivity($clubId, $activityId)
    {
        $club = Club::findOrFail($clubId);
        $activity = Activity::findOrFail($activityId);

        $isRegistered = false;
        if (Auth::check()) {
            $isRegistered = ActivityRegistration::where('activity_id', $activityId)
                ->where('user_id', Auth::id())
                ->exists();
        }

        return view('activities.show', [
            'club' => $club,
            'activity' => $activity,
            'isRegistered' => $isRegistered
        ]);
    }

    public function joinActivity(Request $request, $clubId, $activityId)
    {
        try {
            $user = Auth::user();
            $activity = Activity::findOrFail($activityId);

            if (ActivityRegistration::where('activity_id', $activityId)
                ->where('user_id', $user->id)
                ->exists()) {
                return back()->with('error', 'You already joined this event');
            }

            ActivityRegistration::create([
                'activity_id' => $activityId,
                'user_id' => $user->id,
                'joined_at' => now()
            ]);

            return back()->with('success', 'Successfully joined the event!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to join event');
        }
    }

    public function unjoinActivity(Request $request, $clubId, $activityId) // Updated parameters
    {
        try {
            // Find the ActivityRegistration record for the authenticated user and the specific activity
            $registration = ActivityRegistration::where('activity_id', $activityId)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $registration->delete();

            return back()->with('success', 'You have left the event');

        } catch (\Exception $e) {
            Log::error("Error unjoining activity {$activityId} for user " . Auth::id() . ": " . $e->getMessage());
            return back()->with('error', 'Failed to leave event. ' . $e->getMessage()); // Added error message for debugging
        }
    }
}
