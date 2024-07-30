<?php

declare(strict_types=1);

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

final class StoreUpdateRequest extends FormRequest
{
    public function rules()
    : array
    {
        return [
            'name'      => ['required', 'string', 'min:5', 'max:32'],
            'is_active' => ['boolean'],
        ];
    }

    public function authorize()
    : bool
    {
        return true;
    }
}
