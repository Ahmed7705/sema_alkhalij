<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Company;
use App\Models\Contract;
use App\Models\ContractBeneficiary;
use App\Models\ContractPrice;
use App\Models\Service;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CompanyPortalController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        // 1. Regular patients/customers with no company association receive 403
        if ($user->role === 'customer' && !$user->company_id) {
            abort(403, 'حسابك كعميل غير مرتبط بشركة مسجلة في النظام.');
        }

        // 2. Inactive user check
        if (!$user->is_active) {
            abort(403, 'حسابك معطل حالياً. يرجى التواصل مع إدارة النظام.');
        }

        $isAdmin = in_array($user->role, ['admin', 'super_admin', 'manager']);

        // 3. IDOR Check: If user belongs to a specific company, enforce their company_id
        if ($user->company_id) {
            if ($request->has('company_id') && (int)$request->query('company_id') !== (int)$user->company_id && !$isAdmin) {
                abort(403, 'غير مصرح لك بالوصول لبيانات شركة أخرى (IDOR Protected).');
            }
            $companyId = $user->company_id;
        } else {
            // For Admins/Super Admins, allow selecting company via query param or default to first company
            if ($request->has('company_id') && $request->filled('company_id')) {
                $companyId = $request->query('company_id');
            } else {
                $firstCompany = Company::first();
                if (!$firstCompany) {
                    // No companies exist at all — show admin empty state (do NOT auto-create fake data)
                    $isEn = app()->getLocale() === 'en';
                    return view('company.portal-no-company', compact('isEn'));
                }
                $companyId = $firstCompany->id;
            }
        }

        $company = Company::with(['contracts.contractPrices.service', 'beneficiaries.patient'])->findOrFail($companyId);

        // Check if company itself is inactive for company users
        if ($company->status !== 'active' && !$isAdmin) {
            abort(403, 'حساب الشركة معطل حالياً من قِبل إدارة النظام.');
        }
        
        // Load active contract — do NOT auto-create if missing
        $activeContract = $company->contracts()->where('status', 'active')->latest()->first();
        // $activeContract may be null — views must handle this gracefully

        $contractsList = $company->contracts()->with(['contractPrices.service', 'beneficiaries'])->latest()->get();
        $beneficiaries = ContractBeneficiary::where('company_id', $company->id)
                            ->with(['contract', 'patient'])
                            ->orderBy('created_at', 'desc')
                            ->get();

        $beneficiariesCount = $beneficiaries->count();
        
        $companyBookings = Booking::where('company_id', $company->id)
            ->with(['service', 'patient', 'contract'])
            ->latest()
            ->paginate(10);

        $allCompanies = $isAdmin ? Company::all() : collect([$company]);
        
        // Covered services: only if active contract exists
        if ($activeContract) {
            $coveredServiceIds = ContractPrice::where('contract_id', $activeContract->id)->pluck('service_id');
            $services = Service::where('is_active', true)
                               ->when($coveredServiceIds->isNotEmpty(), function($q) use ($coveredServiceIds) {
                                   $q->whereIn('id', $coveredServiceIds);
                               })->get();
        } else {
            $services = collect(); // No active contract → no services available for corporate requests
        }

        $companyLabSamples = \App\Models\LabSample::where('company_id', $company->id)
            ->with(['patient', 'booking.service', 'medicalReport'])
            ->latest()
            ->get();

        $activeTab = $request->get('tab', 'requests');

        return view('company.portal', compact(
            'company',
            'activeContract',
            'contractsList',
            'beneficiaries',
            'beneficiariesCount',
            'companyBookings',
            'companyLabSamples',
            'services',
            'allCompanies',
            'activeTab'
        ));

    }


    public function storeServiceRequest(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'customer' && !$user->company_id) {
            abort(403, 'غير مصرح.');
        }

        if (!$user->is_active) {
            abort(403, 'حسابك معطل حالياً.');
        }

        $isAdmin = in_array($user->role, ['admin', 'super_admin', 'manager']);

        if ($user->company_id) {
            $companyId = $user->company_id;
        } else {
            $companyId = $request->input('company_id');
            if (!$companyId && $isAdmin) {
                $firstCompany = Company::first();
                $companyId = $firstCompany ? $firstCompany->id : null;
            }
        }

        if (!$companyId) {
            return redirect()->back()->with('error', 'تعذر تحديد الشركة المتعاقدة.');
        }

        $company = Company::findOrFail($companyId);
        if ($company->status !== 'active' && !$isAdmin) {
            abort(403, 'حساب الشركة معطل حالياً.');
        }

        $request->validate([
            'patient_name'          => 'required|string|max:255',
            'identification_type'   => 'required|in:saudi_id,iqama,border_number,gcc_id',
            'identification_number' => 'required|string|max:50',
            'phone'                 => 'required|string|max:20',
            'service_id'            => 'required|exists:services,id',
            'booking_date'          => 'required|date',
            'booking_time'          => 'required|string',
            'city'                  => 'required|string|max:100',
            'address'               => 'required|string|max:500',
            'beneficiary_id'        => 'nullable|exists:contract_beneficiaries,id',
            'contract_id'           => 'nullable|exists:contracts,id',
            'notes'                 => 'nullable|string|max:1000',
        ]);

        // Find Contract
        if ($request->filled('contract_id')) {
            $contract = Contract::where('id', $request->contract_id)->where('company_id', $company->id)->first();
        } else {
            $contract = $company->contracts()->where('status', 'active')->latest()->first();
        }

        if (!$contract || $contract->status !== 'active') {
            return redirect()->back()->withInput()->with('error', 'العقد المحدد غير ساري أو معطل حالياً.');
        }

        // Check if date is within contract period
        $today = date('Y-m-d');
        if ($contract->start_date > $today || $contract->end_date < $today) {
            return redirect()->back()->withInput()->with('error', 'تاريخ العقد المنتهي لا يسمح بإنشاء طلبات جديدة.');
        }

        // Beneficiary Check
        $beneficiary = null;
        if ($request->filled('beneficiary_id')) {
            $beneficiary = ContractBeneficiary::where('id', $request->beneficiary_id)
                ->where('company_id', $company->id)
                ->first();
            if (!$beneficiary || $beneficiary->status !== 'active') {
                return redirect()->back()->withInput()->with('error', 'المستفيد المحدد غير نشط أو لا يتبع لهذه الشركة.');
            }
        }

        $service = Service::findOrFail($request->service_id);

        // Check if service is covered in contract prices
        $hasCustomPrices = ContractPrice::where('contract_id', $contract->id)->exists();
        $contractPrice = ContractPrice::where('contract_id', $contract->id)
            ->where('service_id', $service->id)
            ->first();

        if ($hasCustomPrices && !$contractPrice) {
            return redirect()->back()->withInput()->with('error', 'هذه الخدمة الطبية غير مشمولة ضمن قائمة الخدمات المعمدة لهذا العقد.');
        }

        // Calculate Server-Side Contract Price
        if ($contractPrice) {
            $finalPrice = $contractPrice->custom_price;
        } elseif ($contract->discount_percentage > 0) {
            $finalPrice = round($service->price * (1 - ($contract->discount_percentage / 100)), 2);
        } else {
            $finalPrice = $service->price;
        }

        // booking_number is intentionally omitted — Booking::boot() generates BK-YYYY-NNNNN automatically
        $booking = Booking::create([
            'user_id'               => Auth::id(),
            'company_id'            => $company->id,
            'contract_id'           => $contract->id,
            'patient_id'            => $beneficiary ? $beneficiary->patient_id : null,
            'patient_name'          => $request->patient_name,
            'identification_type'   => $request->identification_type,
            'identification_number' => $request->identification_number,
            'service_id'            => $service->id,
            'booking_date'          => $request->booking_date,
            'booking_time'          => $request->booking_time,
            'city'                  => $request->city,
            'address'               => $request->address,
            'phone'                 => $request->phone,
            'total_price'           => $finalPrice,
            'status'                => 'requested',
            'notes'                 => $request->notes,
        ]);

        AuditLog::log('CREATE_CORPORATE_SERVICE_REQUEST', $booking, [], $booking->toArray());

        return redirect()->back()->with('success', 'تم تقديم طلب الخدمة الطبية للمستفيد بنجاح برقم حجز: ' . $booking->booking_number);
    }

    public function storeBeneficiary(Request $request)
    {
        $user = Auth::user();
        $isAdmin = in_array($user->role, ['admin', 'super_admin', 'manager']);

        if (!$isAdmin && !in_array($user->role, ['company_admin', 'company_operator'])) {
            abort(403, 'غير مصرح لك بإضافة مستفيدين للشركة.');
        }

        $companyId = $user->company_id ?? $request->input('company_id');
        $company = Company::findOrFail($companyId);

        $validated = $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'name' => 'required|string|max:100',
            'identification_type' => 'required|in:saudi_id,iqama,border_number,gcc_id',
            'identification_number' => 'required|string|max:50',
            'phone' => 'nullable|string|max:20',
            'employee_id_number' => 'nullable|string|max:50',
        ]);

        $contract = Contract::where('id', $validated['contract_id'])->where('company_id', $company->id)->firstOrFail();

        // Search existing Patient/User: Primary match by identification_number; fallback by phone only if identification_number is empty
        $existingPatient = null;
        if (!empty($validated['identification_number'])) {
            $existingPatient = User::where('identification_number', $validated['identification_number'])->first();
        } elseif (!empty($validated['phone'])) {
            $existingPatient = User::where('phone', $validated['phone'])->first();
        }

        $beneficiary = ContractBeneficiary::create([
            'contract_id' => $contract->id,
            'company_id' => $company->id,
            'patient_id' => $existingPatient ? $existingPatient->id : null,
            'name' => $validated['name'],
            'identification_type' => $validated['identification_type'],
            'identification_number' => $validated['identification_number'],
            'phone' => $validated['phone'] ?? null,
            'employee_id_number' => $validated['employee_id_number'] ?? null,
            'status' => 'active',
        ]);

        AuditLog::log('CREATE_BENEFICIARY', $beneficiary, [], $beneficiary->toArray());

        return redirect()->back()->with('success', 'تم إضافة المستفيد بنجاح تحت عقد الشركة ' . $contract->contract_number);
    }

    public function printServiceRequest($bookingId)
    {
        $user = Auth::user();
        $isAdmin = in_array($user->role, ['admin', 'super_admin', 'manager']);

        $booking = Booking::with(['company', 'contract', 'service', 'patient'])->findOrFail($bookingId);

        // IDOR Check
        if ($user->company_id && (int)$user->company_id !== (int)$booking->company_id && !$isAdmin) {
            abort(403, 'غير مصرح لك بفرز أو طباعة هذا الطلب (IDOR Protected).');
        }

        return view('company.print-request', compact('booking'));
    }
}
