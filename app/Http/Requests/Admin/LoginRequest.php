<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

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

    public function authorize()
    : bool
    {
        return true;
    }
}
