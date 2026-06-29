<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Services\PurchaseService;

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

        session(['temp_payment_method' => $data['payment_method']]);

        $redirectUrl = $purchaseService->handlePurchase($data, $item);

        return redirect()->away($redirectUrl);
    }

    public function success(PurchaseService $purchaseService, $item_id)
    {
        $paymentMethod = session('temp_payment_method', 2);

        $purchaseService->processPurchase(['payment_method' => $paymentMethod], $item_id);

        session()->forget('temp_payment_method');

        return redirect()->route('items.index')->with('success', '決済が完了し、購入が確定しました！');
    }

    public function edit($item_id)
    {
        return '送付先住所変更画面に遷移成功！';
    }
}
