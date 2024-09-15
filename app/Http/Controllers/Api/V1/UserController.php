<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\V1\UserCollection;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class UserController extends ApiController
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(Request $request)
    : JsonResponse
    {
        $is_active = $request->boolean('is_active');

        $users = $this->user->getUsers($is_active);

        return $this->successResponse(
            new UserCollection($users),
            'success',
            __('crud.users.all'),
        );
    }

    public function store(StoreRequest $request)
    : JsonResponse
    {
        return $this->successResponse(
            new UserResource(User::create($request->validated())),
            'success',
            __('crud.users.created'),
            Response::HTTP_CREATED,
        );
    }

    public function show(User $user)
    : JsonResponse
    {
        return $this->successResponse(
            new UserResource($user),
            'success',
            __('crud.users.one'),
        );
    }

    public function update(UpdateRequest $request, User $user)
    : JsonResponse
    {
        $user->update($request->validated());

        return $this->successResponse(
            new UserResource($user),
            'success',
            __('crud.users.updated'),
        );
    }

    public function destroy(User $user)
    : JsonResponse
    {
        $canBeDeleted = false;

        if ($canBeDeleted) {
            $user->delete();

            return $this->successResponse(
                new UserResource($user),
                'success',
                __('crud.users.deleted'),
            );
        } else {
            return $this->errorResponse(
                Response::HTTP_OK,
                'error',
                __('crud.users.not_deleted'),
            );
        }
    }
}
