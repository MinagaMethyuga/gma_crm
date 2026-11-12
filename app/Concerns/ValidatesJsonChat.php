<?php

namespace App\Concerns;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait ValidatesJsonChat
{
    /**
     * Validate an AJAX chat payload, always answering with JSON.
     *
     * This app only renders JSON exceptions for /api/*, so a plain
     * $request->validate() failure would redirect the fetch call to an HTML
     * page instead of returning a 422 the chat component can read.
     *
     * @return array{0: array<string, mixed>, 1: JsonResponse|null}
     */
    private function validateChat(Request $request, array $rules): array
    {
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return [[], response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422)];
        }

        return [$validator->validated(), null];
    }
}
