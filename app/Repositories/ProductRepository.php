<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function createProduct(array $data): Product
    {
        return Product::create($data);
    }

    public function updateProduct(array $data, int $id): Product
    {
        $product = Product::findOrFail($id);
        $product->update($data);

        return $product;
    }

    public function deleteProduct(int $id): bool
    {
        $product = Product::findOrFail($id);

        return $product->delete();
    }

    public function getProduct(int $id): Product
    {
        return Product::findOrFail($id);
    }

    public function getAllProducts(): Collection
    {
        return Product::all();
    }
}
