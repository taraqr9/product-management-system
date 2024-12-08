<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\AuthRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthRepository implements AuthRepositoryInterface
{
    public function register(array $data): User
    {
        $user = User::create($data);
        $user->assignRole('viewer');

        return $user;
    }

    public function login(array $data): string
    {
        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken('auth_token')->plainTextToken;
    }

    public function logout(): bool
    {
        auth()->user()->currentAccessToken()->delete();

        return true;
    }

    public function createUser(array $data): User
    {
        $currentUser = auth()->user();

        if (! $currentUser || ! $currentUser->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $user = User::create(Arr::except($data, ['role']));

        $role = $data['role'] ?? 'viewer';
        $user->assignRole($role);

        return $user;
    }

    public function deleteUser($id): bool
    {
        $user = User::findOrFail($id);

        return $user->delete();
    }
}
