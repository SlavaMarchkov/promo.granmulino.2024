<?php

declare(strict_types=1);

// 23.02.2025 at 17:04:43
namespace App\Services\Users\Handlers;


use App\Models\Image;
use App\Services\Users\Repositories\UserRepositoryInterface;

final class CreateUserImageHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function handle(
        string $file,
        string $thumbnail,
        int $user_id,
        string $class,
    )
    : Image {
        return $this->userRepository->createImageFromArray($file, $thumbnail, $user_id, $class);
    }
}
