<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityGroupMember extends Model
{
    protected $fillable = [
        'community_group_id',
        'user_id',
        'role',
        'joined_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
    ];
}
