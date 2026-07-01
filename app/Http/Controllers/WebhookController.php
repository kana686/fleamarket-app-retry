<?php

namespace App\Http\Controllers;

use App\Services\PurchaseService;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handle(Request $request, PurchaseService $purchaseService)
    {
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            $purchaseService->handleStripeWebhook($session->id);
        }

        return response()->json(['status' => 'success']);
    }
}
