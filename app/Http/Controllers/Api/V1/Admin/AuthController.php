<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\V1\AdminResource;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

final class AuthController extends Controller
{
    public function login(LoginRequest $request)
    : JsonResponse {
        $credentials = $request->validated();

        if (Auth::guard('admin')->attempt(
            [
                'email'     => $credentials['email'],
                'password'  => $credentials['password'],
                'is_active' => true,
            ]
        )) {
            $admin = Admin::where('email', $credentials['email'])->first();

            // TODO: email or TG notification
            // Notification::send($administrators, new AdminNewUserNotification($user));

            $admin->tokens()->delete();
            $token = $admin->createToken("Token for admin: $admin->name", ['*'], now()->addHours(24));

            $admin->update([
                'logged_in_at' => now(),
            ]);

            return response()->json([
                'token'   => $token->plainTextToken,
                'message' => __('messages.auth.admin_auth_successful'),
            ]);
        } else {
            throw ValidationException::withMessages([
                'email' => [__('messages.auth.invalid_credentials')],
            ]);
        }
    }

    public function logout()
    : JsonResponse
    {
        $user = Auth::guard('admin')->user();
        $user->tokens()->delete();

        return response()->json([
            'message' => __('messages.auth.admin_logged_out'),
        ]);
    }

    public function user()
    : AdminResource
    {
        $user = Auth::guard('admin')->user();
        return new AdminResource($user);
    }
}
