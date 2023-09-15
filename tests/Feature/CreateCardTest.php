<?php

namespace Tests\Feature;

use App\Models\Card;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCardTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_new_card(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->assertCount(0, $user->cards);

        $response = $this->post('/api/cards', [
            "number" => "4491662671878085",
            "expiration_year" => today()->addYear()->year,
            "expiration_month" => today()->addYear()->month,
            "cvv" => "977"
        ], ['Accept' => 'Application/Json']);

        $response->assertStatus(200)
            ->assertJson([
            'id' => $user->fresh()->cards->first()->id,
            'last_digits' => 8085,
            'user_id' => $user->id
        ]);

        $this->assertCount(1, $user->fresh()->cards);
    }
}
