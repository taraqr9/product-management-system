<?php

namespace App\Repositories;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Arr;

class UserRepository implements UserRepositoryInterface
{
    public function createUser(array $data): User
    {
        $user = User::create(Arr::except($data, ['role']));

        $role = $data['role'] ?? RoleEnum::VIEWER->value;
        $user->assignRole($role);

        return $user;
    }

    public function deleteUser($id): bool
    {
        $user = User::findOrFail($id);

        return $user->delete();
    }
}
