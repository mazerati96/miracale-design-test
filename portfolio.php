<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Portfolio — Miracale Design</title>
  <meta name="description" content="Browse the portfolio of Miracale Design — a showcase of past and current handmade art from Virginia." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Nunito:wght@300;400;500;600&family=Dancing+Script:wght@500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />
  <style>
    .page-hero {
      padding: 10rem 3rem 5rem;
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
      width: 32px; height: 1.5px;
      background: var(--terra); opacity: 0.5;
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

    /* ── FILTER TABS ── */
    .filter-bar {
      display: flex;
      justify-content: center;
      gap: 0.6rem;
      padding: 0 3rem 3rem;
      flex-wrap: wrap;
    }
    .filter-btn {
      padding: 0.5rem 1.3rem;
      border-radius: 99px;
      border: 1.5px solid rgba(28,26,23,0.12);
      background: transparent;
      font-family: 'Nunito', sans-serif;
      font-size: 0.8rem;
      font-weight: 600;
      letter-spacing: 0.06em;
      color: var(--ink-soft);
      cursor: pointer;
      transition: all 0.2s;
    }
    .filter-btn:hover { border-color: var(--terra); color: var(--terra); }
    .filter-btn.active {
      background: var(--green);
      border-color: var(--green);
      color: var(--white);
    }

    /* ── MASONRY GRID ── */
    .portfolio-section { padding: 0 3rem 6rem; }
    .portfolio-grid {
      columns: 3;
      column-gap: 1.2rem;
    }
    .portfolio-item {
      break-inside: avoid;
      margin-bottom: 1.2rem;
      border-radius: 14px;
      overflow: hidden;
      cursor: pointer;
      position: relative;
      background: var(--parchment);
      box-shadow: 0 4px 20px rgba(28,26,23,0.07);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .portfolio-item:hover {
      transform: translateY(-4px);
      box-shadow: 0 14px 40px rgba(28,26,23,0.14);
    }
    /* Placeholder artwork frames */
    .portfolio-placeholder {
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      background: linear-gradient(135deg, var(--parchment), #e8d5b5);
    }
    .portfolio-placeholder.tall   { aspect-ratio: 3/4; }
    .portfolio-placeholder.square { aspect-ratio: 1/1; }
    .portfolio-placeholder.wide   { aspect-ratio: 4/3; }
    .portfolio-placeholder img {
      width: 100%; height: 100%;
      object-fit: cover; display: block;
    }
    .portfolio-placeholder-icon  { font-size: 3rem; }
    .portfolio-placeholder-label {
      font-family: 'Dancing Script', cursive;
      font-size: 1rem; color: var(--ink-soft);
    }
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
      transition: opacity 0.3s;
      padding: 2rem;
    }
    .lightbox.open { opacity: 1; pointer-events: all; }
    .lightbox-inner {
      position: relative;
      max-width: 800px; width: 100%;
      max-height: 90vh;
    }
    .lightbox-img {
      width: 100%; max-height: 80vh;
      object-fit: contain;
      border-radius: 12px;
      display: block;
    }
    .lightbox-placeholder {
      width: 100%; aspect-ratio: 4/3;
      background: var(--parchment);
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      flex-direction: column; gap: 0.8rem;
      font-size: 5rem;
    }
    .lightbox-caption {
      margin-top: 1rem; text-align: center;
    }
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
      border: none; border-radius: 50%;
      font-size: 1rem; cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      transition: background 0.2s;
    }
    .lightbox-close:hover { background: var(--ink); }

    /* ── CTA ── */
    .portfolio-cta {
      background: var(--green); padding: 5rem 3rem;
      text-align: center; position: relative; overflow: hidden;
    }
    .portfolio-cta::before {
      content: '';
      position: absolute; width: 400px; height: 400px; border-radius: 50%;
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
    .portfolio-cta-btns {
      display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;
    }
    .btn-ochre {
      display: inline-flex; align-items: center; gap: 0.5rem;
      background: var(--ochre); color: var(--ink);
      padding: 0.85rem 2rem; border-radius: 40px;
      font-family: 'Nunito', sans-serif; font-size: 0.85rem;
      font-weight: 600; letter-spacing: 0.06em; text-decoration: none;
      transition: background 0.25s, transform 0.2s;
      box-shadow: 0 4px 20px rgba(212,168,67,0.3);
    }
    .btn-ochre:hover { background: #c49a38; transform: translateY(-2px); }
    .btn-ghost-light {
      display: inline-flex; align-items: center; gap: 0.4rem;
      color: rgba(255,253,248,0.8);
      font-family: 'Nunito', sans-serif; font-size: 0.85rem;
      font-weight: 600; letter-spacing: 0.04em; text-decoration: none;
      border-bottom: 1.5px solid rgba(255,253,248,0.3);
      padding-bottom: 2px; transition: color 0.2s, border-color 0.2s;
    }
    .btn-ghost-light:hover { color: var(--white); border-color: var(--white); }

    @media (max-width: 900px) {
      .page-hero { padding: 8rem 1.5rem 3rem; }
      .filter-bar { padding: 0 1.5rem 2rem; }
      .portfolio-section { padding: 0 1.5rem 4rem; }
      .portfolio-grid { columns: 2; }
      .portfolio-cta { padding: 4rem 1.5rem; }
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

<!-- FILTER BAR -->
<div class="filter-bar">
  <button class="filter-btn active" data-filter="all">All Work</button>
  <button class="filter-btn" data-filter="clay">Clay Animals</button>
  <button class="filter-btn" data-filter="watercolor">Watercolors</button>
  <button class="filter-btn" data-filter="wood">Wood Art</button>
  <button class="filter-btn" data-filter="keychain">Keychains</button>
</div>

<!-- PORTFOLIO GRID -->
<section class="portfolio-section">
  <div class="portfolio-grid" id="portfolioGrid">

    <!-- Each item: add data-category and replace placeholder with <img> when photos are ready -->

    <div class="portfolio-item" data-category="clay"
         data-title="Clay Fox" data-desc="Hand-sculpted polymer clay · 2024"
         onclick="openLightbox(this)">
      <div class="portfolio-placeholder tall">
        <div class="portfolio-placeholder-icon">🦊</div>
        <div class="portfolio-placeholder-label">Clay Fox</div>
      </div>
      <div class="portfolio-overlay">
        <div class="portfolio-overlay-text">
          <h3>Clay Fox</h3><p>Hand-sculpted clay</p>
        </div>
      </div>
    </div>

    <div class="portfolio-item" data-category="watercolor"
         data-title="Blue Mountains" data-desc="Watercolor on paper · 2024"
         onclick="openLightbox(this)">
      <div class="portfolio-placeholder wide">
        <div class="portfolio-placeholder-icon">🏔️</div>
        <div class="portfolio-placeholder-label">Blue Mountains</div>
      </div>
      <div class="portfolio-overlay">
        <div class="portfolio-overlay-text">
          <h3>Blue Mountains</h3><p>Watercolor painting</p>
        </div>
      </div>
    </div>

    <div class="portfolio-item" data-category="keychain"
         data-title="Mushroom Keychain" data-desc="Hand-painted clay keychain · 2024"
         onclick="openLightbox(this)">
      <div class="portfolio-placeholder square">
        <div class="portfolio-placeholder-icon">🍄</div>
        <div class="portfolio-placeholder-label">Mushroom Keychain</div>
      </div>
      <div class="portfolio-overlay">
        <div class="portfolio-overlay-text">
          <h3>Mushroom Keychain</h3><p>Clay keychain</p>
        </div>
      </div>
    </div>

    <div class="portfolio-item" data-category="wood"
         data-title="Oak Slice Art" data-desc="Pyrography on natural oak · 2024"
         onclick="openLightbox(this)">
      <div class="portfolio-placeholder tall">
        <div class="portfolio-placeholder-icon">🪵</div>
        <div class="portfolio-placeholder-label">Oak Slice Art</div>
      </div>
      <div class="portfolio-overlay">
        <div class="portfolio-overlay-text">
          <h3>Oak Slice Art</h3><p>Wood burning</p>
        </div>
      </div>
    </div>

    <div class="portfolio-item" data-category="clay"
         data-title="Mini Axolotl" data-desc="Polymer clay sculpture · 2024"
         onclick="openLightbox(this)">
      <div class="portfolio-placeholder square">
        <div class="portfolio-placeholder-icon">🦎</div>
        <div class="portfolio-placeholder-label">Mini Axolotl</div>
      </div>
      <div class="portfolio-overlay">
        <div class="portfolio-overlay-text">
          <h3>Mini Axolotl</h3><p>Polymer clay</p>
        </div>
      </div>
    </div>

    <div class="portfolio-item" data-category="watercolor"
         data-title="Sunset Pines" data-desc="Watercolor on paper · 2023"
         onclick="openLightbox(this)">
      <div class="portfolio-placeholder tall">
        <div class="portfolio-placeholder-icon">🌲</div>
        <div class="portfolio-placeholder-label">Sunset Pines</div>
      </div>
      <div class="portfolio-overlay">
        <div class="portfolio-overlay-text">
          <h3>Sunset Pines</h3><p>Watercolor painting</p>
        </div>
      </div>
    </div>

    <div class="portfolio-item" data-category="keychain"
         data-title="Star Keychain" data-desc="Resin &amp; clay keychain · 2024"
         onclick="openLightbox(this)">
      <div class="portfolio-placeholder wide">
        <div class="portfolio-placeholder-icon">⭐</div>
        <div class="portfolio-placeholder-label">Star Keychain</div>
      </div>
      <div class="portfolio-overlay">
        <div class="portfolio-overlay-text">
          <h3>Star Keychain</h3><p>Resin &amp; clay</p>
        </div>
      </div>
    </div>

    <div class="portfolio-item" data-category="wood"
         data-title="Carved Bear" data-desc="Hand-carved pine · 2023"
         onclick="openLightbox(this)">
      <div class="portfolio-placeholder square">
        <div class="portfolio-placeholder-icon">🐻</div>
        <div class="portfolio-placeholder-label">Carved Bear</div>
      </div>
      <div class="portfolio-overlay">
        <div class="portfolio-overlay-text">
          <h3>Carved Bear</h3><p>Pine carving</p>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- LIGHTBOX -->
<div class="lightbox" id="lightbox" onclick="closeLightbox(event)">
  <div class="lightbox-inner" id="lightboxInner">
    <button class="lightbox-close" onclick="closeLightbox()">✕</button>
    <div class="lightbox-placeholder" id="lightboxPlaceholder"></div>
    <div class="lightbox-caption">
      <h3 id="lightboxTitle"></h3>
      <p id="lightboxDesc"></p>
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
  const filterBtns = document.querySelectorAll('.filter-btn');
  const items      = document.querySelectorAll('.portfolio-item');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const f = btn.dataset.filter;
      items.forEach(item => {
        item.style.display = (f === 'all' || item.dataset.category === f) ? '' : 'none';
      });
    });
  });

  // ── Lightbox ──
  function openLightbox(el) {
    const title = el.dataset.title;
    const desc  = el.dataset.desc;
    const icon  = el.querySelector('.portfolio-placeholder-icon');

    document.getElementById('lightboxTitle').textContent = title;
    document.getElementById('lightboxDesc').textContent  = desc;
    document.getElementById('lightboxPlaceholder').innerHTML =
      `<span style="font-size:6rem">${icon ? icon.textContent : '🎨'}</span>`;

    document.getElementById('lightbox').classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeLightbox(e) {
    if (e && e.target !== document.getElementById('lightbox') &&
        !e.target.classList.contains('lightbox-close')) return;
    document.getElementById('lightbox').classList.remove('open');
    document.body.style.overflow = '';
  }

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeLightbox({ target: document.getElementById('lightbox') });
  });
</script>
</body>
</html>