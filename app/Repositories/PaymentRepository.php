<?php

namespace App\Repositories;

use App\Enums\PaymentStatusEnum;
use App\Models\Payment;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Stripe\Charge;
use Stripe\Stripe;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function processPayment(array $data)
    {
        Stripe::setApiKey(config('app.stipe_secret'));

        try {
            DB::beginTransaction();

            Charge::create([
                'amount' => $data['amount'] * 100,
                'currency' => 'usd',
                'source' => $data['token'],
                'description' => $data['description'],
            ]);

            $payment = Payment::create([
                'user_id' => $data['user_id'],
                'product_name' => $data['product_name'],
                'amount' => $data['amount'],
                'status' => PaymentStatusEnum::SUCCESS->value,
            ]);

            DB::commit();

            return $payment;
        } catch (\Exception $e) {
            Payment::create([
                'user_id' => $data['user_id'],
                'product_name' => $data['product_name'],
                'amount' => $data['amount'],
                'status' => PaymentStatusEnum::FAILED->value,
            ]);

            throw $e;
        }
    }
}
