<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        // 今回は誰でも叩けるエンドポイントなので true
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    public function attributes(): array
    {
        // エラーメッセージの項目名（日本語化したい場合）
        return [
            'email' => 'メールアドレス',
        ];
    }
}
