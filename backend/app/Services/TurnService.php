<?php

namespace App\Services;

use App\Models\Turn;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Requests\CreateTurnRequest;
use App\Http\Requests\UpdateTurnRequest;

class TurnService
{

  public function getTurns(Request $request): array
  {
    $queries = $request->input('query');
		$limit = $request->input('limit');
		$ascending = $request->input('ascending');
		$page = $request->input('page');
		$orderBy = $request->input('orderBy');

			$data = Turn::with('movies');

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

  public function getTurn(int $id): ?Turn
  {
    return Turn::find($id);
  }

  public function storeTurn(CreateTurnRequest $request): ?Turn
  {
    try {
      $turn = new Turn();
      $turn->fill($request->all());
      $turn->save();
    } catch(\Throwable $th) {
      return null;
    };

    return $turn;
  }

  public function updateTurn(UpdateTurnRequest $request, int $id): ?Turn
  {
    
    try {
      $turn = Turn::findOrFail($id);
      $turn->fill($request->all());
      $turn->save();      
    } catch (\Throwable $th) {
      return null;
    }

    return $turn;
  }

  public function deleteTurn(int $id)
  {
    try {
      $turn = Turn::findOrFail($id);
      $turn->delete();      
    } catch (\Throwable $th) {
      return false;
    }

    return true;
  }

}