<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
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
