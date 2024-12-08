<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    protected PaymentRepositoryInterface $paymentRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function process(PaymentRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['description'] = 'Payment for '.$data['product_name'];

        try {
            $payment = $this->paymentRepository->processPayment($data);

            return response()->json(['message' => 'Payment successful', 'payment' => $payment], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Payment failed', 'error' => $e->getMessage()], 400);
        }
    }
}
