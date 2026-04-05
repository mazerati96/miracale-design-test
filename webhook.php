<?php
// webhook.php
// Stripe sends a POST to this URL after every payment event.
// Register this URL in your Stripe Dashboard → Webhooks:
//   https://yourdomain.com/webhook.php
//
// Events to listen for (add in Stripe Dashboard):
//   checkout.session.completed
//   payment_intent.payment_failed

require_once 'config/stripe.php';
require_once __DIR__ . '/vendor/autoload.php';

\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

// Get the raw POST body
$payload   = @file_get_contents('php://input');
$sigHeader = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';

// Verify the webhook signature (prevents fake events)
try {
    $event = \Stripe\Webhook::constructEvent(
        $payload,
        $sigHeader,
        STRIPE_WEBHOOK_SECRET
    );
} catch (\UnexpectedValueException $e) {
    http_response_code(400);
    exit('Invalid payload');
} catch (\Stripe\Exception\SignatureVerificationException $e) {
    http_response_code(400);
    exit('Invalid signature');
}

// ── Handle events ─────────────────────────────────────────────────────────

switch ($event->type) {

    case 'checkout.session.completed':
        $session = $event->data->object;

        $customerEmail = $session->customer_details->email  ?? 'unknown';
        $customerName  = $session->customer_details->name   ?? 'Customer';
        $productName   = $session->metadata['product_name'] ?? 'Item';
        $amountTotal   = $session->amount_total
                            ? '$' . number_format($session->amount_total / 100, 2)
                            : 'N/A';
        $shippingAddr  = '';
        if (!empty($session->shipping_details->address)) {
            $addr = $session->shipping_details->address;
            $shippingAddr =
                ($addr->line1    ?? '') . "\n" .
                ($addr->line2    ? $addr->line2 . "\n" : '') .
                ($addr->city     ?? '') . ', ' .
                ($addr->state    ?? '') . ' ' .
                ($addr->postal_code ?? '') . "\n" .
                ($addr->country  ?? '');
        }

        // ── Email artist with order details ──
        $subject = "[New Order] {$productName} — Miracale Design";
        $body    =
            "🎉 You have a new order!\n\n" .
            "──────────────────────────\n" .
            "Item:     {$productName}\n" .
            "Total:    {$amountTotal}\n" .
            "Customer: {$customerName}\n" .
            "Email:    {$customerEmail}\n" .
            ($shippingAddr
                ? "Ship to:\n{$shippingAddr}\n"
                : '') .
            "──────────────────────────\n" .
            "Session:  {$session->id}\n\n" .
            "Log in to Stripe to view full details:\n" .
            "https://dashboard.stripe.com/payments\n";

        $headers  = "From: noreply@miracaledesign.com\r\n";
        $headers .= "Reply-To: miracaledesign2021@gmail.com\r\n";
        mail('miracaledesign2021@gmail.com', $subject, $body, $headers);

        // TODO: When MySQL is set up, also insert into orders table:
        // INSERT INTO orders (stripe_session_id, customer_email, customer_name,
        //                     product_name, amount, shipping_address, created_at)
        // VALUES (?, ?, ?, ?, ?, ?, NOW())
        break;

    case 'payment_intent.payment_failed':
        // Optional: log failed payments for monitoring
        // $intent = $event->data->object;
        break;

    default:
        // Unhandled event type — return 200 anyway so Stripe doesn't retry
        break;
}

http_response_code(200);
echo json_encode(['status' => 'received']);
exit;