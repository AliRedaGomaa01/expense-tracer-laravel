<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'status' => 'error',
                'message' => 'already-verified'
            ]);
        }

        $token = Str::random(20);

        Cache::put("user_{$request->user()->id}_email_verification_token", $token, now()->addMinutes(60));

        Mail::to($request->user()->email)->send(new \App\Mail\VerifyEmailTokenMail($token));

        return response()->json([
            'status' => 'success',
            'message' => 'verification-link-sent'
        ]);
    }
}
