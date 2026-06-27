<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Item;
use App\Services\CommentService;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Item $item, CommentService $service)
    {
        if (! auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'コメントするにはログインが必要です。');
        }

        $service->createComment($request->validated(), $item->id, auth()->id());

        return back()->with('success', 'コメントを投稿しました。');
    }
}
