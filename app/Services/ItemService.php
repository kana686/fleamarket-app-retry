<?php

namespace App\Services;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemService
{
    public function getItems(?string $keyword, string $tab)
    {
        $query = Item::query();
        $userId = Auth::id();

        if (! empty($keyword)) {
            $query->where('name', 'LIKE', '%'.$keyword.'%');
        }

        switch ($tab) {
            case 'mylist':
                $query->whereHas('mylists', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                });
                break;

            case 'sell':
                $query->where('seller_id', $userId);
                break;

            case 'buy':
                $query->where('buyer_id', $userId)
                    ->where('seller_id', '!=', $userId);
                break;

            case 'recommend':
            default:
                if ($userId) {
                    $query->where('seller_id', '!=', $userId);
                }
                break;
        }

        return $query->latest()->get();
    }
}
