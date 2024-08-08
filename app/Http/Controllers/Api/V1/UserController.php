<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\V1\UserCollection;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index(Request $request)
    : UserCollection
    {
        $is_active = $request->boolean('is_active');

        $users = User::query()
            ->when($is_active, fn($query) => $query->where('is_active', true))
            ->get();

        return new UserCollection($users);
    }

    public function store(StoreRequest $request)
    : JsonResponse {
        return response()->json([
            'item'    => new UserResource(User::create($request->validated())),
            'status'  => 'success',
            'message' => 'Пользователь создан.',
        ], Response::HTTP_CREATED);
    }

    public function show(User $user)
    : UserResource {
        return new UserResource($user);
    }

    public function update(UpdateRequest $request, User $user)
    : JsonResponse {
        $user->update($request->validated());
        return response()->json([
            'item'    => new UserResource($user),
            'status'  => 'success',
            'message' => 'Пользователь обновлён.',
        ], Response::HTTP_OK);
    }

    public function destroy(User $user)
    {
    }
}
