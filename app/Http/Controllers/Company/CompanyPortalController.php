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
    public function dashboard()
    {
        $user = Auth::user();

        if (!$user->company_id) {
            abort(403, 'حسابك غير مرتبط بشركة مسجلة النظام.');
        }

        $company = Company::with(['contracts.contractPrices.service'])->findOrFail($user->company_id);
        $activeContract = $company->contracts()->where('status', 'active')->latest()->first();

        $beneficiariesCount = $activeContract ? $activeContract->beneficiaries()->count() : 0;
        
        $companyBookings = Booking::where('company_id', $company->id)
            ->with(['service', 'patient'])
            ->latest()
            ->paginate(10);

        $services = Service::where('is_active', true)->get();

        return view('company.portal', compact(
            'company',
            'activeContract',
            'beneficiariesCount',
            'companyBookings',
            'services'
        ));
    }

    public function storeServiceRequest(Request $request)
    {
        $user = Auth::user();
        if (!$user->company_id) {
            abort(403, 'غير مصرح.');
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

        $company = Company::findOrFail($user->company_id);
        $contract = $company->contracts()->where('status', 'active')->latest()->first();

        if (!$contract) {
            return redirect()->back()->with('error', 'لا يوجد عقد نشط للشركة لتقديم الطلبات.');
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
