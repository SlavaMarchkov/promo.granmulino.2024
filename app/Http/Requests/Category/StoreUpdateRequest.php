<?php

declare(strict_types=1);

namespace App\Http\Requests\Category;

use App\Rules\BooleanRule;
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
            'name'      => ['required', 'string', 'min:5', 'max:32'],
            'is_active' => ['required', new BooleanRule()],
        ];
    }

    public function attributes()
    : array
    {
        return [
            'name'      => 'Группа товаров',
            'is_active' => 'В продаже',
        ];
    }

    protected function prepareForValidation()
    : void
    {
        $this->merge([
            'is_active' => to_boolean(request('is_active')),
        ]);
    }
}
