<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContractBeneficiary;
use App\Models\Contract;
use App\Models\Company;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class BeneficiaryManagerController extends Controller
{
    public function index(Request $request)
    {
        $query = ContractBeneficiary::with(['company', 'contract', 'patient']);

        // Search q
        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'LIKE', "%{$q}%")
                    ->orWhere('identification_number', 'LIKE', "%{$q}%")
                    ->orWhere('employee_id_number', 'LIKE', "%{$q}%")
                    ->orWhere('phone', 'LIKE', "%{$q}%")
                    ->orWhereHas('patient', function ($p) use ($q) {
                        $p->where('name', 'LIKE', "%{$q}%")
                          ->orWhere('email', 'LIKE', "%{$q}%")
                          ->orWhere('phone', 'LIKE', "%{$q}%");
                    });
            });
        }

        // Filter company
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        // Filter contract
        if ($request->filled('contract_id')) {
            $query->where('contract_id', $request->contract_id);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter identification type
        if ($request->filled('identification_type')) {
            $query->where('identification_type', $request->identification_type);
        }

        $beneficiaries = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $companies = Company::orderBy('name')->get();
        $contracts = Contract::orderBy('contract_number')->get();

        return view('admin.beneficiaries.index', compact('beneficiaries', 'companies', 'contracts'));
    }

    public function create(Request $request)
    {
        $companies = Company::where('status', 'active')->orderBy('name')->get();
        $selectedCompanyId = $request->get('company_id', $companies->first()->id ?? null);
        
        $contracts = Contract::where('status', 'active')
                             ->when($selectedCompanyId, fn($q) => $q->where('company_id', $selectedCompanyId))
                             ->orderBy('contract_number')
                             ->get();

        return view('admin.beneficiaries.create', compact('companies', 'contracts', 'selectedCompanyId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'contract_id' => 'required|exists:contracts,id',
            'name' => 'required|string|max:100',
            'identification_type' => 'required|in:saudi_id,iqama,border_number,gcc_id',
            'identification_number' => 'required|string|max:50',
            'phone' => 'nullable|string|max:20',
            'employee_id_number' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
        ]);

        // Validate contract belongs to company
        $contract = Contract::where('id', $validated['contract_id'])
                            ->where('company_id', $validated['company_id'])
                            ->first();

        if (!$contract) {
            return redirect()->back()->withInput()->with('error', 'العقد المحدد لا ينتمي لهذه الشركة.');
        }

        // Prevent duplicate beneficiary identification under same contract
        $duplicate = ContractBeneficiary::where('contract_id', $validated['contract_id'])
                                        ->where('identification_number', $validated['identification_number'])
                                        ->first();
        if ($duplicate) {
            return redirect()->back()->withInput()->with('error', 'هذا المستفيد مسجل بالفعل تحت هذا العقد برقم الهوية نفسه.');
        }

        // Search existing Patient/User: Primary match by identification_number; fallback by phone only if identification_number is empty
        $existingPatient = null;
        if (!empty($validated['identification_number'])) {
            $existingPatient = User::where('identification_number', $validated['identification_number'])->first();
        } elseif (!empty($validated['phone'])) {
            $existingPatient = User::where('phone', $validated['phone'])->first();
        }

        $beneficiary = ContractBeneficiary::create([
            'contract_id' => $validated['contract_id'],
            'company_id' => $validated['company_id'],
            'patient_id' => $existingPatient ? $existingPatient->id : null,
            'name' => $validated['name'],
            'identification_type' => $validated['identification_type'],
            'identification_number' => $validated['identification_number'],
            'phone' => $validated['phone'] ?? null,
            'employee_id_number' => $validated['employee_id_number'] ?? null,
            'status' => $validated['status'],
        ]);

        if ($existingPatient) {
            AuditLog::log('LINK_BENEFICIARY_PATIENT', $beneficiary, [], ['patient_id' => $existingPatient->id, 'patient_name' => $existingPatient->name]);
            $msg = 'تم إضافـة المستفيد بنجاح، وربطه تلقائياً بحساب المريض المسجل (' . $existingPatient->name . ').';
        } else {
            AuditLog::log('CREATE_BENEFICIARY', $beneficiary, [], $beneficiary->toArray());
            $msg = 'تم إضافة المستفيد بنجاح.';
        }

        return redirect()->route('admin.beneficiaries.index')
            ->with('success', $msg);
    }

    public function show($id)
    {
        $beneficiary = ContractBeneficiary::with(['company', 'contract', 'patient', 'bookings.service'])->findOrFail($id);
        return view('admin.beneficiaries.show', compact('beneficiary'));
    }

    public function edit($id)
    {
        $beneficiary = ContractBeneficiary::findOrFail($id);
        $companies = Company::orderBy('name')->get();
        $contracts = Contract::where('company_id', $beneficiary->company_id)->orderBy('contract_number')->get();

        return view('admin.beneficiaries.edit', compact('beneficiary', 'companies', 'contracts'));
    }

    public function update(Request $request, $id)
    {
        $beneficiary = ContractBeneficiary::findOrFail($id);

        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'contract_id' => 'required|exists:contracts,id',
            'name' => 'required|string|max:100',
            'identification_type' => 'required|in:saudi_id,iqama,border_number,gcc_id',
            'identification_number' => 'required|string|max:50',
            'phone' => 'nullable|string|max:20',
            'employee_id_number' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
        ]);

        // Re-check existing patient if identification_number changed
        if ($validated['identification_number'] !== $beneficiary->identification_number || !$beneficiary->patient_id) {
            $existingPatient = null;
            if (!empty($validated['identification_number'])) {
                $existingPatient = User::where('identification_number', $validated['identification_number'])->first();
            } elseif (!empty($validated['phone'])) {
                $existingPatient = User::where('phone', $validated['phone'])->first();
            }

            if ($existingPatient) {
                $beneficiary->patient_id = $existingPatient->id;
            }
        }

        $oldData = $beneficiary->toArray();
        $beneficiary->update($validated);

        AuditLog::log('UPDATE_BENEFICIARY', $beneficiary, $oldData, $beneficiary->toArray());

        return redirect()->route('admin.beneficiaries.index')
            ->with('success', 'تم تحديث بيانات المستفيد بنجاح.');
    }

    public function toggleStatus(Request $request, $id)
    {
        $beneficiary = ContractBeneficiary::findOrFail($id);
        $newStatus = $beneficiary->status === 'active' ? 'inactive' : 'active';
        
        $beneficiary->update(['status' => $newStatus]);

        $logEvent = $newStatus === 'active' ? 'ACTIVATE_BENEFICIARY' : 'DEACTIVATE_BENEFICIARY';
        AuditLog::log($logEvent, $beneficiary, ['status' => $beneficiary->status], ['status' => $newStatus]);

        return redirect()->back()->with('success', 'تم تغيير حالة المستفيد إلى ' . ($newStatus === 'active' ? 'نشط' : 'معطل'));
    }
}
