<?php

namespace App\StateMachines\CardSwitcherTask;

use App\Models\CardSwitcherTask;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

abstract class BaseCardSwitcherTaskState implements CardSwitcherTaskStateContract
{
    public function __construct(
        protected CardSwitcherTask $cardSwitcherTask
    )
    {
    }

    public function finalize()
    {
        throw new UnprocessableEntityHttpException('Not allowed to change the status to finalized');
    }

    public function fail()
    {
        throw new UnprocessableEntityHttpException('Not allowed to change the status to failed');
    }

    public function pending()
    {
        throw new UnprocessableEntityHttpException('Not allowed to change the status to pending');
    }
}
