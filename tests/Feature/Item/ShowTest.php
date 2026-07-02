<?php

namespace Tests\Feature\Item;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Condition;
use App\Models\Item;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MasterDataSeeder::class);
    }

    /** @test */
    public function 商品詳細画面に必要な情報がすべて表示される()
    {
        $condition = Condition::where('content', '良好')->first();
        $category = Category::where('content', 'ファッション')->first();

        $item = Item::factory()->create(['condition_id' => $condition->id]);
        $item->categories()->sync([$category->id]);

        $comment = Comment::factory()->create(['item_id' => $item->id]);

        $response = $this->get(route('items.show', $item->id));

        $response->assertStatus(200);
        $response->assertSee($item->name);
        $response->assertSee($item->brand_name);
        $response->assertSee(number_format($item->price));
        $response->assertSee($item->description);
        $response->assertSee($item->condition->content);
        $response->assertSee($category->content);
        $response->assertSee($comment->content);
        $response->assertSee($comment->user->name);
    }
}
