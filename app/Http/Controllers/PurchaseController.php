<?php

namespace App\Http\Controllers;

class PurchaseController extends Controller
{
    public function show($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        return view('purchases.checkout', compact('item', 'user'));
    }
}
