<?php

namespace App\Http\Controllers;

use App\Services\PurchaseService;
use Illuminate\Http\Request;
use Stripe\Webhook;

class WebhookController extends Controller
{
    public function handle(Request $request, PurchaseService $purchaseService)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                $secret
            );
        } catch (\Exception $e) {

            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $successEvents = ['checkout.session.completed', 'checkout.session.async_payment_succeeded'];

        if (in_array($event->type, $successEvents)) {
            $session = $event->data->object;
            $purchaseService->handleStripeWebhook($session->id, $event->type);
        }

        return response()->json(['status' => 'success']);
    }
}
