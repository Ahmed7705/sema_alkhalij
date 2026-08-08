<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// INCOMING WEBHOOKS API ENDPOINT (Phase 10)
Route::post('v1/webhooks/incoming', [\App\Http\Controllers\Api\WebhookController::class, 'handleIncoming'])->name('api.webhooks.incoming');

