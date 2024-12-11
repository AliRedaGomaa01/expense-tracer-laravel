<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    // public function create(): Response
    // {
    //     return Inertia::render('Auth/Login', [
    //         'canResetPassword' => Route::has('password.request'),
    //         'status' => session('status'),
    //     ]);
    // }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): JsonResponse
    {
        // Reset Test Email because it may be modified or removed by tester
        if ($request->email == 'test@aly-h.com' && $request->password == 'Test123$$') {

            $user = User::updateOrCreate(
                [
                    'email' => 'test@aly-h.com',
                ],
                [
                    'name' => 'Test',
                    'email_verified_at' => now(),
                    'password' => Hash::make('Test123$$'),
                ]
            );

        } else {

            $validator = Validator::make(
                $request->all(),
                [
                    'email' => ['required', 'string', 'email', 'exists:users,email', 'lowercase'],
                    'password' => ['required', 'string'],
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => [
                        'email' => ['The provided credentials are incorrect.'],
                    ]
                ]);
            }

            $validated = $validator->validated();

            $user = User::where('email', $validated['email'])?->first();

            if (!$user || !Hash::check($validated['password'], $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'errors' => [
                        'email' => ['The provided credentials are incorrect.'],
                    ],
                ]);
            }

        }

        $token = $user->createToken('login-token', ['*'], now()->addMinutes(60 * 24));

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

    /**
     * Destroy an authenticated session.
     */
    // public function destroy(Request $request): JsonResponse
    // {
    //     $user = User::find($request->user()->id);

    //     $user->tokens()->delete();

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'tokens deleted successfully'
    //     ]);
    // }
}
