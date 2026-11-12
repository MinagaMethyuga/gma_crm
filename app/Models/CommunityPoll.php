<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityPoll extends Model
{
    protected $fillable = [
        'community_group_id',
        'created_by',
        'question',
        'options',
        'allow_multiple',
        'closes_at',
    ];

    protected $casts = [
        'options' => 'array',
        'allow_multiple' => 'boolean',
        'closes_at' => 'datetime',
    ];

    public function communityGroup()
    {
        return $this->belongsTo(CommunityGroup::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function votes()
    {
        return $this->hasMany(CommunityPollVote::class);
    }

    public function isClosed(): bool
    {
        return $this->closes_at !== null && $this->closes_at->isPast();
    }
}
