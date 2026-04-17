<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Order Confirmed — Miracale Design</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Nunito:wght@300;400;500;600&family=Dancing+Script:wght@500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />
  <style>
    .success-page {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 6rem 2rem;
      position: relative;
      overflow: hidden;
    }
    .success-blob-1 {
      position: absolute; border-radius: 50%; pointer-events: none;
      width: 500px; height: 500px;
      background: radial-gradient(circle, rgba(45,74,62,0.1), transparent 70%);
      top: -100px; right: -100px; filter: blur(80px);
      animation: drift 8s ease-in-out infinite alternate;
    }
    .success-blob-2 {
      position: absolute; border-radius: 50%; pointer-events: none;
      width: 380px; height: 380px;
      background: radial-gradient(circle, rgba(212,168,67,0.1), transparent 70%);
      bottom: -80px; left: -80px; filter: blur(80px);
      animation: drift 11s ease-in-out infinite alternate-reverse;
    }
    .success-card {
      background: var(--white);
      border: 1px solid rgba(28,26,23,0.07);
      border-radius: 28px;
      padding: 3.5rem 3rem;
      max-width: 520px;
      width: 100%;
      text-align: center;
      box-shadow: 0 20px 64px rgba(28,26,23,0.1);
      position: relative;
      z-index: 2;
      animation: fadeUp 0.8s ease both;
    }
    .success-icon {
      width: 72px; height: 72px;
      background: linear-gradient(135deg, var(--green), var(--green-light));
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 1.8rem;
      font-size: 2rem;
      box-shadow: 0 8px 28px rgba(45,74,62,0.3);
    }
    .success-eyebrow {
      font-size: 0.72rem; font-weight: 600; letter-spacing: 0.18em;
      text-transform: uppercase; color: var(--green); margin-bottom: 0.6rem;
    }
    .success-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 2.6rem; font-weight: 300; color: var(--ink);
      line-height: 1.15; margin-bottom: 0.5rem;
    }
    .success-title em { font-style: italic; color: var(--terra); }
    .success-script {
      font-family: 'Dancing Script', cursive;
      font-size: 1.6rem; color: var(--green); margin-bottom: 1.5rem;
      display: block;
    }
    .success-body {
      font-size: 0.92rem; color: var(--ink-soft); line-height: 1.75;
      margin-bottom: 2rem;
    }
    .success-details {
      background: var(--parchment);
      border-radius: 14px; padding: 1.2rem 1.5rem;
      margin-bottom: 2rem; text-align: left;
    }
    .success-detail-row {
      display: flex; justify-content: space-between;
      font-size: 0.82rem; padding: 0.3rem 0;
      border-bottom: 1px solid rgba(28,26,23,0.07);
      color: var(--ink-soft);
    }
    .success-detail-row:last-child { border-bottom: none; }
    .success-detail-row strong { color: var(--ink); }
    .success-actions {
      display: flex; gap: 0.8rem; justify-content: center; flex-wrap: wrap;
    }
  </style>
</head>
<body>

<?php
// Clear the cart now that payment is confirmed
if (session_status() === PHP_SESSION_NONE) session_start();
$_SESSION['cart'] = array();

require_once 'config/stripe.php';

$session     = null;
$customerEmail = null;
$productName = null;
$amountTotal = null;

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
  require_once __DIR__ . '/vendor/autoload.php';
  \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

  $sessionId = $_GET['session_id'] ?? '';
  if ($sessionId) {
    try {
      $session = \Stripe\Checkout\Session::retrieve([
        'id'     => $sessionId,
        'expand' => ['line_items'],
      ]);
      $customerEmail = $session->customer_details->email ?? null;
      $productName   = $session->metadata['product_name'] ?? null;
      $amountTotal   = $session->amount_total
                        ? '$' . number_format($session->amount_total / 100, 2)
                        : null;
    } catch (\Exception $e) {
      // Session retrieval failed — still show success page
    }
  }
}
?>

<?php include 'includes/nav.php'; ?>

<section class="success-page">
  <div class="success-blob-1"></div>
  <div class="success-blob-2"></div>

  <div class="success-card">
    <div class="success-icon">✓</div>
    <div class="success-eyebrow">Payment Confirmed</div>
    <h1 class="success-title">Your order is<br><em>on its way!</em></h1>
    <span class="success-script">Thank you so much 🎨</span>

    <p class="success-body">
      Your payment was successful and your handmade piece is now being
      prepared with love. You'll receive a confirmation email shortly,
      and a tracking number once it ships.
    </p>

    <?php if ($customerEmail || $productName || $amountTotal): ?>
    <div class="success-details">
      <?php if ($productName): ?>
        <div class="success-detail-row">
          <span>Item</span>
          <strong><?= htmlspecialchars($productName) ?></strong>
        </div>
      <?php endif; ?>
      <?php if ($amountTotal): ?>
        <div class="success-detail-row">
          <span>Total paid</span>
          <strong><?= htmlspecialchars($amountTotal) ?></strong>
        </div>
      <?php endif; ?>
      <?php if ($customerEmail): ?>
        <div class="success-detail-row">
          <span>Confirmation sent to</span>
          <strong><?= htmlspecialchars($customerEmail) ?></strong>
        </div>
      <?php endif; ?>
      <div class="success-detail-row">
        <span>Estimated shipping</span>
        <strong>5–10 business days</strong>
      </div>
    </div>
    <?php endif; ?>

    <div class="success-actions">
      <a href="shop.php" class="btn-primary">
        Back to Shop
        <svg width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
      <a href="index.php" class="btn-ghost">Go Home</a>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
<script src="script.js"></script>
</body>
</html>