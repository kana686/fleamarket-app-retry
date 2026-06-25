<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\SearchItemRequest;
use App\Services\ItemService;
use Illuminate\Http\RedirectResponse;
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

    public function show($id)
    {
        $item = $this->itemService->getItemById($id);

        if (! $item) {
            abort(404);
        }
        dd($item);

        return view('items.show', compact('item'));
    }

    public function create()
    {
        $data = $this->itemService->getFormData();

        $categories = $data['categories'];
        $conditions = $data['conditions'];

        return view('items.sell', compact('categories', 'conditions'));
    }

    public function store(ExhibitionRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $this->itemService->createItem($validatedData);

        return redirect()->route('mypage')->with('message', '登録が完了しました！');
    }
}
