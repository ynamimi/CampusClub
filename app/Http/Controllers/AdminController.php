<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Admin;
use App\Models\User;
use App\Models\Registration;
use App\Models\President; // <-- Import the President model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Keep for Admin password hashing
use Illuminate\Support\Facades\Storage; // For deleting old files if needed

class AdminController extends Controller
{
    public function dashboard(Request $request) // Add Request $request for search
    {
        $search = $request->query('search'); // Get search term

        $clubsQuery = Club::query(); // Start query

        if ($search) {
            $clubsQuery->where('name', 'like', '%' . $search . '%');
        }

        // Change 'members' to 'registrations' to count actual registrations
        $clubs = $clubsQuery->withCount('registrations') // <--- CHANGED HERE
                           ->latest()
                           ->paginate(12);

        return view('admin.dashboard', compact('clubs'));
    }

    public function manageAdmins()
    {
        $admins = Admin::all(); // Get all admins
        return view('admin.manage_admins', compact('admins'));
    }

    public function editAdmin($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.edit_admin', compact('admin'));
    }

    public function updateAdmin(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $id,
            'role' => 'required|in:admin,super_admin',
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.manageAdmins')->with('success', 'Admin updated successfully.');
    }

    public function deleteAdmin($id)
    {
        $admin = Admin::findOrFail($id);

        // Optional: Prevent deleting yourself
        if (auth()->id() === $admin->id) {
            return redirect()->back()->with('error', "You can't delete your own account.");
        }

        $admin->delete();

        return redirect()->route('admin.manageAdmins')->with('success', 'Admin deleted successfully.');
    }

    public function createClub()
    {
        return view('admin.create-club');
    }

    public function storeClub(Request $request)
{
    // Define validation rules based on your form's mandatory/optional fields
    $validatedData = $request->validate([
        'name' => 'required|string|max:255|unique:clubs,name', // Club Name
        'acronym' => 'nullable|string|max:10', // Club Acronym (Optional)
        'description' => 'nullable|string', // Club Description (Optional)
        'type' => 'required|in:public,faculty', // Club Type (Mandatory)
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Club Logo (Optional)
        'org_chart' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:10240', // Org Chart (Optional)
        'advisor_name' => 'required|string|max:255', // Advisor Name (Mandatory)
        'email' => 'required|string|email|max:255|unique:clubs,email',
        'password' => 'required|string|min:8|confirmed',

        // President's Information (Initial Account) - UPDATED VALIDATION
        'president_name' => 'required|string|max:255',
        'president_student_id' => 'required|string|max:255|unique:presidents,president_student_id',
        'president_course' => 'required|string|max:255',
        'president_semester' => 'required|string|max:255',
        'contact_phone' => 'nullable|string|max:20',
        // President Password

        // Contact & Social Media Links (Optional)
        'instagram_link' => 'nullable|url|max:255',
        'x_link' => 'nullable|url|max:255',
        'tiktok_link' => 'nullable|url|max:255',
    ]);

    // Handle file uploads
    $logoPath = null;
    if ($request->hasFile('logo')) {
        $logoPath = $request->file('logo')->store('club_images', 'public');
    }

    $orgChartPath = null;
    if ($request->hasFile('org_chart')) {
        $orgChartPath = $request->file('org_chart')->store('org_charts', 'public');
    }

    // Ensure president's student ID is unique before creating
    $existingPresident = President::where('president_student_id', $validatedData['president_student_id'])->first();
if ($existingPresident) {
    return back()->withErrors(['president_student_id' => 'This student ID is already assigned to a president.']);
}

    // Create the President entry first
    $president = President::create([
        'name' => $validatedData['president_name'],
        'president_student_id' => $validatedData['president_student_id'],
        'president_course' => $validatedData['president_course'],
        'president_semester' => $validatedData['president_semester'],
        'contact_phone' => $validatedData['contact_phone'],
    ]);

    // Create the Club record
    $club = Club::create([
        'president_id' => $president->id,
        'name' => $validatedData['name'],
        'acronym' => $validatedData['acronym'],
        'description' => $validatedData['description'],
        'type' => $validatedData['type'],
        'image' => $logoPath, // Stored path
        'org_chart' => $orgChartPath, // Stored path
        'advisor_name' => $validatedData['advisor_name'],
        'email' => $validatedData['email'], // President's login email (Club's email)
        'password' => Hash::make($validatedData['password']), // Hash password for the president
        'target_points' => 0, // Default value, adjust as per your logic/migration
        'instagram_link' => $validatedData['instagram_link'],
        'x_link' => $validatedData['x_link'],
        'tiktok_link' => $validatedData['tiktok_link'],
    ]);

    return redirect()->route('admin.dashboard')->with('success', 'Club ' . $club->name . ' created successfully!');
}

    public function clubMembers(Club $club)
    {
        // This method confirms that members are indeed Registration records
        $members = Registration::where('club_id', $club->id)
            ->with('student') // eager load the user (student)
            ->latest()
            ->paginate(20);

        return view('admin.club-members', compact('club', 'members'));
    }


    public function createAdmin()
    {
        return view('admin.create-admin');
    }

    public function storeAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:super_admin,admin'
        ]);

        Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role']
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Admin created successfully!');
    }

    public function showProfile()
    {
        $admin = auth()->guard('admin')->user();
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = auth()->guard('admin')->user();

        // Corrected validation for updateProfile
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id, // unique:table,column,except_id
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Corrected validation rule
            // Assuming 'advisor_name' is not a direct field on the Admin model itself based on your schema
            // If it IS on the Admin model, you would validate it like:
            // 'advisor_name' => 'nullable|string|max:255', // Or 'required' if mandatory for Admin profile
        ]);

        // Handle profile picture update
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if it exists
            if ($admin->profile_picture) {
                Storage::disk('public')->delete($admin->profile_picture);
            }
            $validated['profile_picture'] = $request->file('profile_picture')->store('admin-profile', 'public');
        }

        $admin->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $admin = auth()->guard('admin')->user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $admin->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password changed successfully!');
    }
}
