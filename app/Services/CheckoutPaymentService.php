<?php

namespace App\Services;

use App\Models\Order;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class CheckoutPaymentService
{
    public function createForOrder(Order $order): PaymentIntent
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentIntent = PaymentIntent::create([
            'amount' => $order->amount,
            'currency' => 'usd',
            'metadata' => [
                'order_id' => $order->id,
                'plan' => $order->plan?->slug,
                'period' => $order->plan_period,
            ],
        ]);

        $order->update(['stripe_payment_intent' => $paymentIntent->id]);

        return $paymentIntent;
    }
}