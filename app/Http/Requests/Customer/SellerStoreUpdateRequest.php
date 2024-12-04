<?php

declare(strict_types=1);

// 15.11.2024 at 16:41:25
namespace App\Http\Requests\Customer;

use App\Rules\BooleanRule;
use Illuminate\Foundation\Http\FormRequest;

final class SellerStoreUpdateRequest extends FormRequest
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
            'name'          => ['required'],
            'is_active'     => ['required', new BooleanRule()],
            'customer_id'   => ['required', 'numeric', 'exists:customers,id'],
            'supervisor_id' => ['nullable', 'exists:customer_sellers,id'],
            'is_supervisor' => ['nullable', new BooleanRule()],
        ];
    }

    public function attributes()
    : array
    {
        return [
            'name' => to_boolean(request('is_supervisor'))
                ? 'ФИО супервайзера'
                : 'ФИО торгового представителя',
        ];
    }

    protected function prepareForValidation()
    : void
    {
        $this->merge([
            'is_active'     => to_boolean(request('is_active')),
            'is_supervisor' => to_boolean(request('is_supervisor')),
            'supervisor_id' => check_item_for_empty_array(request('supervisor_id')),
        ]);
    }
}
