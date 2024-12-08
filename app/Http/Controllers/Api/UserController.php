<?php

namespace App\Http\Controllers\Api;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        if (! auth()->user()->hasRole(RoleEnum::ADMIN->value)) {
            return response()->json([
                'status' => 403,
                'message' => 'Unauthorized action: only admins can create users',
            ], 403);
        }

        try {
            $user = $this->userRepository->createUser($request->validated());

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

    public function destroy($id): JsonResponse
    {
        if (! auth()->user()->hasRole(RoleEnum::ADMIN->value)) {
            return response()->json([
                'status' => 403,
                'message' => 'Unauthorized action: only admins can delete users',
            ], 403);
        }

        try {
            $this->userRepository->deleteUser($id);

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
