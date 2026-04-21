<?php
// Load portfolio items from JSON
$portfolioFile = __DIR__ . '/data/portfolio.json';
$items = array();
if (file_exists($portfolioFile)) {
    $decoded = json_decode(file_get_contents($portfolioFile), true);
    if (is_array($decoded)) $items = $decoded;
}

// Sort: featured first, then newest
usort($items, function($a, $b) {
    if (!empty($a['featured']) && empty($b['featured'])) return -1;
    if (empty($a['featured']) && !empty($b['featured'])) return 1;
    return strcmp($b['date_added'] ?? '', $a['date_added'] ?? '');
});

// Only show items that have an image
$items = array_values(array_filter($items, fn($i) => !empty($i['image'])));

// Build unique category list from actual items (for filter buttons)
$categories = array();
foreach ($items as $item) {
    $cat = $item['category'] ?? '';
    if ($cat && !in_array($cat, $categories)) $categories[] = $cat;
}
sort($categories);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon-32x32.png" />
  <title>Portfolio — Miracale Design</title>
  <meta name="description" content="Browse the portfolio of Miracale Design — a showcase of handmade art from Virginia." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Nunito:wght@300;400;500;600&family=Dancing+Script:wght@500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />
  <style>
    /* ── PAGE HERO ── */
    .page-hero {
      padding: 10rem 3rem 5rem;
      text-align: center; position: relative; overflow: hidden;
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

    /* ── FILTER BAR ── */
    .filter-bar {
      display: flex; justify-content: center;
      gap: 0.6rem; padding: 0 3rem 3rem; flex-wrap: wrap;
    }
    .filter-btn {
      padding: 0.5rem 1.3rem; border-radius: 99px;
      border: 1.5px solid rgba(28,26,23,0.12); background: transparent;
      font-family: 'Nunito', sans-serif; font-size: 0.8rem;
      font-weight: 600; letter-spacing: 0.06em; color: var(--ink-soft);
      cursor: pointer; transition: all 0.2s;
    }
    .filter-btn:hover { border-color: var(--terra); color: var(--terra); }
    .filter-btn.active { background: var(--green); border-color: var(--green); color: var(--white); }

    /* ── MASONRY GRID ── */
    .portfolio-section { padding: 0 3rem 6rem; }
    .portfolio-grid { columns: 3; column-gap: 1.2rem; }
    .portfolio-item {
      break-inside: avoid; margin-bottom: 1.2rem;
      border-radius: 14px; overflow: hidden;
      cursor: pointer; position: relative;
      background: var(--parchment);
      box-shadow: 0 4px 20px rgba(28,26,23,0.07);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .portfolio-item:hover {
      transform: translateY(-4px);
      box-shadow: 0 14px 40px rgba(28,26,23,0.14);
    }
    .portfolio-item img {
      width: 100%; display: block;
      transition: transform 0.5s ease;
    }
    .portfolio-item:hover img { transform: scale(1.04); }

    /* Hover overlay */
    .portfolio-overlay {
      position: absolute; inset: 0;
      background: linear-gradient(to top, rgba(28,26,23,0.75) 0%, transparent 55%);
      opacity: 0; transition: opacity 0.3s;
      display: flex; align-items: flex-end; padding: 1.2rem;
    }
    .portfolio-item:hover .portfolio-overlay { opacity: 1; }
    .portfolio-overlay-text h3 {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.1rem; font-weight: 500; color: var(--white);
    }
    .portfolio-overlay-text p {
      font-size: 0.75rem; color: rgba(255,253,248,0.75); margin-top: 0.1rem;
    }

    /* ── LIGHTBOX ── */
    .lightbox {
      position: fixed; inset: 0;
      background: rgba(28,26,23,0.92);
      z-index: 500;
      display: flex; align-items: center; justify-content: center;
      opacity: 0; pointer-events: none;
      transition: opacity 0.3s; padding: 2rem;
    }
    .lightbox.open { opacity: 1; pointer-events: all; }
    .lightbox-inner {
      position: relative; max-width: 860px; width: 100%;
    }
    .lightbox-img {
      width: 100%; max-height: 82vh;
      object-fit: contain; border-radius: 12px; display: block;
    }
    .lightbox-caption { margin-top: 1rem; text-align: center; }
    .lightbox-caption h3 {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.4rem; font-weight: 400; color: var(--white);
    }
    .lightbox-caption p {
      font-size: 0.82rem; color: rgba(255,253,248,0.6); margin-top: 0.2rem;
    }
    .lightbox-close {
      position: absolute; top: -1rem; right: -1rem;
      width: 36px; height: 36px;
      background: var(--terra); color: var(--white);
      border: none; border-radius: 50%; font-size: 1rem; cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      transition: background 0.2s;
    }
    .lightbox-close:hover { background: var(--ink); }

    /* ── EMPTY STATE ── */
    .portfolio-empty {
      text-align: center; padding: 6rem 2rem; grid-column: 1 / -1;
    }
    .portfolio-empty-icon { font-size: 3rem; margin-bottom: 1rem; }
    .portfolio-empty-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.8rem; font-weight: 400; color: var(--ink); margin-bottom: 0.5rem;
    }
    .portfolio-empty-body { font-size: 0.9rem; color: var(--ink-soft); line-height: 1.7; }

    /* ── CTA ── */
    .portfolio-cta {
      background: var(--green); padding: 5rem 3rem;
      text-align: center; position: relative; overflow: hidden;
    }
    .portfolio-cta::before {
      content: ''; position: absolute;
      width: 400px; height: 400px; border-radius: 50%;
      background: radial-gradient(circle, rgba(212,168,67,0.12), transparent 70%);
      top: -100px; right: -80px; pointer-events: none;
    }
    .portfolio-cta-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(2rem, 3vw, 2.8rem);
      font-weight: 300; color: var(--white); margin-bottom: 0.7rem;
    }
    .portfolio-cta-title em { font-style: italic; color: var(--ochre); }
    .portfolio-cta-sub {
      font-size: 0.92rem; color: rgba(255,253,248,0.7); margin-bottom: 2rem;
    }
    .portfolio-cta-btns { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
    .btn-ochre {
      display: inline-flex; align-items: center; gap: 0.5rem;
      background: var(--ochre); color: var(--ink);
      padding: 0.85rem 2rem; border-radius: 40px;
      font-family: 'Nunito', sans-serif; font-size: 0.85rem;
      font-weight: 700; letter-spacing: 0.05em; text-decoration: none;
      transition: background 0.2s, transform 0.2s;
    }
    .btn-ochre:hover { background: #c49030; transform: translateY(-2px); }
    .btn-ghost-light {
      display: inline-flex; align-items: center; gap: 0.4rem;
      color: rgba(255,253,248,0.8);
      font-family: 'Nunito', sans-serif; font-size: 0.85rem;
      font-weight: 600; letter-spacing: 0.04em; text-decoration: none;
      border-bottom: 1.5px solid rgba(255,253,248,0.3); padding-bottom: 2px;
      transition: color 0.2s, border-color 0.2s;
    }
    .btn-ghost-light:hover { color: var(--white); border-color: rgba(255,253,248,0.7); }

    @media (max-width: 900px) {
      .page-hero { padding: 8rem 1.5rem 3rem; }
      .filter-bar { padding: 0 1.5rem 2.5rem; }
      .portfolio-section { padding: 0 1.5rem 5rem; }
      .portfolio-grid { columns: 2; }
    }
    @media (max-width: 500px) {
      .portfolio-grid { columns: 1; }
    }
  </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<!-- PAGE HERO -->
<section class="page-hero">
  <div class="page-hero-blob page-hero-blob-1"></div>
  <div class="page-hero-blob page-hero-blob-2"></div>
  <div class="page-hero-eyebrow">The Work</div>
  <h1 class="page-hero-title">A gallery of<br><em>handmade art</em></h1>
  <p class="page-hero-sub">
    A look at past and current pieces — from tiny clay animals to full
    watercolor paintings. Every piece shown here was made by hand.
  </p>
</section>

<!-- FILTER BAR — built from actual categories in portfolio.json -->
<?php if (!empty($categories)): ?>
<div class="filter-bar" id="filterBar">
  <button class="filter-btn active" data-filter="all">All Work</button>
  <?php foreach ($categories as $cat): ?>
    <button class="filter-btn" data-filter="<?= htmlspecialchars($cat) ?>">
      <?= htmlspecialchars($cat) ?>
    </button>
  <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- PORTFOLIO GRID -->
<section class="portfolio-section">
  <div class="portfolio-grid" id="portfolioGrid">

    <?php if (empty($items)): ?>
      <div class="portfolio-empty">
        <div class="portfolio-empty-icon">🎨</div>
        <div class="portfolio-empty-title">Gallery coming soon</div>
        <p class="portfolio-empty-body">
          Portfolio pieces are being added. Check back soon!
        </p>
      </div>

    <?php else: ?>
      <?php foreach ($items as $item): ?>
      <div class="portfolio-item"
           data-category="<?= htmlspecialchars($item['category'] ?? '') ?>"
           data-image="<?= htmlspecialchars($item['image']) ?>"
           data-title="<?= htmlspecialchars($item['title']) ?>"
           data-desc="<?= htmlspecialchars($item['description'] ?? '') ?>"
           onclick="openLightbox(this)">
        <img src="<?= htmlspecialchars($item['image']) ?>"
             alt="<?= htmlspecialchars($item['title']) ?>"
             loading="lazy" />
        <div class="portfolio-overlay">
          <div class="portfolio-overlay-text">
            <h3><?= htmlspecialchars($item['title']) ?></h3>
            <?php if (!empty($item['description'])): ?>
              <p><?= htmlspecialchars($item['description']) ?></p>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    <?php endif; ?>

  </div>
</section>

<!-- LIGHTBOX -->
<div class="lightbox" id="lightbox" onclick="handleLightboxClick(event)">
  <div class="lightbox-inner" id="lightboxInner">
    <button class="lightbox-close" onclick="closeLightbox()">✕</button>
    <img class="lightbox-img" id="lightboxImg" src="" alt="" />
    <div class="lightbox-caption">
      <h3 id="lightboxTitle"></h3>
      <p  id="lightboxDesc"></p>
    </div>
  </div>
</div>

<!-- CTA -->
<section class="portfolio-cta reveal">
  <h2 class="portfolio-cta-title">Like what you see?<br><em>It might be for sale.</em></h2>
  <p class="portfolio-cta-sub">Visit the shop for available pieces, or request something custom.</p>
  <div class="portfolio-cta-btns">
    <a href="shop.php" class="btn-ochre">
      Visit the Shop
      <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </a>
    <a href="commissions.php" class="btn-ghost-light">
      Request a Commission
      <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M2 6h8M7 3l3 3-3 3" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </a>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
<script src="script.js"></script>
<script>
  // ── Category filter ──
  var filterBtns = document.querySelectorAll('.filter-btn');
  var items      = document.querySelectorAll('.portfolio-item');

  filterBtns.forEach(function(btn) {
    btn.addEventListener('click', function() {
      filterBtns.forEach(function(b) { b.classList.remove('active'); });
      btn.classList.add('active');
      var f = btn.dataset.filter;
      items.forEach(function(item) {
        item.style.display = (f === 'all' || item.dataset.category === f) ? '' : 'none';
      });
    });
  });

  // ── Lightbox ──
  function openLightbox(el) {
    document.getElementById('lightboxImg').src         = el.dataset.image;
    document.getElementById('lightboxImg').alt         = el.dataset.title;
    document.getElementById('lightboxTitle').textContent = el.dataset.title;
    document.getElementById('lightboxDesc').textContent  = el.dataset.desc;
    document.getElementById('lightbox').classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeLightbox() {
    document.getElementById('lightbox').classList.remove('open');
    document.getElementById('lightboxImg').src = ''; // free memory
    document.body.style.overflow = '';
  }

  function handleLightboxClick(e) {
    if (e.target === document.getElementById('lightbox')) closeLightbox();
  }

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeLightbox();
  });
</script>
</body>
</html>