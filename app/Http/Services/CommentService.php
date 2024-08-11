<?php

namespace App\Http\Services;

use App\Models\Comment;

class CommentService extends BaseService
{
    public function store($data)
    {
        return Comment::create([
            'comment' => $data['comment'],
            'product_id' => $data['product_id'],
            'user_id' => auth()->user()->id
        ]);
    }

    public function update($id, $data)
    {
        $comment = Comment::findorFail($id);
    
        $comment->update([
            'comment' => $data['comment'],
        ]);
        
        return $comment;
    }
}
