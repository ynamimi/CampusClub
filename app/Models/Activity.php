<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'club_id',
        'name',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'venue',
        'activities',
        'poster',
        'points',
        'objectives'
    ];

    protected $casts = [
        'event_date' => 'datetime'
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    // Helper scopes
    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now());
    }

    public function scopePast($query)
    {
        return $query->where('event_date', '<', now());
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'activity_student', 'activity_id', 'student_id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);  // Use the Activity model
    }

   public function registrations()
    {
        return $this->hasMany(ActivityRegistration::class);
    }
}
