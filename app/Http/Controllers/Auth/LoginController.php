<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'يرجى إدخال البريد الإلكتروني أو رقم الجوال',
            'password.required' => 'يرجى إدخال كلمة المرور',
        ]);

        $loginInput = $request->input('login');
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials = [
            $fieldType => $loginInput,
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors(['login' => 'حسابك معطل حالياً. يرجى التواصل مع الدعم الفني.'])->withInput();
            }

            $request->session()->regenerate();
            return redirect()->intended(route('profile'))->with('success', 'مرحباً بك مجدداً، ' . $user->name);
        }

        return back()->withErrors([
            'login' => 'بيانات الدخول غير صحيحة. يرجى التثبت والتحقق.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'تم تسجيل الخروج بنجاح.');
    }
}
