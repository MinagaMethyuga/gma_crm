<?php

namespace App\Http\Controllers;

use App\Concerns\ValidatesJsonChat;
use App\Models\ChatKey;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Stores and serves the public half of each member's E2E chat key.
 *
 * The private key is generated and kept in the browser; only the public key is
 * ever sent here. Keys are readable by accepted friends so a sender can wrap a
 * message for the recipient before it leaves the device.
 */
class ChatKeyController extends Controller
{
    use ValidatesJsonChat;

    public function show(User $user)
    {
        $me = auth()->user();

        abort_unless(
            $me->id === $user->id || $this->areFriends($me, $user),
            403,
        );

        $key = ChatKey::where('user_id', $user->id)->first();

        return response()->json([
            'user_id' => $user->id,
            'public_key' => $key?->public_key,
            'key_version' => $key?->key_version,
        ]);
    }

    public function store(Request $request)
    {
        [$data, $validationError] = $this->validateChat($request, [
            // Base64 SPKI/JWK material is short; cap generously and reject
            // obvious junk early.
            'public_key' => ['required', 'string', 'max:2000', 'regex:/^[A-Za-z0-9+\\/=._-]+$/'],
        ]);

        if ($validationError) {
            return $validationError;
        }

        $existing = ChatKey::where('user_id', auth()->id())->first();

        // Re-publishing the same key is a no-op; a different key is a rotation
        // and must bump the version so peers know which material to use.
        $version = $existing && $existing->public_key !== $data['public_key']
            ? $existing->key_version + 1
            : ($existing?->key_version ?? 1);

        ChatKey::updateOrCreate(
            ['user_id' => auth()->id()],
            ['public_key' => $data['public_key'], 'key_version' => $version],
        );

        return response()->json([
            'ok' => true,
            'key_version' => $version,
        ]);
    }

    private function areFriends(User $a, User $b): bool
    {
        if ($a->id === $b->id) {
            return true;
        }

        return Friendship::where('status', Friendship::STATUS_ACCEPTED)
            ->where(function ($q) use ($a, $b) {
                $q->where('sender_id', $a->id)->where('receiver_id', $b->id);
            })->orWhere(function ($q) use ($a, $b) {
                $q->where('sender_id', $b->id)->where('receiver_id', $a->id);
            })
            ->exists();
    }
}
