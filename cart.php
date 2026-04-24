<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
$cart     = $_SESSION['cart'];
$count    = 0;
$subtotal = 0;
foreach ($cart as $item) {
    $qty       = (int)($item['quantity'] ?? 1);
    $count    += $qty;
    $subtotal += (int)($item['amount'] ?? 0) * $qty;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon-32x32.png" />
  <title>Your Cart — Miracale Design</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Nunito:wght@300;400;500;600&family=Dancing+Script:wght@500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />
  <style>
    .page-hero {
      padding: 9rem 3rem 3rem; text-align: center;
      position: relative; overflow: hidden;
    }
    .page-hero-blob {
      position: absolute; border-radius: 50%;
      filter: blur(90px); pointer-events: none;
    }
    .page-hero-blob-1 {
      width: 380px; height: 380px;
      background: radial-gradient(circle, rgba(45,74,62,0.1), transparent 70%);
      top: -60px; right: 8%;
      animation: drift 9s ease-in-out infinite alternate;
    }
    .page-hero-eyebrow {
      font-size: 0.75rem; font-weight: 600;
      letter-spacing: 0.22em; text-transform: uppercase;
      color: var(--terra); margin-bottom: 0.8rem;
      display: flex; align-items: center; justify-content: center; gap: 0.7rem;
    }
    .page-hero-eyebrow::before, .page-hero-eyebrow::after {
      content: ''; display: inline-block;
      width: 32px; height: 1.5px; background: var(--terra); opacity: 0.5;
    }
    .page-hero-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(2.4rem, 4vw, 4rem);
      font-weight: 300; color: var(--ink); line-height: 1.1;
    }
    .page-hero-title em { font-style: italic; color: var(--green); }

    /* ── CART LAYOUT ── */
    .cart-section {
      padding: 3rem 3rem 6rem;
      display: grid;
      grid-template-columns: 1fr 340px;
      gap: 2.5rem;
      align-items: start;
    }

    /* ── CART ITEMS ── */
    .cart-items { display: flex; flex-direction: column; gap: 1rem; }
    .cart-item {
      display: grid;
      grid-template-columns: 80px 1fr auto;
      gap: 1.2rem;
      align-items: center;
      background: var(--white);
      border: 1px solid rgba(28,26,23,0.07);
      border-radius: 16px;
      padding: 1.2rem 1.4rem;
      box-shadow: 0 2px 12px rgba(28,26,23,0.04);
      transition: box-shadow 0.25s;
    }
    .cart-item:hover { box-shadow: 0 6px 24px rgba(28,26,23,0.09); }
    .cart-item-img {
      width: 80px; height: 80px;
      border-radius: 10px; overflow: hidden;
      background: linear-gradient(135deg, var(--parchment), #e8d5b5);
      flex-shrink: 0; display: flex;
      align-items: center; justify-content: center;
    }
    .cart-item-img img {
      width: 100%; height: 100%; object-fit: cover;
    }
    .cart-item-img-placeholder { font-size: 2rem; }
    .cart-item-info { min-width: 0; }
    .cart-item-category {
      font-size: 0.68rem; font-weight: 600;
      letter-spacing: 0.12em; text-transform: uppercase;
      color: var(--terra); margin-bottom: 0.2rem;
    }
    .cart-item-name {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.15rem; font-weight: 500; color: var(--ink);
      white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .cart-item-price {
      font-size: 0.88rem; color: var(--ink-soft); margin-top: 0.2rem;
    }
    .cart-item-actions {
      display: flex; flex-direction: column;
      align-items: flex-end; gap: 0.6rem; flex-shrink: 0;
    }
    .cart-item-subtotal {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.3rem; font-weight: 500; color: var(--ink);
    }
    /* Quantity controls */
    .qty-wrap {
      display: flex; align-items: center; gap: 0;
      border: 1.5px solid rgba(28,26,23,0.12);
      border-radius: 99px; overflow: hidden;
    }
    .qty-btn {
      width: 30px; height: 30px;
      background: none; border: none; cursor: pointer;
      font-size: 1rem; color: var(--ink-soft);
      display: flex; align-items: center; justify-content: center;
      transition: background 0.15s, color 0.15s;
    }
    .qty-btn:hover { background: var(--parchment); color: var(--ink); }
    .qty-val {
      min-width: 28px; text-align: center;
      font-family: 'Nunito', sans-serif; font-size: 0.85rem; font-weight: 600;
      color: var(--ink);
    }
    .cart-remove-btn {
      background: none; border: none; cursor: pointer;
      font-size: 0.72rem; font-weight: 600;
      color: rgba(201,104,58,0.6); letter-spacing: 0.04em;
      transition: color 0.2s; padding: 0;
    }
    .cart-remove-btn:hover { color: var(--terra); }

    /* Empty cart */
    .cart-empty {
      grid-column: 1 / -1; text-align: center; padding: 5rem 2rem;
    }
    .cart-empty-icon { font-size: 4rem; margin-bottom: 1rem; }
    .cart-empty-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 2rem; font-weight: 400; color: var(--ink); margin-bottom: 0.5rem;
    }
    .cart-empty-sub { font-size: 0.9rem; color: var(--ink-soft); margin-bottom: 2rem; }

    /* ── ORDER SUMMARY SIDEBAR ── */
    .cart-summary {
      background: var(--white);
      border: 1px solid rgba(28,26,23,0.07);
      border-radius: 20px; padding: 2rem;
      box-shadow: 0 4px 24px rgba(28,26,23,0.06);
      position: sticky; top: 6rem;
    }
    .cart-summary-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.4rem; font-weight: 500; color: var(--ink);
      margin-bottom: 1.4rem; padding-bottom: 1rem;
      border-bottom: 1px solid rgba(28,26,23,0.07);
    }
    .summary-row {
      display: flex; justify-content: space-between;
      font-size: 0.88rem; color: var(--ink-soft);
      margin-bottom: 0.7rem;
    }
    .summary-row.total {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.5rem; font-weight: 500; color: var(--ink);
      margin-top: 1rem; padding-top: 1rem;
      border-top: 1px solid rgba(28,26,23,0.09);
    }
    .summary-note {
      font-size: 0.75rem; color: var(--ink-soft);
      text-align: center; margin: 1rem 0;
      line-height: 1.5; opacity: 0.7;
    }
    .checkout-btn {
      display: flex; align-items: center; justify-content: center; gap: 0.5rem;
      width: 100%; padding: 1rem;
      background: var(--green); color: var(--white);
      border: none; border-radius: 40px; cursor: pointer;
      font-family: 'Nunito', sans-serif; font-size: 0.92rem;
      font-weight: 600; letter-spacing: 0.06em;
      transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
      box-shadow: 0 4px 20px rgba(45,74,62,0.28);
      text-decoration: none;
      margin-top: 0.5rem;
    }
    .checkout-btn:hover {
      background: var(--green-light);
      transform: translateY(-2px);
      box-shadow: 0 8px 28px rgba(45,74,62,0.32);
    }
    .checkout-btn:disabled {
      opacity: 0.5; cursor: not-allowed; transform: none;
    }
    .keep-shopping {
      display: block; text-align: center; margin-top: 1rem;
      font-size: 0.8rem; color: var(--ink-soft);
      text-decoration: none; transition: color 0.2s;
    }
    .keep-shopping:hover { color: var(--terra); }

    /* Loading overlay on checkout */
    .cart-loading {
      display: none; position: fixed; inset: 0;
      background: rgba(253,246,236,0.8); backdrop-filter: blur(4px);
      z-index: 300; align-items: center; justify-content: center;
      flex-direction: column; gap: 1rem;
    }
    .cart-loading.show { display: flex; }
    .cart-loading-spinner {
      width: 44px; height: 44px;
      border: 3px solid var(--parchment);
      border-top-color: var(--green);
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .cart-loading-text {
      font-family: 'Dancing Script', cursive;
      font-size: 1.4rem; color: var(--green);
    }

    @media (max-width: 860px) {
      .cart-section { grid-template-columns: 1fr; padding: 2rem 1.5rem 5rem; }
      .cart-summary { position: static; }
      .cart-item { grid-template-columns: 64px 1fr auto; gap: 0.9rem; }
    }
    @media (max-width: 500px) {
      .cart-item { grid-template-columns: 1fr; }
      .cart-item-img { display: none; }
    }
  </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<!-- HERO -->
<section class="page-hero">
  <div class="page-hero-blob page-hero-blob-1"></div>
  <div class="page-hero-eyebrow">Your Selections</div>
  <h1 class="page-hero-title">Your <em>Cart</em></h1>
</section>

<!-- CART -->
<section class="cart-section" id="cartSection">

  <?php if (empty($cart)): ?>
  <div class="cart-empty">
    <div class="cart-empty-icon">🛒</div>
    <div class="cart-empty-title">Your cart is empty</div>
    <p class="cart-empty-sub">Looks like you haven't added anything yet.</p>
    <a href="shop.php" class="btn-primary">
      Browse the Shop
      <svg width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </a>
  </div>

  <?php else: ?>

  <!-- Items list -->
  <div class="cart-items" id="cartItems">
    <?php foreach ($cart as $item):
      $qty      = (int)($item['quantity'] ?? 1);
      $amount   = (int)($item['amount']   ?? 0);
      $lineTotal = $amount * $qty;
    ?>
    <div class="cart-item" id="item-<?= htmlspecialchars($item['price_id']) ?>">
      <div class="cart-item-img">
        <?php if (!empty($item['image_url'])): ?>
          <img src="<?= htmlspecialchars($item['image_url']) ?>"
               alt="<?= htmlspecialchars($item['product_name']) ?>" loading="lazy" />
        <?php else: ?>
          <div class="cart-item-img-placeholder">🎨</div>
        <?php endif; ?>
      </div>

      <div class="cart-item-info">
        <?php if (!empty($item['category'])): ?>
          <div class="cart-item-category"><?= htmlspecialchars(ucfirst($item['category'])) ?></div>
        <?php endif; ?>
        <div class="cart-item-name"><?= htmlspecialchars($item['product_name']) ?></div>
        <div class="cart-item-price">
          $<?= number_format($amount / 100, 2) ?> each
        </div>
      </div>

      <div class="cart-item-actions">
        <div class="cart-item-subtotal" id="subtotal-<?= htmlspecialchars($item['price_id']) ?>">
          $<?= number_format($lineTotal / 100, 2) ?>
        </div>
        <div class="qty-wrap">
          <button class="qty-btn"
                  onclick="updateQty('<?= htmlspecialchars($item['price_id']) ?>', <?= $qty - 1 ?>)">
            −
          </button>
          <span class="qty-val" id="qty-<?= htmlspecialchars($item['price_id']) ?>">
            <?= $qty ?>
          </span>
          <button class="qty-btn"
                  onclick="updateQty('<?= htmlspecialchars($item['price_id']) ?>', <?= $qty + 1 ?>)">
            +
          </button>
        </div>
        <button class="cart-remove-btn"
                onclick="removeItem('<?= htmlspecialchars($item['price_id']) ?>')">
          Remove
        </button>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Summary sidebar -->
  <div class="cart-summary">
    <div class="cart-summary-title">Order Summary</div>

    <div class="summary-row">
      <span>Items (<?= $count ?>)</span>
      <span id="summaryCount"><?= $count ?></span>
    </div>
    <div class="summary-row">
      <span>Subtotal</span>
      <span id="summarySubtotal">$<?= number_format($subtotal / 100, 2) ?></span>
    </div>
    <div class="summary-row">
      <span>Shipping</span>
      <span>Calculated at checkout</span>
    </div>
    <div class="summary-row total">
      <span>Total</span>
      <span id="summaryTotal">$<?= number_format($subtotal / 100, 2) ?></span>
    </div>

    <p class="summary-note">
      🔒 Secure checkout via Stripe.<br>
      Shipping calculated at checkout.
    </p>

    <form action="checkout.php" method="POST" id="cartCheckoutForm">
      <input type="hidden" name="source" value="cart" />
      <button type="submit" class="checkout-btn" id="checkoutBtn">
        Proceed to Checkout
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
    </form>

    <a href="shop.php" class="keep-shopping">← Keep shopping</a>
  </div>

  <?php endif; ?>

</section>

<!-- Loading overlay -->
<div class="cart-loading" id="cartLoading">
  <div class="cart-loading-spinner"></div>
  <div class="cart-loading-text">Preparing your checkout...</div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="script.js"></script>
<script>
// ── Update quantity ──
function updateQty(priceId, newQty) {
    fetch('cart-handler.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=update&price_id=' + encodeURIComponent(priceId) + '&quantity=' + newQty
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (!data.success) return;
        if (newQty <= 0) {
            // Remove row from DOM
            var row = document.getElementById('item-' + priceId);
            if (row) row.remove();
            // If cart now empty, reload to show empty state
            if (data.count === 0) { location.reload(); return; }
        } else {
            var qtyEl = document.getElementById('qty-' + priceId);
            if (qtyEl) qtyEl.textContent = newQty;
            // Update line total — find amount from existing display
            updateLineTotals(priceId, newQty);
        }
        refreshSummary(data.count, data.subtotal);
        updateNavBadge(data.count);
    });
}

