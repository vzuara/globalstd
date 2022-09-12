<?php

namespace App\Services;

use App\Models\Movie;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Http\Requests\CreateMovieRequest;
use App\Http\Requests\UpdateMovieRequest;

class MovieService
{

  public function getMovies(): array
  {
    $movies = Movie::all();
    return $movies->toArray();
  }

  public function getMovie(int $id): ?Movie
  {
    return Movie::find($id);
  }

  public function storeMovie(CreateMovieRequest $request): ?Movie
  {
    try {
      $movie = new Movie();
      $movie->fill($request->all());

      if ($file = $request->file('image')) {
        $path = $file->store('public/images');
        $movie->image = $path;
      }

      $movie->save();
    } catch(\Throwable $th) {
      return null;
    };

    return $movie;
  }

  public function updateMovie(UpdateMovieRequest $request, int $id): ?Movie
  {
    
    try {
      $movie = Movie::findOrFail($id);
      $oldImage = $movie->image;

      $movie->fill($request->all());
      
      if ($file = $request->file('image')) {

        $exists = Storage::disk('local')->exists($oldImage);
        if ($exists) {
          Storage::delete($oldImage);
        }

        $path = $file->store('public/images');
        $movie->image = $path;
      }

      $movie->save();      
    } catch (\Throwable $th) {
      return null;
    }

    return $movie;
  }

  public function deleteMovie(int $id): bool
  {
    
    try {
      $movie = Movie::findOrFail($id);
      $movie->delete();      
    } catch (\Throwable $th) {
      return false;
    }

    return true;
  }

}