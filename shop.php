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
      ?>
      <div class="product-card" data-category="<?= htmlspecialchars($category) ?>">
        <div class="product-img-wrap">
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
        </div>

        <div class="product-info">
          <?php if ($category): ?>
            <div class="product-category"><?= htmlspecialchars(ucfirst($category)) ?></div>
          <?php endif; ?>
          <div class="product-name"><?= htmlspecialchars($product->name) ?></div>
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
              <form action="checkout.php" method="POST">
                <input type="hidden" name="price_id"    value="<?= htmlspecialchars($priceId) ?>" />
                <input type="hidden" name="product_name" value="<?= htmlspecialchars($product->name) ?>" />
                <button type="submit" class="product-buy-btn">
                  Buy Now
                  <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M2 6h8M7 3l3 3-3 3" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
              </form>
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
</script>
</body>
</html>