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
        if ($data['payment_method'] == 2) {
            return $this->createStripeSession($item->id, $item->price);
        }

        $this->processPurchase($data, $item->id);

        return null;
    }

    public function createStripeSession($itemId, $price)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
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

        return $session->url;
    }

    public function processPurchase(array $data, $itemId)
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
            ]);

            session()->forget(['edited_address', 'selected_payment_method']);
        });
    }
}
