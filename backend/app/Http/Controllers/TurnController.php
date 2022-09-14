<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Requests\CreateTurnRequest;
use App\Http\Requests\UpdateTurnRequest;
use App\Services\TurnService;

class TurnController extends Controller
{
    private $turnService;

    public function __construct(TurnService $turnService) {
        $this->turnService = $turnService;
    }

    public function index(Request $request): JsonResponse
    {
        $turns = $this->turnService->getTurns($request);
        return response()->json($turns);
    }

    public function show(int $id): JsonResponse
    {
        $turn = $this->turnService->getTurn($id);

        if (!$turn) {
            return response()->json(['msg' => 'Turn not found'], 404);
        }
        return response()->json(['turn' => $turn]);
    }

    public function store(CreateTurnRequest $request): JsonResponse
    {
        $turn = $this->turnService->storeTurn($request);

        if (!$turn) {
            return response()->json(['msg' => 'Try later'], 500);
        }
        return response()->json(['turn' => $turn]);
    }

    public function update(UpdateTurnRequest $request, int $id): JsonResponse
    {
        $turn = $this->turnService->updateTurn($request, $id);

        if (!$turn) {
            return response()->json(['msg' => 'turn not exist'], 404);
        }
        return response()->json(['turn' => $turn]);
    }

    public function delete(int $id): JsonResponse
    {
        $response = $this->turnService->deleteTurn($id);
        if (!$response === true) {
            return response()->json(['msg' => 'turn not exist'], 404);
        }
        return response()->json(['msg' => 'ok']);
    }
}
