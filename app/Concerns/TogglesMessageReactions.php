<?php

namespace App\Concerns;

use App\Models\MessageReaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

trait TogglesMessageReactions
{
    /**
     * Adds the reaction when the member has not left it yet and removes it
     * when they have, which is what a click on a pill is expected to do.
     *
     * @return array{active: bool, reactions: array<int, array<string, mixed>>}
     */
    protected function toggleReactionOn(Model $message, ?string $emoji): array
    {
        $canonical = MessageReaction::canonical($emoji);

        if ($canonical === null) {
            abort(422, 'That reaction is not available.');
        }

        $existing = fn () => MessageReaction::query()
            ->where('message_type', $message->getMorphClass())
            ->where('message_id', $message->getKey())
            ->where('user_id', auth()->id())
            ->where('emoji', $canonical);

        $active = true;

        if ($existing()->exists()) {
            $existing()->delete();
            $active = false;
        } else {
            try {
                $existing()->create([
                    'message_type' => $message->getMorphClass(),
                    'message_id' => $message->getKey(),
                    'user_id' => auth()->id(),
                    'emoji' => $canonical,
                ]);
            } catch (QueryException) {
                // Two tabs reacted at once and the unique index stored it
                // first, so this member's reaction is present after all.
                $active = true;
            }
        }

        return [
            'active' => $active,
            'reactions' => $this->reactionPayload($message),
        ];
    }

    /**
     * Clears reactions for messages removed by a bulk delete. Model deletion
     * events do not fire for query-builder deletes, so those paths call this.
     */
    protected function purgeReactionsFor(string $messageType, iterable $messageIds): int
    {
        $ids = collect($messageIds)->filter()->unique()->values();

        if ($ids->isEmpty()) {
            return 0;
        }

        return MessageReaction::query()
            ->where('message_type', $messageType)
            ->whereIntegerInRaw('message_id', $ids)
            ->delete();
    }

    /**
     * Collapses a message's reaction rows into one entry per emoji.
     *
     * @return array<int, array{emoji: string, count: int, mine: bool, names: array<int, string>>}
     */
    protected function reactionPayload(Model $message, ?int $userId = null): array
    {
        $userId ??= auth()->id();

        $message->loadMissing('reactions.user:id,name');

        /** @var Collection<int, MessageReaction> $reactions */
        $reactions = $message->reactions ?? collect();

        if ($reactions->isEmpty()) {
            return [];
        }

        return $reactions
            ->groupBy('emoji')
            ->map(fn (Collection $rows, string $emoji) => [
                'emoji' => $emoji,
                'count' => $rows->count(),
                'mine' => $rows->contains(fn (MessageReaction $r) => (int) $r->user_id === (int) $userId),
                // Enough for the tooltip without inflating every message payload.
                'names' => $rows->take(10)
                    ->map(fn (MessageReaction $r) => $r->user?->name ?? 'Member')
                    ->values()
                    ->all(),
            ])
            ->sortBy(fn (array $row) => MessageReaction::sortKey($row['emoji']))
            ->values()
            ->all();
    }
}
