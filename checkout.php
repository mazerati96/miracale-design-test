<?php
// checkout.php
// Receives a Stripe price_id from the shop, creates a Checkout Session,
// and redirects the customer to Stripe's hosted payment page.

require_once 'config/stripe.php';
require_once __DIR__ . '/vendor/autoload.php';

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: shop.php');
    exit;
}

$priceId     = trim($_POST['price_id']     ?? '');
$productName = trim($_POST['product_name'] ?? 'Item');

if (empty($priceId)) {
    header('Location: shop.php?error=missing_price');
    exit;
}

\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price'    => $priceId,
            'quantity' => 1,
        ]],
        'mode'        => 'payment',
        'success_url' => SITE_URL . '/success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url'  => SITE_URL . '/cancel.php',
        'shipping_address_collection' => [
            'allowed_countries' => ['US', 'CA', 'GB', 'AU'], // add more as needed
        ],
        'metadata' => [
            'product_name' => $productName,
        ],
        'custom_text' => [
            'submit' => [
                'message' => 'Handmade with love in Virginia 🎨 — allow 5–10 business days for shipping.',
            ],
        ],
    ]);

    // Redirect to Stripe's hosted checkout page
    header('Location: ' . $session->url);
    exit;

} catch (\Stripe\Exception\ApiErrorException $e) {
    // Redirect back to shop with an error flag
    header('Location: shop.php?error=' . urlencode($e->getMessage()));
    exit;
}