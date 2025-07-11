<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Call the ClubSeeder to seed the club data
        $this->call(ClubSeeder::class);
    }
}
