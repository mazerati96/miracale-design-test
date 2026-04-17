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

// ── CREATE STRIPE CHECKOUT SESSION ─────────────────────────────────────────
try {
    $session = \Stripe\Checkout\Session::create(array(
        'payment_method_types'         => array('card'),
        'line_items'                   => $lineItems,
        'mode'                         => 'payment',
        'success_url'                  => SITE_URL . '/success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url'                   => SITE_URL . '/cancel.php',
        'shipping_address_collection'  => array(
            'allowed_countries' => array('US', 'CA', 'GB', 'AU'),
        ),
        'metadata'    => array(
            'product_names' => implode(', ', $productNames),
            'source'        => $source,
        ),
        'custom_text' => array(
            'submit' => array(
                'message' => 'Handmade with love in Virginia 🎨 — allow 5–10 business days for shipping.',
            ),
        ),
    ));

    header('Location: ' . $session->url);
    exit;

} catch (\Stripe\Exception\ApiErrorException $e) {
    $back = ($source === 'cart') ? 'cart.php' : 'shop.php';
    header('Location: ' . $back . '?error=' . urlencode($e->getMessage()));
    exit;
}