<?php

declare(strict_types=1);

// 26.09.2024 at 19:39:58
namespace App\Services\Users\Handlers;


use App\Enums\User\RoleEnum;
use App\Models\Role;
use App\Models\User;
use App\Services\Users\Repositories\UserRepositoryInterface;

final readonly class CreateUserHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private Role                    $role,
    )
    {
    }

    public function handle(array $data)
    : User
    {
        $data['last_name'] = process_name($data['last_name']);
        $data['first_name'] = process_name($data['first_name']);
        $data['middle_name'] = process_name($data['middle_name']);
        $data['role_id'] = $this->role->getRoleId(RoleEnum::MANAGER->getName());

        return $this->userRepository->createFromArray($data);
    }
}
