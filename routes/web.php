<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PresidentController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;

// Default route
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Registration
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Student Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

    // President Login
    Route::get('president/login', [LoginController::class, 'showPresidentLogin'])->name('president.login');
    Route::post('president/login', [LoginController::class, 'presidentLogin'])->name('president.login.submit');

    // Admin Login
    Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});

// Logout (accessible to all authenticated users)
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth:web,president,admin');

// Admin Routes
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function() {
    // Dashboard
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Club Management
    Route::get('create-club', [AdminController::class, 'createClub'])->name('createClub');
    Route::post('store-club', [AdminController::class, 'storeClub'])->name('storeClub');
    Route::get('clubs/{club}/members', [AdminController::class, 'clubMembers'])->name('clubMembers');

    // Admin Management (using your preferred naming)
    Route::get('/admins', [AdminController::class, 'manageAdmins'])->name('manageAdmins');
    Route::get('create-admin', [AdminController::class, 'createAdmin'])->name('createAdmin');
    Route::post('store-admin', [AdminController::class, 'storeAdmin'])->name('storeAdmin');
    Route::get('/admins/{id}/edit', [AdminController::class, 'editAdmin'])->name('editAdmin');
    Route::put('/admins/{id}', [AdminController::class, 'updateAdmin'])->name('updateAdmin');
    Route::delete('/admins/{id}', [AdminController::class, 'deleteAdmin'])->name('deleteAdmin');

    Route::get('/profile', [AdminController::class, 'showProfile'])->name('profile');
    Route::post('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/change-password', [AdminController::class, 'changePassword'])->name('changePassword');
});

// Student Routes
Route::middleware(['auth:web'])->prefix('student')->name('student.')->group(function () {
    Route::get('/home', [StudentController::class, 'home'])->name('home');
    Route::get('/profile', [StudentController::class, 'showProfile'])->name('profile');
    Route::put('/profile/update', [StudentController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/image', [StudentController::class, 'updateImage'])->name('profile.image');
    Route::post('/profile/change-password', [StudentController::class, 'changePassword'])->name('changePassword');
    Route::get('/clubs', [StudentController::class, 'clubs'])->name('clubs');
    Route::get('create-admin', [AdminController::class, 'createAdmin'])->name('createAdmin'); // This looks like a copy-paste error for student routes
    Route::post('store-admin', [AdminController::class, 'storeAdmin'])->name('storeAdmin'); // This looks like a copy-paste error for student routes
});

// President Routes
Route::middleware(['auth:president'])->prefix('president')->name('president.')->group(function () {
    Route::get('/dashboard/{club_id}', [PresidentController::class, 'index'])->name('dashboard');
    Route::get('/profile', [PresidentController::class, 'showProfile'])->name('profile');
    Route::get('/profile/edit', [PresidentController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [PresidentController::class, 'updateProfile'])->name('profile.update');

    Route::post('/profile/change-password', [PresidentController::class, 'changePassword'])->name('changePassword');

    // Club Management
    Route::get('/update-details', [PresidentController::class, 'updateDetails'])->name('updateDetails');
    Route::post('/update-details', [PresidentController::class, 'updateDetailsSubmit'])->name('updateDetails.submit');


    // Members Management
    Route::get('/memberships/{id}', [PresidentController::class, 'memberships'])->name('memberships');
    Route::get('/memberships/edit/{member_id}', [PresidentController::class, 'editMember'])->name('editMember');
    Route::put('/memberships/update/{member_id}', [PresidentController::class, 'updateMember'])->name('updateMember');
    Route::delete('/remove-member/{member_id}', [PresidentController::class, 'removeMember'])->name('removeMember');

    // Activities Management
    Route::get('/activities', [PresidentController::class, 'activities'])->name('activities');
    Route::get('/activities/{id}', [PresidentController::class, 'fetchEventDetails']);
    Route::get('/{club_id}/activities/create', [PresidentController::class, 'createActivity'])->name('createActivity');
    Route::post('/{club_id}/activities', [PresidentController::class, 'storeActivity'])->name('storeActivity');
    Route::get('activities/{activity_id}/update', [PresidentController::class, 'updateEventDetails'])->name('activities.update');
    Route::post('activities/{activity_id}/update', [PresidentController::class, 'storeUpdatedActivity'])->name('activities.storeUpdate');
    Route::delete('/{club_id}/activities/{activity_id}', [PresidentController::class, 'destroyActivity'])->name('destroyActivity');

    // Targets and PDFs
    Route::post('/{club}/set-target', [PresidentController::class, 'setTarget'])->name('setTarget');
    Route::get('/generate-pdf/{activityId}', [PresidentController::class, 'generatePDF'])->name('generatePDF');
});

// Public Club Routes
Route::controller(ClubController::class)->group(function () {
    Route::get('/club/{id}', 'show')->name('club.show');
    Route::get('/club/{id}/register', 'showRegisterForm')->name('club.register');
    Route::post('/club/{id}/register', 'register')->name('club.register.submit');
    Route::get('/clubs/category/{type}', 'category')->name('clubs.category');
    Route::get('club/events/{activity}', 'showEvent')->name('club.events.show');
    Route::get('/clubs/{club}/activities/{activity}', 'showActivity')->name('club.activity.show');
    Route::post('/clubs/{club}/activities/{activity}/join', 'joinActivity')
        ->middleware('auth:web')
        ->name('club.activity.join');
    Route::delete('/clubs/{clubId}/activities/{activityId}/unjoin', 'unjoinActivity')
        ->middleware('auth:web')
        ->name('club.activity.unjoin');
    Route::get('/back-to-top', 'backToTop')->name('club.backToTop');
});

// Fallback home route
Route::get('/home', [HomeController::class, 'index'])->name('home');
