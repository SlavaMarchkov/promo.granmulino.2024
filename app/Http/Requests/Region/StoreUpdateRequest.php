<?php

declare(strict_types=1);

namespace App\Http\Requests\Region;

use Illuminate\Foundation\Http\FormRequest;

final class StoreUpdateRequest extends FormRequest
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

    public function messages()
    : array
    {
        return [
            'required' => 'Поле ":attribute" нужно заполнить.',
            'min'      => [
                'string' => 'Поле ":attribute" должно иметь не менее :min символов.',
            ],
            'max'      => [
                'string' => 'Поле ":attribute" должно иметь не более :max символов.',
            ],
        ];
    }

    protected function prepareForValidation()
    : void
    {
        $code = $this->input('code', true);
        $this->merge([
            'code' => process_code($code),
        ]);
    }
}
