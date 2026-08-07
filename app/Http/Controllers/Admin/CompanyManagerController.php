<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyManagerController extends Controller
{
    public function index(Request $request)
    {
        $query = Company::query()->withCount(['users', 'contracts', 'bookings']);

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('cr_number', 'like', "%{$search}%")
                  ->orWhere('company_code', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        $companies = $query->latest()->paginate(15)->withQueryString();

        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cr_number' => 'nullable|string|max:100|unique:companies,cr_number',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'status' => 'required|string|in:active,inactive,suspended',
        ]);

        $companyCode = 'COMP-' . strtoupper(Str::random(6));
        while (Company::where('company_code', $companyCode)->exists()) {
            $companyCode = 'COMP-' . strtoupper(Str::random(6));
        }

        $company = Company::create([
            'name' => $validated['name'],
            'company_code' => $companyCode,
            'cr_number' => $validated['cr_number'] ?? null,
            'contact_person' => $validated['contact_person'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'city' => $validated['city'] ?? null,
            'address' => $validated['address'] ?? null,
            'status' => $validated['status'],
        ]);

        AuditLog::log('CREATE_COMPANY', $company, null, $company->toArray());

        return redirect()->route('admin.companies.show', $company->id)
            ->with('success', 'تم إنشاء سجل الشركة بنجاح كود: ' . $company->company_code);
    }

    public function show(Request $request, $id)
    {
        $company = Company::with(['activeContract', 'contractRequest'])->findOrFail($id);

        $activeContractsCount = $company->contracts()->where('status', 'active')->count();
        
        // Calculate beneficiaries count safely
        $beneficiariesCount = 0;
        if (\Illuminate\Support\Facades\Schema::hasTable('contract_beneficiaries')) {
            $contractIds = $company->contracts()->pluck('id');
            $beneficiariesCount = \Illuminate\Support\Facades\DB::table('contract_beneficiaries')
                ->whereIn('contract_id', $contractIds)
                ->count();
        }

        $totalVisitsCount = $company->bookings()->count();
        $completedVisitsCount = $company->bookings()->where('status', 'completed')->count();
        $activeVisitsCount = $company->bookings()->whereIn('status', ['assigned', 'accepted', 'in_progress'])->count();

        $users = $company->users()->latest()->paginate(10, ['*'], 'users_page');
        $contracts = $company->contracts()->latest()->paginate(10, ['*'], 'contracts_page');
        $bookings = $company->bookings()->with('service', 'assignedProvider')->latest()->paginate(10, ['*'], 'visits_page');
        
        $auditLogs = AuditLog::where(function ($q) use ($id) {
            $q->where('model_type', Company::class)->where('model_id', $id);
        })->latest()->limit(20)->get();

        return view('admin.companies.show', compact(
            'company',
            'activeContractsCount',
            'beneficiariesCount',
            'totalVisitsCount',
            'completedVisitsCount',
            'activeVisitsCount',
            'users',
            'contracts',
            'bookings',
            'auditLogs'
        ));
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('admin.companies.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cr_number' => 'nullable|string|max:100|unique:companies,cr_number,' . $company->id,
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'status' => 'required|string|in:active,inactive,suspended',
        ]);

        $oldValues = $company->toArray();
        $company->update($validated);

        AuditLog::log('UPDATE_COMPANY', $company, $oldValues, $company->toArray());

        return redirect()->route('admin.companies.show', $company->id)
            ->with('success', 'تم تحديث بيانات الشركة بنجاح.');
    }

    public function toggleStatus($id)
    {
        $company = Company::findOrFail($id);
        $newStatus = $company->status === 'active' ? 'inactive' : 'active';

        $oldStatus = $company->status;
        $company->update(['status' => $newStatus]);

        AuditLog::log($newStatus === 'active' ? 'ACTIVATE_COMPANY' : 'DEACTIVATE_COMPANY', $company, ['status' => $oldStatus], ['status' => $newStatus]);

        return redirect()->back()->with('success', 'تم تغيير حالة الشركة إلى: ' . $newStatus);
    }

    public function addUser(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:50',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:company_admin,company_operator',
            'is_active' => 'required|boolean',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
            'company_id' => $company->id,
            'is_active' => $validated['is_active'],
        ]);

        AuditLog::log('ADD_COMPANY_USER', $company, null, ['user_id' => $user->id, 'email' => $user->email, 'role' => $user->role]);

        return redirect()->back()->with('success', 'تم تسجيل مستخدم جديد للشركة بنجاح: ' . $user->name);
    }

    public function detachUser(Request $request, $id, $userId)
    {
        $company = Company::findOrFail($id);
        $user = User::where('company_id', $company->id)->findOrFail($userId);

        $user->update(['company_id' => null]);

        AuditLog::log('DETACH_COMPANY_USER', $company, ['user_id' => $user->id], ['company_id' => null]);

        return redirect()->back()->with('success', 'تم إزالة ارتباط المستخدم من الشركة بنجاح.');
    }

    public function toggleUserStatus(Request $request, $id, $userId)
    {
        $company = Company::findOrFail($id);
        $user = User::where('company_id', $company->id)->findOrFail($userId);

        $newActive = !$user->is_active;
        $user->update(['is_active' => $newActive]);

        AuditLog::log($newActive ? 'ACTIVATE_COMPANY_USER' : 'DEACTIVATE_COMPANY_USER', $user, ['is_active' => !$newActive], ['is_active' => $newActive]);

        return redirect()->back()->with('success', 'تم تغيير حالة حساب المستخدم بنجاح.');
    }
}
