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

  public function getMovies(Request $request): array
  {
    $queries = $request->input('query');
		$limit = $request->input('limit');
		$ascending = $request->input('ascending');
		$page = $request->input('page');
		$orderBy = $request->input('orderBy');

			$data = Movie::with('turns');

		if (isset($queries) && $queries) {
			foreach(json_decode($queries) as $field => $query) {
				$data->where($field, 'LIKE', '%' . $query . '%');
			};
		}

		$count = $data->count();
		
		if (isset($limit) && $limit) {
      $data->limit($limit)->skip($limit * ($page - 1));
    }
				
    if (isset($orderBy)) {
      $direction = $ascending == 1 ? 'ASC' : 'DESC';
    } else {
      $direction = 'ASC';
      $orderBy = 'id';
    }
    $data->orderBy($orderBy, $direction);

		$results = $data->get()->toArray();

		return [
			'data'	=> $results,
			'count' => $count
		];
  }

  public function getMovie(int $id): ?Movie
  {
    return Movie::with('turns')->where('id', $id)->first();
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

        if ($oldImage) {
          $exists = Storage::disk('local')->exists($oldImage);
          if ($exists) {
            Storage::delete($oldImage);
          }
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