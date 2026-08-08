<?php

namespace App\Services\Drivers;

interface WhatsAppDriverInterface
{
    /**
     * Send a WhatsApp message.
     *
     * @param string $recipient Phone number e.g. 966500000000
     * @param string $message Text or template content
     * @return array Response payload with status and provider reference ID
     */
    public function sendWhatsApp(string $recipient, string $message, ?int $userId = null): array;
}

