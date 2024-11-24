<?php

declare(strict_types=1);

// 24.11.2024 at 18:46:25
namespace App\Http\Requests\Customer;

use App\Rules\BooleanRule;
use Illuminate\Foundation\Http\FormRequest;

final class SellerUpdateRequest extends FormRequest
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
            'name'                   => ['required'],
            'is_active'              => ['required', new BooleanRule()],
            'customer_id'            => ['required', 'exists:customers,id'],
            'customer_supervisor_id' => ['nullable', 'numeric', 'exists:customer_supervisors,id'],
        ];
    }

    public function attributes()
    : array
    {
        return [
            'name' => 'ФИО торгового представителя',
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
