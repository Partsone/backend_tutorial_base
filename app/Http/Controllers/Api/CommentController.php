<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;

/**
 * コメント関連のAPIを提供するコントローラ
 */

class CommentController extends Controller
{
    /**
     * 指定された記事のコメント一覧を取得する（新しい順）
     *
     * @param  Article  $article  対象の記事
     * @return \Illuminate\Http\JsonResponse コメント一覧（ページネーションあり）
     */
    public function index(Article $article)
    {
        $comments = $article->comments()
            ->orderByDesc('created_at')
            ->paginate(10);

        return response()->json($comments, 200);
    }

    /**
     * 指定された記事にコメントを作成する
     *
     * @param  Request  $request  リクエスト（body を含む）
     * @param  Article  $article  コメント対象の記事
     * @return \Illuminate\Http\JsonResponse 作成したコメント
     */
    public function store(Request $request, Article $article)
    {
        $validated = $request->validate([
            'body' => 'required|string|min:10|max:100',
        ]);

        $userId = auth()->id() ?? 1;

        $comment = Comment::create([
            'article_id' => $article->id,
            'user_id'    => $userId,
            'body'       => $validated['body'],
        ]);

        return response()->json($comment, 201);
    }

    /**
     * コメントを更新する（本人のみ）
     *
     * @param  Request  $request   リクエスト（更新する body を含む）
     * @param  Article  $article   コメントが属する記事
     * @param  Comment  $comment   更新対象のコメント
     * @return \Illuminate\Http\JsonResponse 更新後のコメント
     */
    public function update(Request $request, Article $article, Comment $comment)
    {
        if ($comment->article_id !== $article->id) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $this->authorize('update', $comment);

        $validated = $request->validate([
            'body' => 'required|string|min:10|max:100',
        ]);

        $comment->update($validated);

        return response()->json($comment, 200);
    }

    /**
     * コメントを削除する（本人のみ）
     *
     * @param  Article  $article  コメントが属する記事
     * @param  Comment  $comment  削除対象のコメント
     * @return \Illuminate\Http\JsonResponse 削除結果
     */
    public function destroy(Article $article, Comment $comment)
    {
        if ($comment->article_id !== $article->id) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        // 認可チェック（Policy 呼び出し）
        $this->authorize('delete', $comment);

        $comment->delete(); // 論理削除 or 物理削除

        return response()->json(['message' => 'Deleted'], 200);
    }
    /**
     * コンストラクタ
     * 開発中は特定ユーザーでログインする処理を挟むことができる
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            //auth()->loginUsingId(1);  // ← 開発用：ID=1 でログイン（コメント作成者IDに合わせてOK）
            return $next($request);
        });
    }
}
