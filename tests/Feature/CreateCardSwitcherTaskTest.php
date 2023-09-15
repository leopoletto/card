<?php

namespace Tests\Feature;

use App\Enums\CardSwitcherTaskStatusEnum;
use App\Models\Card;
use App\Models\CardSwitcherTask;
use App\Models\Merchant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCardSwitcherTaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_card_switcher_task(): void
    {
        $card = Card::factory()->create();
        $merchant = Merchant::factory()->create();

        $this->actingAs($card->user);

        $response = $this->post('/api/card-switcher-tasks', [
            'card_id' => $card->id,
            'merchant_id' => $merchant->id
        ], ['Accept' => 'Application/Json']);

        $response->assertCreated()
            ->assertJson($card->fresh()->cardSwitcherTasks->first()->toArray());
    }

    public function test_finalize_card_switcher_task(): void
    {
        $cardSwitcherTask = CardSwitcherTask::factory()->create();
        $this->actingAs($cardSwitcherTask->card->user);

        $response = $this->patch('/api/card-switcher-tasks/' . $cardSwitcherTask->id . '/finalize', [], [
            'Accept' => 'Application/Json'
        ]);

        $response->assertNoContent();

        $this->assertSame(CardSwitcherTaskStatusEnum::Finished->value, $cardSwitcherTask->fresh()->status);
    }

    public function test_fail_card_switcher_task(): void
    {
        $cardSwitcherTask = CardSwitcherTask::factory()->create();
        $this->actingAs($cardSwitcherTask->card->user);

        $response = $this->patch('/api/card-switcher-tasks/' . $cardSwitcherTask->id . '/fail', [], [
            'Accept' => 'Application/Json'
        ]);

        $response->assertNoContent();

        $this->assertSame(CardSwitcherTaskStatusEnum::Failed->value, $cardSwitcherTask->fresh()->status);
    }

    public function test_card_switcher_task_state_is_properly_handled(): void
    {
        $cardSwitcherTask = CardSwitcherTask::factory()->failed()->create();
        $this->actingAs($cardSwitcherTask->card->user);

        $response = $this->patch('/api/card-switcher-tasks/' . $cardSwitcherTask->id . '/finalize', [], [
            'Accept' => 'Application/Json'
        ]);

        $response->assertUnprocessable()
            ->assertJsonFragment(['message' => 'Not allowed to change the status to finalized']);

        $response = $this->patch('/api/card-switcher-tasks/' . $cardSwitcherTask->id . '/fail', [], [
            'Accept' => 'Application/Json'
        ]);

        $response->assertUnprocessable()
            ->assertJsonFragment(['message' => 'Not allowed to change the status to failed']);
    }
}
