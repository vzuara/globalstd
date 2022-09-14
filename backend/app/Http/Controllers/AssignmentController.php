<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Services\AssignmentService;
use App\Http\Requests\AssignmentRequest;
use App\Http\Requests\AssignmentDeleteRequest;

class AssignmentController extends Controller
{
    
    private $assignmentService;

    public function __construct(AssignmentService $assignmentService) {
        $this->assignmentService = $assignmentService;
    }

    public function store(AssignmentRequest $request): JsonResponse
    {
        $response = $this->assignmentService->storeAssignment($request);

        if (!$response) {
            return response()->json(['msg' => 'Itinearary was not saved, try again'], 304);
        }
        return response()->json(['msg' => 'ok']);
    }

    public function delete(AssignmentDeleteRequest $request,int $id): JsonResponse
    {
        $response = $this->assignmentService->deleteAssignment($request, $id);
        if (!$response === true) {
            return response()->json(['msg' => 'Assignment not exist'], 404);
        }
        return response()->json(['msg' => 'ok']);
    }
}
