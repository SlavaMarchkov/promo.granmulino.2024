<?php

declare(strict_types=1);

// 22.02.2025 at 16:19:12
namespace App\Http\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;

final class StoreUserImageRequest extends FormRequest
{
    public function authorize()
    : bool
    {
        return auth()->user()->isManager();
    }

    public function rules()
    : array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'images'  => ['nullable', 'array'],
        ];
    }
}
