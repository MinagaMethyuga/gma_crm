<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityMessageReport extends Model
{
    protected $fillable = [
        'community_group_id',
        'community_group_message_id',
        'reported_user_id',
        'reporter_id',
        'reason',
        'details',
        'message_snapshot',
        'status',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'details' => 'encrypted',
        'message_snapshot' => 'encrypted',
    ];

    public const STATUS_PENDING = 'pending';

    public const STATUS_REMOVED = 'removed';

    public const STATUS_DISMISSED = 'dismissed';

    public const REASON_SPAM = 'spam';

    public const REASON_HARASSMENT = 'harassment';

    public const REASON_HATE = 'hate';

    public const REASON_INAPPROPRIATE = 'inappropriate';

    public const REASON_MISINFORMATION = 'misinformation';

    public const REASON_OTHER = 'other';

    public const REASONS = [
        self::REASON_SPAM => 'Spam or advertising',
        self::REASON_HARASSMENT => 'Harassment or bullying',
        self::REASON_HATE => 'Hate speech',
        self::REASON_INAPPROPRIATE => 'Inappropriate content',
        self::REASON_MISINFORMATION => 'Misinformation',
        self::REASON_OTHER => 'Other',
    ];

    public function communityGroup()
    {
        return $this->belongsTo(CommunityGroup::class);
    }

    public function message()
    {
        return $this->belongsTo(CommunityGroupMessage::class, 'community_group_message_id');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reportedUser()
    {
        return $this->belongsTo(User::class, 'reported_user_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function reasonLabel(): string
    {
        return self::REASONS[$this->reason] ?? ucfirst((string) $this->reason);
    }
}
