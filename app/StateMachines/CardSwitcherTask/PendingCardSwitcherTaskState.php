<?php

namespace App\StateMachines\CardSwitcherTask;

use App\Enums\CardSwitcherTaskStatusEnum;
use Exception;

class PendingCardSwitcherTaskState extends BaseCardSwitcherTaskState
{
    public function fail(): void
    {
        $this->cardSwitcherTask->fill([
            'status' => CardSwitcherTaskStatusEnum::Failed->value
        ])->save();
    }

    public function finalize(): void
    {
        $this->cardSwitcherTask->fill([
            'status' => CardSwitcherTaskStatusEnum::Finished->value
        ])->save();
    }
}
