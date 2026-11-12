<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MessageReaction extends Model
{
    /**
     * The only reactions a member can leave. Keeping this a fixed set means the
     * client cannot invent values and the picker stays predictable.
     */
    public const EMOJI = ['👍', '❤️', '😂', '🎉', '😮', '😢', '🔥', '👏'];

    /** Variation selectors render differently across platforms, so ignore them. */
    public const VARIATION_SELECTOR = "\u{FE0F}";

    protected $fillable = [
        'message_type',
        'message_id',
        'user_id',
        'emoji',
    ];

    public function message(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Strips decoration so "❤️" and "❤" are treated as the same reaction. */
    public static function normalise(?string $emoji): ?string
    {
        $emoji = trim((string) $emoji);

        return $emoji === '' ? null : str_replace(self::VARIATION_SELECTOR, '', $emoji);
    }

    /** Returns the whitelist entry matching $emoji, or null when unsupported. */
    public static function canonical(?string $emoji): ?string
    {
        $needle = self::normalise($emoji);
        if ($needle === null) {
            return null;
        }

        foreach (self::EMOJI as $allowed) {
            if (self::normalise($allowed) === $needle) {
                return $allowed;
            }
        }

        return null;
    }

    /** Sort key so a message's reactions always render in the same order. */
    public static function sortKey(?string $emoji): int
    {
        $needle = self::normalise($emoji);

        foreach (self::EMOJI as $index => $allowed) {
            if (self::normalise($allowed) === $needle) {
                return $index;
            }
        }

        return count(self::EMOJI);
    }
}
