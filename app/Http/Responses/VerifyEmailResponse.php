<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\VerifyEmailResponse as VerifyEmailResponseContract;
use Symfony\Component\HttpFoundation\Response;

class VerifyEmailResponse implements VerifyEmailResponseContract
{
    public function toResponse($request): Response
    {
        $user = $request->user();

        $redirect = $user && $user->isAdmin()
            ? redirect()->intended('/dashboard?verified=1')
            : redirect()->intended('/member/dashboard?verified=1');

        return $request->wantsJson()
            ? new JsonResponse('', 204)
            : $redirect;
    }
}
