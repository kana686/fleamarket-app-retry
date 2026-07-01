<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Services\PurchaseService;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function show(PurchaseService $purchaseService, $item_id)
    {
        $data = $purchaseService->getCheckoutData($item_id);

        return view('purchases.checkout', $data);
    }

    public function store(PurchaseRequest $request, PurchaseService $purchaseService, $item_id)
    {
        $item = Item::findOrFail($item_id);
        $data = $request->validated();

        $stripeSession = $purchaseService->handlePurchase($data, $item);

        $purchaseService->processPurchase($data, $item_id, $stripeSession['id']);

        return redirect()->away($stripeSession['url']);
    }

    public function success(Request $request, PurchaseService $purchaseService, $item_id)
    {
        return redirect()->route('items.index')->with('success', '決済手続きを受け付けました。');
    }
}
