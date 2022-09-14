<?php

namespace App\Services;

use App\Models\Movie;
use App\Models\Turn;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Requests\AssignmentRequest;
use App\Http\Requests\AssignmentDeleteRequest;

class AssignmentService
{

  public function storeAssignment(AssignmentRequest $request): bool
  {
    $movie_id = $request->input('movie_id');
    $turn_ids = $request->input('turn_ids');
    $itinerary = $request->input('itinerary');
    
    try {
      $movie = Movie::find($movie_id);
      $movie->turns()->attach($turn_ids, ['itinerary' => $itinerary]);
    } catch(\Throwable $th) {
      return false;
    };

    return true;
  }

  public function deleteAssignment(AssignmentDeleteRequest $request, int $id): bool
  {
    $turn_id = $request->input('turn_id');
    
    try {
      $movie = Movie::find($id);
      $movie->turns()->detach($turn_id);
    } catch(\Throwable $th) {
      return false;
    };

    return true;
  }

}