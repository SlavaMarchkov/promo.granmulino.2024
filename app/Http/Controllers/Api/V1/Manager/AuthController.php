<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\V1\UserResource;
use App\Mail\Manager\LoginMail;
use App\Mail\Manager\LogoutMail;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

final class AuthController extends Controller
{
    public function login(LoginRequest $request)
    : JsonResponse
    {
        $credentials = $request->validated();

        if (Auth::guard('web')->attempt(
            [
                'email'     => $credentials['email'],
                'password'  => $credentials['password'],
                'is_active' => true,
            ],
        )) {
            $user = User::where('email', $credentials['email'])->first();

            $user->tokens()->delete();
            $token = $user->createToken("Token for user: $user->full_name");

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

    public function user()
    : UserResource
    {
//        dump('here');
        $user = Auth::guard('web')->user();
        return new UserResource($user);
    }

    public function logout(Request $request)
    : JsonResponse
    {
        $request->user()->tokens()->delete();

        try {
            Mail::to(config('mail.to.admin'))->send(new LogoutMail($request->user()));
        } catch (Exception $exception) {
            // TODO: log exception
        }

        Auth::guard('web')->logout();

        return response()->json([
            'message' => __('messages.auth.logged_out'),
        ]);
    }
}
