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
