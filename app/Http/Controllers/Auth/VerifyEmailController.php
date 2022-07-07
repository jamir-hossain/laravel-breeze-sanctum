<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request, $id)
    {
        try {
            $decryptedId = Crypt::decryptString($id);
            if ($request->user()->hasVerifiedEmail()) {
                return response(['status'=>'Email Already Verified', 'user'=>$request->user()], 200);
            }

            if ($request->user()->markEmailAsVerified()) {
                event(new Verified($request->user()));
            }
            return response(['status'=>'Email Successfully Verified', 'user'=>$request->user()], 200);
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
