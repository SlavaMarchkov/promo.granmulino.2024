<?php

declare(strict_types=1);

namespace App\Http\Requests\Region;

use Illuminate\Foundation\Http\FormRequest;

final class StoreUpdateRequest extends FormRequest
{
    public function authorize()
    : bool
    {
        return auth()->user()->isAdmin();
    }

    public function rules()
    : array
    {
        return [
            'code' => ['required', 'string', 'min:2', 'max:8'],
            'name' => ['required', 'string', 'max:128'],
        ];
    }

    public function attributes()
    : array
    {
        return [
            'code' => 'Код',
            'name' => 'Название',
        ];
    }
}
