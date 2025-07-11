<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    // Specify which attributes are mass assignable
    protected $fillable = [
        'user_id',
        'club_id',
        'fullname',
        'student_id',
        'course',
        'semester',
        'phone',
        'gender'
    ];

    // Define the relationship with Club
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

}
