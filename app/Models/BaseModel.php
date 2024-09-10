<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function findPrevious($id)
    : ?int
    {
        return $this->query()
            ->where('id', '<', $id)
            ->max('id');
    }

    public function findNext($id)
    : ?int
    {
        return $this->query()
            ->where('id', '>', $id)
            ->min('id');
    }
}
