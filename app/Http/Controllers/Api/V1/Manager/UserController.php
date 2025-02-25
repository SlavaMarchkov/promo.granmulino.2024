<?php

declare(strict_types=1);

// 22.02.2025 at 13:33:28
namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Image\StoreUserImageRequest;
use App\Http\Resources\V1\User\UserResource;
use App\Models\User;
use App\Services\Users\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class UserController extends ApiController
{

    public function __construct(
        private readonly UserService $userService,
    ) {
    }

    public function store(StoreUserImageRequest $request)
    : JsonResponse {
        $data = $request->validated();
        $user_id = (int)$data['user_id'];
        $images = $data['images'];

        foreach ($images as $image) {
            $file = upload_image(
                $image,
                config('image.path_to_user_images'),
                config('image.default_width')
            );
            $thumbnail = upload_thumbnail(
                $image,
                $file,
                config('image.path_to_user_thumbnails')
            );
            $this->userService->storeUserImage($file, $thumbnail, $user_id, User::class);
        }

        $user = $this->userService->findUserById($user_id);

        return $this->successResponse(
            new UserResource($user->load('images')),
            'success',
            __('crud.users.updated'),
        );
    }

    public function update(Request $request, User $user)
    {
    }

    public function upload()
    {
        return response()->noContent();
    }
}
