<?php

namespace App\Services;

class AddressService
{
    public function getAddressData($user)
    {
        return [
            'post_code' => session('edited_post_code', $user->post_code),
            'address' => session('edited_address', $user->address),
            'building' => session('edited_building', $user->building),
        ];
    }

    public function saveTemporaryAddress(array $data)
    {
        session([
            'edited_post_code' => $data['post_code'],
            'edited_address' => $data['address'],
            'edited_building' => $data['building'],
        ]);
    }
}
