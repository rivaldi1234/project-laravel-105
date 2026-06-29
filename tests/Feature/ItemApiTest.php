<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat category dengan id 1
        Category::factory()->create([
            'id'   => 1,
            'name' => 'Electronics',
        ]);

        // Buat user biasa
        $this->user = User::factory()->create([
            'role' => 'user',
        ]);

        // Buat user admin
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);
    }

    /**
     * Test 1: Guest tidak bisa mengakses daftar items (harus 401)
     */
    public function test_guest_cannot_access_items(): void
    {
        $this->getJson('/api/v1/items')
            ->assertStatus(401);
    }

    /**
     * Test 2: User biasa bisa melihat daftar items (harus 200)
     */
    public function test_user_can_list_items(): void
    {
        $token = $this->user->createToken('api-token')->plainTextToken;

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/v1/items')
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data',
                'message',
            ]);
    }

    /**
     * Test 3: User biasa TIDAK bisa menghapus item (harus 403)
     */
    public function test_user_cannot_delete_item(): void
    {
        $token = $this->user->createToken('api-token')->plainTextToken;

        $this->deleteJson(
            '/api/v1/items/1',
            [],
            ['Authorization' => 'Bearer ' . $token]
        )->assertStatus(403);
    }

    /**
     * Test 4: Admin BISA menghapus item (harus 204)
     */
    public function test_admin_can_delete_item(): void
    {
        // Buat item dengan category_id = 1
        $item  = Item::factory()->create(['category_id' => 1]);
        $token = $this->admin->createToken('api-token')->plainTextToken;

        $this->deleteJson(
            '/api/v1/items/' . $item->id,
            [],
            ['Authorization' => 'Bearer ' . $token]
        )->assertStatus(204);
    }
}