<?php

namespace Database\Factories;

use App\Models\Opinion;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class OpinionFactory extends Factory
{
    protected $model = Opinion::class;

    public function definition()
    {
        return [
            'opinion' => $this->faker->paragraph, 
            'rating' => $this->faker->numberBetween(1, 5), 
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id, 
            'course_id' => Course::inRandomOrder()->first()->id ?? Course::factory()->create()->id, 
        ];
    }
}
