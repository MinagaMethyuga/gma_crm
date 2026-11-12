<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;

class DirectMessage extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'image',
        'ciphertext',
        'nonce',
        'key_version',
    ];

    protected $casts = [
        'message' => 'encrypted',
        // Defense-in-depth: the E2E ciphertext is already opaque to the server,
        // but a second at-rest layer keeps a raw DB dump useless without APP_KEY.
        'ciphertext' => 'encrypted',
        'key_version' => 'integer',
    ];

    /**
     * Whether this row carries an end-to-end encrypted body rather than a
     * server-readable one. When true the plaintext `message` column is NULL.
     */
    public function isEncrypted(): bool
    {
        return $this->ciphertext !== null && $this->ciphertext !== '';
    }

    public function imageUrl(): ?string
    {
        if ($this->image && Storage::disk('local')->exists($this->image)) {
            return route('member.friends.messages.image', $this);
        }

        return null;
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function reactions(): MorphMany
    {
        return $this->morphMany(MessageReaction::class, 'message');
    }

    protected static function booted(): void
    {
        // Reactions point at a message polymorphically, so the database cannot
        // cascade them for us.
        static::deleting(function (self $message) {
            $message->reactions()->delete();
        });
    }
}
