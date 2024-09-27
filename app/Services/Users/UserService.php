<?php

declare(strict_types=1);

// 26.09.2024 at 18:01:53
namespace App\Services\Users;


use App\Models\User;
use App\Services\Users\Handlers\CreateUserHandler;
use App\Services\Users\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final readonly class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private CreateUserHandler       $createUserHandler,
    )
    {
    }

    public function findUser(User $user)
    : ?User
    {
        return $this->userRepository->find($user);
    }

    public function getUsers(array $params)
    : Collection
    {
        return $this->userRepository->get($params);
    }

    public function storeUser(array $data)
    : User
    {
        return $this->createUserHandler->handle($data);
    }

    public function updateUser(User $user, array $data)
    : User
    {
        // do some logic
        // TODO - проверить на is_active. Если передано false, то удалить user_id из таблицы personal_tokens
        // см. документацию по revoke tokens
        return $this->userRepository->updateFromArray($user, $data);
    }

    public function deleteUser(User $user)
    : ?int
    {
        return $this->userRepository->delete($user);
    }
}
