<?php

namespace App\Http\Controllers\Api;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Repositories\Contracts\AuthRepositoryInterface;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(UserRegistrationRequest $request): JsonResponse
    {
        try {
            $user = $this->authRepository->register($request->validated());

            return response()->json([
                'status' => 200,
                'message' => 'User registered successfully',
                'data' => ['user' => $user],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        try {
            $token = $this->authRepository->login($request->validated());

            return response()->json([
                'status' => 200,
                'message' => 'Login successful',
                'data' => ['token' => $token],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Login failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout(): JsonResponse
    {
        try {
            $this->authRepository->logout();

            return response()->json([
                'status' => 200,
                'message' => 'Logout successful',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Logout failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function createUser(CreateUserRequest $request): JsonResponse
    {
        if (! auth()->user()->hasRole(RoleEnum::ADMIN->value)) {
            return response()->json([
                'status' => 403,
                'message' => 'Unauthorized action: only admins can delete users',
            ], 403);
        }

        try {
            $user = $this->authRepository->createUser($request->validated());

            return response()->json([
                'status' => 200,
                'message' => 'User created successfully',
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'User creation failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteUser($id): JsonResponse
    {
        if (! auth()->user()->hasRole(RoleEnum::ADMIN->value)) {
            return response()->json([
                'status' => 403,
                'message' => 'Unauthorized action: only admins can delete users',
            ], 403);
        }

        try {
            $this->authRepository->deleteUser($id);

            return response()->json([
                'status' => 200,
                'message' => 'User deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'User deletion failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
