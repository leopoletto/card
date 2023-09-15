<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCardSwitcherTaskRequest;
use App\Models\CardSwitcherTask;

class CreateCardSwitcherTaskController extends Controller
{
    public function __invoke(CreateCardSwitcherTaskRequest $request): CardSwitcherTask
    {
        return CardSwitcherTask::create([
            'card_id' => $request->validated('card_id'),
            'merchant_id' => $request->validated('merchant_id'),
        ]);
    }
}
