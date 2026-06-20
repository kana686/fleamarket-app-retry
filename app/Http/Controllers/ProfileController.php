<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Services\ItemService;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $profileService;

    protected $itemService;

    public function __construct(ProfileService $profileService, ItemService $itemService)
    {
        $this->profileService = $profileService;
        $this->itemService = $itemService;
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $tab = $request->query('tab', 'sell');
        $items = $this->itemService->getItems($request->keyword, $tab);

        return view('profile.index', compact('user', 'tab', 'items'));
    }

    public function edit(Request $request)
    {
        $user = $request->user();
        $fields = $this->profileService->getEditFields($user);

        return view('profile.edit', compact('user', 'fields'));
    }

    public function update(ProfileRequest $request)
    {
        $this->profileService->updateProfile($request->validated());

        if ($this->profileService->isFirstLogin()) {
            return redirect()->route('items.index')->with('success', 'プロフィールを登録しました。');
        }

        return redirect()->route('mypage')->with('success', 'プロフィールを更新しました。');

    }
}
