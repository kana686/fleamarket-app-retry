<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MasterDataSeeder::class);
    }

    #[Test]
    public function 「購入する」ボタンを押下すると購入が完了する()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $sessionId = 'cs_test_123';
        $purchase = Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'stripe_session_id' => $sessionId,
            'status' => Purchase::STATUS_PENDING,
            'payment_method' => 2,
        ]);

        $payload = [
            'type' => 'checkout.session.completed',
            'data' => [
                'object' => ['id' => $sessionId],
            ],
        ];

        $this->postJson(route('webhooks.stripe'), $payload)
            ->assertStatus(200);

        $this->assertEquals(Purchase::STATUS_COMPLETED, $purchase->fresh()->status);
    }

    #[Test]
    public function コンビニ払いでも支払い完了通知で購入が完了する()
    {
        $sessionId = 'test_convenience_id';
        $purchase = Purchase::factory()->create([
            'payment_method' => 1,
            'status' => Purchase::STATUS_PENDING,
            'stripe_session_id' => $sessionId,
        ]);

        $this->postJson(route('webhooks.stripe'), [
            'type' => 'checkout.session.completed',
            'data' => ['object' => ['id' => $sessionId]],
        ]);

        $this->assertEquals(Purchase::STATUS_PENDING, $purchase->fresh()->status);

        $this->postJson(route('webhooks.stripe'), [
            'type' => 'checkout.session.async_payment_succeeded',
            'data' => ['object' => ['id' => $sessionId]],
        ]);

        $this->assertEquals(Purchase::STATUS_COMPLETED, $purchase->fresh()->status);
    }

    #[Test]
    public function 購入した商品は商品一覧画面にて「sold」と表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Purchase::factory()->create([
            'item_id' => $item->id,
            'user_id' => $user->id,
            'status' => Purchase::STATUS_COMPLETED,
        ]);

        $this->actingAs($user)
            ->get(route('items.index'))
            ->assertSee('Sold');
    }

    #[Test]
    public function 購入した商品がプロフィールの購入した商品一覧に表示される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['name' => '腕時計']);

        Purchase::factory()->create([
            'item_id' => $item->id,
            'user_id' => $user->id,
            'status' => Purchase::STATUS_COMPLETED,
        ]);

        $this->actingAs($user)
            ->get(route('mypage', ['tab' => 'buy']))
            ->assertStatus(200)
            ->assertSee('腕時計');
    }
}
