<?php

namespace App\Repositories\Contracts;

interface PaymentRepositoryInterface
{
    public function processPayment(array $data);
}
