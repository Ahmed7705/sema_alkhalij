<?php

namespace App\Services;

class ZatcaInvoiceService
{
    /**
     * Generate ZATCA Phase 1 & 2 Compliant TLV Base64 QR Payload.
     */
    public static function generateTlvQrCode(
        string $sellerName,
        string $vatNumber,
        string $timestamp,
        float $totalWithVat,
        float $vatAmount
    ): string {
        $sellerNameTlv = self::toTlv(1, $sellerName);
        $vatNumberTlv = self::toTlv(2, $vatNumber);
        $timestampTlv = self::toTlv(3, $timestamp);
        $totalWithVatTlv = self::toTlv(4, number_format($totalWithVat, 2, '.', ''));
        $vatAmountTlv = self::toTlv(5, number_format($vatAmount, 2, '.', ''));

        $tlvString = $sellerNameTlv . $vatNumberTlv . $timestampTlv . $totalWithVatTlv . $vatAmountTlv;

        return base64_encode($tlvString);
    }

    /**
     * Convert Tag, Value to TLV binary string.
     */
    private static function toTlv(int $tag, string $value): string
    {
        $valueLength = strlen($value);
        return pack('C2', $tag, $valueLength) . $value;
    }
}
