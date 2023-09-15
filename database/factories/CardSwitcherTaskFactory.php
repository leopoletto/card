<?php

namespace Database\Factories;

use App\Enums\CardSwitcherTaskStatusEnum;
use App\Models\Card;
use App\Models\CardSwitcherTask;
use App\Models\Merchant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CardSwitcherTaskFactory extends Factory
{
    protected $model = CardSwitcherTask::class;

    public function definition(): array
    {
        return [
            'status' => CardSwitcherTaskStatusEnum::Pending->value,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'merchant_id' => Merchant::factory(),
            'card_id' => Card::factory(),
            'previous_card_id' => null,
        ];
    }

    public function failed(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => CardSwitcherTaskStatusEnum::Failed->value,
            ];
        });
    }

    public function finished(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => CardSwitcherTaskStatusEnum::Finished->value,
            ];
        });
    }

    public function withPreviousCard(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => Card::factory(),
            ];
        });
    }
}
