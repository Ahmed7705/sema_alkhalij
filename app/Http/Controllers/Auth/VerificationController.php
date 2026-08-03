<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    public function showVerificationForm(Request $request)
    {
        $email = session('verify_email') ?? $request->query('email');
        return view('auth.verify-otp', compact('email'));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|string|size:6',
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب',
            'code.required' => 'يرجى أدخال كود التفعيل المكون من 6 أرقام',
            'code.size' => 'كود التفعيل يتكون من 6 أرقام بالضبط',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'المستخدم غير موجود'])->withInput();
        }

        if ($user->verification_code !== $request->code) {
            return back()->withErrors(['code' => 'كود التفعيل غير صحيح'])->withInput();
        }

        if ($user->code_expires_at && now()->gt($user->code_expires_at)) {
            return back()->withErrors(['code' => 'انتهت صلاحية كود التفعيل. يرجى طلب كود جديد.'])->withInput();
        }

        // Activate and verify user
        $user->update([
            'email_verified_at' => now(),
            'verification_code' => null,
            'code_expires_at' => null,
        ]);

        Auth::login($user);
        session()->forget('verify_email');

        return redirect()->route('profile')->with('success', 'تم تفعيل حسابك بنجاح! مرحباً بك في سيما الخليج.');
    }

    public function resend(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        $otp = (string) rand(100000, 999999);
        $user->update([
            'verification_code' => $otp,
            'code_expires_at' => now()->addMinutes(15),
        ]);

        try {
            Mail::send('emails.verify-otp', ['user' => $user, 'otp' => $otp], function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('كود تفعيل جديد - سيما الخليج للخدمات الطبية');
            });
        } catch (\Exception $e) {
            \Log::error('Resend OTP error: ' . $e->getMessage());
        }

        return back()->with('success', 'تمت إعادة إرسال كود التفعيل الجديد إلى بريدك الإلكتروني.');
    }
}
