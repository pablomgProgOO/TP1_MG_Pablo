<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories\UserFactory;
use Database\Factories\CriticFactory;
use App\Models\User;
use App\Models\Critic;


class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            LanguageSeeder::class,
            FilmSeeder::class,
            ActorSeeder::class,
            ActorFilmSeeder::class,
        ]);
        User::factory(10)->create()->each(function ($user) {
            $user->critics()->createMany(Critic::factory(30)->make()->toArray());
        });
    }
}

