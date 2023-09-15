<?php

namespace App\Models;

use App\Enums\CardSwitcherTaskStatusEnum;
use App\StateMachines\CardSwitcherTask\CardSwitcherTaskStateContract;
use App\StateMachines\CardSwitcherTask\FailCardSwitcherTaskState;
use App\StateMachines\CardSwitcherTask\FinalizeCardSwitcherTaskState;
use App\StateMachines\CardSwitcherTask\PendingCardSwitcherTaskState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class CardSwitcherTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'merchant_id',
        'card_id',
    ];

    protected $attributes = [
        'previous_card_id' => null,
        'status' => CardSwitcherTaskStatusEnum::Pending->value
    ];

    protected static function booting(): void
    {
        parent::booting();

        self::created(function (CardSwitcherTask $task) {
            $previousTask = CardSwitcherTask::query()
                ->with('card')
                ->whereNot('id', $task->id)
                ->where('merchant_id', $task->merchant_id)
                ->where('card_id', $task->card_id)
                ->orderByDesc('created_at')
                ->first();

            if ($previousTask) {
                $task->previousCard()->associate($previousTask->card)->save();
            }
        });
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    public function previousCard(): BelongsTo
    {
        return $this->belongsTo(Card::class, 'previous_card_id');
    }

    public function state(): CardSwitcherTaskStateContract
    {
        return match ($this->status) {
            CardSwitcherTaskStatusEnum::Pending->value => new PendingCardSwitcherTaskState($this),
            CardSwitcherTaskStatusEnum::Finished->value => new FinalizeCardSwitcherTaskState($this),
            CardSwitcherTaskStatusEnum::Failed->value => new FailCardSwitcherTaskState($this),
            default => throw new UnprocessableEntityHttpException('Invalid status'),
        };
    }
}
