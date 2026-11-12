<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityPollVote extends Model
{
    protected $fillable = [
        'community_poll_id',
        'user_id',
        'option_index',
    ];

    protected $casts = [
        'option_index' => 'integer',
    ];

    public function poll()
    {
        return $this->belongsTo(CommunityPoll::class, 'community_poll_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
