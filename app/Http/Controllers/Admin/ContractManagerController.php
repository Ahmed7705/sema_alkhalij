<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\ContractPrice;
use App\Models\Company;
use App\Models\Service;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractManagerController extends Controller
{
    public function index(Request $request)
    {
        $query = Contract::with(['company', 'contractPrices', 'beneficiaries']);

        // Filter search term
        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('contract_number', 'LIKE', "%{$q}%")
                    ->orWhereHas('company', function ($c) use ($q) {
                        $c->where('name', 'LIKE', "%{$q}%")
                          ->orWhere('cr_number', 'LIKE', "%{$q}%");
                    });
            });
        }

        // Filter company
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $contracts = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $companies = Company::orderBy('name')->get();

        return view('admin.contracts.index', compact('contracts', 'companies'));
    }

    public function create()
    {
        $companies = Company::where('status', 'active')->orderBy('name')->get();
        return view('admin.contracts.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'contract_number' => 'nullable|string|max:50|unique:contracts,contract_number',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'payment_terms' => 'required|string|max:50',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'status' => 'required|in:draft,pending,active,expired,suspended,cancelled',
            'notes' => 'nullable|string',
        ]);

        $company = Company::findOrFail($validated['company_id']);
        if ($company->status !== 'active') {
            return redirect()->back()->withInput()->with('error', 'لا يمكن إنشاء عقد لشركة غير نشطة.');
        }

        $contract = Contract::create([
            'company_id' => $validated['company_id'],
            'contract_number' => $validated['contract_number'] ?? null,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'payment_terms' => $validated['payment_terms'],
            'discount_percentage' => $validated['discount_percentage'] ?? 0,
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        AuditLog::log('CREATE_CONTRACT', $contract, [], $contract->toArray());

        return redirect()->route('admin.contracts.show', $contract->id)
            ->with('success', 'تم إنشاء العقد بنجاح برقم ' . $contract->contract_number);
    }

    public function show(Request $request, $id)
    {
        $contract = Contract::with([
            'company',
            'contractPrices.service',
            'beneficiaries.patient',
            'beneficiaries.company',
            'bookings.patient',
            'bookings.service'
        ])->findOrFail($id);

        $availableServices = Service::whereNotIn('id', $contract->contractPrices->pluck('service_id'))
                                    ->orderBy('name')
                                    ->get();

        $activeTab = $request->get('tab', 'overview');

        return view('admin.contracts.show', compact('contract', 'availableServices', 'activeTab'));
    }

    public function edit($id)
    {
        $contract = Contract::findOrFail($id);
        $companies = Company::orderBy('name')->get();
        return view('admin.contracts.edit', compact('contract', 'companies'));
    }

    public function update(Request $request, $id)
    {
        $contract = Contract::findOrFail($id);

        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'contract_number' => 'required|string|max:50|unique:contracts,contract_number,' . $contract->id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'payment_terms' => 'required|string|max:50',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'status' => 'required|in:draft,pending,active,expired,suspended,cancelled',
            'notes' => 'nullable|string',
        ]);

        $oldData = $contract->toArray();
        $contract->update($validated);

        AuditLog::log('UPDATE_CONTRACT', $contract, $oldData, $contract->toArray());

        return redirect()->route('admin.contracts.show', $contract->id)
            ->with('success', 'تم تحديث بيانات العقد بنجاح.');
    }

    public function toggleStatus(Request $request, $id)
    {
        $contract = Contract::findOrFail($id);
        $request->validate([
            'status' => 'required|in:draft,pending,active,expired,suspended,cancelled'
        ]);

        $oldStatus = $contract->status;
        $contract->update(['status' => $request->status]);

        AuditLog::log('CONTRACT_STATUS_CHANGE', $contract, ['status' => $oldStatus], ['status' => $request->status]);

        return redirect()->back()->with('success', 'تم تغيير حالة العقد إلى ' . $contract->status);
    }

    public function addService(Request $request, $id)
    {
        $contract = Contract::findOrFail($id);

        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'custom_price' => 'required|numeric|min:0',
        ]);

        // Prevent duplicate service pricing
        $exists = ContractPrice::where('contract_id', $contract->id)
                               ->where('service_id', $validated['service_id'])
                               ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'هذه الخدمة مضافة ومسقّفة أصلًا بهذا العقد.');
        }

        $contractPrice = ContractPrice::create([
            'contract_id' => $contract->id,
            'service_id' => $validated['service_id'],
            'custom_price' => $validated['custom_price'],
        ]);

        AuditLog::log('ADD_CONTRACT_SERVICE', $contractPrice, [], $contractPrice->toArray());

        return redirect()->route('admin.contracts.show', ['id' => $contract->id, 'tab' => 'services'])
            ->with('success', 'تمت إضافة الخدمة وتحديد السعر التعاقدي المخصص بنجاح.');
    }

    public function removeService(Request $request, $id, $serviceId)
    {
        $contract = Contract::findOrFail($id);
        $contractPrice = ContractPrice::where('contract_id', $contract->id)
                                      ->where('service_id', $serviceId)
                                      ->firstOrFail();

        $oldData = $contractPrice->toArray();
        $contractPrice->delete();

        AuditLog::log('REMOVE_CONTRACT_SERVICE', $contract, $oldData, []);

        return redirect()->route('admin.contracts.show', ['id' => $contract->id, 'tab' => 'services'])
            ->with('success', 'تم إزالة الخدمة والسعر المخصص من العقد.');
    }

    public function updatePrice(Request $request, $id, $priceId)
    {
        $contract = Contract::findOrFail($id);
        $contractPrice = ContractPrice::where('contract_id', $contract->id)
                                      ->where('id', $priceId)
                                      ->firstOrFail();

        $validated = $request->validate([
            'custom_price' => 'required|numeric|min:0',
        ]);

        $oldPrice = $contractPrice->custom_price;
        $contractPrice->update(['custom_price' => $validated['custom_price']]);

        AuditLog::log('UPDATE_CONTRACT_PRICE', $contractPrice, ['custom_price' => $oldPrice], ['custom_price' => $validated['custom_price']]);

        return redirect()->route('admin.contracts.show', ['id' => $contract->id, 'tab' => 'services'])
            ->with('success', 'تم تحديث السعر التعاقدي المخصص بنجاح.');
    }
}
