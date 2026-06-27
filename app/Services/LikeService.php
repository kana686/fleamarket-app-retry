<?php

namespace App\Services;

use App\Models\Mylist;

class LikeService
{
    public function addLike($itemId, $userId)
    {
        return Mylist::firstOrCreate([
            'item_id' => $itemId,
            'user_id' => $userId,
        ]);
    }

    public function removeLike($itemId, $userId)
    {
        return Mylist::where('item_id', $itemId)->where('user_id', $userId)->delete();
    }
}
