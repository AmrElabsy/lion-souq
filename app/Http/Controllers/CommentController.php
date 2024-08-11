<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Http\Services\CommentService;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
{
    public function __construct(
        private CommentService $service
    ) {}
    
    public function store(StoreCommentRequest $request)
    {
        $comment = $this->service->store($request->all());
        return new CommentResource($comment);
    }
}
