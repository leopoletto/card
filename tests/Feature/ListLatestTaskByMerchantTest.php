<?php

namespace Tests\Feature;

use App\Enums\CardSwitcherTaskStatusEnum;
use App\Models\Card;
use App\Models\CardSwitcherTask;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListLatestTaskByMerchantTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_the_latest_tasks_by_merchant_for_the_auth_user()
    {
        $user = User::factory()->create();

        $tasks = CardSwitcherTask::factory(15)
            ->for(Card::factory()->for($user))
            ->sequence(
                ['status' => CardSwitcherTaskStatusEnum::Pending->value],
                ['status' => CardSwitcherTaskStatusEnum::Finished->value],
                ['status' => CardSwitcherTaskStatusEnum::Failed->value]
            )
            ->create();

        $this->actingAs($user);

        $response = $this->get('/api/latest-card-switcher-tasks', [
            'Accept' => 'Application/Json'
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(5);
        $response->assertJsonStructure([
            '*' => [
                'merchant_id',
                'card_id',
                'created',
                'status',
                'merchant' => [
                    'id', 'name', 'website', 'created_at', 'updated_at'
                ],
                'card' => [
                    'id', 'expiration', 'cvv', 'user_id', 'created_at', 'updated_at'
                ],
                'previous_card'
            ],
        ]);
    }
}
