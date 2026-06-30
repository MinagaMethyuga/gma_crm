<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Passkeys\Contracts\PasskeyLoginResponse as PasskeyLoginResponseContract;
use Symfony\Component\HttpFoundation\Response;

class PasskeyLoginResponse implements PasskeyLoginResponseContract
{
    public function toResponse($request): Response
    {
        $user = $request->user();

        $redirect = $user && $user->isAdmin()
            ? redirect()->intended('/dashboard')
            : redirect()->intended('/member/dashboard');

        return $request->wantsJson()
            ? new JsonResponse(['redirect' => $redirect->getTargetUrl()], 200)
            : $redirect;
    }
}
