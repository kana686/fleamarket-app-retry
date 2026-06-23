<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Condition;
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
                $query->where('user_id', $userId);
                break;

            case 'buy':
                $query->whereHas('purchases', function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                });
                break;

            case 'recommend':
            default:
                if ($userId) {
                    $query->where('user_id', '!=', $userId);
                }
                break;
        }

        return $query->latest()->get();
    }

    public function getFormData(): array
    {
        return [
            'categories' => Category::all(),
            'conditions' => Condition::all(),
        ];
    }

    public function createItem(array $data)
    {
        if (isset($data['img_url'])) {
            $path = $data['img_url']->store('items', 'public');
            $data['img_url'] = $path;
        }

        $item = Item::create([
            'user_id' => Auth::id(),
            'condition_id' => $data['condition_id'],
            'name' => $data['name'],
            'brand_name' => $data['brand_name'] ?? null,
            'price' => $data['price'],
            'description' => $data['description'],
            'img_url' => $data['img_url'],
        ]);

        $item->categories()->sync($data['categories']);

        return $item;
    }
}
