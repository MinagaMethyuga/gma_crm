<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CommunityGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'category',
        'description',
        'slug',
        'logo',
        'is_private',
        'join_method',
        'status',
        'created_by',
        'admin_only_messages',
        'message_cooldown_count',
        'message_cooldown_minutes',
    ];

    protected $casts = [
        'is_private' => 'boolean',
        'admin_only_messages' => 'boolean',
        'message_cooldown_count' => 'integer',
        'message_cooldown_minutes' => 'integer',
    ];

    public const JOIN_OPEN = 'open';

    public const JOIN_REQUEST = 'request';

    public const JOIN_PRIVATE = 'private';

    public const JOIN_METHODS = [
        self::JOIN_OPEN => 'Public (open join)',
        self::JOIN_REQUEST => 'Request to join (approval)',
        self::JOIN_PRIVATE => 'Private (hidden)',
    ];

    /**
     * The permanent slug of the official association group.
     */
    public const SLUG_OFFICIAL = 'gma-official';

    /**
     * The permanent name of the official association group.
     */
    public const NAME_OFFICIAL = 'GMA Official';

    public const CATEGORY_GENERAL = 'general';

    public const CATEGORIES = [
        self::CATEGORY_GENERAL => 'General',
        'networking' => 'Networking',
        'startups' => 'Startups & Founders',
        'technology' => 'Technology',
        'marketing' => 'Marketing & Growth',
        'investments' => 'Investments',
        'events' => 'Events',
        'partners' => 'Partnerships',
        'support' => 'Member Support',
    ];

    public const STATUS_PENDING = 'pending';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_REJECTED = 'rejected';

    public const STATUSES = [
        self::STATUS_PENDING => 'Awaiting approval',
        self::STATUS_APPROVED => 'Published',
        self::STATUS_REJECTED => 'Declined',
    ];

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'community_group_members')
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }

    public function joinRequests()
    {
        return $this->hasMany(CommunityGroupJoinRequest::class);
    }

    public function pendingJoinRequests()
    {
        return $this->joinRequests()->where('status', 'pending');
    }

    public function messages()
    {
        return $this->hasMany(CommunityGroupMessage::class);
    }

    public function polls()
    {
        return $this->hasMany(CommunityPoll::class);
    }

    public function messageReports()
    {
        return $this->hasMany(CommunityMessageReport::class);
    }

    public function getIsPublicAttribute(): bool
    {
        return $this->join_method !== self::JOIN_PRIVATE;
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * The normalised category key, falling back to "general" for uncategorised groups.
     */
    public function categorySlug(): string
    {
        $category = Str::slug((string) $this->category);

        return $category === '' ? self::CATEGORY_GENERAL : $category;
    }

    /**
     * The human readable category name.
     */
    public function categoryLabel(): string
    {
        $slug = $this->categorySlug();

        return self::CATEGORIES[$slug] ?? (Str::headline((string) $this->category) ?: 'General');
    }

    public function logoUrl(): ?string
    {
        if ($this->logo && Storage::disk('public')->exists($this->logo)) {
            return asset('storage/'.$this->logo);
        }

        return null;
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($group) {
            if (empty($group->slug)) {
                $group->slug = Str::slug($group->name);
                $count = static::withTrashed()->where('slug', $group->slug)->count();
                if ($count > 0) {
                    $group->slug .= '-'.($count + 1);
                }
            }
        });
        static::saving(function ($group) {
            $group->is_private = $group->join_method === self::JOIN_PRIVATE;
        });
        static::deleting(function ($group) {
            if ($group->logo && Storage::disk('public')->exists($group->logo)) {
                Storage::disk('public')->delete($group->logo);
            }
        });
    }
}
