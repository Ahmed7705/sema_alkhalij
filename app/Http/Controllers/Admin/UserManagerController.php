<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagerController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate(['role' => 'required|string|in:admin,customer,editor']);

        $user->update(['role' => $request->role]);

        return back()->with('success', 'تم تحديث دور وصلاحيات المستخدم بنجاح.');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);

        return back()->with('success', 'تم تغيير حالة تفعيل حساب المستخدم.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'لا يمكنك حذف حسابك الحالي أثناء الجلسة.');
        }

        $user->delete();

        return back()->with('success', 'تم حذف حساب المستخدم بنجاح.');
    }
}
