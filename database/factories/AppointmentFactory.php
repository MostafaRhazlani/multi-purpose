<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointments>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory()->create()->id,
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'start_time' => $startTime = fake()->dateTimeBetween('-1 year', '+1 year'),
            'end_time' => Carbon::parse($startTime)->addHours(2),
            'status' => rand(1, 3)
        ];
    }
}
