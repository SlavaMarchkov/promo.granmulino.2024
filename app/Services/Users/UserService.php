<?php

declare(strict_types=1);

// 26.09.2024 at 18:01:53
namespace App\Services\Users;


use App\Models\User;
use App\Services\Users\Handlers\CreateUserHandler;
use App\Services\Users\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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

    public function findUserById(int $user_id)
    : ?User
    {
        return $this->userRepository->findById($user_id);
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
        if ($data['is_active'] === false) {
            $this->clearTokensAndSessions($user);
        }

        return $this->userRepository->updateFromArray($user, $data);
    }

    public function deleteUser(User $user)
    : int
    {
        $this->clearTokensAndSessions($user);
        return $this->userRepository->delete($user);
    }

    /**
     * @param User $user
     * @return void
     */
    private function clearTokensAndSessions(User $user)
    : void {
        $user->tokens()->delete();
        DB::delete('delete from sessions where user_id = ?', [$user->id]);
    }
}
