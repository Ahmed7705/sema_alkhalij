<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class InvoiceGeneratorService
{
    /**
     * Generate an invoice for a Medical Home Booking.
     */
    public function generateForBooking(Booking $booking): Invoice
    {
        return DB::transaction(function () use ($booking) {
            // Check if invoice already exists
            $existing = Invoice::where('booking_id', $booking->id)->first();
            if ($existing) {
                return $existing;
            }

            $invoiceNumber = self::generateInvoiceNumber();
            $uuid = ZatcaService::generateUuid();
            $issueDate = now()->format('Y-m-d');
            $dueDate = now()->addDays(7)->format('Y-m-d');

            $totalAmount = (float) $booking->total_price;
            $vatRate = 15.00;
            // Total amount = Subtotal + VAT (VAT = Total * 15 / 115)
            $vatAmount = round($totalAmount * ($vatRate / (100 + $vatRate)), 2);
            $subtotal = round($totalAmount - $vatAmount, 2);

            $sellerName = self::getSellerName();
            $sellerVat = self::getSellerVatNumber();
            $timestamp = now()->toIso8601String();

            $qrTlv = ZatcaService::generateTlvQrCode(
                $sellerName,
                $sellerVat,
                $timestamp,
                $totalAmount,
                $vatAmount
            );

            $invoiceHash = ZatcaService::calculateInvoiceHash($invoiceNumber, $timestamp, $totalAmount);

            $invoice = Invoice::create([
                'invoice_number' => $invoiceNumber,
                'uuid' => $uuid,
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id,
                'company_id' => $booking->company_id,
                'contract_id' => $booking->contract_id,
                'issue_date' => $issueDate,
                'due_date' => $dueDate,
                'subtotal' => $subtotal,
                'discount_amount' => 0.00,
                'vat_rate' => $vatRate,
                'vat_amount' => $vatAmount,
                'total_amount' => $totalAmount,
                'payment_status' => $booking->payment_status === 'paid' ? 'paid' : 'unpaid',
                'zatca_status' => 'generated',
                'qr_code_tlv' => $qrTlv,
                'invoice_hash' => $invoiceHash,
                'notes' => 'فاتورة ضريبية رسمية لخدمة طبية - حجز #' . $booking->booking_number,
            ]);

            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_type' => 'service',
                'item_id' => $booking->service_id,
                'description' => $booking->service->title_ar ?? $booking->service->name ?? 'خدمة رعاية طبية منزلية',
                'quantity' => 1,
                'unit_price' => $subtotal,
                'subtotal' => $subtotal,
                'vat_amount' => $vatAmount,
                'total_amount' => $totalAmount,
            ]);

            \App\Models\AuditLog::log('CREATE_INVOICE', $invoice, [], $invoice->toArray());

            return $invoice;
        });
    }

    /**
     * Generate an invoice for an E-Commerce Medical Store Order.
     */
    public function generateForOrder(Order $order): Invoice
    {
        return DB::transaction(function () use ($order) {
            $existing = Invoice::where('order_id', $order->id)->first();
            if ($existing) {
                return $existing;
            }

            $invoiceNumber = self::generateInvoiceNumber();
            $uuid = ZatcaService::generateUuid();
            $issueDate = now()->format('Y-m-d');

            $totalAmount = (float) $order->total_price;
            $vatRate = 15.00;
            $vatAmount = round($totalAmount * ($vatRate / (100 + $vatRate)), 2);
            $subtotal = round($totalAmount - $vatAmount, 2);

            $qrTlv = ZatcaService::generateTlvQrCode(
                self::getSellerName(),
                self::getSellerVatNumber(),
                now()->toIso8601String(),
                $totalAmount,
                $vatAmount
            );

            $invoiceHash = ZatcaService::calculateInvoiceHash($invoiceNumber, now()->toIso8601String(), $totalAmount);

            $invoice = Invoice::create([
                'invoice_number' => $invoiceNumber,
                'uuid' => $uuid,
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'issue_date' => $issueDate,
                'due_date' => $issueDate,
                'subtotal' => $subtotal,
                'discount_amount' => 0.00,
                'vat_rate' => $vatRate,
                'vat_amount' => $vatAmount,
                'total_amount' => $totalAmount,
                'payment_status' => $order->payment_status === 'paid' ? 'paid' : 'unpaid',
                'zatca_status' => 'generated',
                'qr_code_tlv' => $qrTlv,
                'invoice_hash' => $invoiceHash,
                'notes' => 'فاتورة مستلزمات طبية - طلب متجر #' . $order->order_number,
            ]);

            foreach ($order->items as $item) {
                $itemTotal = (float) $item->subtotal;
                $itemVat = round($itemTotal * ($vatRate / (100 + $vatRate)), 2);
                $itemSubtotal = round($itemTotal - $itemVat, 2);

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item_type' => 'product',
                    'item_id' => $item->product_id,
                    'description' => $item->product_name ?? 'مستلزم طبي',
                    'quantity' => $item->quantity,
                    'unit_price' => round($itemSubtotal / max(1, $item->quantity), 2),
                    'subtotal' => $itemSubtotal,
                    'vat_amount' => $itemVat,
                    'total_amount' => $itemTotal,
                ]);
            }

            \App\Models\AuditLog::log('CREATE_INVOICE', $invoice, [], $invoice->toArray());

            return $invoice;
        });
    }

    /**
     * Generate a Corporate Invoice for a Company Contract.
     */
    public function generateForCorporateContract(Company $company, Contract $contract, float $amount, string $description = 'مطالبة شهرية لعقد خدمات طبية للشركات'): Invoice
    {
        return DB::transaction(function () use ($company, $contract, $amount, $description) {
            $invoiceNumber = self::generateInvoiceNumber();
            $uuid = ZatcaService::generateUuid();
            $issueDate = now()->format('Y-m-d');
            $dueDate = now()->addDays(30)->format('Y-m-d');

            $subtotal = round($amount, 2);
            $vatRate = 15.00;
            $vatAmount = round($subtotal * ($vatRate / 100), 2);
            $totalAmount = round($subtotal + $vatAmount, 2);

            $qrTlv = ZatcaService::generateTlvQrCode(
                self::getSellerName(),
                self::getSellerVatNumber(),
                now()->toIso8601String(),
                $totalAmount,
                $vatAmount
            );

            $invoiceHash = ZatcaService::calculateInvoiceHash($invoiceNumber, now()->toIso8601String(), $totalAmount);

            $invoice = Invoice::create([
                'invoice_number' => $invoiceNumber,
                'uuid' => $uuid,
                'company_id' => $company->id,
                'contract_id' => $contract->id,
                'issue_date' => $issueDate,
                'due_date' => $dueDate,
                'subtotal' => $subtotal,
                'discount_amount' => 0.00,
                'vat_rate' => $vatRate,
                'vat_amount' => $vatAmount,
                'total_amount' => $totalAmount,
                'payment_status' => 'unpaid',
                'zatca_status' => 'generated',
                'qr_code_tlv' => $qrTlv,
                'invoice_hash' => $invoiceHash,
                'notes' => "فاتورة مطالبة مالية لشركة {$company->name} بموجب العقد {$contract->contract_code}",
            ]);

            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_type' => 'contract_billing',
                'item_id' => $contract->id,
                'description' => $description,
                'quantity' => 1,
                'unit_price' => $subtotal,
                'subtotal' => $subtotal,
                'vat_amount' => $vatAmount,
                'total_amount' => $totalAmount,
            ]);

            \App\Models\AuditLog::log('CREATE_INVOICE', $invoice, [], $invoice->toArray());

            return $invoice;
        });
    }

    public static function getSellerName(): string
    {
        return config('zatca.seller_name', env('COMPANY_NAME', 'شركة سما الخليج للخدمات الطبية'));
    }

    public static function getSellerVatNumber(): string
    {
        return config('zatca.vat_number', env('VAT_REGISTRATION_NUMBER', ''));
    }

    /**
     * Generate sequential collision-safe invoice number. Format: INV-YYYY-NNNNNN
     */
    public static function generateInvoiceNumber(): string
    {
        return DB::transaction(function () {
            $year = date('Y');
            $prefix = "INV-{$year}-";

            $latest = Invoice::where('invoice_number', 'LIKE', "{$prefix}%")
                ->lockForUpdate()
                ->orderBy('id', 'desc')
                ->first();

            if (!$latest) {
                $number = 100001;
            } else {
                $lastNumber = (int) substr($latest->invoice_number, -6);
                $number = $lastNumber + 1;
            }

            return $prefix . str_pad($number, 6, '0', STR_PAD_LEFT);
        });
    }
}
