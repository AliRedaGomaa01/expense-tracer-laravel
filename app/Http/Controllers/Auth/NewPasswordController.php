<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;

class NewPasswordController extends Controller
{
    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'token' => ['required', 'string'],
                    'email' => ['required', 'email', 'exists:users,email', 'lowercase'],
                    'password' => ['required', 'confirmed', Rules\Password::defaults()],
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();

            $user = User::where('email', $validated['email'])->first();

            $user->password = Hash::make($validated['password']);
            $user->save();

            $token = Cache::get("user_{$validated['email']}_password_reset_token");

            if ($token != $validated['token']) {
                return response()->json([
                    'status' => 'error',
                    'errors' => [
                        'token' => 'The provided token is invalid.'
                    ]
                ]);
            }

            Cache::forget("user_{$validated['email']}_password_reset_token");

            event(new PasswordReset($user));

            return response()->json([
                'status' => 'success',
                'message' => 'password was reset successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json($e);
        }
    }
}
