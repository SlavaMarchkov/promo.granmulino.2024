<?php

declare(strict_types=1);

// 08.11.2024 at 00:26:21
namespace App\Http\Requests\Promo;

use Illuminate\Foundation\Http\FormRequest;

final class StoreRequest extends FormRequest
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
            'title' => ['required'],
        ];
    }
}
