<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\RefundRequest;
use App\Services\InvoiceGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinanceManagerController extends Controller
{
    public function dashboard(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $invoicesQuery = Invoice::query();
        $paymentsQuery = Payment::query();

        if ($startDate) {
            $invoicesQuery->whereDate('issue_date', '>=', $startDate);
            $paymentsQuery->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $invoicesQuery->whereDate('issue_date', '<=', $endDate);
            $paymentsQuery->whereDate('created_at', '<=', $endDate);
        }

        $totalRevenue = (clone $paymentsQuery)->where('status', 'completed')->sum('amount');
        $paidInvoicesTotal = (clone $invoicesQuery)->where('payment_status', 'paid')->sum('total_amount');
        $pendingInvoicesTotal = (clone $invoicesQuery)->where('payment_status', 'unpaid')->sum('total_amount');
        $failedPaymentsCount = (clone $paymentsQuery)->where('status', 'failed')->count();
        $refundedTotal = RefundRequest::where('status', 'approved')->sum('amount');
        $vatCollectedTotal = (clone $invoicesQuery)->where('payment_status', 'paid')->sum('vat_amount');

        $corporateRevenue = (clone $invoicesQuery)->whereNotNull('company_id')->where('payment_status', 'paid')->sum('total_amount');
        $individualRevenue = (clone $invoicesQuery)->whereNull('company_id')->where('payment_status', 'paid')->sum('total_amount');

        $recentPayments = Payment::with(['invoice', 'user', 'company'])->latest()->take(10)->get();
        $recentInvoices = Invoice::with(['user', 'company'])->latest()->take(10)->get();
        $pendingRefunds = RefundRequest::with(['payment', 'user'])->where('status', 'pending')->latest()->get();

        return view('admin.finance.dashboard', compact(
            'totalRevenue',
            'paidInvoicesTotal',
            'pendingInvoicesTotal',
            'failedPaymentsCount',
            'refundedTotal',
            'vatCollectedTotal',
            'corporateRevenue',
            'individualRevenue',
            'recentPayments',
            'recentInvoices',
            'pendingRefunds'
        ));
    }

    public function invoices(Request $request)
    {
        $query = Invoice::with(['user', 'company', 'booking.service']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('invoice_number', 'LIKE', "%{$q}%")
                    ->orWhereHas('user', function ($u) use ($q) {
                        $u->where('name', 'LIKE', "%{$q}%")->orWhere('phone', 'LIKE', "%{$q}%");
                    })
                    ->orWhereHas('company', function ($c) use ($q) {
                        $c->where('name', 'LIKE', "%{$q}%");
                    });
            });
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        $invoices = $query->latest()->paginate(20)->withQueryString();
        $companies = Company::orderBy('name')->get();

        return view('admin.finance.invoices.index', compact('invoices', 'companies'));
    }

    public function showInvoice($id)
    {
        $invoice = Invoice::with(['items', 'payments', 'refundRequests', 'user', 'company', 'booking.service', 'order'])->findOrFail($id);
        return view('admin.finance.invoices.show', compact('invoice'));
    }

    public function storeCorporateInvoice(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'contract_id' => 'required|exists:contracts,id',
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string|max:500',
        ]);

        $company = Company::findOrFail($validated['company_id']);
        $contract = Contract::findOrFail($validated['contract_id']);

        $service = new InvoiceGeneratorService();
        $invoice = $service->generateForCorporateContract($company, $contract, (float) $validated['amount'], $validated['description']);

        return redirect()->route('admin.finance.invoices.show', $invoice->id)->with('success', 'تم إصدار الفاتورة الضريبية للشركة بنجاح.');
    }

    public function payments(Request $request)
    {
        $query = Payment::with(['invoice', 'user', 'company']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('payment_number', 'LIKE', "%{$q}%")
                    ->orWhere('transaction_reference', 'LIKE', "%{$q}%")
                    ->orWhereHas('user', function ($u) use ($q) {
                        $u->where('name', 'LIKE', "%{$q}%");
                    });
            });
        }

        if ($request->filled('method')) {
            $query->where('payment_method', $request->method);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->latest()->paginate(20)->withQueryString();

        return view('admin.finance.payments.index', compact('payments'));
    }

    public function showPayment($id)
    {
        $payment = Payment::with(['invoice.items', 'user', 'company', 'refundRequests'])->findOrFail($id);
        return view('admin.finance.payments.show', compact('payment'));
    }

    public function refunds(Request $request)
    {
        $query = RefundRequest::with(['payment.invoice', 'user', 'approver']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $refunds = $query->latest()->paginate(20)->withQueryString();

        return view('admin.finance.refunds.index', compact('refunds'));
    }

    public function approveRefund(Request $request, $id)
    {
        $refund = RefundRequest::findOrFail($id);
        if ($refund->status !== 'pending') {
            return redirect()->back()->with('error', 'تمت معالجة طلب الاسترجاع سابقاً.');
        }

        DB::transaction(function () use ($refund, $request) {
            $refund->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'processed_at' => now(),
                'notes' => $request->input('notes', 'تمت الموافقة من الإدارة المالية'),
            ]);

            // Mark payment and invoice as refunded
            $refund->payment->update(['status' => 'refunded']);
            if ($refund->invoice) {
                $refund->invoice->update(['payment_status' => 'refunded']);
            }

            AuditLog::log('REFUND_APPROVED', $refund, [], $refund->toArray());
            AuditLog::log('PAYMENT_REFUNDED', $refund->payment, [], $refund->payment->toArray());
            if ($refund->invoice) {
                AuditLog::log('UPDATE_INVOICE', $refund->invoice, [], $refund->invoice->toArray());
            }
        });

        return redirect()->back()->with('success', 'تمت الموافقة على طلب الاسترجاع ومعالجة الحسابات بنجاح.');
    }


    public function rejectRefund(Request $request, $id)
    {
        $refund = RefundRequest::findOrFail($id);
        if ($refund->status !== 'pending') {
            return redirect()->back()->with('error', 'تمت معالجة طلب الاسترجاع سابقاً.');
        }

        $refund->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'processed_at' => now(),
            'notes' => $request->input('notes', 'تم رفض طلب الاسترجاع لعدم استيفاء الشروط'),
        ]);

        AuditLog::log('REFUND_REJECTED', $refund, [], $refund->toArray());

        return redirect()->back()->with('success', 'تم رفض طلب الاسترجاع.');
    }

    public function vatReport()
    {
        $invoices = Invoice::where('payment_status', 'paid')->get();
        $totalSubtotal = $invoices->sum('subtotal');
        $totalVat = $invoices->sum('vat_amount');
        $totalInclusive = $invoices->sum('total_amount');

        return view('admin.finance.vat-report', compact('invoices', 'totalSubtotal', 'totalVat', 'totalInclusive'));
    }
}
