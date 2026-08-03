<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'الاسم الكامل مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة',
            'email.unique' => 'البريد الإلكتروني مسجل بالفعل',
            'phone.required' => 'رقم الجوال مطلوب',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'يجب أن لا تقل كلمة المرور عن 8 أحرف',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق',
        ]);

        // Generate 6-digit verification code
        $otp = (string) rand(100000, 999999);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'verification_code' => $otp,
            'code_expires_at' => now()->addMinutes(15),
            'role' => 'customer',
            'is_active' => true,
        ]);

        // Send OTP verification email
        try {
            Mail::send('emails.verify-otp', ['user' => $user, 'otp' => $otp], function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('كود التفعيل - سيما الخليج للخدمات الطبية');
            });
        } catch (\Exception $e) {
            // Log mail failure gracefully, allow testing mode
            \Log::error('Failed to send OTP verification mail: ' . $e->getMessage());
        }

        // Store email in session for verification screen
        session(['verify_email' => $user->email]);

        return redirect()->route('verify.otp.form')->with('success', 'تم إنشاء الحساب بنجاح! تم إرسال كود التحقق إلى بريدك الإلكتروني.');
    }
}
