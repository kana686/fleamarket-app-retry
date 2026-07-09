<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MasterDataSeeder::class);
    }

    #[Test]
    public function ログインユーザーはコメントを送信できる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)
            ->post(route('comments.store', $item->id), [
                'content' => '購入を検討しています',
            ])
            ->assertStatus(302)
            ->assertSessionHas('success', 'コメントを投稿しました。');

        $this->assertDatabaseHas('comments', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'content' => '購入を検討しています',
        ]);
    }

    #[Test]
    public function ログイン前のユーザーはコメントを送信できない()
    {
        $item = Item::factory()->create();

        $response = $this->post(route('comments.store', $item->id), [
            'content' => 'テストコメント',
        ]);

        $response->assertRedirect(route('items.show', $item->id));
        $this->assertDatabaseMissing('comments', ['content' => 'テストコメント']);
    }

    #[Test]
    public function バリデーションエラー_コメントが空の場合はエラーになる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)
            ->post(route('comments.store', $item->id), ['content' => ''])
            ->assertSessionHasErrors(['content' => 'コメントを入力してください']);
    }

    #[Test]
    public function バリデーションエラー_コメントが256文字以上の場合はエラーになる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $tooLongContent = str_repeat('a', 256);

        $this->actingAs($user)
            ->post(route('comments.store', $item->id), ['content' => $tooLongContent])
            ->assertSessionHasErrors(['content' => 'コメントは255文字以内で入力してください']);
    }
}
