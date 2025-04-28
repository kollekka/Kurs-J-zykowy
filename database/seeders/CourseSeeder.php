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
                'level' => 'A2',
                'group_size' => 10,
                'start_date' => '2025-05-01',
                'end_date' => '2025-06-01',
                'price' => 199.99,
                'instructor_id' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Advanced Spanish',
                'language' => 'Spanish',
                'level' => 'C1',
                'group_size' => 12,
                'start_date' => '2025-06-15',
                'end_date' => '2025-07-15',
                'price' => 299.99,
                'instructor_id' => 2, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
