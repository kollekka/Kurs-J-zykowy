<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Enrollment;
use App\Models\Instructor;  
use App\Models\Course;
use App\Models\Payment;
use App\Models\Lesson;  
use App\Models\Opinion;
    
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Adrian',
            'email' => 'adrian@gmail.com',
            'password' => bcrypt('1234'),
            'is_admin'=> true,
        ]);  
             
        User::factory()->count(20)->create();

        Instructor::factory()->count(10)->create();

        Course::factory()
            ->count(15)
            ->create()
            ->each(function ($course) {
                Lesson::factory()->count(5)->create(['course_id' => $course->id]);

                Opinion::factory()->count(3)->create(['course_id' => $course->id]);
            });

        Enrollment::factory()->count(50)->create()->each(function ($enrollment) {
            Payment::factory()->create([
                'enrollment_id' => $enrollment->id,
                'amount' => $enrollment->course->price,
                'status' => 'paid', 
            ]);
        });

    }
}
