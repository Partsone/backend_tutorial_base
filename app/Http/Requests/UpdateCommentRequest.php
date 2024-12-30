<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    public function authorize(): bool
    {
        $comment = $this->route('comment');// ルートからコメントを取得
        $userId = $this->user()->id;// 現在の認証ユーザーのIDを取得

        return $comment->user_id === $userId; // コメントの所有者かどうか確認
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => 'sometimes|required|string|min:10|max:100'
        ];
    }
}
