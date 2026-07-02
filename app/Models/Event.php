<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'cover_image',
        'start_date',
        'end_date',
        'address',
        'hall_name',
        'has_seating_capacity',
        'seating_capacity',
        'event_type',
        'website_link',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'has_seating_capacity' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attendees(): HasMany
    {
        return $this->hasMany(EventAttendee::class);
    }

    public function registeredCount(): int
    {
        return $this->attendees()->where('status', 'registered')->count();
    }

    public function isFull(): bool
    {
        if (!$this->has_seating_capacity || !$this->seating_capacity) {
            return false;
        }
        return $this->registeredCount() >= $this->seating_capacity;
    }
}
