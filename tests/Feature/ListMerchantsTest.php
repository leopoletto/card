<?php

namespace Tests\Feature;

use App\Models\Merchant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListMerchantsTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_a_list_of_merchants()
    {
        $user = User::create([
            'email' => 'acme@example.com',
            'password' => 'password',
        ]);

        $this->actingAs($user);

        $this->assertDatabaseCount(Merchant::class, 0);

        $merchants = Merchant::factory(10)->create();

        $response = $this->get('/api/merchants');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => $merchants->toArray()
        ]);
    }
}
