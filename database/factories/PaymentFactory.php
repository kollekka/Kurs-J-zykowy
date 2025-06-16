<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $enrollment = Enrollment::inRandomOrder()->first() ?? Enrollment::factory()->create(); 

        return [
            'enrollment_id' => $enrollment->id,
            'amount' => $enrollment->course->price ?? $this->faker->randomFloat(2, 50, 500), 
            'payment_date' => $this->faker->dateTimeThisMonth(),
            'payment_method' => $this->faker->randomElement(['card', 'bank_transfer', 'paypal']),
            'status' => 'paid', 
        ];
    }
}
