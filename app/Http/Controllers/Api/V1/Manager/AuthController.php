<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Manager;

use App\Enums\User\RoleEnum;
use App\Http\Controllers\ApiController;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\V1\UserResource;
use App\Mail\Manager\LoginMail;
use App\Mail\Manager\LogoutMail;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

            // TODO: email or TG notification when user signs in
            // Notification::send($administrators, new AdminNewUserNotification($user));
            try {
                Mail::to(config('mail.to.admin'))->send(new LoginMail($user));
            } catch (Exception $exception) {
                // TODO: log exception
            }

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

        try {
            Mail::to(config('mail.to.admin'))->send(new LogoutMail($user));
        } catch (Exception $exception) {
            // TODO: log exception
        }

        return $this->successResponse(
            '',
            'success',
            __('messages.auth.logged_out'),
        );
    }
}
