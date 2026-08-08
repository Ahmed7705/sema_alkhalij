<?php

namespace App\Services;

use Illuminate\Support\Str;

class ZatcaService
{
    /**
     * Generate ZATCA Phase 1 & 2 compliant Base64 TLV QR Code.
     * Tag 1: Seller Name
     * Tag 2: VAT Registration Number
     * Tag 3: Timestamp (ISO 8601)
     * Tag 4: Total Amount (with VAT)
     * Tag 5: VAT Amount
     */
    public static function generateTlvQrCode(
        string $sellerName,
        string $vatNumber,
        string $timestamp,
        float $totalAmount,
        float $vatAmount
    ): string {
        $tlv = '';
        $tlv .= self::encodeTlvTag(1, $sellerName);
        $tlv .= self::encodeTlvTag(2, $vatNumber);
        $tlv .= self::encodeTlvTag(3, $timestamp);
        $tlv .= self::encodeTlvTag(4, number_format($totalAmount, 2, '.', ''));
        $tlv .= self::encodeTlvTag(5, number_format($vatAmount, 2, '.', ''));

        return base64_encode($tlv);
    }

    private static function encodeTlvTag(int $tag, string $value): string
    {
        $length = strlen($value);
        return pack('C2', $tag, $length) . $value;
    }

    /**
     * Calculate SHA-256 Invoice Hash for ZATCA Phase 2 chaining.
     */
    public static function calculateInvoiceHash(string $invoiceNumber, string $timestamp, float $totalAmount): string
    {
        $raw = "{$invoiceNumber}|{$timestamp}|" . number_format($totalAmount, 2, '.', '');
        return hash('sha256', $raw);
    }

    /**
     * Generate UUID v4 for ZATCA E-Invoice identifier.
     */
    public static function generateUuid(): string
    {
        return (string) Str::uuid();
    }

    /**
     * Prepare ZATCA Phase 2 UBL 2.1 XML structure.
     */
    public static function prepareXmlPayload(array $invoiceData): string
    {
        $uuid = $invoiceData['uuid'] ?? self::generateUuid();
        $invoiceNumber = $invoiceData['invoice_number'] ?? 'INV-000';
        $seller = $invoiceData['seller_name'] ?? config('zatca.seller_name', env('COMPANY_NAME', 'شركة سما الخليج للخدمات الطبية'));
        $vat = $invoiceData['vat_number'] ?? config('zatca.vat_number', env('VAT_REGISTRATION_NUMBER', ''));
        $issueDate = $invoiceData['issue_date'] ?? date('Y-m-d');
        $total = number_format($invoiceData['total_amount'] ?? 0, 2, '.', '');
        $vatAmount = number_format($invoiceData['vat_amount'] ?? 0, 2, '.', '');

        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">
    <cbc:ProfileID>reporting:1.0</cbc:ProfileID>
    <cbc:ID>{$invoiceNumber}</cbc:ID>
    <cbc:UUID>{$uuid}</cbc:UUID>
    <cbc:IssueDate>{$issueDate}</cbc:IssueDate>
    <cac:AccountingSupplierParty>
        <cac:Party>
            <cac:PartyName><cbc:Name>{$seller}</cbc:Name></cac:PartyName>
            <cac:PartyTaxScheme><cbc:CompanyID>{$vat}</cbc:CompanyID></cac:PartyTaxScheme>
        </cac:Party>
    </cac:AccountingSupplierParty>
    <cac:LegalMonetaryTotal>
        <cbc:TaxInclusiveAmount currencyID="SAR">{$total}</cbc:TaxInclusiveAmount>
    </cac:LegalMonetaryTotal>
    <cac:TaxTotal>
        <cbc:TaxAmount currencyID="SAR">{$vatAmount}</cbc:TaxAmount>
    </cac:TaxTotal>
</Invoice>
XML;
    }

}
