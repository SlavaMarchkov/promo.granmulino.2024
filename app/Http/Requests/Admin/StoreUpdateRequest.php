<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Models\Role;
use App\Rules\BooleanRule;
use App\Rules\CyrillicCharsRule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

final class StoreUpdateRequest extends FormRequest
{
    public function authorize(Role $role)
    : bool {
        return auth()->user()->isSuperAdmin($role);
    }

    public function rules(Role $role)
    : array {
        $admin_roles = [
            $role->superAdminRoleId(),
            $role->priceAdminRoleId(),
            $role->plainAdminRoleId(),
        ];

        return [
            'last_name'   => ['required', 'string', 'max:32', new CyrillicCharsRule()],
            'first_name'  => ['required', 'string', 'max:16', new CyrillicCharsRule()],
            'middle_name' => ['nullable', 'string', 'max:32', new CyrillicCharsRule()],
            'email'       => [
                'required',
                'email:dns',
                'max:255',
                Rule::unique('users')
                    ->where(fn(Builder $qb) => $qb->whereIn('role_id', $admin_roles))
                    ->ignore($this->request->get('id')),
            ],
            'is_active'   => ['required', new BooleanRule()],
            'is_admin'    => ['required', new BooleanRule()],
            'role_id'     => ['required', 'integer', 'in:' . collect($admin_roles)->implode(',')],
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
            'role_id'     => 'Роль в системе',
        ];
    }

    public function messages()
    : array
    {
        return [
            'role_id.in' => 'Выберите админскую роль',
        ];
    }

    protected function prepareForValidation()
    : void
    {
        $role = request()->input('role');

        $this->merge([
            'email'     => str(request('email'))->squish()->lower()->value(),
            'is_active' => to_boolean(request('is_active')),
            'is_admin'  => to_boolean(request('is_admin')),
            'role_id'   => DB::table('roles')
                ->select('id')
                ->where('slug', $role)
                ->value('id'),
        ]);
    }
}
