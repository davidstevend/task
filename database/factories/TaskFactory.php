<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'task' => $this->faker->text(200),
            'description' => $this->faker->text(500),
            'date' => now(),
            'expiration_date' => now(),
            'user_id' => rand(1, 30),
            'finished' =>  $this->faker->randomElement(['SI', 'NO']),
        ];
    }
}
