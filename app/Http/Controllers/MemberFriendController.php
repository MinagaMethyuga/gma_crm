<?php

namespace App\Http\Controllers;

use App\Concerns\TogglesMessageReactions;
use App\Concerns\ValidatesJsonChat;
use App\Models\DirectMessage;
use App\Models\Friendship;
use App\Models\User;
use App\Notifications\DirectMessageNotification;
use App\Services\Translation\MessageTranslator;
use Illuminate\Http\Request;

class MemberFriendController extends Controller
{
    use TogglesMessageReactions;
    use ValidatesJsonChat;

    public function messages(User $user)
    {
        abort_unless($this->areFriends(auth()->user(), $user), 403);

        $senderId = auth()->id();

        $messages = DirectMessage::where(function ($q) use ($senderId, $user) {
            $q->where('sender_id', $senderId)->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($senderId, $user) {
            $q->where('sender_id', $user->id)->where('receiver_id', $senderId);
        })
            ->with(['sender', 'reactions.user:id,name'])
            ->latest('id')
            ->take(200)
            ->get()
            ->sortBy('id')
            ->values()
            ->map(fn ($m) => $this->payload($m));

        return response()->json(['messages' => $messages]);
    }

    public function sendMessage(User $user, Request $request)
    {
        abort_unless($this->areFriends(auth()->user(), $user), 403);

        [$data, $validationError] = $this->validateChat($request, [
            'message' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,gif,webp', 'max:5120'],
            // Client-side E2E payload. The body is base64 AES-GCM ciphertext the
            // server cannot read; the nonce is its paired IV. When present the
            // plaintext `message` field must be empty.
            'ciphertext' => ['nullable', 'string', 'max:20000'],
            'nonce' => ['nullable', 'string', 'max:64'],
            'key_version' => ['nullable', 'integer', 'min:1', 'max:1000000'],
        ]);

        if ($validationError) {
            return $validationError;
        }

        $messageText = $this->sanitiseText($data['message'] ?? '') ?? '';
        $image = $request->file('image');
        $ciphertext = $data['ciphertext'] ?? null;

        if ($messageText === '' && ! $image && ! $ciphertext) {
            return response()->json(['message' => 'The message must have text or an image.'], 422);
        }

        if ($ciphertext !== null && $messageText !== '') {
            return response()->json(['message' => 'An encrypted message cannot also carry plaintext.'], 422);
        }

        $message = DirectMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $user->id,
            // E2E rows keep the server-readable column empty on purpose.
            'message' => $ciphertext !== null ? null : $messageText,
            'ciphertext' => $ciphertext,
            'nonce' => $ciphertext !== null ? ($data['nonce'] ?? null) : null,
            'key_version' => $ciphertext !== null ? ($data['key_version'] ?? null) : null,
            // Chat attachments live on the private disk and are served only
            // through the access-checked stream route, never the public webroot.
            'image' => $image ? $image->store('direct-messages', 'local') : null,
        ]);

        if ($message->receiver_id !== $message->sender_id) {
            $user->notify(new DirectMessageNotification(auth()->user(), $message));
        }

        return response()->json(['message' => $this->payload($message)], 201);
    }

    public function deleteMessages(User $user, Request $request)
    {
        abort_unless($this->areFriends(auth()->user(), $user), 403);

        [$data, $validationError] = $this->validateChat($request, [
            'ids' => ['required', 'array', 'min:1', 'max:50'],
            'ids.*' => ['integer', 'distinct'],
        ]);

        if ($validationError) {
            return $validationError;
        }

        $query = DirectMessage::where('sender_id', auth()->id())
            ->where('receiver_id', $user->id)
            ->whereIntegerInRaw('id', $data['ids']);

        $this->purgeReactionsFor(DirectMessage::class, $query->pluck('id'));

        $deleted = $query->delete();

        return response()->json(['deleted' => $deleted]);
    }

    public function toggleReaction(User $user, DirectMessage $message, Request $request)
    {
        abort_unless($this->areFriends(auth()->user(), $user), 403);
        $this->assertMessageInConversation($user, $message);

        $result = $this->toggleReactionOn($message, $request->input('emoji'));

        return response()->json([
            'active' => $result['active'],
            'reactions' => $result['reactions'],
        ]);
    }

    private function areFriends(User $a, User $b): bool
    {
        if ($a->id === $b->id) {
            return false;
        }

        return Friendship::where('status', Friendship::STATUS_ACCEPTED)
            ->where(function ($q) use ($a, $b) {
                $q->where('sender_id', $a->id)->where('receiver_id', $b->id);
            })->orWhere(function ($q) use ($a, $b) {
                $q->where('sender_id', $b->id)->where('receiver_id', $a->id);
            })
            ->exists();
    }

    /**
     * Strip any markup and control characters before a message body is stored.
     * The client renders with textContent, so this is defense-in-depth against
     * a future template that trusts the stored string as HTML.
     */
    private function sanitiseText(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim(strip_tags($value));
        $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value);

        return $value === '' ? null : $value;
    }

    /** Keeps a member from reacting to a message from a conversation they are not in. */
    private function assertMessageInConversation(User $user, DirectMessage $message): void
    {
        $mine = auth()->id();

        $isOurs = ($message->sender_id === $mine && $message->receiver_id === $user->id)
            || ($message->sender_id === $user->id && $message->receiver_id === $mine);

        abort_unless($isOurs, 404);
    }

    private function payload(DirectMessage $message): array
    {
        // End-to-end rows intentionally skip the server-side translator: the
        // server has no plaintext to translate. The client decrypts and (if it
        // wants) translates locally.
        $plain = $message->isEncrypted() ? null : $message->message;

        return [
            'id' => $message->id,
            'message' => $message->isEncrypted()
                ? null
                : app(MessageTranslator::class)->translateMessage($plain ?? '', null, auth()->user()?->preferred_language),
            'ciphertext' => $message->ciphertext,
            'nonce' => $message->nonce,
            'key_version' => $message->key_version,
            'encrypted' => $message->isEncrypted(),
            // Whose public key decrypts this row: the other participant.
            'encrypted_peer_id' => $message->isEncrypted()
                ? ($message->sender_id === auth()->id() ? $message->receiver_id : $message->sender_id)
                : null,
            'image_url' => $message->imageUrl(),
            'user_name' => $message->sender?->name ?? 'Member',
            'avatar_url' => $message->sender?->avatarUrl() ?: null,
            'is_own' => $message->sender_id === auth()->id(),
            'time' => $message->created_at?->format('g:i A'),
            'reactions' => $this->reactionPayload($message),
        ];
    }
}
