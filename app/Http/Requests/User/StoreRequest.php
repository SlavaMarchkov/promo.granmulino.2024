<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

final class StoreRequest extends FormRequest
{
    public function rules()
    : array
    {
        // TODO: добавить Rule для проверки имени на кириллицу
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
        ];
    }

    public function authorize()
    : bool
    {
        return true;
    }
}
