<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('instructors')->insert([
            [
                'full_name' => 'John Doe',
                'bio' => 'Experienced English instructor with over 10 years of teaching.',
                'email' => 'john.doe@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'full_name' => 'Jane Smith',
                'bio' => 'Specialist in Spanish language and culture.',
                'email' => 'jane.smith@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
