<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;

use App\Services\AuthService;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }
    
    public function login(LoginRequest $request): JsonResponse
    {
        $authResponse = $this->authService->login($request);

        if (!$authResponse) {
            return response()->json(['msg' => 'These credentials do not match our records'], 404);
        }
        return response()->json($authResponse);
    }
}
