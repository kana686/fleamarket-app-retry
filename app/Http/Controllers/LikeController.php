<?php

namespace App\Http\Controllers;

class LikeController extends Controller
{
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
