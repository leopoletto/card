<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Card extends Model
{
    use HasFactory;

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

    public function cardSwitcherTasks(): HasMany
    {
        return $this->hasMany(CardSwitcherTask::class);
    }
}
