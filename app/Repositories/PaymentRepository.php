<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Models\Product;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function processPayment(array $data)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $charge = Charge::create([
                'amount' => $data['amount'] * 100, // Amount in cents
                'currency' => 'usd',
                'source' => $data['token'],
                'description' => $data['description'],
            ]);

            // Save payment details
            return Payment::create([
                'user_id' => $data['user_id'],
                'product_name' => $data['product_name'],
                'amount' => $data['amount'],
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            // Log the failure and return status
            Payment::create([
                'user_id' => $data['user_id'],
                'product_name' => $data['product_name'],
                'amount' => $data['amount'],
                'status' => 'failed',
            ]);

            throw $e;
        }
    }
}
