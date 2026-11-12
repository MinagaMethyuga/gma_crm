<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatKey extends Model
{
    protected $table = 'user_chat_keys';

    protected $fillable = [
        'user_id',
        'public_key',
        'key_version',
    ];

    protected $casts = [
        // The public key is opaque base64 material; keep it a plain string.
        'public_key' => 'string',
        'key_version' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
