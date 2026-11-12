<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CommunityGroupMessage extends Model
{
    protected $fillable = [
        'community_group_id',
        'user_id',
        'message',
        'image',
        'reply_to_id',
        'poll_id',
        'type',
        'pinned_at',
        'pinned_by',
    ];

    protected $casts = [
        'pinned_at' => 'datetime',
        'message' => 'encrypted',
    ];

    public const TYPE_TEXT = 'text';

    public const TYPE_POLL = 'poll';

    public function imageUrl(): ?string
    {
        // Private disk: the raw path is useless without going through the
        // access-checked stream route, which verifies group membership.
        if ($this->image && Storage::disk('local')->exists($this->image)) {
            return route('member.community.messages.image', $this);
        }

        return null;
    }

    public function communityGroup()
    {
        return $this->belongsTo(CommunityGroup::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replyTo()
    {
        return $this->belongsTo(self::class, 'reply_to_id');
    }

    public function replies()
    {
        return $this->hasMany(self::class, 'reply_to_id');
    }

    public function poll()
    {
        return $this->belongsTo(CommunityPoll::class, 'poll_id');
    }

    public function pinnedBy()
    {
        return $this->belongsTo(User::class, 'pinned_by');
    }

    public function reports()
    {
        return $this->hasMany(CommunityMessageReport::class, 'community_group_message_id');
    }

    public function reactions()
    {
        return $this->morphMany(MessageReaction::class, 'message');
    }

    public function isPinned(): bool
    {
        return $this->pinned_at !== null;
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
