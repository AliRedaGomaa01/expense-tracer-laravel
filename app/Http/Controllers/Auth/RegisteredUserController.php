<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $verifyToken = Str::random(20);

        Cache::put("user_{$user->id}_email_verification_token", $verifyToken, now()->addMinutes(60));

        Mail::to($user->email)->send(new \App\Mail\VerifyEmailTokenMail($verifyToken));

        $token = $user->createToken('register-token', ['*'], now()->addMinutes(60 * 24));

        return response()->json([
            'status' => 'success',
            'data' => [
                'token' => [
                    'text' => $token->plainTextToken,
                    'expires_at' => PersonalAccessToken::findToken($token->plainTextToken)->expires_at
                ],
                'user' => $user
            ]
        ]);
    }
}
