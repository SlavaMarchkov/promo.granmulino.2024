<?php

namespace App\Models;

use App\Traits\Models\HasCapitalize;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use Notifiable;
    use HasCapitalize;

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'email',
        'password',
        'is_active',
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
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function fullName()
    : Attribute
    {
        return new Attribute(
            get: fn() => $this->last_name . ' ' . $this->first_name,
        );
    }

    public function setPasswordAttribute(string $password)
    : void
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function getUsers(bool $is_active = false)
    : Collection
    {
        return $this->query()
            ->when($is_active, fn($query) => $query->where('is_active', true))
            ->get();
    }
}
