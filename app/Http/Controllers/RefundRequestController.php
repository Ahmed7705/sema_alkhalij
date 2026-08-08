<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Payment;
use App\Models\RefundRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RefundRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'reason' => 'required|string|max:1000',
        ]);

        $payment = Payment::with('invoice')->findOrFail($validated['payment_id']);
        $user = Auth::user();

        // IDOR check: Only owner of payment can request refund
        if ((int) $payment->user_id !== (int) $user->id && !in_array($user->role, ['admin', 'super_admin', 'manager'])) {
            return redirect()->back()->with('error', 'غير مصرح لك بتقديم طلب استرجاع لهذه العملية.');
        }


        if ($payment->status !== 'completed') {
            return redirect()->back()->with('error', 'يمكن تقديم طلب الاسترجاع للعمليات المكتملة فقط.');
        }

        $existingPending = RefundRequest::where('payment_id', $payment->id)
            ->where('status', 'pending')
            ->exists();

        if ($existingPending) {
            return redirect()->back()->with('error', 'يوجد طلب استرجاع قيد الدراسة لهذه العملية بالفعل.');
        }

        DB::transaction(function () use ($payment, $user, $validated) {
            $year = date('Y');
            $prefix = "REF-{$year}-";
            $latest = RefundRequest::where('refund_number', 'LIKE', "{$prefix}%")->latest('id')->first();
            $num = $latest ? ((int) substr($latest->refund_number, -6) + 1) : 100001;
            $refundNumber = $prefix . str_pad($num, 6, '0', STR_PAD_LEFT);

            $refund = RefundRequest::create([
                'refund_number' => $refundNumber,
                'payment_id' => $payment->id,
                'invoice_id' => $payment->invoice_id,
                'user_id' => $user->id,
                'amount' => $payment->amount,
                'reason' => $validated['reason'],
                'status' => 'pending',
            ]);

            AuditLog::log('REFUND_REQUESTED', $refund, [], $refund->toArray());
        });

        return redirect()->back()->with('success', 'تم تقديم طلب الاسترجاع بنجاح، وسيتم مراجعته من الإدارة المالية.');
    }
}
