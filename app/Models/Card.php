<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    protected $fillable = [
        'number',
        'expiration',
        'cvv',
    ];

    protected $casts = [
        'expiration' => 'date',
        'number' => 'encrypted',
        'cvv' => 'encrypted',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
