<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function createUser(array $data): User;

    public function deleteUser(int $id): bool;
}
