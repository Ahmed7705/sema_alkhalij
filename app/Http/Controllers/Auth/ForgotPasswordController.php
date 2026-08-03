<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'يرجى إدخال البريد الإلكتروني',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة',
            'email.exists' => 'البريد الإلكتروني غير مسجل لدينا',
        ]);

        $otp = (string) rand(100000, 999999);
        $user = User::where('email', $request->email)->first();

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $otp,
                'created_at' => now(),
            ]
        );

        try {
            Mail::send('emails.reset-password-otp', ['user' => $user, 'otp' => $otp], function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('كود إعادة تعيين كلمة المرور - سيما الخليج');
            });
        } catch (\Exception $e) {
            \Log::error('Failed to send password reset email: ' . $e->getMessage());
        }

        session(['reset_email' => $request->email]);

        return redirect()->route('password.reset.form')->with('success', 'تم إرسال كود إعادة تعيين كلمة المرور إلى بريدك الإلكتروني.');
    }
}
