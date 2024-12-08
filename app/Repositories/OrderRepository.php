<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Product;
use App\Repositories\Contracts\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function createOrder(array $data): Order
    {
        $product = Product::findOrFail($data['product_id']);

        if ($product->stock < $data['quantity']) {
            throw new \Exception('Insufficient stock');
        }

        $data['total_price'] = $product->price * $data['quantity'];
        $product->decrement('stock', $data['quantity']);

        return Order::create($data);
    }

    public function getOrderById($id): Order
    {
        return Order::findOrFail($id);
    }
}
