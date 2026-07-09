<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MasterDataSeeder::class);
    }

    #[Test]
    public function 住所を変更するとセッションに保存されて購入画面に反映される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)
            ->get(route('purchases.address.edit', $item->id))
            ->assertStatus(200);

        $response = $this->actingAs($user)
            ->patch(route('purchases.address.update', $item->id), [
                'post_code' => '999-9999',
                'address' => '大阪府大阪市',
                'building' => 'テストマンション',
            ]);

        $response->assertRedirect(route('purchases.checkout', $item->id));

        $this->assertEquals('999-9999', session('edited_post_code'));

        $this->actingAs($user)
            ->get(route('purchases.checkout', $item->id))
            ->assertSee('999-9999')
            ->assertSee('大阪府大阪市');
    }

    #[Test]
    public function 購入した商品に送付先住所が紐づいて登録される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('purchases.store', $item->id), [
                'payment_method' => 1,
                'item_id' => $item->id,
                'post_code' => '999-9999',
                'address' => '大阪府大阪市',
                'building' => 'テストマンション',
            ]);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'post_code' => '999-9999',
            'address' => '大阪府大阪市',
            'building' => 'テストマンション',
        ]);
    }
}
