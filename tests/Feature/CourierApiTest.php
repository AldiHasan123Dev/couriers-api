<?php

namespace Tests\Feature;

use App\Models\Courier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourierApiTest extends TestCase
{
    use RefreshDatabase;

    private function courierData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Budiono Hadi Agung',
            'email' => 'budiono@example.com',
            'phone' => '081234567890',
            'address' => 'Surabaya',
            'level' => 2,
            'is_active' => true,
        ], $overrides);
    }

    public function test_store_saves_courier_to_database(): void
    {
        $response = $this->postJson(
            '/api/couriers',
            $this->courierData()
        );

        $response->assertCreated()
            ->assertJsonPath('data.name', 'Budiono Hadi Agung');

        $this->assertDatabaseHas('couriers', [
            'email' => 'budiono@example.com',
            'name' => 'Budiono Hadi Agung',
            'level' => 2,
        ]);
    }

    public function test_store_rejects_invalid_data(): void
    {
        $response = $this->postJson('/api/couriers', [
            'name' => '',
            'email' => 'email-tidak-valid',
            'phone' => '',
            'level' => 6,
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name',
                'email',
                'phone',
                'level',
            ]);

        $this->assertDatabaseCount('couriers', 0);
    }

    public function test_index_returns_paginated_couriers(): void
    {
        Courier::create($this->courierData([
            'email' => 'zaki@example.com',
            'name' => 'Zaki',
        ]));

        Courier::create($this->courierData([
            'email' => 'andi@example.com',
            'name' => 'Andi',
        ]));

        $response = $this->getJson('/api/couriers?per_page=1');

        $response->assertOk()
            ->assertJsonPath('per_page', 1)
            ->assertJsonPath('total', 2)
            ->assertJsonPath('data.0.name', 'Andi');
    }

    public function test_search_matches_multiple_name_keywords(): void
    {
        Courier::create($this->courierData([
            'email' => 'budiono@example.com',
            'name' => 'Budiono Hadi Agung',
        ]));

        Courier::create($this->courierData([
            'email' => 'budianto@example.com',
            'name' => 'Budianto Santoso',
        ]));

        $response = $this->getJson(
            '/api/couriers?search=budi+agung'
        );

        $response->assertOk()
            ->assertJsonPath('total', 1)
            ->assertJsonPath('data.0.name', 'Budiono Hadi Agung');
    }

    public function test_level_filter_returns_only_requested_levels(): void
    {
        Courier::create($this->courierData([
            'email' => 'level1@example.com',
            'level' => 1,
        ]));

        Courier::create($this->courierData([
            'email' => 'level2@example.com',
            'level' => 2,
        ]));

        Courier::create($this->courierData([
            'email' => 'level3@example.com',
            'level' => 3,
        ]));

        $response = $this->getJson('/api/couriers?level=2,3');

        $response->assertOk()
            ->assertJsonPath('total', 2);

        $this->assertEqualsCanonicalizing(
            [2, 3],
            array_column($response->json('data'), 'level')
        );
    }

    public function test_show_returns_courier_data(): void
    {
        $courier = Courier::create($this->courierData());

        $this->getJson("/api/couriers/{$courier->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $courier->id)
            ->assertJsonPath('data.email', 'budiono@example.com')
            ->assertJsonPath('data.level', 2);
    }

    public function test_update_changes_courier_in_database(): void
    {
        $courier = Courier::create($this->courierData());

        $response = $this->putJson(
            "/api/couriers/{$courier->id}",
            [
                'name' => 'Budiono Agung',
                'level' => 3,
            ]
        );

        $response->assertOk()
            ->assertJsonPath('data.name', 'Budiono Agung')
            ->assertJsonPath('data.level', 3);

        $this->assertDatabaseHas('couriers', [
            'id' => $courier->id,
            'name' => 'Budiono Agung',
            'level' => 3,
            'email' => 'budiono@example.com',
        ]);
    }

    public function test_update_rejects_level_outside_range(): void
    {
        $courier = Courier::create($this->courierData());

        $this->putJson("/api/couriers/{$courier->id}", [
            'level' => 6,
        ])->assertUnprocessable()
          ->assertJsonValidationErrors(['level']);

        $this->assertDatabaseHas('couriers', [
            'id' => $courier->id,
            'level' => 2,
        ]);
    }

    public function test_destroy_deletes_courier_from_database(): void
    {
        $courier = Courier::create($this->courierData());

        $this->deleteJson("/api/couriers/{$courier->id}")
            ->assertOk()
            ->assertJson([
                'message' => 'Data kurir berhasil dihapus.',
            ]);

        $this->assertDatabaseMissing('couriers', [
            'id' => $courier->id,
        ]);
    }
}
