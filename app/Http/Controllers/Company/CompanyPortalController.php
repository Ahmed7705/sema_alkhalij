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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyPortalController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();

        // Regular patients/customers with no company association receive 403
        if ($user->role === 'customer' && !$user->company_id) {
            abort(403, 'حسابك كعميل غير مرتبط بشركة مسجلة في النظام.');
        }

        // If user is tied to a specific company, use that.
        // Otherwise (for Admin, Super Admin, Managers), check query param or fallback to first company.
        $companyId = $user->company_id;

        if (!$companyId) {
            if ($request->has('company_id') && $request->filled('company_id')) {
                $companyId = $request->query('company_id');
            } else {
                $firstCompany = Company::first();
                if ($firstCompany) {
                    $companyId = $firstCompany->id;
                } else {
                    // Seed a default active corporate client
                    $company = Company::create([
                        'name' => 'شركة أرامكو السعودية للخدمات الطبية',
                        'company_code' => 'COMP-ARAMCO',
                        'contact_person' => 'مدير التعاقدات والخدمات الطبية',
                        'phone' => '0590000001',
                        'email' => 'corporate@sema-alkhalij.com',
                        'city' => 'جدة',
                        'status' => 'active',
                    ]);
                    $companyId = $company->id;
                }
            }
        }

        $company = Company::with(['contracts.contractPrices.service'])->findOrFail($companyId);
        
        // Find or seed active contract if none exists for full scenario testing
        $activeContract = $company->contracts()->where('status', 'active')->latest()->first();
        if (!$activeContract) {
            $activeContract = Contract::create([
                'company_id' => $company->id,
                'contract_number' => 'CNT-' . date('Y') . '-' . rand(100, 999),
                'start_date' => date('Y-01-01'),
                'end_date' => date('Y-12-31'),
                'payment_terms' => 'Net 30 Days (آجل 30 يوم)',
                'discount_percentage' => 15.00,
                'status' => 'active',
            ]);
        }

        $beneficiariesCount = $activeContract ? $activeContract->beneficiaries()->count() : 0;
        
        $companyBookings = Booking::where('company_id', $company->id)
            ->with(['service', 'patient'])
            ->latest()
            ->paginate(10);

        $allCompanies = Company::all();
        $services = Service::where('is_active', true)->get();

        return view('company.portal', compact(
            'company',
            'activeContract',
            'beneficiariesCount',
            'companyBookings',
            'services',
            'allCompanies'
        ));
    }

    public function storeServiceRequest(Request $request)
    {
        $user = Auth::user();
        if ($user->role === 'customer' && !$user->company_id) {
            abort(403, 'غير مصرح.');
        }

        $companyId = $user->company_id;
        if (!$companyId) {
            $companyId = $request->input('company_id');
            if (!$companyId) {
                $firstCompany = Company::first();
                $companyId = $firstCompany ? $firstCompany->id : null;
            }
        }

        if (!$companyId) {
            return redirect()->back()->with('error', 'تعذر تحديد الشركة المتعاقدة.');
        }

        $request->validate([
            'patient_name' => 'required|string|max:255',
            'identification_type' => 'required|string',
            'identification_number' => 'required|string',
            'phone' => 'required|string',
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $company = Company::findOrFail($companyId);
        $contract = $company->contracts()->where('status', 'active')->latest()->first();

        if (!$contract) {
            $contract = Contract::create([
                'company_id' => $company->id,
                'contract_number' => 'CNT-' . date('Y') . '-' . rand(100, 999),
                'start_date' => date('Y-01-01'),
                'end_date' => date('Y-12-31'),
                'payment_terms' => 'Net 30 Days (آجل 30 يوم)',
                'discount_percentage' => 15.00,
                'status' => 'active',
            ]);
        }

        // Calculate Server-Side Contract Price if special pricing exists
        $service = Service::findOrFail($request->service_id);
        $contractPrice = ContractPrice::where('contract_id', $contract->id)
            ->where('service_id', $service->id)
            ->first();

        $finalPrice = $contractPrice ? $contractPrice->custom_price : $service->price;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'company_id' => $company->id,
            'contract_id' => $contract->id,
            'booking_number' => 'CP-' . strtoupper(\Illuminate\Support\Str::random(6)),
            'patient_name' => $request->patient_name,
            'identification_type' => $request->identification_type,
            'identification_number' => $request->identification_number,
            'service_id' => $service->id,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'city' => $request->city,
            'address' => $request->address,
            'phone' => $request->phone,
            'total_price' => $finalPrice,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'تم تقديم طلب الخدمة الطبية للمستفيد بنجاح برقم حجز: ' . $booking->booking_number);
    }
}
