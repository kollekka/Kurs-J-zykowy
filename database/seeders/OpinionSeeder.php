<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Opinion;

class OpinionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Opinion::create([
            'user_id' => 1,
            'course_id' => 1,
            'opinion' => 'To był fantastyczny kurs! Bardzo dużo się nauczyłem i prowadzący był świetny.',
            'rating' => 5,
            'created_at' => now(), 
            'updated_at' => now(),
        ]);

        Opinion::create([
            'user_id' => 1,
            'course_id' => 1, 
            'opinion' => 'Kurs był w porządku, ale niektóre tematy mogłyby być lepiej wyjaśnione.',
            'rating' => 3,
            'created_at' => now(), 
            'updated_at' => now(),
        ]);
    }
}
