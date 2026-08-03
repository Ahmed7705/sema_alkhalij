<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Booking;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the Patient & Customer Portal Dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $userPhone = $user ? $user->phone : null;
        $userId = $user ? $user->id : null;

        $bookings = Booking::with('service')
            ->where(function ($q) use ($userId, $userPhone) {
                if ($userId) $q->where('user_id', $userId);
                if ($userPhone) $q->orWhere('phone', $userPhone);
            })
            ->latest()
            ->get();

        $orders = Order::with('items')
            ->where(function ($q) use ($userId, $userPhone) {
                if ($userId) $q->where('user_id', $userId);
                if ($userPhone) $q->orWhere('phone', $userPhone);
            })
            ->latest()
            ->get();

        $addresses = $userId ? Address::where('user_id', $userId)->get() : collect();

        return view('profile', compact('bookings', 'orders', 'addresses'));
    }

    /**
     * Update User Profile Details.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ], [
            'name.required' => 'الاسم مطلوب.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',
        ]);

        $user->update($validated);

        return back()->with('success', 'تم تحديث البيانات الشخصية بنجاح.');
    }

    /**
     * Update User Password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'كلمة المرور الحالية مطلوبة.',
            'new_password.required' => 'كلمة المرور الجديدة مطلوبة.',
            'new_password.min' => 'كلمة المرور الجديدة يجب أن تكون 8 أحرف على الأقل.',
            'new_password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'تم تغيير كلمة المرور بنجاح.');
    }
}
