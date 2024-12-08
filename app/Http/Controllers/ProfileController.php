<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            $request->rules()
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ]);
        }

        $request->user()->fill($validator->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        $token = Str::random(20);

        Cache::put("user_{$request->user()->id}_email_verification_token", $token, now()->addMinutes(60));

        Mail::to($request->user()->email)->send(new \App\Mail\VerifyEmailTokenMail($token ));

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $request->user()
            ]
    ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'password' => ['required', 'current_password'],
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ]);
        }

        $user = $request->user();

        $user->tokens()->delete();

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'account deleted successfully'
    ]);
    }
}
