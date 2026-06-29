<?php

namespace App\Services;

use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Charge;
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

    public function processPurchase(array $data, $itemId)
    {
        return DB::transaction(function () use ($data, $itemId) {
            $user = Auth::user();
            $shippingAddress = session('edited_address', $user->address);

            $item = Item::findOrFail($itemId);
            $price = $item->price;

            if ($data['payment_method'] == 2) {
                try {
                    Stripe::setApiKey(config('services.stripe.secret'));

                    Charge::create([
                        'amount' => $data['price'],
                        'currency' => 'jpy',
                        'source' => $data['stripeToken'],
                    ]);
                } catch (\Exception $e) {
                    Log::error('決済失敗: '.$e->getMessage());
                    throw new \Exception('決済処理に失敗しました。カード情報を確認してください。');
                }
            }

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
