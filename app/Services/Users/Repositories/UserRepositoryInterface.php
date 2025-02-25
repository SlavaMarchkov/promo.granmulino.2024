<?php

declare(strict_types=1);

// 26.09.2024 at 18:36:32
namespace App\Services\Users\Repositories;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function find(User $user)
    : ?User;

    public function findById(int $user_id)
    : ?User;

    public function get(array $params = [])
    : Collection;

    public function createFromArray(array $data)
    : User;

    public function updateFromArray(User $user, array $data)
    : User;

    public function delete(User $user)
    : int;

    public function createImageFromArray(string $file, string $thumbnail, int $user_id, string $class)
    : Image;
}
