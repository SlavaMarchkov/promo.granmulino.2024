<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Enums\User\RoleEnum;
use App\Models\Role;
use App\Rules\BooleanRule;
use App\Rules\CyrillicCharsRule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateRequest extends FormRequest
{
    public function authorize()
    : bool
    {
        return auth()->user()->isAdmin();
    }

    public function rules(Role $role)
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
                Rule::unique('users')
                    ->where(fn(Builder $qb) => $qb->where('role_id', $role->getRoleId(RoleEnum::MANAGER->getName())))
                    ->ignore($this->request->get('id')),
            ],
            'is_active'   => ['required', new BooleanRule],
            'password'    => ['required', 'sometimes', 'string', 'min:6'],
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
            'email'     => str(request('email'))->squish()->lower()->value(),
            'is_active' => to_boolean(request('is_active')),
        ]);
    }
}
