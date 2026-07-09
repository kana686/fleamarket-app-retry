<?php

namespace Tests\Browser;

use App\Models\Item;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PaymentMethodTest extends DuskTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MasterDataSeeder::class);
    }

    /** @test */
    public function 支払い方法を選択すると小計画面に反映される()
    {
        $seller = User::factory()->create();
        $buyer = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);

        $this->actingAs($buyer);

        $this->browse(function (Browser $browser) use ($item) {
            $browser->visit(route('purchases.checkout', $item->id))
                ->waitFor('#payment-method-select', 10);

            $browser->click('#payment-method-select')
                ->select('payment_method', 'カード支払い')
                ->script("document.getElementById('payment-method-select').dispatchEvent(new Event('change'));");

            $browser->waitForText('カード支払い', 10)
                ->assertSeeIn('#payment-method-display', 'カード支払い');
        });
    }
}
