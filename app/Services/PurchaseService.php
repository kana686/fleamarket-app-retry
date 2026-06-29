<?php

namespace App\Services;

use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        $shippingAddress = session('edited_address', $user->address);

        Purchase::create([
            'item_id' => $itemId,
            'user_id' => $user->id,
            'payment_method' => $data['payment_method'],
            'post_code' => $user->post_code,
            'address' => $shippingAddress,
        ]);

    }
}
