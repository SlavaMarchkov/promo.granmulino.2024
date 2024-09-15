<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Rules\CyrillicCharsRule;
use Illuminate\Foundation\Http\FormRequest;

final class StoreRequest extends FormRequest
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
            'email'       => ['required', 'email:dns', 'max:255', 'unique:users'],
            'password'    => ['required'],
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

    protected function prepareForValidation()
    : void
    {
        $this->merge([
            'email'       => str(request('email'))->squish()->lower()->value(),
            'last_name'   => process_name(request('last_name')),
            'first_name'  => process_name(request('first_name')),
            'middle_name' => process_name(request('middle_name')),
        ]);
    }
}
