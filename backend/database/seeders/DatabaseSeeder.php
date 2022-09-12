<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Movie;
use App\Models\turn;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            TurnSeeder::class,
            MovieSeeder::class,
        ]);

        $turns = Turn::all();

        Movie::all()->each(function ($movie) use ($turns) { 
            $movie->turns()->attach(
                $turns->random(rand(1, $turns->count()))->pluck('id')->toArray(),
                ['itinerary' => fake()->dateTime()]
            ); 
        });
    }
}
