<?php

// App/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'students'; // Correctly points to your 'students' table

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        // Add the profile fields that exist on your 'students' table and you want to update
        'student_id',
        'course',
        'semester',
        'phone',
        // 'gender' is typically not on the 'students' table, so don't add it here.
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships (reviewing 'registrations' relationship)
    public function clubs()
    {
        return $this->belongsToMany(Club::class, 'club_student', 'student_id', 'club_id');
    }

    public function activityRegistrations()
    {
        return $this->hasMany(ActivityRegistration::class);
    }

    public function presidedClub()
    {
        return $this->hasOne(Club::class, 'president_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'student_id'); // Match the foreign key
    }
}
