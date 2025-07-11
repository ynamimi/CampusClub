<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
         Schema::create('clubs', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('acronym')->nullable();
        $table->text('description')->nullable();
        $table->string('type')->default('public');
        $table->string('image')->nullable();
        $table->string('org_chart')->nullable();
        $table->string('advisor_name');
        $table->string('instagram_link')->nullable();
        $table->string('x_link')->nullable();
        $table->string('tiktok_link')->nullable();
        $table->string('email');
        $table->string('password');
        $table->integer('target_points')->default(0);
        $table->foreignId('president_id')->nullable()->constrained('presidents', 'president_id')->onDelete('set null');
        $table->timestamps();
    });
    }

    public function down()
    {
        Schema::dropIfExists('clubs');
    }
};
