<?php

namespace App\Services;

use App\Models\Turn;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Requests\CreateTurnRequest;
use App\Http\Requests\UpdateTurnRequest;

class TurnService
{

  public function getTurns(): array
  {
    $turns = Turn::all();
    return $turns->toArray();
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

  public function deleteTurn(int $id): bool
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