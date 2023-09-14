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
        $user = User::create([
            'email' => 'acme@example.com',
            'password' => 'password',
        ]);

        $this->actingAs($user);

        $this->assertCount(0, $user->cards);

        $response = $this->post('/api/credit-cards', [
            "number" => "4491662671878085",
            "expiration_year" => today()->addYear()->year,
            "expiration_month" => today()->addYear()->month,
            "cvv" => "977"
        ]);

        $response->assertStatus(200);

        $this->assertCount(1, $user->fresh()->cards);

        $response->assertJson([
            'id' => $user->fresh()->cards->first()->id,
            'last_digits' => 8085,
            'user_id' => $user->id
        ]);
    }
}
