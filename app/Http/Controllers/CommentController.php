<?php

namespace App\Http\Controllers;

use App\Events\StoreCommentEvent;
use App\Http\Requests\Comment\StoreRequest;
use App\Http\Resources\Comment\ShowChildrenCommentsResource;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Exception;

class CommentController extends Controller
{

    /**
     * @var CommentService
     */
    private CommentService $commentService;

    /**
     * @param CommentService $commentService
     */
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }


    /**
     * @param Post $post
     * @param StoreRequest $request
     * @return array
     * @throws Exception
     */
    public function store(Post $post, StoreRequest $request)
    {
        $data = $request->validated();
        $comment = $this->commentService->create($post, $data);

        broadcast(new StoreCommentEvent($comment))->toOthers();

        return ShowChildrenCommentsResource::make($comment)->resolve();

    }

    /**
     * @param $parentId
     * @return array
     */
    public function showChildren($parentId): array
    {
        $comments = Comment::with('parent')
            ->where('parent_id', $parentId)
            ->withCount('replies')
            ->orderByDesc('created_at')
            ->get();

        return ShowChildrenCommentsResource::collection($comments)->resolve();

    }
}
