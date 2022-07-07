<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            if ($request->user()->hasVerifiedEmail()) {
                return response()->json(['status' => 'Email Already Verified']);
            }
    
            $request->user()->sendEmailVerificationNotification();
            return response()->json(['status' => 'A new verification link has been sent to the email address you
            provided during registration.']);
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
