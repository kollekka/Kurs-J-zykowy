<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{
    protected $model = Lesson::class;

    public function definition()
    {
        $course = Course::inRandomOrder()->first() ?? Course::factory()->create();

        $startDate = \Carbon\Carbon::parse($course->start_date ?? now());

       
        $durationMinutes = $this->faker->numberBetween(30, 120); 
        $duration = sprintf('%02d:%02d', intdiv($durationMinutes, 60), $durationMinutes % 60); 

        return [
            'course_id' => $course->id,
            'title' => $this->faker->sentence(5),
            'content' => $this->faker->paragraphs(3, true),
            'duration' => $duration, 
            'date' => $startDate->addDays($this->faker->numberBetween(1, 30)),
            'time' => $this->faker->time('H:i'), 
        ];
    }
}
