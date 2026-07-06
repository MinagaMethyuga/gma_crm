<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Plan;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function initCheckout(Request $request, Plan $plan)
    {
        if (! $request->user()) {
            session(['pending_plan_id' => $plan->id]);
            return redirect()->route('login');
        }

        return $this->processCheckout($request, $plan);
    }

    protected function processCheckout(Request $request, Plan $plan)
    {
        $period = $request->input('period', 'one_time');
        $amount = $plan->price_one_time ? $plan->price_one_time : ($plan->{"price_{$period}"} ?? $plan->price_monthly);

        $order = Order::create([
            'user_id' => $request->user()->id,
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

    public function create(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
            'period' => ['nullable', 'string', 'in:one_time,monthly,yearly'],
        ]);

        $plan = Plan::findOrFail($validated['plan_id']);

        $request->merge(['period' => $validated['period'] ?? 'one_time']);

        return $this->processCheckout($request, $plan);
    }

    public function success(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $order = Order::where('user_id', $user->id)
                ->latest()
                ->first();

            if ($order && $order->status === 'pending') {
                $order->update(['status' => 'paid']);
            }

            if ($order) {
                $user->update([
                    'plan_id' => $order->plan_id,
                    'plan_subscribed_at' => $order->updated_at ?? now(),
                ]);
            }
        }

        return view('checkout.success', [
            'order' => $order ?? null,
            'user' => $user,
        ]);
    }

    public function cancel()
    {
        return view('checkout.cancel');
    }
}
