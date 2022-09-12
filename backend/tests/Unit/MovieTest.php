<?php

namespace Tests\Unit;

use App\Models\Movie;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\Http\Requests\CreateMovieRequest;
use App\Http\Requests\UpdateMovieRequest;

use App\Services\MovieService;

class MovieTest extends TestCase
{
    use RefreshDatabase;

   
    public function test_should_show_a_list_of_movies()
    {
        $movieService = new MovieService();
        Movie::factory()->count(5)->create();

        $movies = $movieService->getMovies();
        
        $this->assertCount(5, $movies);
    }

    public function test_should_show_a_movie()
    {
        $movieService = new MovieService();
        $movie = Movie::factory()->create();

        $newMovie = $movieService->getMovie($movie->id);
        
        $this->assertNotNull($newMovie);
    }

    public function test_should_store_a_movie()
    {
        $movieService = new MovieService();
        $request = new CreateMovieRequest();

        $request->merge([
            'name' => 'Movie 1',
            'published_at' => '2020-10-10',
            'status' => true
        ]);

        $movie = $movieService->storeMovie($request);
        
        $this->assertDatabaseHas('movies', [
            'name' => $movie->name,
            'published_at' => $movie->published_at,
            'status' => $movie->status
        ]);
    }

    public function test_should_update_a_movie()
    {
        $movieService = new MovieService();
        $request = new UpdateMovieRequest();

        $movie = Movie::factory()->create();

        $request->merge([
            'name' => 'Movie 1',
            'published_at' => '2020-10-10',
            'status' => true
        ]);

        $movieUpdated = $movieService->updateMovie($request, $movie->id);
        
        $this->assertDatabaseHas('movies', [
            'name' => $movieUpdated->name,
            'published_at' => $movieUpdated->published_at,
            'status' => $movieUpdated->status
        ]);
    }
}
