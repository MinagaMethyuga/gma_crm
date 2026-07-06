<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Symfony\Component\HttpFoundation\Response;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request): Response
    {
        if ($pendingPlanId = session()->pull('pending_plan_id')) {
            return $request->wantsJson()
                ? new JsonResponse(['two_factor' => false], 201)
                : redirect()->route('checkout.init', ['plan' => $pendingPlanId]);
        }

        $user = $request->user();

        if ($user && $user->current_team_id) {
            return $request->wantsJson()
                ? new JsonResponse(['two_factor' => false], 201)
                : redirect()->route('member.dashboard');
        }

        return $request->wantsJson()
            ? new JsonResponse(['two_factor' => false], 201)
            : redirect()->route('pricing');
    }
}
