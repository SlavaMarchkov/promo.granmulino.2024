<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function getRoleId(string $role)
    : int
    {
        return $this->query()
            ->where('slug', $role)
            ->value('id');
    }
}
