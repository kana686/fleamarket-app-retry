<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function show($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        $shippingAddress = session('edited_address', $user->address);

        $paymentMethods = [
            1 => 'コンビニ払い',
            2 => 'クレジット払い',
        ];
        $paymentMethod = session('selected_payment_method', 1);

        return view('purchases.checkout', compact('item', 'user', 'shippingAddress', 'paymentMethods', 'paymentMethod'));
    }
}
