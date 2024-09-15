<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Rules\BooleanRule;
use App\Rules\CyrillicCharsRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize()
    : bool
    {
        return true;
    }

    public function rules()
    : array
    {
        return [
            'last_name'   => ['required', 'string', 'max:32', new CyrillicCharsRule],
            'first_name'  => ['required', 'string', 'max:16', new CyrillicCharsRule],
            'middle_name' => ['nullable', 'string', 'max:32', new CyrillicCharsRule],
            'email'       => [
                'required',
                'email:dns',
                'max:255',
                Rule::unique('users')->ignore($this->request->get('id')),
            ],
            'is_active'   => ['required', new BooleanRule],
            'password'    => ['nullable', 'string', 'min:6'],
        ];
    }

    public function attributes()
    : array
    {
        return [
            'last_name'   => 'Фамилия',
            'first_name'  => 'Имя',
            'middle_name' => 'Отчество',
            'email'       => 'Email',
            'password'    => 'Пароль',
        ];
    }
}
