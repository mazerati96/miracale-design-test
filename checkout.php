<?php
// checkout.php
// Handles two modes:
//   1. source=cart  → reads $_SESSION['cart'], builds multi-line-item Stripe session
//   2. price_id POST → single item "Buy Now" (original behaviour, unchanged)

if (session_status() === PHP_SESSION_NONE) session_start();

require_once 'config/stripe.php';
require_once __DIR__ . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: shop.php');
    exit;
}

\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

$source = $_POST['source'] ?? 'single';

// ── BUILD LINE ITEMS ────────────────────────────────────────────────────────
$lineItems    = array();
$productNames = array();

if ($source === 'cart') {
    $cart = isset($_SESSION['cart']) && is_array($_SESSION['cart'])
        ? $_SESSION['cart']
        : array();

    if (empty($cart)) {
        header('Location: cart.php');
        exit;
    }

    foreach ($cart as $item) {
        $priceId = trim($item['price_id']     ?? '');
        $qty     = max(1, (int)($item['quantity'] ?? 1));
        $name    = trim($item['product_name'] ?? 'Item');
        if (empty($priceId)) continue;
        $lineItems[]    = array('price' => $priceId, 'quantity' => $qty);
        $productNames[] = ($qty > 1 ? $qty . 'x ' : '') . $name;
    }

    if (empty($lineItems)) {
        header('Location: cart.php');
        exit;
    }

} else {
    // Single Buy Now
    $priceId     = trim($_POST['price_id']     ?? '');
    $productName = trim($_POST['product_name'] ?? 'Item');

    if (empty($priceId)) {
        header('Location: shop.php?error=missing_price');
        exit;
    }

    $lineItems[]    = array('price' => $priceId, 'quantity' => 1);
    $productNames[] = $productName;
}

// ── FETCH SHIPPING RATES FROM STRIPE ───────────────────────────────────────
// Pulls all active shipping rates you created in the Stripe Dashboard.
$shippingOptions = array();
$hasLocalOnly    = false; // will be true only if ALL rates are local

try {
    $rates = \Stripe\ShippingRate::all(array('active' => true, 'limit' => 20));

    $localRateIds    = array();
    $nonLocalRateIds = array();

    foreach ($rates->data as $rate) {
        $displayName = strtolower($rate->display_name ?? '');
        $shippingOptions[] = array('shipping_rate' => $rate->id);

        if (strpos($displayName, 'local') !== false) {
            $localRateIds[] = $rate->id;
        } else {
            $nonLocalRateIds[] = $rate->id;
        }
    }

    // If every available rate is a "local" rate, suppress the shipping delay message
    $hasLocalOnly = !empty($localRateIds) && empty($nonLocalRateIds);

} catch (\Stripe\Exception\ApiErrorException $e) {
    // If we can't fetch rates, fall through with no shipping options
    // (Stripe will still collect the address; you can add fallback rates here if needed)
    $shippingOptions = array();
    $hasLocalOnly    = false;
}

// ── BUILD CHECKOUT SESSION PARAMS ──────────────────────────────────────────
$sessionParams = array(
    'payment_method_types'        => array('card'),
    'line_items'                  => $lineItems,
    'mode'                        => 'payment',
    'success_url'                 => SITE_URL . '/success.php?session_id={CHECKOUT_SESSION_ID}',
    'cancel_url'                  => SITE_URL . '/cancel.php',
    'metadata'                    => array(
        'product_names' => implode(', ', $productNames),
        'source'        => $source,
    ),
);

// Attach shipping rates if we found any
if (!empty($shippingOptions)) {
    $sessionParams['shipping_options']            = $shippingOptions;
    // shipping_address_collection is required alongside shipping_options
    $sessionParams['shipping_address_collection'] = array(
        'allowed_countries' => array('US', 'CA', 'GB', 'AU'),
    );
} else {
    // Fallback: still collect address even if no rates were found
    $sessionParams['shipping_address_collection'] = array(
        'allowed_countries' => array('US', 'CA', 'GB', 'AU'),
    );
}

// Only show the "5–10 business days" message when non-local shipping is available.
// If the customer could choose local pickup/delivery, the delay note is irrelevant.
if (!$hasLocalOnly) {
    $sessionParams['custom_text'] = array(
        'submit' => array(
            'message' => 'Handmade with love in Virginia 🎨 — allow 5–10 business days for shipping.',
        ),
    );
}

// ── CREATE STRIPE CHECKOUT SESSION ─────────────────────────────────────────
try {
    $session = \Stripe\Checkout\Session::create($sessionParams);

    header('Location: ' . $session->url);
    exit;

} catch (\Stripe\Exception\ApiErrorException $e) {
    $back = ($source === 'cart') ? 'cart.php' : 'shop.php';
    header('Location: ' . $back . '?error=' . urlencode($e->getMessage()));
    exit;
}