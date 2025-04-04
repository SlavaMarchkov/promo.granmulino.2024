<?php

declare(strict_types=1);

// 26.09.2024 at 18:39:39
namespace App\Services\Users\Repositories;


use App\Models\Image;
use App\Models\User;
use App\Services\Users\Filters\Images;
use App\Services\Users\Filters\IsActive;
use App\Services\Users\Filters\IsAdmin;
use App\Services\Users\Filters\RoleId;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pipeline\Pipeline;

final class EloquentUserRepository implements UserRepositoryInterface
{
    public function find(User $user)
    : ?User {
        return User::query()->where('id', $user->id)->first();
    }

    public function findById(int $user_id)
    : ?User {
        return User::query()->where('id', $user_id)->first();
    }

    /**
     * @throws BindingResolutionException
     */
    public function get(array $params = [])
    : Collection {
        request()->merge($params);
        $users = app()->make(Pipeline::class)
            ->send(User::query())
            ->through([
                IsActive::class,
                IsAdmin::class,
                RoleId::class,
                Images::class,
            ])
            ->thenReturn();
        return $users->get();
    }

    public function createFromArray(array $data)
    : User {
        return User::query()->create($data);
    }

    public function updateFromArray(User $user, array $data)
    : User {
        $user->update($data);
        return $user;
    }

    public function delete(User $user)
    : int {
        $customers_count = $user->customers->count();

        if ($customers_count == 0) {
            $user->delete();
        }

        return $customers_count;
    }

    public function createImageFromArray(
        string $file,
        string $thumbnail,
        int $user_id,
        string $class,
    )
    : Image {
        return Image::query()->updateOrCreate([
            'file'           => $file,
            'imageable_id'   => $user_id,
        ], [
            'file'           => $file,
            'thumbnail'      => $thumbnail,
            'imageable_id'   => $user_id,
            'imageable_type' => $class,
            'is_main'        => false,
        ]);
    }
}
