<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('enrollments')->insert([
            [
                'user_id' => 1, // Zakładamy, że użytkownik o ID 1 istnieje
                'course_id' => 1, // Zakładamy, że kurs o ID 1 istnieje
                'enrollment_date' => now(),
                'status' => 'confirmed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // Zakładamy, że użytkownik o ID 2 istnieje
                'course_id' => 2, // Zakładamy, że kurs o ID 2 istnieje
                'enrollment_date' => now(),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

