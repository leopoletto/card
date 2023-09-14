<?php

namespace Tests\Feature;

use App\Models\CreditCard;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCreditCardTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_new_credit_card(): void
    {
        $user = User::create([
            'email' => 'acme@example.com',
            'password' => 'password',
        ]);

        $this->actingAs($user);

        $this->assertCount(0, $user->creditCards);

        $response = $this->post('/api/credit-cards', [
            "number" => "4491662671878085",
            "expiration_year" => "2023",
            "expiration_month" => "12",
            "cvv" => "977"
        ]);

        $response->assertStatus(200);

        $this->assertCount(1, $user->fresh()->creditCards);

        $response->assertJson([
            'id' => $user->fresh()->creditCards->first()->id,
            'last_digits' => 8085,
            'user_id' => $user->id
        ]);
    }
}
