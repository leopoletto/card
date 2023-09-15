<?php

namespace App\Http\Controllers;

use App\Enums\CardSwitcherTaskStatusEnum;
use App\Models\CardSwitcherTask;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListLatestTaskByMerchantController extends Controller
{
    public function __invoke(Request $request): Collection
    {
        $user = $request->user();

        return  CardSwitcherTask::query()
            ->select(['merchant_id', 'card_id', DB::raw('max(created_at) AS created'), 'status'])
            ->where('status', CardSwitcherTaskStatusEnum::Finished->value)
            ->whereHas('card', fn(Builder $query) => $query->where('user_id', $user->id))
            ->with('merchant', 'card', 'previousCard')
            ->groupBy(['merchant_id', 'card_id', 'status'])
            ->get();
    }
}
