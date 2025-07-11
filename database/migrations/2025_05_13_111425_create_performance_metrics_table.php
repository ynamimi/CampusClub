<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformanceMetricsTable extends Migration
{
    public function up()
    {
        Schema::create('performance_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained()->onDelete('cascade');  // Link to the club
            $table->float('total_points')->default(0);  // Store total points for the club
            $table->float('completed_percentage')->default(0);  // Store completed percentage
            $table->float('remaining_percentage')->default(0);  // Store remaining percentage
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('performance_metrics');
    }
}
