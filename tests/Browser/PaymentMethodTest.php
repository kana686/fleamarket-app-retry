<?php

namespace Tests\Browser;

use App\Models\Item;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PaymentMethodTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MasterDataSeeder::class);
    }

    /** @test */
    public function 支払い方法を選択すると小計画面に反映される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->browse(function (Browser $browser) use ($user, $item) {
            $browser->loginAs($user)
                ->visit(route('purchases.checkout', $item->id))
                ->assertSee('未選択')
                ->select('payment_method', '2')
                ->waitForText('カード支払い')
                ->assertSeeIn('#payment-method-display', 'カード支払い');
        });
    }
}
