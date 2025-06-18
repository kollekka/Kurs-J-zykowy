<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class LessonFactory extends Factory
{
    protected $model = Lesson::class;

    public function definition()
    {
        $course = Course::inRandomOrder()->first() ?? Course::factory()->create();

        $startDate = Carbon::parse($course->start_date ?? now());
        $endDate = Carbon::parse($course->end_date ?? now()->addMonth());

        $lessons = [];
        $current = $startDate->copy();

        while ($current->lte($endDate)) {
            
            $hour = rand(8, 19);
            $minute = [0, 15, 30, 45][array_rand([0, 15, 30, 45])];
            $time = sprintf('%02d:%02d:00', $hour, $minute);

            $durationMinutes = rand(45, 90); // np. 64
            $duration = sprintf('%02d:%02d:00', intdiv($durationMinutes, 60), $durationMinutes % 60);

            $lessons[] = [
                'course_id' => $course->id,
                'title' => $this->faker->sentence(3),
                'content' => $this->faker->paragraph(),
                'duration' => $duration, 
                'date' => $current->toDateString(),
                'time' => $time,
            ];

            
            $current->addDay();
        }

        return $lessons[array_rand($lessons)];
    }
}
