<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\StaffProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StaffManagerController extends Controller
{
    public function index(Request $request)
    {
        $staffRoles = ['doctor', 'nurse', 'physio', 'lab_tech', 'customer_service', 'manager'];

        $query = User::with('staffProfile')
            ->where(function ($q) use ($staffRoles) {
                $q->whereIn('role', $staffRoles)
                  ->orWhereHas('staffProfile');
            });

        // Search Filter
        if ($request->filled('q')) {
            $qStr = $request->input('q');
            $query->where(function ($sub) use ($qStr) {
                $sub->where('name', 'LIKE', "%{$qStr}%")
                    ->orWhere('email', 'LIKE', "%{$qStr}%")
                    ->orWhere('phone', 'LIKE', "%{$qStr}%")
                    ->orWhereHas('staffProfile', function ($sp) use ($qStr) {
                        $sp->where('license_number', 'LIKE', "%{$qStr}%")
                           ->orWhere('specialty', 'LIKE', "%{$qStr}%")
                           ->orWhere('job_title', 'LIKE', "%{$qStr}%");
                    });
            });
        }

        // Role / Staff Type Filter
        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        // Active Status Filter
        if ($request->filled('is_active')) {
            $status = $request->input('is_active') === '1';
            $query->where('is_active', $status);
        }

        $staffMembers = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();

        return view('admin.staff.index', compact('staffMembers'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6',
            'role' => ['required', Rule::in(['doctor', 'nurse', 'physio', 'lab_tech', 'customer_service', 'manager'])],
            'staff_type' => 'nullable|string|max:100',
            'specialty' => 'nullable|string|max:255',
            'license_number' => 'nullable|string|max:100',
            'job_title' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => $validated['is_active'],
            'email_verified_at' => now(),
        ]);

        StaffProfile::create([
            'user_id' => $user->id,
            'staff_type' => $validated['staff_type'] ?? $validated['role'],
            'specialty' => $validated['specialty'],
            'license_number' => $validated['license_number'],
            'job_title' => $validated['job_title'],
            'is_active' => $validated['is_active'],
        ]);

        AuditLog::log('CREATE_STAFF', $user, "Created staff profile for {$user->name} ({$user->role})");

        return redirect()->route('admin.staff.index')->with('success', __('Staff member created successfully.'));
    }

    public function show($id)
    {
        $staff = User::with(['staffProfile'])->findOrFail($id);

        $assignedVisits = \App\Models\Booking::with(['service', 'user'])
            ->where('assigned_provider_id', $staff->id)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.staff.show', compact('staff', 'assignedVisits'));
    }

    public function edit($id)
    {
        $staff = User::with('staffProfile')->findOrFail($id);

        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, $id)
    {
        $staff = User::with('staffProfile')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($staff->id)],
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:6',
            'role' => ['required', Rule::in(['doctor', 'nurse', 'physio', 'lab_tech', 'customer_service', 'manager'])],
            'staff_type' => 'nullable|string|max:100',
            'specialty' => 'nullable|string|max:255',
            'license_number' => 'nullable|string|max:100',
            'job_title' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'is_active' => $validated['is_active'],
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $staff->update($userData);

        $profileData = [
            'staff_type' => $validated['staff_type'] ?? ($validated['role'] ?? 'doctor'),
            'specialty' => $validated['specialty'] ?? null,
            'license_number' => $validated['license_number'] ?? null,
            'job_title' => $validated['job_title'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ];

        if ($staff->staffProfile) {
            $staff->staffProfile->update($profileData);
        } else {
            $profileData['user_id'] = $staff->id;
            StaffProfile::create($profileData);
        }

        AuditLog::log('UPDATE_STAFF', $staff, "Updated staff profile for {$staff->name}");

        return redirect()->route('admin.staff.index')->with('success', __('Staff member updated successfully.'));
    }

    public function toggleStatus($id)
    {
        $staff = User::with('staffProfile')->findOrFail($id);

        $newStatus = !$staff->is_active;

        $staff->update(['is_active' => $newStatus]);
        if ($staff->staffProfile) {
            $staff->staffProfile->update(['is_active' => $newStatus]);
        }

        $actionText = $newStatus ? 'activated' : 'deactivated';
        AuditLog::log('TOGGLE_STAFF_STATUS', $staff, "Staff profile for {$staff->name} was {$actionText}.");

        return redirect()->back()->with('success', __("Staff member account {$actionText} successfully."));
    }
}
