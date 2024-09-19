<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

final class AuthController extends Controller
{
    public function login(LoginRequest $request)
    : JsonResponse {
        $credentials = $request->validated();

        if (Auth::attempt([
            'email'     => $credentials['email'],
            'password'  => $credentials['password'],
            'is_active' => true,
        ])) {
            $user = User::where('email', $credentials['email'])->first();

            $user->tokens()->delete();
            $token = $user->createToken("Token for user: $user->name");

            $user->update([
                'logged_in_at' => now(),
            ]);

            // TODO: email or TG notification when user signs in
            // Notification::send($administrators, new AdminNewUserNotification($user));

            return response()->json([
                'token'   => $token->plainTextToken,
                'message' => __('messages.auth.auth_successful'),
            ]);
        } else {
            throw ValidationException::withMessages([
                'email' => [__('messages.auth.invalid_credentials')],
            ]);
        }
    }

    public function user(Request $request)
    : UserResource {
        return new UserResource($request->user());
    }

    public function logout(Request $request)
    : JsonResponse {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => __('messages.auth.logged_out'),
        ]);
    }
}
