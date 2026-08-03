<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request)
    {
        $email = session('reset_email') ?? $request->query('email');
        return view('auth.reset-password', compact('email'));
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required|string|size:6',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب',
            'token.required' => 'يرجى أدخال كود إعادة التعيين المكون من 6 أرقام',
            'token.size' => 'كود إعادة التعيين يتكون من 6 أرقام',
            'password.required' => 'كلمة المرور الجديدة مطلوبة',
            'password.min' => 'يجب أن لا تقل كلمة المرور عن 8 أحرف',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق',
        ]);

        $resetRecord = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetRecord) {
            return back()->withErrors(['token' => 'كود إعادة التعيين غير صحيح أو منتهي الصلاحية.'])->withInput();
        }

        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_resets')->where('email', $request->email)->delete();
        session()->forget('reset_email');

        Auth::login($user);

        return redirect()->route('profile')->with('success', 'تم تغيير كلمة المرور بنجاح وتسجيل دخولك.');
    }
}
