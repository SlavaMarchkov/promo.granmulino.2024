<?php

namespace App\Models;

use App\Traits\Models\HasCapitalize;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use Notifiable;
    use HasCapitalize;

    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'display_name',
        'email',
        'password',
        'is_active',
        'is_admin',
        'role_id',
        'logged_in_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts()
    : array
    {
        return [
            'is_active'         => 'boolean',
            'is_admin'          => 'boolean',
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function role()
    : BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function customers()
    : HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function retailers()
    : HasManyThrough
    {
        return $this->hasManyThrough(Retailer::class, Customer::class);
    }

    public function fullName()
    : Attribute
    {
        return new Attribute(
            get: fn() => $this->last_name . ' ' . $this->first_name,
        );
    }

    public function isManager()
    : bool
    {
        return $this->is_admin === false;
    }

    public function isAdmin()
    : bool
    {
        return $this->is_admin === true;
    }

    public function isSuperAdmin(Role $role)
    : bool
    {
        return $this->isAdmin()
            && $this->role_id === $role->superAdminRoleId();
    }

    public function isPriceAdmin(Role $role)
    : bool
    {
        return $this->isAdmin()
            && $this->role_id === $role->priceAdminRoleId();
    }

    public function isPlainAdmin(Role $role)
    : bool
    {
        return $this->isAdmin()
            && $this->role_id === $role->plainAdminRoleId();
    }
}
