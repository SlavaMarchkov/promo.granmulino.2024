<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Admin\StoreUpdateRequest;
use App\Http\Resources\V1\User\UserCollection;
use App\Http\Resources\V1\User\UserResource;
use App\Services\Users\UserService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class AdminController extends ApiController
{
    public function __construct(
        private readonly UserService $userService,
    ) {}

    public function index()
    : JsonResponse
    {
        $admins = $this->userService->getUsers([
            'is_admin'  => true,
        ]);

        return $this->successResponse(
            new UserCollection($admins),
            'success',
            __(''),
        );
    }

    public function store(StoreUpdateRequest $request)
    : JsonResponse
    {
        $data = $request->validated();
        $admin = $this->userService->storeUser($data);

        return $this->successResponse(
            new UserResource($admin),
            'success',
            __('crud.admins.created'),
            Response::HTTP_CREATED,
        );
    }

    public function update(int $user_id, StoreUpdateRequest $request)
    : JsonResponse
    {
        $data = $request->validated();
        $admin = $this->userService->findUserById($user_id);
        $admin = $this->userService->updateUser($admin, $data);

        return $this->successResponse(
            new UserResource($admin),
            'success',
            __('crud.admins.updated'),
        );
    }

    public function destroy(int $user_id)
    : JsonResponse
    {
        $admin = $this->userService->findUserById($user_id);
        $result = $this->userService->deleteUser($admin);

        return ($result == 0)
            ? $this->successResponse(
                new UserResource($admin),
                'success',
                __('crud.admins.deleted'),
            )
            : $this->errorResponse(
                Response::HTTP_OK,
                'error',
                __('crud.admins.not_deleted'),
            );
    }
}
