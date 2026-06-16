<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();

        $fields = [
            ['name' => 'name',      'label' => 'ユーザー名', 'value' => $user->name ?? ''],
            ['name' => 'post_code', 'label' => '郵便番号',  'value' => $user->post_code ?? ''],
            ['name' => 'address',   'label' => '住所',      'value' => $user->address ?? ''],
            ['name' => 'building',  'label' => '建物名',    'value' => $user->building ?? ''],
        ];

        return view('profile.edit', compact('user', 'fields'));
    }
}
