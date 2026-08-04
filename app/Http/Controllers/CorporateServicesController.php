<?php

namespace App\Http\Controllers;

use App\Models\ContractRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class CorporateServicesController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)->get();
        return view('corporate-services', compact('services'));
    }

    public function storeContractRequest(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'cr_number' => 'nullable|string|max:100',
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'city' => 'required|string|max:100',
            'requested_services' => 'nullable|string',
            'expected_beneficiaries' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $contractRequest = ContractRequest::create([
            'company_name' => $validated['company_name'],
            'cr_number' => $validated['cr_number'],
            'contact_person' => $validated['contact_person'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'city' => $validated['city'],
            'requested_services' => $validated['requested_services'],
            'expected_beneficiaries' => $validated['expected_beneficiaries'],
            'notes' => $validated['notes'],
            'status' => 'new',
        ]);

        return redirect()->back()->with('success', 'تم استلام طلب التعاقد لشركة ' . $contractRequest->company_name . ' بنجاح وسيتم التواصل معكم من قِبل إدارة العلاقات الطبية.');
    }
}
