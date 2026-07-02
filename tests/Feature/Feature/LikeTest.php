<?php

namespace Tests\Feature\Feature;

use App\Models\Item;
use App\Models\Mylist;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MasterDataSeeder::class);
    }

    /** @test */
    public function いいねアイコン押下でログインユーザーはいいねを登録できる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)
            ->postJson(route('like.store', $item->id))
            ->assertStatus(200)
            ->assertJson(['status' => 'liked']);

        $this->assertDatabaseHas('mylists', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    /** @test */
    public function いいね済みのアイコンは色が変化する()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        Mylist::create(['user_id' => $user->id, 'item_id' => $item->id]);

        $this->actingAs($user)
            ->get(route('items.show', $item->id))
            ->assertSee('is-liked')
            ->assertSee('logo-heart-pink.png');
    }

    /** @test */
    public function 再度いいねアイコン押下でログインユーザーはいいねを解除できる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        Mylist::create(['user_id' => $user->id, 'item_id' => $item->id]);

        $this->actingAs($user)
            ->deleteJson(route('like.destroy', $item->id))
            ->assertStatus(200)
            ->assertJson(['status' => 'unliked']);

        $this->assertDatabaseMissing('mylists', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}
