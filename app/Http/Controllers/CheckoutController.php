<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Plan;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function create(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
            'period' => ['required', 'in:monthly,yearly'],
        ]);

        $plan = Plan::findOrFail($validated['plan_id']);
        $period = $validated['period'];
        $amount = $plan->{"price_{$period}"};

        $order = Order::create([
            'user_id' => $request->user()?->id,
            'plan_id' => $plan->id,
            'plan_period' => $period,
            'amount' => $amount,
            'status' => 'pending',
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentIntent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'usd',
            'metadata' => [
                'order_id' => $order->id,
                'plan' => $plan->slug,
                'period' => $period,
            ],
        ]);

        $order->update(['stripe_payment_intent' => $paymentIntent->id]);

        return view('checkout.pay', [
            'clientSecret' => $paymentIntent->client_secret,
            'stripeKey' => config('services.stripe.key'),
            'order' => $order,
            'plan' => $plan,
        ]);
    }

    public function success(Request $request)
    {
        return view('checkout.success');
    }

    public function cancel()
    {
        return view('checkout.cancel');
    }
}