function updateLineTotals(priceId, qty) {
    // Read the unit price from the "each" text to recalc line total
    var row = document.getElementById('item-' + priceId);
    if (!row) return;
    var priceText = row.querySelector('.cart-item-price');
    if (!priceText) return;
    var match = priceText.textContent.match(/\$([\d.]+)/);
    if (!match) return;
    var unitCents = Math.round(parseFloat(match[1]) * 100);
    var lineTotal = unitCents * qty;
    var subtotalEl = document.getElementById('subtotal-' + priceId);
    if (subtotalEl) subtotalEl.textContent = '$' + (lineTotal / 100).toFixed(2);

    // Update qty buttons
    var minusBtn = row.querySelectorAll('.qty-btn')[0];
    var plusBtn  = row.querySelectorAll('.qty-btn')[1];
    if (minusBtn) minusBtn.setAttribute('onclick', "updateQty('" + priceId + "'," + (qty-1) + ")");
    if (plusBtn)  plusBtn.setAttribute('onclick',  "updateQty('" + priceId + "'," + (qty+1) + ")");
}

// ── Remove item ──
function removeItem(priceId) {
    fetch('cart-handler.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=remove&price_id=' + encodeURIComponent(priceId)
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        var row = document.getElementById('item-' + priceId);
        if (row) {
            row.style.opacity = '0';
            row.style.transform = 'translateX(20px)';
            row.style.transition = 'all 0.3s ease';
            setTimeout(function() {
                row.remove();
                if (data.count === 0) { location.reload(); }
            }, 300);
        }
        refreshSummary(data.count, data.subtotal);
        updateNavBadge(data.count);
    });
}

// ── Refresh summary sidebar ──
function refreshSummary(count, subtotalCents) {
    var subtotal = '$' + (subtotalCents / 100).toFixed(2);
    var el;
    el = document.getElementById('summaryCount');    if (el) el.textContent = count;
    el = document.getElementById('summarySubtotal'); if (el) el.textContent = subtotal;
    el = document.getElementById('summaryTotal');    if (el) el.textContent = subtotal;
}

// ── Update nav cart badge ──
function updateNavBadge(count) {
    var badges = document.querySelectorAll('.cart-badge');
    badges.forEach(function(b) {
        b.textContent = count;
        b.style.display = count > 0 ? 'flex' : 'none';
    });
}

// ── Show loading on checkout ──
document.getElementById('cartCheckoutForm').addEventListener('submit', function() {
    document.getElementById('cartLoading').classList.add('show');
});
</script>
</body>
</html>