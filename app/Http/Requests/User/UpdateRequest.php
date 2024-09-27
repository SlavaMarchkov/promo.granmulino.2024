<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

class UpdateRequest extends StoreRequest
{
    public function rules()
    : array
    {
        $rules = parent::rules();
        $rules['password'] = ['nullable', 'string', 'min:6'];

        return $rules;
    }
}
