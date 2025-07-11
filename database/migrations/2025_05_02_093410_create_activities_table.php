<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained()->onDelete('cascade');
            $table->string('name');  // Changed from 'title' to match model
            $table->date('event_date');
            $table->time('start_time');  // Added start time for the event
            $table->time('end_time');    // Added end time for the event
            $table->string('venue')->nullable();
            $table->text('objectives');
            $table->text('activities');  // Added column for the event activities description
            $table->string('poster')->nullable();  // Added column for the event poster image
            $table->integer('points')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
