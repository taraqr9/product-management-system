<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function store(OrderStoreRequest $request): JsonResponse
    {
        try {
            $order = $this->orderRepository->createOrder($request->validated());

            return response()->json([
                'status' => 201,
                'message' => 'Order placed successfully',
                'order' => $order,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Order placement failed',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
