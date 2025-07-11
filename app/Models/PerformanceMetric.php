<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceMetric extends Model
{
    use HasFactory;

    // Define the table name if it's not the plural form of the model name
    protected $table = 'performance_metrics';

    // Define the fillable attributes to allow mass assignment
    protected $fillable = [
        'club_id',
        'total_points',
        'completed_percentage',
        'remaining_percentage'
    ];

    // If you're using a custom primary key or don't want timestamps
    // protected $primaryKey = 'id';  // Optional if you have a custom primary key
    // public $timestamps = false;  // If you don't want to use timestamps
}
