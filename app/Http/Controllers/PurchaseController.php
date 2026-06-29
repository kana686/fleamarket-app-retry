<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
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
        $purchaseService->processPurchase($request->validated(), $item_id);

        return redirect()->route('purchases.index')->with('success', '購入が完了しました！');
    }

    public function edit($item_id)
    {
        return '送付先住所変更画面に遷移成功！';
    }
}
