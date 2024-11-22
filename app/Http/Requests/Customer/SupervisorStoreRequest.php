<?php

declare(strict_types=1);

// 15.11.2024 at 16:41:25
namespace App\Http\Requests\Customer;

use App\Rules\BooleanRule;
use Illuminate\Foundation\Http\FormRequest;

final class SupervisorStoreRequest extends FormRequest
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
            'name'        => ['required'],
            'is_active'   => ['required', new BooleanRule()],
            'customer_id' => ['required', 'exists:customers,id'],
        ];
    }

    public function attributes()
    : array
    {
        return [
            'name' => 'ФИО супервайзера'
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
