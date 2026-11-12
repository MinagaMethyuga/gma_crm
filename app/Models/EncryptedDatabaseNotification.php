<?php

namespace App\Models;

use Illuminate\Notifications\DatabaseNotification;

/**
 * Database notification whose JSON payload is encrypted at rest.
 *
 * The User model points its `notifications()` relation at this class so every
 * row written through the notification pipeline gets the `encrypted:array`
 * cast applied, including the message previews stored in `data`.
 *
 * @property array<string, mixed> $data
 */
class EncryptedDatabaseNotification extends DatabaseNotification
{
    /** @var array<string, string> */
    protected $casts = [
        'data' => 'encrypted:array',
        'read_at' => 'datetime',
    ];
}
