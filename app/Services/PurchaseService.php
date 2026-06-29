<?php

namespace App\Services;

use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class PurchaseService
{
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
