<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchItemRequest;
use App\Services\ItemService;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    protected $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function index(SearchItemRequest $request)
    {
        $validated = $request->validated();
        $keyword = $validated['keyword'] ?? null;
        $tab = $validated['tab'] ?? 'recommend';

        if ($tab === 'mylist' && ! Auth::check()) {
            return redirect()->route('login.create');
        }

        $items = $this->itemService->getItems($keyword, $tab);

        return view('items.index', compact('items'));
    }

    public function create() // 表示確認用
    {
        return view('items.sell');
    }

    public function store(Request $request) // 表示確認用
    {
        return redirect()->route('mypage')->with('message', '登録が完了しました！');
    }
}
