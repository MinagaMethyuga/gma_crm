<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Exception\UnexpectedValueException;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                config('services.stripe.webhook_secret')
            );
        } catch (SignatureVerificationException | UnexpectedValueException $e) {
            return response('Invalid signature', 400);
        }

        if ($event->type === 'payment_intent.succeeded') {
            $paymentIntent = $event->data->object;
            $orderId = $paymentIntent->metadata->order_id ?? null;

            if ($orderId) {
                $order = Order::find($orderId);

                if ($order) {
                    if ($order->status === 'paid') {
                        return response('OK', 200);
                    }

                    $order->update([
                        'status' => 'paid',
                        'stripe_payment_intent' => $paymentIntent->id,
                    ]);

                    $plan = \App\Models\Plan::find($order->plan_id);
                    $isCorporate = $plan && in_array($plan->slug, ['business', 'executive']);

                    if ($isCorporate && $order->user) {
                        $team = null;
                        if ($order->team_id) {
                            $team = \App\Models\Team::find($order->team_id);
                        } else {
                            $team = $order->user->currentTeam;
                            if (!$team) {
                                $team = \App\Models\Team::create([
                                    'name' => $order->user->company_name ?? $order->user->name . "'s Team",
                                    'is_personal' => false,
                                ]);
                                $order->user->teams()->attach($team, ['role' => \App\Enums\TeamRole::Owner]);
                                $order->user->update(['current_team_id' => $team->id]);
                            }
                            $order->update(['team_id' => $team->id]);
                        }

                        if ($team) {
                            $maxSeats = $plan->slug === 'executive' ? 15 : 5;
                            $team->update([
                                'plan_id' => $order->plan_id,
                                'plan_subscribed_at' => now(),
                                'max_seats' => $maxSeats,
                                'subscription_status' => 'active',
                                'stripe_checkout_session_id' => $paymentIntent->id,
                            ]);
                        }
                    } elseif ($order->user) {
                        $order->user->update([
                            'plan_id' => $order->plan_id,
                            'plan_subscribed_at' => now(),
                        ]);
                    }
                }
            }
        }

        return response('OK', 200);
    }
}
