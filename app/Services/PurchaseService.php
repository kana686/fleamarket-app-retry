<?php

namespace App\Services;

use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class PurchaseService
{
    public function getCheckoutData($itemId)
    {
        $item = Item::findOrFail($itemId);
        $user = Auth::user();

        return [
            'item' => $item,
            'user' => $user,
            'shippingAddress' => session('edited_address', $user->address),
            'paymentMethods' => [
                1 => 'コンビニ払い',
                2 => 'クレジット払い',
            ],
            'paymentMethod' => session('selected_payment_method', null),
        ];
    }

    public function handlePurchase(array $data, $item)
    {
        return $this->createStripeSession($item->id, $item->price, $data['payment_method']);
    }

    public function createStripeSession($itemId, $price, $paymentMethod)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $methods = ($paymentMethod == 1) ? ['konbini'] : ['card'];

        $session = Session::create([
            'payment_method_types' => $methods,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => ['name' => '商品購入'],
                    'unit_amount' => $price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('purchases.success', ['item_id' => $itemId]),
            'cancel_url' => route('purchases.show', ['item_id' => $itemId]),
        ]);

        return [
            'url' => $session->url,
            'id' => $session->id,
        ];
    }

    public function processPurchase(array $data, $itemId, $stripeSessionId)
    {
        return DB::transaction(function () use ($data, $itemId) {
            $user = Auth::user();
            $shippingAddress = session('edited_address', $user->address);

            Purchase::create([
                'item_id' => $itemId,
                'user_id' => $user->id,
                'payment_method' => $data['payment_method'],
                'post_code' => $user->post_code,
                'address' => $shippingAddress,
                'stripe_session_id' => $stripeSessionId,
                'status' => 'completed',
            ]);

            session()->forget(['edited_address', 'selected_payment_method']);
        });
    }
}
