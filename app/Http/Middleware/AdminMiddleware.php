<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'يرجى تسجيل الدخول للوصول للوحة التحكم.');
        }

        $user = auth()->user();
        if ($user->role !== 'admin' && !$user->isSuperAdmin()) {
            return redirect()->route('home')->with('error', 'عذراً، هذه الصفحة مخصصة لمديري النظام فقط.');
        }

        return $next($request);
    }
}
