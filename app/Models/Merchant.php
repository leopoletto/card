<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Merchant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'website',
    ];

    public function cardSwitcherTasks(): HasMany
    {
        return $this->hasMany(CardSwitcherTask::class);
    }
}
