<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Enrollment;
use App\Models\Instructor;  
use App\Models\Course;
use App\Models\Payment;
use App\Models\Lesson;
    
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Course::factory(10)->create();
        User::factory()->create([
            'name' => 'Adrian',
            'email' => 'adrian@gmail.com',
            'password' => bcrypt('1234'),
            'is_admin'=> true,
        ]);  
        User::factory()->create([
            'name' => 'Tomek',
            'email' => 'tomek@gmail.com',
            'password' => bcrypt('1234'),
        ]);  
             
         $this->call([
            InstructorSeeder::class,
            CourseSeeder::class,
            EnrollmentSeeder::class,
            PaymentSeeder::class,
            LessonSeeder::class,
        ]);

    }
}
