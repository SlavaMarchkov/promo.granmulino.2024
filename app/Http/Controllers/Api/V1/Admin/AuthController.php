<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Enums\User\RoleEnum;
use App\Http\Controllers\ApiController;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\V1\User\UserResource;
use App\Models\User;
use App\Notifications\LoginAdminNotification;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

final class AuthController extends ApiController
{
    public function login(LoginRequest $request)
    : JsonResponse
    {
        $credentials = $request->validated();

        if (Auth::attempt([
            'email'     => $credentials['email'],
            'password'  => $credentials['password'],
            'is_active' => true,
            'is_admin'  => true,
        ],
        )) {
            $role_ids = DB::table('roles')
                ->where(
                    'slug',
                    '!=',
                    RoleEnum::MANAGER->getName(),
                )
                ->pluck('id');

            $admin = User::query()
                ->where('email', $credentials['email'])
                ->where('is_admin', true)
                ->whereIn('role_id', $role_ids)
                ->first();

            $role = $admin->role->slug;

            $admin->tokens()->delete();

            $token = $admin
                ->createToken("Token for $role: $admin->display_name", ['*'], now()->addHours(24))
                ->plainTextToken;

            $admin->update([
                'logged_in_at' => now(),
            ]);

            $admin->notify(new LoginAdminNotification());

            return $this->successResponse(
                ['token' => $token],
                'success',
                __('messages.auth.admin_auth_successful'),
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
        $admin = auth()->user();
        $admin->tokens()->delete();

        event(new Logout('web', $admin));

        return $this->successResponse(
            '',
            'success',
            __('messages.auth.admin_logged_out'),
        );
    }
}
