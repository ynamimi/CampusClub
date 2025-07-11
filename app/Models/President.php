<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Ensure HasFactory is used
use Illuminate\Support\Facades\Storage;

class President extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'presidents'; // Assuming your presidents are in a 'presidents' table

    protected $fillable = [
        'name',
        'president_student_id',     // Must match database column
        'president_course',         // Must match database column
        'president_semester',       // Must match database column
        'contact_phone',
        'club_id',
        'is_active',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'president_semester' => 'integer', // <--- IMPORTANT: Ensure this is present for correct comparison
    ];

    public function club()
    {
        return $this->hasOne(Club::class, 'president_id');
    }

    public function student()
    {
        // This relationship assumes a 'User' model (or 'Student' model) exists
        // and has an 'email' column that matches the 'email' column in the 'presidents' table.
        return $this->belongsTo(User::class, 'email', 'email');
    }

    // Accessor to get the full URL of the profile picture
    public function getProfilePictureAttribute($value)
    {
        return $value ? Storage::url($value) : null;
    }
}
