<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Enums\User\RoleEnum;
use App\Http\Controllers\ApiController;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\V1\User\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

final class AuthController extends ApiController
{
    public function login(LoginRequest $request)
    : JsonResponse {
        $credentials = $request->validated();

        event(new Attempting('admin', $credentials, false));

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

        if ($admin) {
            $role = $admin->role->slug;

            $admin->tokens()->delete();
            $request->session()->regenerate();

            $token = $admin
                ->createToken("Token for $role: $admin->display_name", ['*'], now()->addHours(24))
                ->plainTextToken;

            $admin->update([
                'logged_in_at' => now(),
            ]);

            event(new Login('admin', $admin, false));

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
        request()->session()->invalidate();
//        request()->session()->regenerateToken();

//        DB::delete('delete from sessions where user_id = ?', [$admin->id]);

        event(new Logout('admin', $admin));

        return $this->successResponse(
            '',
            'success',
            __('messages.auth.admin_logged_out'),
        );
    }
}
