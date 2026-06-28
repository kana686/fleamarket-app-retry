<?php

namespace App\Http\Controllers;

use App\Services\LikeService;

class LikeController extends Controller
{
    protected $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    public function store($id)
    {
        $this->likeService->addLike($id, auth()->id());

        return response()->json(['status' => 'liked']);
    }

    public function destroy($id)
    {
        $this->likeService->removeLike($id, auth()->id());

        return response()->json(['status' => 'unliked']);
    }
}
