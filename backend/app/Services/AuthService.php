<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Requests\LoginRequest;

class AuthService
{

  public function login(LoginRequest $request): ?array
  {
    try {
      $user = User::where('email', $request->input('email'))->first();
      
      if (!$user && !Hash::check($request->input('password'), $user->password)) {
        return null;
      }
      $token = $user->createToken(Str::random(40))->plainTextToken;
    } catch(\Throwable $th) {
      return null;
    };

    return [
      'user' => $user->toArray(),
      'token' => $token
    ];
  }
}