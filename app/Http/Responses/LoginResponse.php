<?php

namespace App\Http\Responses;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Symfony\Component\HttpFoundation\Response;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): Response
    {
        $user = $request->user();

        if ($user && ! $user->isAdmin()) {
            // Resume an abandoned order the user was brought back to via email
            if ($resumeOrderId = session()->pull('resume_order_id')) {
                $order = Order::find($resumeOrderId);
                if ($order && $order->user_id === $user->id) {
                    return $request->wantsJson()
                        ? new JsonResponse(['two_factor' => false], 200)
                        : redirect()->route('checkout.resume', ['order' => $order->id]);
                }
            }

            // If user had a pending plan selection before login, redirect to checkout
            if ($pendingPlanId = session()->pull('pending_plan_id')) {
                return $request->wantsJson()
                    ? new JsonResponse(['two_factor' => false], 200)
                    : redirect()->route('checkout.init', ['plan' => $pendingPlanId]);
            }

            $hasMembership = $user->plan_id !== null || Order::where('user_id', $user->id)
                ->where('status', 'paid')
                ->exists();

            if (! $hasMembership) {
                return $request->wantsJson()
                    ? new JsonResponse(['two_factor' => false], 200)
                    : redirect()->route('pricing');
            }
        }

        $redirect = $user && $user->isAdmin()
            ? redirect()->intended('/dashboard')
            : redirect()->intended('/member/dashboard');

        return $request->wantsJson()
            ? new JsonResponse(['two_factor' => false], 200)
            : $redirect;
    }
}
