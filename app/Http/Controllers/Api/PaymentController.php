<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use Illuminate\Support\Facades\Request;

class PaymentController extends Controller
{
    private $paymentRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function process(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'product_name' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        try {
            $payment = $this->paymentRepository->processPayment([
                'user_id' => auth()->id(),
                'token' => $request->token,
                'product_name' => $request->product_name,
                'amount' => $request->amount,
                'description' => 'Payment for ' . $request->product_name,
            ]);

            return response()->json(['message' => 'Payment successful', 'payment' => $payment], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Payment failed', 'error' => $e->getMessage()], 400);
        }
    }
}
