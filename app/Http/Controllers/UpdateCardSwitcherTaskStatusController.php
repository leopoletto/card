<?php

namespace App\Http\Controllers;

use App\Models\CardSwitcherTask;
use Illuminate\Http\Response;

class UpdateCardSwitcherTaskStatusController extends Controller
{
    public function finalize(CardSwitcherTask $cardSwitcherTask): Response
    {
        $cardSwitcherTask->state()->finalize();
        return response()->noContent();

    }

    public function fail(CardSwitcherTask $cardSwitcherTask): Response
    {
        $cardSwitcherTask->state()->fail();
        return response()->noContent();
    }
}
