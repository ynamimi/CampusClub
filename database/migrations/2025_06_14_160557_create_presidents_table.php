<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('presidents', function (Blueprint $table) {
        $table->id(); // Auto-incrementing primary key
        $table->string('name');
        $table->string('president_student_id')->unique();
        $table->string('president_course');
        $table->unsignedTinyInteger('president_semester');
        $table->string('contact_phone');
        $table->rememberToken();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presidents');
    }
};
