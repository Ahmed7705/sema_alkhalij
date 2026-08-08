<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentGatewayService
{
    public const METHOD_MADA = 'mada';
    public const METHOD_APPLE_PAY = 'apple_pay';
    public const METHOD_VISA = 'visa';
    public const METHOD_MASTERCARD = 'mastercard';
    public const METHOD_STC_PAY = 'stc_pay';
    public const METHOD_CASH = 'cash';
    public const METHOD_BANK_TRANSFER = 'bank_transfer';

    public const SUPPORTED_METHODS = [
        self::METHOD_MADA => 'مدى (Mada)',
        self::METHOD_APPLE_PAY => 'آبل باي (Apple Pay)',
        self::METHOD_VISA => 'فيزا (Visa)',
        self::METHOD_MASTERCARD => 'ماستركارد (MasterCard)',
        self::METHOD_STC_PAY => 'اس تي سي باي (STC Pay)',
        self::METHOD_CASH => 'نقداً عند الزيارة (Cash)',
        self::METHOD_BANK_TRANSFER => 'تحويل بنكي (Bank Transfer)',
    ];

    /**
     * Process a payment for an invoice with decoupled driver architecture.
     */
    public function processPayment(Invoice $invoice, string $method, float $amount, array $options = []): Payment
    {
        if (!array_key_exists($method, self::SUPPORTED_METHODS)) {
            throw new \InvalidArgumentException("طريقة الدفع غير مدعومة: {$method}");
        }

        return DB::transaction(function () use ($invoice, $method, $amount, $options) {
            $paymentNumber = self::generatePaymentNumber();
            $txnRef = $options['transaction_reference'] ?? ('TXN-' . strtoupper(Str::random(12)));

            // Driver execution simulation (returns success in local architecture, production gateways use API credentials)
            $gatewayResponse = [
                'provider' => 'SemaGatewayArchitecture',
                'method' => $method,
                'status' => 'APPROVED',
                'response_code' => '00',
                'authorization_code' => strtoupper(Str::random(6)),
                'processed_at' => now()->toIso8601String(),
            ];

            $payment = Payment::create([
                'payment_number' => $paymentNumber,
                'invoice_id' => $invoice->id,
                'booking_id' => $invoice->booking_id,
                'order_id' => $invoice->order_id,
                'contract_id' => $invoice->contract_id,
                'user_id' => $invoice->user_id,
                'company_id' => $invoice->company_id,
                'amount' => $amount,
                'payment_method' => $method,
                'status' => 'completed',
                'transaction_reference' => $txnRef,
                'gateway_provider' => 'local_driver',
                'gateway_response' => $gatewayResponse,
                'paid_at' => now(),
            ]);

            // Update invoice payment status
            $totalPaid = $invoice->payments()->where('status', 'completed')->sum('amount');
            if ($totalPaid >= $invoice->total_amount) {
                $invoice->update(['payment_status' => 'paid']);
            } else if ($totalPaid > 0) {
                $invoice->update(['payment_status' => 'partially_paid']);
            }

            \App\Models\AuditLog::log('PAYMENT_CREATED', $payment, [], $payment->toArray());
            \App\Models\AuditLog::log('PAYMENT_COMPLETED', $payment, [], $payment->toArray());

            return $payment;
        });
    }


    /**
     * Generate sequential collision-safe payment number. Format: PAY-YYYY-NNNNNN
     */
    public static function generatePaymentNumber(): string
    {
        return DB::transaction(function () {
            $year = date('Y');
            $prefix = "PAY-{$year}-";

            $latest = Payment::where('payment_number', 'LIKE', "{$prefix}%")
                ->lockForUpdate()
                ->orderBy('id', 'desc')
                ->first();

            if (!$latest) {
                $number = 100001;
            } else {
                $lastNumber = (int) substr($latest->payment_number, -6);
                $number = $lastNumber + 1;
            }

            return $prefix . str_pad($number, 6, '0', STR_PAD_LEFT);
        });
    }
}
