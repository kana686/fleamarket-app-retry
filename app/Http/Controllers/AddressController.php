<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\Item;
use App\Services\AddressService;

class AddressController extends Controller
{
    protected $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function edit(Item $item)
    {
        $address = (object) $this->addressService->getAddressData(auth()->user());

        return view('purchases.address', compact('item', 'address'));
    }

    public function update(AddressRequest $request, Item $item)
    {
        $this->addressService->saveTemporaryAddress($request->validated());

        return redirect()->route('purchases.checkout', $item->id);
    }
}
