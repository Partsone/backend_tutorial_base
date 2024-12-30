<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DestroyCommentRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\DestroyCommentResource;
use App\Http\Resources\StoreCommentResource;
use App\Http\Resources\UpdateCommentResource;
use App\Models\Comment;
use App\Models\Article;
use App\Models\User;
use App\Services\CommentService;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * 記事ごとにコメントを取得する
     */
    public function articleindex(Article $article)
    {
        $comments = $this->commentService->getCommentByArticle($article);
        return response()->json($comments, 200);
    }

    /**
     * ユーザごとにコメントを取得する
     */
    public function userindex(User $user)
    {
        $comments = $this->commentService->getCommentsByUser($user);
        return response()->json($comments, 200);
    }

    /**
     * コメントを投稿する
     */
    public function store(Article $article, StoreCommentRequest $request)
    {
        $comment = $this->commentService->createComment($article, [
            'content' => $request->input('content'),
            'user_id' => $request->user()->id,
        ]);
        return new StoreCommentResource($comment);
    }

    /**
     * コメントを編集する
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $updatedComment = $this->commentService->updateComment($comment, [
            'content' => $request->input('content'),
        ]);
        return new UpdateCommentResource($updatedComment);
    }

    /**
     * コメントを削除する
     */
    public function destroy(DestroyCommentRequest $request, Comment $comment)
    {
        $response = $this->commentService->deleteComment($comment);
        return new DestroyCommentResource($comment);
    }
}
