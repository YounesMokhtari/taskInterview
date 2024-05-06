<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Monitoring>
 */
class MonitorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word,
            'url' => $this->faker->url,
            'interval' => $this->faker->numberBetween(1, 60), // Assuming interval is in minutes
            'method' => $this->faker->randomElement(['get', 'post', 'put', 'delete']),
            'body' => $this->faker->text,
            'last_run_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'should_run_at' => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}
