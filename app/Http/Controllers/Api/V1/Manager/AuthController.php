<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Manager;

use App\Enums\User\RoleEnum;
use App\Http\Controllers\ApiController;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\V1\User\UserResource;
use App\Jobs\LoginManagerJob;
use App\Jobs\LogoutManagerJob;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final class AuthController extends ApiController
{
    public function login(LoginRequest $request, Role $role)
    : JsonResponse
    {
        $credentials = $request->validated();

        if (Auth::attempt([
            'email'     => $credentials['email'],
            'password'  => $credentials['password'],
            'is_active' => true,
            'is_admin'  => false,
        ],
        )) {
            $user = User::query()
                ->where('email', $credentials['email'])
                ->where('is_admin', false)
                ->where('role_id', $role->getRoleId(RoleEnum::MANAGER->getName()))
                ->first();

            $role = $user->role->slug; // "MANAGER"

            $user->tokens()->delete();

            $token = $user
                ->createToken("Token for $role: $user->full_name")
                ->plainTextToken;

            $user->update([
                'logged_in_at' => now(),
            ]);

            LoginManagerJob::dispatch($user);

            return $this->successResponse(
                ['token' => $token],
                'success',
                __('messages.auth.auth_successful'),
            );
        }

        return $this->errorResponse(
            Response::HTTP_UNAUTHORIZED,
            'error',
            __('messages.auth.invalid_credentials'),
        );
    }

    public function user()
    : UserResource
    {
        $user = auth()->user();
        return new UserResource($user);
    }

    public function logout()
    : JsonResponse
    {
        $user = auth()->user();
        $user->tokens()->delete();

        LogoutManagerJob::dispatch($user);

        return $this->successResponse(
            '',
            'success',
            __('messages.auth.logged_out'),
        );
    }
}
