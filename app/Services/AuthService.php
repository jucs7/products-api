<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(protected UserRepository $userRepository) {}

    public function register(array $data): User
    {   
        $current = Auth::guard('sanctum')->user();

        if (!$current || !$current->isAdmin()) {
            $data['role'] = 'user';
        }

        return $this->userRepository->create($data);
    }

    public function login(array $data): array
    {
        $user = $this->userRepository->findByEmail($data['email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new AuthenticationException("Credenciales invalidas.");
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return ['token' => $token, 'user' => $user];
    }

    public function logout(User $user): void
    {
        $user->tokens()->delete();
    }
}