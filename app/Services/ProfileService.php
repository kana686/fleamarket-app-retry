<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public function getEditFields($user): array
    {
        return [
            ['name' => 'name',      'label' => 'ユーザー名', 'value' => $user->name ?? ''],
            ['name' => 'post_code', 'label' => '郵便番号',  'value' => $user->post_code ?? ''],
            ['name' => 'address',   'label' => '住所',      'value' => $user->address ?? ''],
            ['name' => 'building',  'label' => '建物名',    'value' => $user->building ?? ''],
        ];
    }

    public function updateProfile(array $data): void
    {
        $user = Auth::user();

        if (isset($data['img_url'])) {

            if ($user->img_url) {
                Storage::disk('public')->delete($user->img_url);
            }

            $data['img_url'] = $data['img_url']->store('profiles', 'public');
        }

        $user->fill($data);
        $user->save();
    }

    public function isFirstLogin(): bool
    {
        return session()->pull('is_first_login') !== null;
    }
}
