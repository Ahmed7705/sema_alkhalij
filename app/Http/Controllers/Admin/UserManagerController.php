<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $currentUser = Auth::user();

        $request->validate([
            'role' => 'required|string|in:admin,super_admin,customer,doctor,nurse,physio,lab_tech,customer_service,manager,company_admin,editor'
        ]);

        // Guard: Prevent Admin from removing their own admin role
        if ($user->id === $currentUser->id && !in_array($request->role, ['admin', 'super_admin'])) {
            return back()->with('error', 'لا يمكنك إزالة صلاحيات الأدمن عن حسابك الحالي أثناء الجلسة.');
        }

        // Guard: Protect Super Admin accounts from non-super_admin users
        if ($user->role === 'super_admin' && $currentUser->role !== 'super_admin') {
            return back()->with('error', 'غير مصرح لك بتعديل دور حساب المدير الفائق (Super Admin).');
        }

        $oldRole = $user->role;
        $user->update(['role' => $request->role]);

        AuditLog::log('UPDATE_USER_ROLE', $user, ['role' => $oldRole], ['role' => $user->role]);

        return back()->with('success', 'تم تحديث دور وصلاحيات المستخدم بنجاح.');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $currentUser = Auth::user();

        // Guard: Prevent Admin from deactivating their own active account
        if ($user->id === $currentUser->id && $user->is_active) {
            return back()->with('error', 'لا يمكنك تعطيل حسابك الحالي أثناء الجلسة.');
        }

        // Guard: Protect Super Admin accounts from non-super_admin users
        if ($user->role === 'super_admin' && $currentUser->role !== 'super_admin') {
            return back()->with('error', 'غير مصرح لك بتغيير حالة تفعيل حساب المدير الفائق (Super Admin).');
        }

        $oldActive = $user->is_active;
        $newActive = !$oldActive;

        $user->update(['is_active' => $newActive]);

        AuditLog::log($newActive ? 'ACTIVATE_USER' : 'DEACTIVATE_USER', $user, ['is_active' => $oldActive], ['is_active' => $newActive]);

        return back()->with('success', 'تم تغيير حالة تفعيل حساب المستخدم.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $currentUser = Auth::user();

        if ($user->id === $currentUser->id) {
            return back()->with('error', 'لا يمكنك حذف حسابك الحالي أثناء الجلسة.');
        }

        // Guard: Protect Super Admin accounts from non-super_admin users
        if ($user->role === 'super_admin' && $currentUser->role !== 'super_admin') {
            return back()->with('error', 'غير مصرح لك بحذف حساب المدير الفائق (Super Admin).');
        }

        $oldValues = $user->toArray();
        $user->delete();

        AuditLog::log('DELETE_USER', $user, $oldValues, []);

        return back()->with('success', 'تم حذف حساب المستخدم بنجاح.');
    }
}

