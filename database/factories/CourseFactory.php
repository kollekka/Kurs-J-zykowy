<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Lesson;
use App\Models\Opinion;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    protected $model = Course::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3), 
            'language' => $this->faker->randomElement(['English', 'Spanish', 'French', 'German', 'Italian']),
            'level' => $this->faker->randomElement(['A1', 'A2', 'B1', 'B2', 'C1', 'C2']),
            'start_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'end_date' => $this->faker->dateTimeBetween('+1 month', '+6 months'),
            'instructor_id' => Instructor::inRandomOrder()->first()->id, 
            'price' => $this->faker->randomFloat(2, 50, 1000), 
            'group_size' => $this->faker->numberBetween(6, 20),
        ];
    }
    public function withLessons()
    {
        $count = 5;
        return $this->has(Lesson::factory()->count($count), 'lessons');
    }
    public function withOpinions($count = 5)
    {
        return $this->has(Opinion::factory()->count($count), 'opinions');
    }
}
