<?php

namespace App\Services;

use App\Models\Comment;

class CommentService
{
    public function createComment(array $data, int $userId)
    {
        return Comment::create([
            'item_id' => $itemId,
            'user_id' => $userId,
            'content' => $data['content'],
        ]);
    }
}
