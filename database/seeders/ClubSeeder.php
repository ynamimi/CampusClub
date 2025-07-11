<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\Registration; // Add this import for the Registration model
use Illuminate\Database\Seeder;

class ClubSeeder extends Seeder
{
    public function run()
    {
        // Delete records from the 'registrations' table first
        Registration::query()->delete(); // Correct way to delete all records from the registrations table

        // Truncate the clubs table and reset auto-increment ID
        Club::query()->delete();
        // Add your seed data here
        $publicClubs = [
            [
                'name' => 'Kelab Debat dan Pidato',
                'acronym' => 'DEBATE',
                'description' => 'Debating and public speaking club',
                'type' => 'public',
                'image' => 'debat.jpg'
            ],
            [
                'name' => 'Persatuan Ikatan Mahasiswa Madani',
                'acronym' => 'IMAM',
                'description' => 'Student association for civil society',
                'type' => 'public',
                'image' => 'imam.jpg'
            ],
            [
                'name' => 'Pembimbing Rakan Sebaya',
                'acronym' => 'PEERS',
                'description' => 'Student Association',
                'type' => 'public',
                'image' => 'peers.jpg'
            ],
        ];

        // Seed faculty clubs
        $facultyClubs = [
            [
                'name' => 'Bachelor of IT Society',
                'acronym' => 'BiTS',
                'description' => 'Faculty of Computer and Mathematical Sciences',
                'type' => 'faculty',
                'image' => 'bits.jpg'
            ],
            [
                'name' => 'COSMiTs',
                'acronym' => 'COSMiTs',
                'description' => 'Faculty of Computer and Mathematical Sciences',
                'type' => 'faculty',
                'image' => 'cosmits.jpg'
            ],
            [
                'name' => 'Human Resource Club',
                'acronym' => 'Hures',
                'description' => 'Faculty of Human Resource Management',
                'type' => 'faculty',
                'image' => 'hures.jpg'
            ]
        ];

        // Insert all clubs into the 'clubs' table
        Club::insert(array_merge($publicClubs, $facultyClubs));
    }
}
