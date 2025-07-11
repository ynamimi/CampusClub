<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('students');
            $table->unsignedBigInteger('club_id');
            $table->string('fullname');
            $table->string('student_id');
            $table->string('course');
            $table->string('semester');
            $table->string('email');
            $table->string('phone');
            $table->timestamps();

            // Foreign key relationship
            $table->foreign('club_id')->references('id')->on('clubs')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
