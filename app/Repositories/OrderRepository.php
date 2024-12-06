<?php

namespace App\Repositories;

use App\Enums\RoleEnum;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Repositories\Contracts\AuthRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function createOrder(array $data)
    {
        $product = Product::findOrFail($data['product_id']);

        if ($product->stock < $data['quantity']) {
            throw new \Exception('Insufficient stock');
        }

        $totalPrice = $product->price * $data['quantity'];

        // Deduct stock
        $product->decrement('stock', $data['quantity']);

        // Create order
        return Order::create([
            'user_id' => $data['user_id'],
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity'],
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);
    }

    public function getOrderById($id)
    {
        return Order::findOrFail($id);
    }
}
