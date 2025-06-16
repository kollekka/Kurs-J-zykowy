<?php

namespace Database\Factories;

use App\Models\Enrollment;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnrollmentFactory extends Factory
{
    protected $model = Enrollment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id, 
            'course_id' => Course::inRandomOrder()->first()->id ?? Course::factory()->create()->id, 
            'enrollment_date' => $this->faker->dateTimeBetween('-1 month', 'now'), 
            'status' => 'active',
        ];
    }
}
