<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Purchase;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MasterDataSeeder::class);
    }

    /** @test */
    public function 「購入する」ボタンを押下すると購入が完了する()
    {
        $item = Item::factory()->create();
        $purchase = Purchase::factory()->create([
            'item_id' => $item->id,
            'stripe_session_id' => 'cs_test_123',
            'status' => Purchase::STATUS_PENDING,
        ]);

        $payload = [
            'type' => 'checkout.session.completed',
            'data' => [
                'object' => ['id' => 'cs_test_123'],
            ],
        ];

        $this->postJson(route('webhooks.stripe'), $payload)
            ->assertStatus(200);

        $this->assertEquals(Purchase::STATUS_COMPLETED, $purchase->fresh()->status);
    }
}
