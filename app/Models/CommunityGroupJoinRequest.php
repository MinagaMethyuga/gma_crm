<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityGroupJoinRequest extends Model
{
    protected $fillable = [
        'community_group_id',
        'user_id',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public const STATUS_PENDING = 'pending';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_DECLINED = 'declined';

    public function communityGroup()
    {
        return $this->belongsTo(CommunityGroup::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
