<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Enums\User\RoleEnum;
use App\Http\Controllers\ApiController;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\V1\UserCollection;
use App\Http\Resources\V1\UserResource;
use App\Models\Role;
use App\Models\User;
use App\Services\Users\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class UserController extends ApiController
{
    public function __construct(
        private readonly UserService $userService,
        private readonly Role        $role,
    )
    {
    }

    public function index(Request $request)
    : JsonResponse
    {
        $users = $this->userService->getUsers([
            'is_active' => $request->boolean('is_active'),
            'is_admin'  => false,
            'role_id'   => $this->role->getRoleId(RoleEnum::MANAGER->getName()),
        ]);

        return $this->successResponse(
            new UserCollection($users),
            'success',
            __('crud.users.all'),
        );
    }

    public function store(StoreRequest $request)
    : JsonResponse
    {
        $user = $this->userService->storeUser($request->validated());

        return $this->successResponse(
            new UserResource($user),
            'success',
            __('crud.users.created'),
            Response::HTTP_CREATED,
        );
    }

    public function show(User $user)
    : JsonResponse
    {
        $user = $this->userService->findUser($user);

        return $this->successResponse(
            new UserResource($user),
            'success',
            __('crud.users.one'),
        );
    }

    public function update(UpdateRequest $request, User $user)
    : JsonResponse
    {
        $data = $request->validated();
        $user = $this->userService->updateUser($user, $data);

        return $this->successResponse(
            new UserResource($user),
            'success',
            __('crud.users.updated'),
        );
    }

    public function destroy(User $user)
    : JsonResponse
    {
        $result = $this->userService->deleteUser($user);

        return ($result === null)
            ? $this->successResponse(
                new UserResource($user),
                'success',
                __('crud.users.deleted'),
            )
            : $this->errorResponse(
                Response::HTTP_OK,
                'error',
                __('crud.users.not_deleted'),
            );
    }
}
