<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Shop — Miracale Design</title>
  <meta name="description" content="Shop handmade art from Miracale Design — clay animals, watercolors, wood art, and custom keychains." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Nunito:wght@300;400;500;600&family=Dancing+Script:wght@500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />
  <style>
    .page-hero {
      padding: 10rem 3rem 4rem;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    .page-hero-blob {
      position: absolute; border-radius: 50%;
      filter: blur(90px); pointer-events: none;
    }
    .page-hero-blob-1 {
      width: 420px; height: 420px;
      background: radial-gradient(circle, rgba(201,104,58,0.12), transparent 70%);
      top: -60px; right: 10%;
      animation: drift 9s ease-in-out infinite alternate;
    }
    .page-hero-blob-2 {
      width: 320px; height: 320px;
      background: radial-gradient(circle, rgba(212,168,67,0.1), transparent 70%);
      bottom: 0; left: 5%;
      animation: drift 12s ease-in-out infinite alternate-reverse;
    }
    .page-hero-eyebrow {
      font-size: 0.75rem; font-weight: 600;
      letter-spacing: 0.22em; text-transform: uppercase;
      color: var(--terra); margin-bottom: 1rem;
      display: flex; align-items: center; justify-content: center; gap: 0.7rem;
    }
    .page-hero-eyebrow::before, .page-hero-eyebrow::after {
      content: ''; display: inline-block;
      width: 32px; height: 1.5px; background: var(--terra); opacity: 0.5;
    }
    .page-hero-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(3rem, 5vw, 5rem);
      font-weight: 300; color: var(--ink); line-height: 1.1; margin-bottom: 1rem;
    }
    .page-hero-title em { font-style: italic; color: var(--green); }
    .page-hero-sub {
      font-size: 1rem; color: var(--ink-soft);
      max-width: 480px; margin: 0 auto; line-height: 1.7;
    }

    /* ── SHOP LAYOUT ── */
    .shop-section { padding: 3rem 3rem 6rem; }

    /* Filter bar */
    .shop-filter-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 2.5rem;
      flex-wrap: wrap;
      gap: 1rem;
    }
    .shop-filter-tabs {
      display: flex; gap: 0.5rem; flex-wrap: wrap;
    }
    .shop-filter-btn {
      padding: 0.45rem 1.1rem;
      border-radius: 99px;
      border: 1.5px solid rgba(28,26,23,0.12);
      background: transparent;
      font-family: 'Nunito', sans-serif;
      font-size: 0.78rem; font-weight: 600;
      letter-spacing: 0.05em; color: var(--ink-soft);
      cursor: pointer; transition: all 0.2s;
    }
    .shop-filter-btn:hover { border-color: var(--terra); color: var(--terra); }
    .shop-filter-btn.active {
      background: var(--green); border-color: var(--green); color: var(--white);
    }
    .shop-count {
      font-size: 0.82rem; color: var(--ink-soft);
    }

    /* Product grid */
    .shop-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.8rem;
    }
    .product-card {
      background: var(--white);
      border: 1px solid rgba(28,26,23,0.07);
      border-radius: 18px;
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      display: flex; flex-direction: column;
    }
    .product-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 16px 48px rgba(28,26,23,0.12);
    }

    /* Product image */
    .product-img-wrap {
      position: relative;
      overflow: hidden;
      aspect-ratio: 1/1;
      background: linear-gradient(135deg, var(--parchment), #e8d5b5);
    }
    .product-img-wrap img {
      width: 100%; height: 100%;
      object-fit: cover; display: block;
      transition: transform 0.5s ease;
    }
    .product-card:hover .product-img-wrap img { transform: scale(1.05); }
    .product-img-placeholder {
      width: 100%; height: 100%;
      display: flex; flex-direction: column;
      align-items: center; justify-content: center; gap: 0.5rem;
    }
    .product-img-placeholder-icon { font-size: 3.5rem; }
    .product-img-placeholder-label {
      font-family: 'Dancing Script', cursive;
      font-size: 1rem; color: var(--ink-soft);
    }

    /* Sold out badge */
    .product-badge {
      position: absolute; top: 0.9rem; left: 0.9rem;
      background: var(--terra); color: var(--white);
      font-size: 0.68rem; font-weight: 700;
      letter-spacing: 0.08em; text-transform: uppercase;
      padding: 0.25rem 0.6rem; border-radius: 6px;
    }
    .product-badge.sold-out { background: var(--ink-soft); }

    /* Product info */
    .product-info {
      padding: 1.3rem 1.5rem 1.5rem;
      display: flex; flex-direction: column; flex: 1;
    }
    .product-category {
      font-size: 0.68rem; font-weight: 600;
      letter-spacing: 0.14em; text-transform: uppercase;
      color: var(--terra); margin-bottom: 0.35rem;
    }
    .product-name {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.25rem; font-weight: 500;
      color: var(--ink); margin-bottom: 0.4rem; line-height: 1.2;
    }
    .product-desc {
      font-size: 0.82rem; color: var(--ink-soft);
      line-height: 1.6; flex: 1; margin-bottom: 1.1rem;
    }
    .product-footer {
      display: flex; align-items: center;
      justify-content: space-between; gap: 0.8rem;
    }
    .product-price {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.5rem; font-weight: 500; color: var(--ink);
    }
    /* Add to Cart button */
    .product-buy-btn {
      display: inline-flex; align-items: center; gap: 0.4rem;
      background: var(--green); color: var(--white);
      padding: 0.6rem 1.3rem; border-radius: 40px;
      font-family: 'Nunito', sans-serif;
      font-size: 0.8rem; font-weight: 600;
      letter-spacing: 0.05em; border: none; cursor: pointer;
      text-decoration: none;
      transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
      box-shadow: 0 3px 14px rgba(45,74,62,0.22);
    }
    .product-buy-btn:hover {
      background: var(--green-light);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(45,74,62,0.28);
    }
    .product-buy-btn:disabled,
    .product-buy-btn.sold-out {
      background: rgba(28,26,23,0.15);
      color: var(--ink-soft);
      cursor: not-allowed; box-shadow: none; transform: none;
    }
    .product-buy-btn.adding {
      background: var(--ochre); color: var(--ink);
      pointer-events: none;
    }

    /* ── QUANTITY STEPPER (replaces Add to Cart after adding) ── */
    .qty-stepper {
      display: none;                /* hidden until item is in cart */
      align-items: center;
      gap: 0;
      border: 2px solid var(--green);
      border-radius: 40px;
      overflow: hidden;
      animation: stepperPop 0.25s cubic-bezier(0.34,1.56,0.64,1) both;
    }
    .qty-stepper.visible { display: inline-flex; }
    @keyframes stepperPop {
      from { transform: scale(0.7); opacity: 0; }
      to   { transform: scale(1);   opacity: 1; }
    }
    .qty-stepper-btn {
      width: 34px; height: 34px;
      background: none; border: none; cursor: pointer;
      font-size: 1.1rem; font-weight: 600;
      color: var(--green); line-height: 1;
      display: flex; align-items: center; justify-content: center;
      transition: background 0.15s, color 0.15s;
      flex-shrink: 0;
    }
    .qty-stepper-btn:hover { background: var(--green); color: var(--white); }
    .qty-stepper-val {
      min-width: 28px; text-align: center;
      font-family: 'Nunito', sans-serif; font-size: 0.88rem;
      font-weight: 700; color: var(--ink);
      pointer-events: none;
    }

    /* Modal stepper matches modal button width */
    .modal-qty-stepper {
      display: none;
      align-items: center; justify-content: center;
      gap: 0;
      border: 2px solid var(--green);
      border-radius: 40px; overflow: hidden;
      width: 100%; height: 46px;
      animation: stepperPop 0.25s cubic-bezier(0.34,1.56,0.64,1) both;
    }
    .modal-qty-stepper.visible { display: inline-flex; }
    .modal-qty-stepper .qty-stepper-btn {
      flex: 1; height: 100%; font-size: 1.2rem;
    }
    .modal-qty-stepper .qty-stepper-val {
      flex: 0 0 44px; font-size: 1rem;
    }

    /* ── VIEW DETAILS HOVER OVERLAY ON CARD IMAGE ── */
    .product-img-wrap { cursor: pointer; }
    .product-img-view {
      position: absolute; inset: 0;
      background: rgba(28,26,23,0.45);
      display: flex; align-items: center; justify-content: center;
      opacity: 0; transition: opacity 0.25s ease;
      backdrop-filter: blur(2px);
    }
    .product-img-view span {
      background: var(--white); color: var(--ink);
      font-family: 'Nunito', sans-serif; font-size: 0.78rem;
      font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;
      padding: 0.5rem 1.1rem; border-radius: 99px;
    }
    .product-img-wrap:hover .product-img-view { opacity: 1; }
    .product-name { cursor: pointer; }
    .product-name:hover { color: var(--terra); }

    /* ── PRODUCT MODAL ── */
    .product-modal {
      position: fixed; inset: 0;
      background: rgba(28,26,23,0.6);
      backdrop-filter: blur(6px);
      z-index: 450;
      display: flex;
      align-items: flex-start;      /* start at top so tall modals scroll down, not up */
      justify-content: center;
      padding: 2rem 1.5rem;
      opacity: 0; pointer-events: none;
      transition: opacity 0.3s ease;
      overflow-y: auto;
    }
    .product-modal.open {
      opacity: 1; pointer-events: all;
    }
    .product-modal-inner {
      background: var(--white);
      border-radius: 24px;
      width: 100%; max-width: 860px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      overflow: hidden;
      box-shadow: 0 32px 80px rgba(28,26,23,0.22);
      transform: translateY(24px) scale(0.98);
      transition: transform 0.3s cubic-bezier(0.34,1.2,0.64,1);
      position: relative;
    }
    .product-modal.open .product-modal-inner {
      transform: translateY(0) scale(1);
    }
    /* Close button */
    .modal-close-btn {
      position: absolute; top: 1.2rem; right: 1.2rem;
      width: 36px; height: 36px; border-radius: 50%;
      background: rgba(28,26,23,0.08); border: none; cursor: pointer;
      font-size: 1rem; color: var(--ink-soft); z-index: 10;
      display: flex; align-items: center; justify-content: center;
      transition: background 0.2s, color 0.2s;
    }
    .modal-close-btn:hover { background: var(--terra); color: white; }

    /* Image panel */
    .modal-img-panel {
      background: linear-gradient(135deg, var(--parchment), #e8d5b5);
      min-height: 420px;
      max-height: 80vh;             /* never taller than viewport */
      display: flex; align-items: center; justify-content: center;
      overflow: hidden; position: relative;
    }
    .modal-img-panel img {
      width: 100%; height: 100%;
      object-fit: contain;          /* show full image without cropping */
      display: block;
    }
    .modal-img-placeholder { font-size: 6rem; }
    .modal-sold-out-ribbon {
      position: absolute; top: 1rem; left: 1rem;
      background: var(--ink-soft); color: white;
      font-size: 0.68rem; font-weight: 700;
      letter-spacing: 0.1em; text-transform: uppercase;
      padding: 0.28rem 0.7rem; border-radius: 6px;
    }

    /* Info panel */
    .modal-info-panel {
      padding: 2.5rem 2.2rem;
      display: flex; flex-direction: column;
      justify-content: center; gap: 0;
    }
    .modal-category {
      font-size: 0.7rem; font-weight: 700;
      letter-spacing: 0.18em; text-transform: uppercase;
      color: var(--terra); margin-bottom: 0.6rem;
    }
    .modal-name {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(1.6rem, 2.5vw, 2.2rem);
      font-weight: 400; color: var(--ink); line-height: 1.15;
      margin-bottom: 1rem;
    }
    .modal-price {
      font-family: 'Cormorant Garamond', serif;
      font-size: 2rem; font-weight: 500; color: var(--ink);
      margin-bottom: 1.2rem;
    }
    .modal-divider {
      height: 1px; background: rgba(28,26,23,0.08);
      margin: 0 0 1.2rem;
    }
    .modal-desc {
      font-size: 0.92rem; color: var(--ink-soft);
      line-height: 1.8; margin-bottom: 1.6rem; flex: 1;
    }
    .modal-handmade-note {
      display: flex; align-items: center; gap: 0.6rem;
      font-size: 0.78rem; color: var(--ink-soft);
      background: var(--parchment); border-radius: 10px;
      padding: 0.7rem 1rem; margin-bottom: 1.6rem;
    }
    .modal-actions { display: flex; flex-direction: column; gap: 0.8rem; }
    .modal-add-btn {
      display: flex; align-items: center; justify-content: center; gap: 0.5rem;
      width: 100%; padding: 0.9rem;
      background: var(--green); color: var(--white);
      border: none; border-radius: 40px; cursor: pointer;
      font-family: 'Nunito', sans-serif; font-size: 0.92rem;
      font-weight: 600; letter-spacing: 0.06em;
      transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
      box-shadow: 0 4px 20px rgba(45,74,62,0.28);
    }
    .modal-add-btn:hover {
      background: var(--green-light);
      transform: translateY(-2px);
      box-shadow: 0 8px 28px rgba(45,74,62,0.32);
    }
    .modal-add-btn.adding { background: var(--ochre); color: var(--ink); pointer-events: none; }
    .modal-add-btn:disabled {
      background: rgba(28,26,23,0.15); color: var(--ink-soft);
      cursor: not-allowed; transform: none; box-shadow: none;
    }
    .modal-view-cart {
      display: block; text-align: center;
      font-size: 0.8rem; color: var(--ink-soft);
      text-decoration: none; transition: color 0.2s;
    }
    .modal-view-cart:hover { color: var(--terra); }

    @media (max-width: 680px) {
      .product-modal-inner { grid-template-columns: 1fr; }
      .modal-img-panel { min-height: 260px; }
      .modal-info-panel { padding: 1.8rem; max-height: none; }
    }
    .cart-toast {
      position: fixed; bottom: 2rem; left: 50%;
      transform: translateX(-50%) translateY(calc(100% + 3rem));
      opacity: 0;
      pointer-events: none;
      background: var(--ink); color: var(--white);
      padding: 0.8rem 1.5rem; border-radius: 99px;
      font-family: 'Nunito', sans-serif; font-size: 0.88rem;
      font-weight: 600; z-index: 400;
      display: flex; align-items: center; gap: 0.7rem;
      box-shadow: 0 8px 32px rgba(28,26,23,0.25);
      transition: transform 0.35s cubic-bezier(0.34,1.56,0.64,1), opacity 0.35s ease;
      white-space: nowrap;
    }
    .cart-toast.show {
      transform: translateX(-50%) translateY(0);
      opacity: 1;
      pointer-events: all;
    }
    .cart-toast a {
      color: var(--ochre); text-decoration: none; font-weight: 700;
    }
    .cart-toast a:hover { text-decoration: underline; }

    /* ── FLOATING CART BAR ── */
    .cart-bar {
      position: fixed; bottom: 0; left: 0; right: 0;
      background: var(--green); color: var(--white);
      padding: 1rem 2rem; z-index: 300;
      display: flex; align-items: center; justify-content: space-between;
      gap: 1rem; transform: translateY(100%);
      transition: transform 0.35s ease;
      box-shadow: 0 -4px 24px rgba(28,26,23,0.15);
    }
    .cart-bar.show { transform: translateY(0); }
    .cart-bar-info {
      font-family: 'Nunito', sans-serif; font-size: 0.9rem; font-weight: 600;
    }
    .cart-bar-count { opacity: 0.75; font-size: 0.8rem; }
    .cart-bar-btn {
      display: inline-flex; align-items: center; gap: 0.5rem;
      background: var(--white); color: var(--green);
      padding: 0.65rem 1.5rem; border-radius: 40px;
      font-family: 'Nunito', sans-serif; font-size: 0.85rem; font-weight: 700;
      text-decoration: none; flex-shrink: 0;
      transition: background 0.2s, transform 0.2s;
      box-shadow: 0 3px 14px rgba(255,253,248,0.2);
    }
    .cart-bar-btn:hover { background: var(--parchment); transform: translateY(-1px); }

    /* Empty / error states */
    .shop-empty {
      grid-column: 1 / -1;
      text-align: center; padding: 5rem 2rem;
    }
    .shop-empty-icon { font-size: 3rem; margin-bottom: 1rem; }
    .shop-empty-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.8rem; font-weight: 400; color: var(--ink); margin-bottom: 0.5rem;
    }
    .shop-empty-body { font-size: 0.9rem; color: var(--ink-soft); line-height: 1.7; }

    /* Loading skeleton */
    .skeleton {
      background: linear-gradient(90deg, var(--parchment) 25%, #f0e0c4 50%, var(--parchment) 75%);
      background-size: 200% 100%;
      animation: shimmer 1.4s infinite;
      border-radius: 8px;
    }
    @keyframes shimmer {
      0%   { background-position: 200% 0; }
      100% { background-position: -200% 0; }
    }
    .skeleton-card {
      border-radius: 18px; overflow: hidden;
      border: 1px solid rgba(28,26,23,0.07);
    }
    .skeleton-img { aspect-ratio: 1/1; }
    .skeleton-body { padding: 1.3rem 1.5rem 1.5rem; }
    .skeleton-line { height: 14px; margin-bottom: 10px; }
    .skeleton-line.short { width: 40%; }
    .skeleton-line.medium { width: 70%; }
    .skeleton-line.tall { height: 18px; width: 55%; }

    @media (max-width: 900px) {
      .page-hero { padding: 8rem 1.5rem 3rem; }
      .shop-section { padding: 2rem 1.5rem 5rem; }
      .shop-grid { grid-template-columns: repeat(2, 1fr); gap: 1.2rem; }
    }
    @media (max-width: 500px) {
      .shop-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

<?php
require_once 'config/stripe.php';

// Load Stripe via Composer autoload
// Run on server: composer require stripe/stripe-php
$stripeLoaded = file_exists(__DIR__ . '/vendor/autoload.php');
if ($stripeLoaded) {
  require_once __DIR__ . '/vendor/autoload.php';
  \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
}

// Fetch products from Stripe
$products    = [];
$fetchError  = null;

if ($stripeLoaded) {
  try {
    // Fetch all active products with their prices
    $stripeProducts = \Stripe\Product::all([
      'active' => true,
      'expand' => ['data.default_price'],
      'limit'  => 100,
    ]);
    $products = $stripeProducts->data;

    // Sort by created date, newest first
    usort($products, fn($a, $b) => $b->created - $a->created);

  } catch (\Stripe\Exception\ApiErrorException $e) {
    $fetchError = 'Unable to load products right now. Please try again shortly.';
  }
} else {
  $fetchError = 'setup'; // triggers setup notice for dev
}
?>

<?php include 'includes/nav.php'; ?>

<!-- PAGE HERO -->
<section class="page-hero">
  <div class="page-hero-blob page-hero-blob-1"></div>
  <div class="page-hero-blob page-hero-blob-2"></div>
  <div class="page-hero-eyebrow">Available Now</div>
  <h1 class="page-hero-title">The <em>Shop</em></h1>
  <p class="page-hero-sub">
    Every piece is handmade and one of a kind. Once it's gone, it's gone —
    so grab your favourite before someone else does.
  </p>
</section>

<!-- SHOP -->
<section class="shop-section">

  <?php if ($fetchError === 'setup'): ?>
    <!-- DEV NOTICE: Stripe not yet set up -->
    <div style="background:rgba(212,168,67,0.12); border:1.5px solid rgba(212,168,67,0.4);
                border-radius:14px; padding:1.5rem 2rem; margin-bottom:2rem;
                font-size:0.88rem; color:var(--ink-soft); line-height:1.7;">
      <strong style="color:var(--ink)">⚙️ Developer notice:</strong>
      Stripe is not yet configured. To enable the shop:<br>
      1. Copy <code>config/stripe.example.php</code> → <code>config/stripe.php</code> and add your keys.<br>
      2. Run <code>composer require stripe/stripe-php</code> via SSH on Hostinger.<br>
      3. Add products at <a href="https://dashboard.stripe.com/products" target="_blank" style="color:var(--terra)">dashboard.stripe.com/products</a>.
    </div>
  <?php elseif ($fetchError): ?>
    <div style="background:rgba(201,104,58,0.1); border:1.5px solid rgba(201,104,58,0.2);
                border-radius:14px; padding:1.2rem 1.8rem; margin-bottom:2rem;
                font-size:0.88rem; color:var(--terra);">
      <?= htmlspecialchars($fetchError) ?>
    </div>
  <?php endif; ?>

  <!-- Filter bar — categories pulled from Stripe product metadata -->
  <div class="shop-filter-bar">
    <div class="shop-filter-tabs" id="filterTabs">
      <button class="shop-filter-btn active" data-filter="all">All</button>
      <?php
        // Build category list from product metadata
        $categories = [];
        foreach ($products as $p) {
          $cat = $p->metadata['category'] ?? null;
          if ($cat && !in_array($cat, $categories)) $categories[] = $cat;
        }
        sort($categories);
        foreach ($categories as $cat):
      ?>
        <button class="shop-filter-btn" data-filter="<?= htmlspecialchars($cat) ?>">
          <?= htmlspecialchars(ucfirst($cat)) ?>
        </button>
      <?php endforeach; ?>
    </div>
    <div class="shop-count" id="shopCount">
      <?= count($products) ?> item<?= count($products) !== 1 ? 's' : '' ?>
    </div>
  </div>

  <!-- Product grid -->
  <div class="shop-grid" id="shopGrid">

    <?php if (empty($products) && !$fetchError): ?>
      <div class="shop-empty">
        <div class="shop-empty-icon">🛍️</div>
        <div class="shop-empty-title">No items listed yet</div>
        <p class="shop-empty-body">
          Check back soon — new pieces are added regularly.<br>
          Want something custom? <a href="commissions.php" style="color:var(--terra)">Request a commission.</a>
        </p>
      </div>

    <?php else: ?>
      <?php foreach ($products as $product):
        $price    = $product->default_price;
        $amount   = $price ? $price->unit_amount : null;
        $currency = $price ? strtoupper($price->currency) : 'USD';
        $inStock  = ($product->metadata['in_stock'] ?? 'true') !== 'false';
        $category = $product->metadata['category'] ?? '';
        $imageUrl = !empty($product->images) ? $product->images[0] : null;
        $priceId  = $price ? $price->id : null;

        // Build JS-safe versions for onclick attributes
        $jsName     = htmlspecialchars(addslashes($product->name), ENT_QUOTES);
        $jsDesc     = htmlspecialchars(addslashes($product->description ?? ''), ENT_QUOTES);
        $jsImage    = htmlspecialchars($imageUrl ?? '', ENT_QUOTES);
        $jsCat      = htmlspecialchars($category, ENT_QUOTES);
        $jsPriceId  = htmlspecialchars($priceId ?? '', ENT_QUOTES);
        $jsAmount   = (int)$amount;
        $jsInStock  = $inStock ? 'true' : 'false';
      ?>
      <div class="product-card" data-category="<?= htmlspecialchars($category) ?>">

        <!-- Clicking the image opens the modal -->
        <div class="product-img-wrap"
             onclick="openModal('<?= $jsName ?>', <?= $jsAmount ?>, '<?= $jsDesc ?>', '<?= $jsImage ?>', '<?= $jsCat ?>', <?= $jsInStock ?>, '<?= $jsPriceId ?>')">
          <?php if ($imageUrl): ?>
            <img src="<?= htmlspecialchars($imageUrl) ?>"
                 alt="<?= htmlspecialchars($product->name) ?>"
                 loading="lazy" />
          <?php else: ?>
            <div class="product-img-placeholder">
              <div class="product-img-placeholder-icon">🎨</div>
              <div class="product-img-placeholder-label"><?= htmlspecialchars($product->name) ?></div>
            </div>
          <?php endif; ?>
          <?php if (!$inStock): ?>
            <span class="product-badge sold-out">Sold Out</span>
          <?php endif; ?>
          <!-- "View Details" hover overlay -->
          <div class="product-img-view"><span>View Details</span></div>
        </div>

        <div class="product-info">
          <?php if ($category): ?>
            <div class="product-category"><?= htmlspecialchars(ucfirst($category)) ?></div>
          <?php endif; ?>

          <!-- Clicking the name also opens the modal -->
          <div class="product-name"
               onclick="openModal('<?= $jsName ?>', <?= $jsAmount ?>, '<?= $jsDesc ?>', '<?= $jsImage ?>', '<?= $jsCat ?>', <?= $jsInStock ?>, '<?= $jsPriceId ?>')">
            <?= htmlspecialchars($product->name) ?>
          </div>

          <?php if ($product->description): ?>
            <div class="product-desc"><?= htmlspecialchars($product->description) ?></div>
          <?php endif; ?>
          <div class="product-footer">
            <div class="product-price">
              <?php if ($amount): ?>
                $<?= number_format($amount / 100, 2) ?>
              <?php else: ?>
                <span style="font-size:1rem; color:var(--ink-soft)">Contact for price</span>
              <?php endif; ?>
            </div>
            <?php if ($inStock && $priceId): ?>
              <button type="button"
                      class="product-buy-btn"
                      id="btn-<?= htmlspecialchars($priceId) ?>"
                      onclick="addToCart(
                        '<?= $jsPriceId ?>',
                        '<?= $jsName ?>',
                        <?= $jsAmount ?>,
                        '<?= $jsImage ?>',
                        '<?= $jsCat ?>',
                        this
                      )">
                Add to Cart
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M2 6h8M7 3l3 3-3 3" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
              </button>
              <!-- Quantity stepper — hidden until item added to cart -->
              <div class="qty-stepper" id="stepper-<?= htmlspecialchars($priceId) ?>"
                   data-price-id="<?= htmlspecialchars($priceId) ?>">
                <button class="qty-stepper-btn" onclick="stepQty('<?= $jsPriceId ?>', -1)">−</button>
                <span   class="qty-stepper-val" id="stepval-<?= htmlspecialchars($priceId) ?>">1</span>
                <button class="qty-stepper-btn" onclick="stepQty('<?= $jsPriceId ?>',  1)">+</button>
              </div>
            <?php else: ?>
              <button class="product-buy-btn sold-out" disabled>Sold Out</button>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    <?php endif; ?>

  </div>
</section>

<?php include 'includes/footer.php'; ?>

<!-- ── PRODUCT MODAL ── -->
<div class="product-modal" id="productModal">
  <div class="product-modal-inner">
    <button class="modal-close-btn" onclick="closeModal()" aria-label="Close">✕</button>

    <!-- Left: image -->
    <div class="modal-img-panel" id="modalImgPanel">
      <img id="modalImg" src="" alt="" style="display:none" />
      <div class="modal-img-placeholder" id="modalImgPlaceholder" style="display:none">🎨</div>
      <div class="modal-sold-out-ribbon" id="modalSoldOutRibbon" style="display:none">Sold Out</div>
    </div>

    <!-- Right: info -->
    <div class="modal-info-panel">
      <div class="modal-category" id="modalCategory"></div>
      <div class="modal-name"     id="modalName"></div>
      <div class="modal-price"    id="modalPrice"></div>
      <div class="modal-divider"></div>
      <div class="modal-desc"     id="modalDesc"></div>
      <div class="modal-handmade-note">✦ Every piece is handmade and one of a kind.</div>
      <div class="modal-actions">
        <button class="modal-add-btn" id="modalAddBtn">Add to Cart</button>
        <div class="modal-qty-stepper" id="modalStepper">
          <button class="qty-stepper-btn" onclick="modalStepQty(-1)">−</button>
          <span   class="qty-stepper-val" id="modalStepVal">1</span>
          <button class="qty-stepper-btn" onclick="modalStepQty( 1)">+</button>
        </div>
        <a href="cart.php" class="modal-view-cart">View Cart →</a>
      </div>
    </div>
  </div>
</div>

<!-- Cart toast notification -->
<div class="cart-toast" id="cartToast">
  <span id="cartToastMsg">Added to cart!</span>
  <a href="cart.php">View Cart →</a>
</div>

<!-- Floating cart bar (appears when cart has items) -->
<div class="cart-bar" id="cartBar">
  <div class="cart-bar-info">
    <div id="cartBarTitle">Your cart</div>
    <div class="cart-bar-count" id="cartBarCount"></div>
  </div>
  <a href="cart.php" class="cart-bar-btn">
    View Cart
    <svg width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
  </a>
</div>

<script src="script.js"></script>
<script>
  // ── Category filter ──
  const filterBtns = document.querySelectorAll('.shop-filter-btn');
  const cards      = document.querySelectorAll('.product-card');
  const countEl    = document.getElementById('shopCount');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const f = btn.dataset.filter;
      let visible = 0;
      cards.forEach(card => {
        const show = f === 'all' || card.dataset.category === f;
        card.style.display = show ? '' : 'none';
        if (show) visible++;
      });
      countEl.textContent = `${visible} item${visible !== 1 ? 's' : ''}`;
    });
  });

  // ── Cart state ──
  let cartCount    = 0;
  let toastTimeout = null;

  // Track quantities per price_id so steppers stay in sync
  const cartQtys = {};

  // ── Show stepper on a card ──
  function showStepper(priceId, qty) {
    const btn     = document.getElementById('btn-' + priceId);
    const stepper = document.getElementById('stepper-' + priceId);
    const valEl   = document.getElementById('stepval-' + priceId);
    if (!btn || !stepper) return;
    btn.style.display     = 'none';
    stepper.classList.add('visible');
    if (valEl) valEl.textContent = qty;
    cartQtys[priceId] = qty;
  }

  // ── Hide stepper, restore Add to Cart button ──
  function hideStepper(priceId) {
    const btn     = document.getElementById('btn-' + priceId);
    const stepper = document.getElementById('stepper-' + priceId);
    if (!btn || !stepper) return;
    stepper.classList.remove('visible');
    btn.style.display = '';
    btn.innerHTML = 'Add to Cart <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M2 6h8M7 3l3 3-3 3" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    delete cartQtys[priceId];
  }

  // ── Stepper +/− on card ──
  function stepQty(priceId, delta) {
    const current = cartQtys[priceId] || 0;
    const newQty  = Math.max(0, current + delta);

    fetch('cart-handler.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'action=update&price_id=' + encodeURIComponent(priceId) + '&quantity=' + newQty
    })
    .then(r => r.json())
    .then(data => {
      if (newQty === 0) {
        hideStepper(priceId);
        // Sync modal stepper if it's open for this product
        if (currentModalPriceId === priceId) syncModalStepper(0);
      } else {
        const valEl = document.getElementById('stepval-' + priceId);
        if (valEl) valEl.textContent = newQty;
        cartQtys[priceId] = newQty;
        if (currentModalPriceId === priceId) syncModalStepper(newQty);
      }
      cartCount = data.count;
      refreshCartBar(data.count, data.subtotal);
      updateNavBadge(data.count);
    });
  }

  // ── Add to cart (initial add) ──
  function addToCart(priceId, name, amount, imageUrl, category, btn) {
    btn.classList.add('adding');
    btn.textContent = 'Adding...';

    const body = new URLSearchParams({
      action:       'add',
      price_id:     priceId,
      product_name: name,
      amount:       amount,
      image_url:    imageUrl,
      category:     category,
    });

    fetch('cart-handler.php', { method: 'POST', body: body })
      .then(r => r.json())
      .then(data => {
        btn.classList.remove('adding');
        if (data.success) {
          const newQty = (cartQtys[priceId] || 0) + 1;
          showStepper(priceId, newQty);
          // Sync modal if open
          if (currentModalPriceId === priceId) syncModalStepper(newQty);
          cartCount = data.count;
          showToast(data.message);
          refreshCartBar(data.count, data.subtotal);
          updateNavBadge(data.count);
        } else {
          btn.classList.remove('adding');
          btn.innerHTML = 'Add to Cart <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M2 6h8M7 3l3 3-3 3" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>';
        }
      })
      .catch(() => {
        btn.classList.remove('adding');
        btn.innerHTML = 'Add to Cart <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M2 6h8M7 3l3 3-3 3" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>';
      });
  }

  // ── Restore steppers on page load for items already in session cart ──
  fetch('cart-handler.php?action=count')
    .then(r => r.json())
    .then(data => {
      cartCount = data.count || 0;
      refreshCartBar(cartCount, data.subtotal || 0);
      updateNavBadge(cartCount);
      // Fetch full cart to restore individual steppers
      return fetch('cart-handler.php?action=items');
    })
    .then(r => r.ok ? r.json() : null)
    .then(data => {
      if (data && data.items) {
        data.items.forEach(item => {
          cartQtys[item.price_id] = item.quantity;
          showStepper(item.price_id, item.quantity);
        });
      }
    })
    .catch(() => {}); // fail silently if items endpoint not yet added

  // ── Modal stepper sync ──
  let currentModalPriceId = null;

  function syncModalStepper(qty) {
    const addBtn  = document.getElementById('modalAddBtn');
    const stepper = document.getElementById('modalStepper');
    const valEl   = document.getElementById('modalStepVal');
    if (qty > 0) {
      addBtn.style.display  = 'none';
      stepper.classList.add('visible');
      if (valEl) valEl.textContent = qty;
    } else {
      stepper.classList.remove('visible');
      addBtn.style.display = '';
      addBtn.disabled      = false;
      addBtn.textContent   = 'Add to Cart';
    }
  }

  function modalStepQty(delta) {
    if (!currentModalPriceId) return;
    stepQty(currentModalPriceId, delta);
  }

  // ── Modal open/close ──
  const modal = document.getElementById('productModal');

  function openModal(name, amount, desc, imageUrl, category, inStock, priceId) {
    currentModalPriceId = priceId;

    document.getElementById('modalName').textContent     = name;
    document.getElementById('modalCategory').textContent = category ? category.toUpperCase() : '';
    document.getElementById('modalDesc').textContent     = desc || '';
    document.getElementById('modalPrice').textContent    = amount ? '$' + (amount / 100).toFixed(2) : 'Contact for price';

    const img         = document.getElementById('modalImg');
    const placeholder = document.getElementById('modalImgPlaceholder');
    if (imageUrl) {
      img.src = imageUrl; img.alt = name;
      img.style.display         = 'block';
      placeholder.style.display = 'none';
    } else {
      img.style.display         = 'none';
      placeholder.style.display = 'flex';
    }

    document.getElementById('modalSoldOutRibbon').style.display = inStock ? 'none' : 'block';

    const addBtn = document.getElementById('modalAddBtn');
    if (inStock && priceId) {
      addBtn.disabled  = false;
      addBtn.onclick   = () => {
        const dummyBtn = document.createElement('button');
        dummyBtn.className = 'product-buy-btn';
        document.body.appendChild(dummyBtn);
        addToCart(priceId, name, amount, imageUrl, category, dummyBtn);
        dummyBtn.remove();
      };
      // Restore stepper state if already in cart
      const existingQty = cartQtys[priceId] || 0;
      syncModalStepper(existingQty);
    } else {
      addBtn.disabled    = true;
      addBtn.textContent = 'Sold Out';
      addBtn.onclick     = null;
      syncModalStepper(0);
    }

    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeModal() {
    modal.classList.remove('open');
    document.body.style.overflow = '';
  }

  modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

  // ── Toast ──
  function showToast(msg) {
    const toast = document.getElementById('cartToast');
    document.getElementById('cartToastMsg').textContent = msg;
    toast.classList.add('show');
    clearTimeout(toastTimeout);
    toastTimeout = setTimeout(() => toast.classList.remove('show'), 3500);
  }

  // ── Cart bar ──
  function refreshCartBar(count, subtotalCents) {
    const bar = document.getElementById('cartBar');
    if (count > 0) {
      bar.classList.add('show');
      document.getElementById('cartBarTitle').textContent =
        '$' + (subtotalCents / 100).toFixed(2) + ' in your cart';
      document.getElementById('cartBarCount').textContent =
        count + ' item' + (count !== 1 ? 's' : '');
    } else {
      bar.classList.remove('show');
    }
  }

  // ── Nav badge ──
  function updateNavBadge(count) {
    document.querySelectorAll('.cart-badge').forEach(b => {
      b.textContent = count;
      b.style.display = count > 0 ? 'flex' : 'none';
    });
  }
</script>
</body>
</html>