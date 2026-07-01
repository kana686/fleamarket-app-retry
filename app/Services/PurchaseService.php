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
            'shippingPostCode' => session('edited_post_code', $user->post_code),
            'shippingAddress' => session('edited_address', $user->address),
            'shippingBuilding' => session('edited_building', $user->building),
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

        $user = Auth::user();
        $methods = ($paymentMethod == 1) ? ['konbini'] : ['card'];

        $session = Session::create([
            'payment_method_types' => $methods,
            'customer_email' => $user->email,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => ['name' => '商品購入'],
                    'unit_amount' => $price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('purchases.success', ['item' => $itemId]),
            'cancel_url' => route('purchases.checkout', ['item' => $itemId]),
        ]);

        return [
            'url' => $session->url,
            'id' => $session->id,
        ];
    }

    public function processPurchase(array $data, $itemId, $stripeSessionId)
    {
        return DB::transaction(function () use ($data, $itemId, $stripeSessionId) {
            $user = Auth::user();

            $status = ($data['payment_method'] == Purchase::PAYMENT_METHOD_CONVENIENCE)
                ? Purchase::STATUS_PENDING
                : Purchase::STATUS_COMPLETED;

            Purchase::create([
                'item_id' => $itemId,
                'user_id' => $user->id,
                'payment_method' => $data['payment_method'],
                'post_code' => $data['post_code'],
                'address' => $data['address'],
                'building' => $data['building'] ?? null,
                'stripe_session_id' => $stripeSessionId,
                'status' => $status,
            ]);

            session()->forget([
                'edited_post_code',
                'edited_address',
                'edited_building',
                'selected_payment_method',
                'temp_payment_method',
                'temp_stripe_session_id',
                'temp_purchase_data',
            ]);
        });
    }

    public function finalizePurchase($item_id, $user)
    {
        $addressData = [
            'post_code' => session('edited_post_code', $user->post_code),
            'address' => session('edited_address', $user->address),
            'building' => session('edited_building', $user->building),
            'payment_method' => session('temp_payment_method', 2),
        ];

        $stripeSessionId = session('temp_stripe_session_id');

        $this->processPurchase($addressData, $item_id, $stripeSessionId);

        session()->forget([
            'temp_payment_method',
            'temp_stripe_session_id',
            'edited_post_code',
            'edited_address',
            'edited_building',
            'selected_payment_method',
        ]);
    }

    public function handleStripeWebhook($sessionId)
    {
        return DB::transaction(function () use ($sessionId) {
            $purchase = Purchase::where('stripe_session_id', $sessionId)->first();

            if ($purchase) {
                if ($purchase->status !== Purchase::STATUS_COMPLETED) {
                    $purchase->update(['status' => Purchase::STATUS_COMPLETED]);
                }

                return true;
            }

            return false;
        });
    }
}
