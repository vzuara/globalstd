<?php

namespace Tests\Unit;

use App\Models\User;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\Http\Requests\LoginRequest;

use App\Services\AuthService;

class AuthTest extends TestCase
{
    use RefreshDatabase;
   
    public function test_should_show_can_login()
    {
        $authService = new AuthService();
        $request = new LoginRequest();

        $request->merge([
            'email' => 'user@gmail.com',
            'password' => 'password'
        ]);

        $user = User::factory()->create($request->all());

        $response = $authService->login($request);
        
        $this->assertArrayHasKey('token', $response);
    }

    public function test_should_show_cannot_login()
    {
        $authService = new AuthService();
        $request = new LoginRequest();

        $request->merge([
            'email' => 'user@gmail.com',
            'password' => 'password'
        ]);

        $user = User::factory()->create($request->all());

        $request->merge([
            'email' => 'user1@gmail.com',
            'password' => 'password'
        ]);

        $response = $authService->login($request);
        
        $this->assertNull($response);
    }
}
