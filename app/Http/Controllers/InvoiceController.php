<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * View/Print/Download PDF for an Invoice (Tax Invoice / Simplified Invoice).
     */
    public function downloadPdf($id)
    {
        $invoice = Invoice::with(['items', 'user', 'company', 'booking.service', 'order'])->findOrFail($id);

        $user = Auth::user();
        if (!$user) {
            abort(401);
        }

        // Authorization check: Admin OR Owner Patient OR Company Admin of Patient/Company
        $isAdmin = in_array($user->role, ['admin', 'super_admin', 'manager']);
        $isPatientOwner = ($invoice->user_id && (int) $invoice->user_id === (int) $user->id);
        $isCompanyAdmin = ($invoice->company_id && (int) $user->company_id === (int) $invoice->company_id);

        if (!$isAdmin && !$isPatientOwner && !$isCompanyAdmin) {
            abort(403, 'غير مصرح لك باستعراض هذه الفاتورة.');
        }

        AuditLog::log('DOWNLOAD_INVOICE', $invoice, [], ['downloaded_by' => $user->id]);

        return view('finance.pdf.invoice', compact('invoice'));
    }

    /**
     * View/Print Payment Receipt (سند قبض).
     */
    public function downloadReceipt($paymentId)
    {
        $payment = Payment::with(['invoice.items', 'user', 'company', 'booking.service'])->findOrFail($paymentId);

        $user = Auth::user();
        if (!$user) {
            abort(401);
        }

        $isAdmin = in_array($user->role, ['admin', 'super_admin', 'manager']);
        $isPatientOwner = ($payment->user_id && (int) $payment->user_id === (int) $user->id);
        $isCompanyAdmin = ($payment->company_id && (int) $user->company_id === (int) $payment->company_id);

        if (!$isAdmin && !$isPatientOwner && !$isCompanyAdmin) {
            abort(403, 'غير مصرح لك باستعراض سند القبض.');
        }

        AuditLog::log('DOWNLOAD_RECEIPT', $payment, [], ['downloaded_by' => $user->id]);

        return view('finance.pdf.receipt', compact('payment'));
    }

    /**
     * View/Print Corporate Account Statement (كشف حساب شركة).
     */
    public function downloadCorporateStatement($companyId)
    {
        $company = Company::findOrFail($companyId);

        $user = Auth::user();
        if (!$user) {
            abort(401);
        }

        $isAdmin = in_array($user->role, ['admin', 'super_admin', 'manager']);
        $isCompanyAdmin = ((int) $user->company_id === (int) $company->id && in_array($user->role, ['company_admin', 'company_user']));

        if (!$isAdmin && !$isCompanyAdmin) {
            abort(403, 'غير مصرح لك باستعراض كشف حساب الشركة.');
        }

        $invoices = Invoice::where('company_id', $company->id)->latest()->get();
        $payments = Payment::where('company_id', $company->id)->where('status', 'completed')->latest()->get();

        $totalInvoiced = $invoices->sum('total_amount');
        $totalPaid = $payments->sum('amount');
        $balanceDue = max(0, $totalInvoiced - $totalPaid);

        AuditLog::log('DOWNLOAD_STATEMENT', $company, [], ['downloaded_by' => $user->id]);

        return view('finance.pdf.statement', compact('company', 'invoices', 'payments', 'totalInvoiced', 'totalPaid', 'balanceDue'));
    }

}
