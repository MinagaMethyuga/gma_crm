<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_hash',
        'source_language',
        'target_language',
        'source_text',
        'translated_text',
    ];

    protected $casts = [
        'source_text' => 'encrypted',
        'translated_text' => 'encrypted',
    ];
}
