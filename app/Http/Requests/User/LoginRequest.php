<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

final class LoginRequest extends FormRequest
{
    public function rules()
    : array
    {
        return [
            'email'    => ['required', 'email', 'max:255'],
            'password' => ['required'],
        ];
    }

    public function attributes()
    : array
    {
        return [
            'email'    => 'Email',
            'password' => 'Пароль',
        ];
    }

    public function messages()
    : array
    {
        return [
            'required' => 'Поле ":attribute" нужно заполнить.',
        ];
    }

    public function authorize()
    : bool
    {
        return true;
    }
}
