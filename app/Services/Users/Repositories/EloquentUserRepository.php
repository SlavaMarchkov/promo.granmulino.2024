<?php

declare(strict_types=1);

// 26.09.2024 at 18:39:39
namespace App\Services\Users\Repositories;


use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final class EloquentUserRepository implements UserRepositoryInterface
{
    public function find(User $user)
    : ?User
    {
        return User::query()->where('id', $user->id)->first();
    }

    public function get(array $params = [])
    : Collection
    {
        $usersSql = User::query();
        $this->applyFilters($usersSql, $params);
        return $usersSql->get();
    }

    public function createFromArray(array $data)
    : User
    {
        return User::query()->create($data);
    }

    public function updateFromArray(User $user, array $data)
    : User
    {
        $user->update($data);
        return $user;
    }

    private function applyFilters(Builder $qb, array $params)
    : void
    {
        $qb->when($params['is_active'] == true, fn($qb) => $qb->where('is_active', true))
            ->when($params['is_admin'] == true, fn($qb) => $qb->where('is_admin', true))
            ->where('role_id', $params['role_id']);
    }

    public function delete(User $user)
    : ?int
    {
        $customers_count = $user->customers_count;

        if (!$customers_count) {
            $user->delete();
        }

        return $customers_count;
    }
}
