<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use Illuminate\Http\JsonResponse;

use App\Services\MovieService;

class MovieController extends Controller
{

    private $movieService;

    public function __construct(MovieService $movieService) {
        $this->movieService = $movieService;
    }

    public function index(): JsonResponse
    {
        $movies = $this->movieService->getMovies();
        return response()->json(['movies' => $movies]);
    }

    public function show(int $id): JsonResponse
    {
        $movie = $this->movieService->getMovie($id);

        if (!$movie) {
            return response()->json(['msg' => 'Movie not found'], 404);
        }
        return response()->json(['movie' => $movie]);
    }

    public function store(CreateMovieRequest $request): JsonResponse
    {
        $movie = $this->movieService->storeMovie($request);

        if (!$movie) {
            return response()->json(['msg' => 'Try later'], 500);
        }
        return response()->json(['movie' => $movie]);
    }

    public function update(UpdateMovieRequest $request, int $id): JsonResponse
    {
        $movie = $this->movieService->updateMovie($request, $id);

        if (!$movie) {
            return response()->json(['msg' => 'Movie not exist'], 404);
        }
        return response()->json(['movie' => $movie]);
    }

    public function delete(int $id): JsonResponse
    {
        $response = $this->movieService->deleteMovie($id);

        if (!$response) {
            return response()->json(['msg' => 'Movie not exist'], 404);
        }
        return response()->json(['msg' => 'ok']);
    }
}
