<?php

namespace App\Services;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemService
{
    public function getItems(?string $keyword, string $tab)
    {
        $query = Item::query();

        if (! empty($keyword)) {
            $query->where('name', 'LIKE', '%'.$keyword.'%');
        }

        if ($tab === 'mylist') {
            $query->whereHas('mylists', function ($q) {
                $q->where('user_id', Auth::id());
            });
        }

        return $query->latest()->get();
    }
}
