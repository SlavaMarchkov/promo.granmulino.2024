<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

final class AuthController extends Controller
{
    public function register(StoreRequest $request)
    {
        return response()->json([
            'user'    => new UserResource(User::create($request->validated())),
            'message' => 'Регистрация завершена. Выполните вход в систему.',
        ], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Пароль или email введены неверно.'],
            ]);
        }

        $user = User::where('email', $credentials['email'])->firstOrFail();

        $user->tokens()->delete();
        $token = $user->createToken("Token for user: $user->name", ['*'], now()->addMinutes(10));

        return response()->json([
            'user'    => new UserResource($user),
            'token'   => $token->plainTextToken,
            'message' => 'Вы успешно авторизовались в системе.',
        ]);
    }

    public function user(Request $request)
    {
        return new UserResource($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Вы вышли из системы.',
        ]);
    }
}
