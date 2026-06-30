<?php

namespace App\Http\Controllers;

use App\Models\Item;

class AddressController extends Controller
{
    public function edit(Item $item)
    {
        $itemId = $item->id;

        $address = (object) session("temp_address.{$item_id}", [
            'post_code' => auth()->user()->post_code,
            'address' => auth()->user()->address,
            'building' => auth()->user()->building,
        ]);

        return view('purchases.address.edit', compact('item', 'address'));
    }
}
