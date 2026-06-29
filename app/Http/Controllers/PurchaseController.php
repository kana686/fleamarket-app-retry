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

        try {
            $redirectUrl = $purchaseService->handlePurchase($data, $item);

            if ($redirectUrl) {
                return redirect()->away($redirectUrl);
            }

            return redirect()->route('items.index')->with('success', '購入が完了しました！');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function success(PurchaseService $purchaseService, $item_id)
    {
        $purchaseService->processPurchase(['payment_method' => 2], $item_id);

        return redirect()->route('items.index')->with('success', '決済が完了し、購入が確定しました！');
    }

    public function edit($item_id)
    {
        return '送付先住所変更画面に遷移成功！';
    }
}
