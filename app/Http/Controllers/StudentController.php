<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\User;
use App\Models\Registration;
use App\Models\ActivityRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function home()
    {
        $user = auth()->user();
        $clubs = Club::all();
        return view('student.home', compact('clubs'));
    }

    public function profile()
    {
        $user = auth()->user(); // The authenticated User model

        // Attempt to find the latest registration record for this user.
        // This will be used to pre-fill student_id, course, semester, phone, and gender.
        $latestRegistration = Registration::where('user_id', $user->id)
                                          ->orderByDesc('created_at')
                                          ->first();

        // Pass both the user and the latest registration (if found) to the view
        return view('student.profile', compact('user', 'latestRegistration'));
    }

    public function updateProfile(Request $request)
{
    $user = auth()->user();

    // Validate only the editable fields
    $validatedData = $request->validate([
        'student_id' => 'nullable|string|max:20',
        'course' => 'nullable|string|max:100',
        'semester' => 'nullable|integer|min:1|max:10',
        'phone' => 'nullable|string|max:15',
        'gender' => 'nullable|in:male,female'
    ]);

    DB::beginTransaction();
    try {
        // 1. Update the user's profile in students table
        $user->update($validatedData);

        // 2. Update ALL related registration records
        if ($user->registrations()->exists()) {
            $user->registrations()->update([
                'student_id' => $validatedData['student_id'],
                'course' => $validatedData['course'],
                'semester' => $validatedData['semester'],
                'phone' => $validatedData['phone'],
                'gender' => $validatedData['gender'],
                'fullname' => $user->name // Keep synchronized with user's name
            ]);
        }

        DB::commit();
        return redirect()->back()->with('success', 'Profile and registration records updated successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error("Profile update failed for user {$user->id}: " . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to update profile. Please try again.');
    }
}

    public function showProfile()
    {
        $user = auth()->user(); // Get the logged-in user
        // Attempt to find the latest registration record for this user.
        // This will be used to pre-fill student_id, course, semester, phone, and gender.
        $latestRegistration = Registration::where('student_id', $user->id)
                                  ->orderByDesc('created_at')
                                  ->first();
        return view('student.profile', compact('user', 'latestRegistration')); // Pass both user and latestRegistration
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = auth()->user();

        // Delete old image if exists
        if ($user->profile_picture) {
            Storage::delete('public/'.$user->profile_picture);
        }

        // Store new image
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        $user->profile_picture = $path;
        $user->save();

        return back()->with('success', 'Profile picture updated successfully!');
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

    public function clubs()
    {
        $user = auth()->user();
        $clubs = $user->clubs; // Assuming you have a clubs relationship

        // Get all activities the student has joined
        $activities = ActivityRegistration::with('activity.club')
            ->where('user_id', $user->id)
            ->get()
            ->groupBy('activity.club.name');

        return view('student.club', compact('clubs', 'activities'));
    }
}
