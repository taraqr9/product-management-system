<?php

namespace App\Repositories\Contracts;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function createProduct(array $data): Product;

    public function updateProduct(array $data, int $id): Product;

    public function deleteProduct(int $id): bool;

    public function getProduct(int $id): Product;

    public function getAllProducts();
}
