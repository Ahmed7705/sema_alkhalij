<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WebhookService;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handleIncoming(Request $request, WebhookService $webhookService)
    {
        $headers = $request->headers->all();
        $payload = $request->all();
        $event = $request->header('X-Sema-Event', 'incoming_webhook');

        $log = $webhookService->processIncoming($headers, $payload, $event);

        return response()->json([
            'success' => true,
            'log_id' => $log->id,
            'message' => 'Webhook received and processed successfully.',
        ]);
    }
}
