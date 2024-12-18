<?php

declare(strict_types=1);

namespace App\Http\Requests\Promo;

use Illuminate\Foundation\Http\FormRequest;

final class PromoMarkUpdateRequest extends FormRequest
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
            'goals'    => ['required', 'numeric', 'min:0', 'max:5'],
            'sales'    => ['required', 'numeric', 'min:0', 'max:5'],
            'staff'    => ['required', 'numeric', 'min:0', 'max:5'],
            'comments' => ['nullable', 'string'],
        ];
    }
}
