<?php
namespace App\Services;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;

class CommentService {
    public function getCommentByArticle(Article $article)
    {
        return $article->comments()
            ->orderBy('created_at', 'desc')
            ->get();
    }


    public function getCommentsByUser(User $user)
    {
        return $user->comments;
    }

    public function createComment(Article $article, array $data)
    {
        return $article->comments()->create($data);
    }

    public function updateComment(Comment $comment, array $data)
    {
        $comment->update($data);
        return $comment;
    }

    public function deleteComment(Comment $comment)
    {
        $comment->delete();
        return ['message' => 'Comment deleted'];
    }


}
