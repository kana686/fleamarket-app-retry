<?php

namespace Tests\Browser;

use App\Models\Item;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Tests\DuskTestCase;

class PaymentMethodTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(MasterDataSeeder::class);
    }

    #[Test]
    public function 支払い方法を選択すると小計画面に反映される()
    {
        $seller = User::factory()->create();
        $buyer = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);

        $this->browse(function (Browser $browser) use ($buyer, $item) {
            $browser->loginAs($buyer)
                ->visit(route('purchases.checkout', $item->id))
                ->waitFor('#payment-method-select', 10);

            $browser->select('payment_method', 2)
                ->script("document.getElementById('payment-method-select').dispatchEvent(new Event('change'));");

            $browser->waitForTextIn('#payment-method-display', 'カード支払い');
        });
    }
}
