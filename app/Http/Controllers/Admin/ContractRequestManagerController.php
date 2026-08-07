<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Company;
use App\Models\ContractRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ContractRequestManagerController extends Controller
{
    public function index(Request $request)
    {
        $query = ContractRequest::query()->with('convertedCompany');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('cr_number', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $contractRequests = $query->latest()->paginate(15)->withQueryString();

        return view('admin.contract-requests.index', compact('contractRequests'));
    }

    public function show($id)
    {
        $contractRequest = ContractRequest::with(['convertedCompany', 'reviewedBy', 'approvedBy'])->findOrFail($id);

        $auditLogs = AuditLog::where(function ($q) use ($id) {
            $q->where('model_type', ContractRequest::class)->where('model_id', $id);
        })->latest()->limit(15)->get();

        return view('admin.contract-requests.show', compact('contractRequest', 'auditLogs'));
    }

    public function updateStatus(Request $request, $id)
    {
        $contractRequest = ContractRequest::findOrFail($id);

        $request->validate([
            'status' => 'required|string|in:new,under_review,approved,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string',
        ]);

        $newStatus = $request->status;
        $currentStatus = $contractRequest->status;

        // State Machine Validations
        if ($currentStatus === $newStatus) {
            return redirect()->back()->with('error', 'الطلب محدد بهذه الحالة بالفعل.');
        }

        if ($contractRequest->converted_company_id && $newStatus !== 'approved') {
            return redirect()->back()->with('error', 'لا يمكن تغيير حالة طلب تعاقد تم تحويله إلى شركة رسمية بالنظام بالفعل.');
        }

        if ($currentStatus === 'rejected' && $newStatus === 'approved') {
            return redirect()->back()->with('error', 'يجب إعادة الطلب المرفوض إلى حالة (قيد المراجعة) أولاً قبل الموافقة عليه.');
        }

        $oldValues = $contractRequest->toArray();
        $updateData = ['status' => $newStatus];

        if ($newStatus === 'under_review') {
            $updateData['reviewed_by'] = Auth::id();
            $updateData['reviewed_at'] = now();
        } elseif ($newStatus === 'approved') {
            $updateData['approved_by'] = Auth::id();
            $updateData['approved_at'] = now();
        } elseif ($newStatus === 'rejected') {
            $updateData['rejection_reason'] = $request->rejection_reason;
        }

        $contractRequest->update($updateData);

        AuditLog::log('STATUS_CHANGE_CONTRACT_REQUEST', $contractRequest, $oldValues, $contractRequest->toArray());

        return redirect()->back()->with('success', 'تم تحديث حالة طلب التعاقد بنجاح إلى: ' . $newStatus);
    }

    public function convertToCompany($id)
    {
        $contractRequest = ContractRequest::findOrFail($id);

        if ($contractRequest->status !== 'approved') {
            return redirect()->back()->with('error', 'يمكن فقط تحويل طلبات التعاقد المعتمدة (Approved) إلى شركات حقيقية.');
        }

        if ($contractRequest->converted_company_id) {
            return redirect()->route('admin.companies.show', $contractRequest->converted_company_id)
                ->with('error', 'تم تحويل هذا الطلب إلى شركة بالفعل بالنظام.');
        }

        // Prevent duplicate CR number if CR number is present
        if (!empty($contractRequest->cr_number)) {
            $existingCompany = Company::where('cr_number', $contractRequest->cr_number)->first();
            if ($existingCompany) {
                // Link contract request to existing company
                $contractRequest->update(['converted_company_id' => $existingCompany->id]);
                return redirect()->route('admin.companies.show', $existingCompany->id)
                    ->with('success', 'تم ربط الطلب بالشركة الموجودة بالفعل ذات نفس السجل التجاري.');
            }
        }

        try {
            DB::beginTransaction();

            $companyCode = 'COMP-' . strtoupper(Str::random(6));
            while (Company::where('company_code', $companyCode)->exists()) {
                $companyCode = 'COMP-' . strtoupper(Str::random(6));
            }

            $company = Company::create([
                'name' => $contractRequest->company_name,
                'company_code' => $companyCode,
                'cr_number' => $contractRequest->cr_number,
                'contact_person' => $contractRequest->contact_person,
                'phone' => $contractRequest->phone,
                'email' => $contractRequest->email,
                'city' => $contractRequest->city,
                'address' => $contractRequest->notes,
                'status' => 'active',
                'contract_request_id' => $contractRequest->id,
            ]);

            $contractRequest->update([
                'converted_company_id' => $company->id,
            ]);

            AuditLog::log('CONVERT_CONTRACT_REQUEST_TO_COMPANY', $company, ['contract_request_id' => $contractRequest->id], $company->toArray());

            DB::commit();

            return redirect()->route('admin.companies.show', $company->id)
                ->with('success', 'تم تحويل طلب التعاقد بنجاح وإنشاء شركة رسمية جديدة بكود: ' . $company->company_code);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'فشلت عملية تحويل الطلب لشركة: ' . $e->getMessage());
        }
    }
}
