<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->insert([
            [
                'name' => 'English for Beginners',
                'language' => 'English',
                'level' => 'Beginner',
                'start_date' => '2025-05-01',
                'end_date' => '2025-06-01',
                'price' => 199.99,
                'instructor_id' => 1, // Zakładamy, że instruktor o ID 1 istnieje
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Advanced Spanish',
                'language' => 'Spanish',
                'level' => 'Advanced',
                'start_date' => '2025-06-15',
                'end_date' => '2025-07-15',
                'price' => 299.99,
                'instructor_id' => 2, // Zakładamy, że instruktor o ID 2 istnieje
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
