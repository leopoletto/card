<?php

namespace App\Http\Controllers;

use App\Models\CardSwitcherTask;

class UpdateCardSwitcherTaskStatusController extends Controller
{
    public function finalize(CardSwitcherTask $cardSwitcherTask)
    {
        $cardSwitcherTask->state()->finalize();
    }

    public function fail(CardSwitcherTask $cardSwitcherTask)
    {
        $cardSwitcherTask->state()->fail();
    }
}
