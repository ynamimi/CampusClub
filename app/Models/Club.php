<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable; // ✅ Add this
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\PerformanceMetric;
use App\Models\User;
use App\Models\Registration;
use App\Models\Activity;
use App\Models\ClubPerformance;
use App\Models\President;

class Club extends Authenticatable
{
    use HasFactory, Notifiable; // ✅ Make sure this includes Notifiable

    protected $table = 'clubs';

    protected $fillable = [
        'president_id',
        'name',
        'acronym',
        'description',
        'type',
        'image',
        'org_chart',
        'instagram_link',
        'x_link',
        'tiktok_link',
        'email',
        'password',
        'target_points',
        'advisor_name',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
        'email_verified_at' => 'datetime',
    ];

    public function students()
    {
        return $this->belongsToMany(User::class, 'club_student', 'club_id', 'student_id');
    }

    // In Club.php
    public function president()
    {
        return $this->belongsTo(President::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'club_student', 'club_id', 'student_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function performanceData()
    {
        return $this->hasOne(ClubPerformance::class);
    }

    public function getPresident()
    {
        return $this->president;
    }

    public function performanceMetrics()
    {
        return $this->hasOne(PerformanceMetric::class);
    }
}
