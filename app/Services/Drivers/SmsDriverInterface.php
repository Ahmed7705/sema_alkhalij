<?php

namespace App\Services\Drivers;

interface SmsDriverInterface
{
    /**
     * Send an SMS to recipient phone number.
     *
     * @param string $recipient Phone number e.g. 966500000000
     * @param string $message Text content
     * @return array Response payload with status and provider reference ID
     */
    public function sendSms(string $recipient, string $message, ?int $userId = null): array;
}

