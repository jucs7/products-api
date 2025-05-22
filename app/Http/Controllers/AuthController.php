<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function register(RegisterRequest $registerRequest)
    {
        $user = $this->authService->register($registerRequest->validated());
        return response()->json($user, 201);
    }

    public function login(LoginRequest $loginRequest)
    {
        $data = $this->authService->login($loginRequest->validated());
        return response()->json($data);
    }

    public function logout()
    {
        $this->authService->logout(Auth::user());
        return response()->json(['message' => 'Usuario deslogeado.']);
    }
}
