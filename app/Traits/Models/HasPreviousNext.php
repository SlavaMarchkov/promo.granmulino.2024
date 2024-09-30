<?php

declare(strict_types=1);

// 30.09.2024 at 15:51:39
namespace App\Traits\Models;

trait HasPreviousNext
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
