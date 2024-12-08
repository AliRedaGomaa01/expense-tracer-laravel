<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(Request $request)      
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'token' => ['required', 'string'],
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ]);
            }

            $validated = $validator->validated();

            $token = Cache::get("user_{$request->user()->id}_email_verification_token");

            if ($token != $validated['token']) {
                return response()->json([
                    'status' => 'error',
                    'errors' => [
                        'token' => 'The provided token is invalid.'
                    ]
                ]);
            }

            if ($request->user()->hasVerifiedEmail()) {
                Cache::forget("user_{$request->user()->id}_email_verification_token");
                return response()->json([
                    'status' => 'error' ,
                    'message' => 'already-verified' ,
                ]);
            }

            if ($request->user()->markEmailAsVerified()) {
                event(new Verified($request->user()));
            }

            if ($request->user()->hasVerifiedEmail()) {
                Cache::forget("user_{$request->user()->id}_email_verification_token");
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'user' => $request->user()
                    ]
            ]);
            }
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }
}
