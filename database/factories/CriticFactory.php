<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Film;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Critic>
 */
class CriticFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    //https://laravel.com/docs/12.x/queries#random-ordering
    //https://fakerphp.org/formatters/numbers-and-strings/
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'film_id' => Film::inRandomOrder()->first()->id, 
            'score' => $this->faker->randomFloat(1, 0, 10), 
            'comment' => $this->faker->paragraph(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
