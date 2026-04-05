<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reviews — Miracale Design</title>
  <meta name="description" content="See what customers are saying about Miracale Design's handmade art from Virginia." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Nunito:wght@300;400;500;600&family=Dancing+Script:wght@500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />
  <style>
    /* ── PAGE HERO ── */
    .page-hero {
      padding: 10rem 3rem 5rem;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    .page-hero-blob {
      position: absolute;
      border-radius: 50%;
      filter: blur(90px);
      pointer-events: none;
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
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.22em;
      text-transform: uppercase;
      color: var(--terra);
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.7rem;
    }
    .page-hero-eyebrow::before,
    .page-hero-eyebrow::after {
      content: '';
      display: inline-block;
      width: 32px; height: 1.5px;
      background: var(--terra);
      opacity: 0.5;
    }
    .page-hero-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(3rem, 5vw, 5rem);
      font-weight: 300;
      color: var(--ink);
      line-height: 1.1;
      margin-bottom: 1rem;
    }
    .page-hero-title em {
      font-style: italic;
      color: var(--green);
    }
    .page-hero-sub {
      font-size: 1rem;
      color: var(--ink-soft);
      max-width: 480px;
      margin: 0 auto;
      line-height: 1.7;
    }

    /* ── RATING SUMMARY ── */
    .rating-summary {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 3rem;
      padding: 3rem;
      margin: 0 3rem 1rem;
      background: var(--parchment);
      border-radius: 20px;
      flex-wrap: wrap;
    }
    .rating-big {
      text-align: center;
    }
    .rating-big-number {
      font-family: 'Cormorant Garamond', serif;
      font-size: 5rem;
      font-weight: 300;
      color: var(--ink);
      line-height: 1;
    }
    .rating-big-stars {
      color: var(--ochre);
      font-size: 1.3rem;
      letter-spacing: 3px;
      margin: 0.3rem 0;
    }
    .rating-big-label {
      font-size: 0.78rem;
      color: var(--ink-soft);
      letter-spacing: 0.08em;
    }
    .rating-divider {
      width: 1px;
      height: 80px;
      background: rgba(28,26,23,0.12);
    }
    .rating-bars {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
      min-width: 220px;
    }
    .rating-bar-row {
      display: flex;
      align-items: center;
      gap: 0.7rem;
    }
    .rating-bar-label {
      font-size: 0.78rem;
      color: var(--ink-soft);
      width: 36px;
      text-align: right;
      flex-shrink: 0;
    }
    .rating-bar-track {
      flex: 1;
      height: 6px;
      background: rgba(28,26,23,0.1);
      border-radius: 99px;
      overflow: hidden;
    }
    .rating-bar-fill {
      height: 100%;
      background: var(--ochre);
      border-radius: 99px;
      transition: width 1s ease;
    }
    .rating-bar-count {
      font-size: 0.75rem;
      color: var(--ink-soft);
      width: 16px;
    }

    /* ── REVIEWS GRID ── */
    .reviews-section {
      padding: 4rem 3rem 5rem;
    }
    .reviews-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.4rem;
      margin-bottom: 3rem;
    }
    .review-card {
      background: var(--white);
      border: 1px solid rgba(28,26,23,0.07);
      border-radius: 18px;
      padding: 2rem;
      display: flex;
      flex-direction: column;
      gap: 1rem;
      box-shadow: 0 3px 16px rgba(28,26,23,0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    .review-card::before {
      content: '"';
      font-family: 'Cormorant Garamond', serif;
      font-size: 7rem;
      font-weight: 300;
      color: var(--parchment);
      position: absolute;
      top: -1rem; right: 1.2rem;
      line-height: 1;
      pointer-events: none;
    }
    .review-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 36px rgba(28,26,23,0.1);
    }
    .review-card.featured {
      background: var(--green);
      border-color: transparent;
    }
    .review-card.featured::before { color: rgba(255,253,248,0.08); }
    .review-stars {
      color: var(--ochre);
      font-size: 0.85rem;
      letter-spacing: 2px;
    }
    .review-card.featured .review-stars { color: var(--ochre); }
    .review-text {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.15rem;
      font-style: italic;
      line-height: 1.6;
      color: var(--ink);
      position: relative;
      z-index: 1;
      flex: 1;
    }
    .review-card.featured .review-text { color: rgba(255,253,248,0.9); }
    .review-meta {
      display: flex;
      align-items: center;
      gap: 0.7rem;
      margin-top: auto;
    }
    .review-avatar {
      width: 38px; height: 38px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--blush), var(--parchment));
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      flex-shrink: 0;
    }
    .review-card.featured .review-avatar {
      background: rgba(255,253,248,0.15);
    }
    .review-author {
      font-size: 0.85rem;
      font-weight: 600;
      color: var(--ink);
    }
    .review-card.featured .review-author { color: var(--white); }
    .review-product {
      font-size: 0.75rem;
      color: var(--ink-soft);
      margin-top: 0.1rem;
    }
    .review-card.featured .review-product { color: rgba(255,253,248,0.55); }

    /* ── SUBMIT FORM ── */
    .submit-section {
      background: linear-gradient(135deg, var(--parchment), #F0DFC0);
      margin: 0 3rem 5rem;
      border-radius: 24px;
      padding: 4rem;
      position: relative;
      overflow: hidden;
    }
    .submit-section::after {
      content: '✦';
      position: absolute;
      right: -10px; bottom: -30px;
      font-size: 14rem;
      color: rgba(201,104,58,0.06);
      line-height: 1;
      pointer-events: none;
    }
    .submit-inner {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 4rem;
      align-items: start;
    }
    .submit-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(1.8rem, 2.8vw, 2.6rem);
      font-weight: 400;
      line-height: 1.2;
      color: var(--ink);
      margin-bottom: 0.7rem;
    }
    .submit-title em { font-style: italic; color: var(--terra); }
    .submit-sub {
      font-size: 0.92rem;
      color: var(--ink-soft);
      line-height: 1.7;
    }

    /* Form */
    .review-form { display: flex; flex-direction: column; gap: 1.1rem; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .form-group { display: flex; flex-direction: column; gap: 0.4rem; }
    .form-label {
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--ink-soft);
    }
    .form-input,
    .form-textarea {
      background: var(--white);
      border: 1.5px solid rgba(28,26,23,0.12);
      border-radius: 10px;
      padding: 0.75rem 1rem;
      font-family: 'Nunito', sans-serif;
      font-size: 0.9rem;
      color: var(--ink);
      transition: border-color 0.2s, box-shadow 0.2s;
      outline: none;
      width: 100%;
    }
    .form-input:focus,
    .form-textarea:focus {
      border-color: var(--green);
      box-shadow: 0 0 0 3px rgba(45,74,62,0.1);
    }
    .form-textarea { resize: vertical; min-height: 110px; }

    /* Star picker */
    .star-picker { display: flex; flex-direction: column; gap: 0.5rem; }
    .star-picker-row {
      display: flex;
      gap: 0.4rem;
    }
    .star-btn {
      font-size: 1.6rem;
      cursor: pointer;
      background: none;
      border: none;
      color: rgba(28,26,23,0.2);
      transition: color 0.15s, transform 0.15s;
      padding: 0;
      line-height: 1;
    }
    .star-btn:hover,
    .star-btn.active { color: var(--ochre); }
    .star-btn:hover { transform: scale(1.15); }
    #starInput { display: none; }

    /* Submit btn & feedback */
    .form-submit {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      background: var(--green);
      color: var(--white);
      padding: 0.9rem 2rem;
      border-radius: 40px;
      font-family: 'Nunito', sans-serif;
      font-size: 0.88rem;
      font-weight: 600;
      letter-spacing: 0.06em;
      border: none;
      cursor: pointer;
      transition: background 0.25s, transform 0.2s, box-shadow 0.25s;
      box-shadow: 0 4px 20px rgba(45,74,62,0.25);
      align-self: flex-start;
    }
    .form-submit:hover {
      background: var(--green-light);
      transform: translateY(-2px);
      box-shadow: 0 8px 28px rgba(45,74,62,0.3);
    }
    .form-submit:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
    }
    .form-feedback {
      padding: 0.8rem 1.1rem;
      border-radius: 10px;
      font-size: 0.88rem;
      display: none;
    }
    .form-feedback.success {
      background: rgba(45,74,62,0.1);
      color: var(--green);
      border: 1px solid rgba(45,74,62,0.2);
      display: block;
    }
    .form-feedback.error {
      background: rgba(201,104,58,0.1);
      color: var(--terra);
      border: 1px solid rgba(201,104,58,0.2);
      display: block;
    }

    /* Mobile nav drawer styles */
    .nav-hamburger {
      display: none;
      flex-direction: column;
      gap: 5px;
      background: none;
      border: none;
      cursor: pointer;
      padding: 4px;
    }
    .nav-hamburger span {
      display: block;
      width: 24px; height: 2px;
      background: var(--ink);
      border-radius: 2px;
      transition: all 0.3s;
    }
    .nav-drawer {
      position: fixed;
      top: 0; right: -100%;
      width: min(320px, 85vw);
      height: 100vh;
      background: var(--white);
      z-index: 200;
      padding: 3rem 2rem;
      transition: right 0.35s ease;
      box-shadow: -8px 0 40px rgba(28,26,23,0.12);
    }
    .nav-drawer.open { right: 0; }
    .nav-drawer-close {
      position: absolute;
      top: 1.5rem; right: 1.5rem;
      background: none; border: none;
      font-size: 1.2rem;
      cursor: pointer;
      color: var(--ink-soft);
    }
    .nav-drawer-links {
      list-style: none;
      margin-top: 2rem;
      display: flex;
      flex-direction: column;
      gap: 0.2rem;
    }
    .nav-drawer-links a {
      display: block;
      padding: 0.9rem 0;
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.6rem;
      font-weight: 400;
      color: var(--ink);
      text-decoration: none;
      border-bottom: 1px solid rgba(28,26,23,0.07);
      transition: color 0.2s;
    }
    .nav-drawer-links a:hover { color: var(--terra); }
    .nav-overlay {
      position: fixed;
      inset: 0;
      background: rgba(28,26,23,0.35);
      z-index: 190;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.35s;
    }
    .nav-overlay.open { opacity: 1; pointer-events: all; }

    /* Active nav link */
    .nav-links a.active { color: var(--terra); }
    .nav-links a.active::after { width: 100%; }

    /* ── RESPONSIVE ── */
    @media (max-width: 900px) {
      .nav-hamburger { display: flex; }
      .nav-links { display: none; }
      .page-hero { padding: 8rem 1.5rem 3rem; }
      .rating-summary { margin: 0 1.5rem 1rem; gap: 1.5rem; }
      .rating-divider { display: none; }
      .reviews-section { padding: 3rem 1.5rem 4rem; }
      .reviews-grid { grid-template-columns: 1fr; }
      .submit-section { margin: 0 1.5rem 4rem; padding: 2.5rem 1.8rem; }
      .submit-inner { grid-template-columns: 1fr; gap: 2rem; }
      .form-row { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<!-- PAGE HERO -->
<section class="page-hero">
  <div class="page-hero-blob page-hero-blob-1"></div>
  <div class="page-hero-blob page-hero-blob-2"></div>
  <div class="page-hero-eyebrow">Customer Love</div>
  <h1 class="page-hero-title">What people are<br><em>saying</em></h1>
  <p class="page-hero-sub">
    Every kind word means the world. Here's what customers across Virginia
    and beyond have shared about their Miracale Design pieces.
  </p>
</section>

<!-- RATING SUMMARY -->
<div class="rating-summary reveal">
  <div class="rating-big">
    <div class="rating-big-number">5.0</div>
    <div class="rating-big-stars">★★★★★</div>
    <div class="rating-big-label">Average Rating</div>
  </div>
  <div class="rating-divider"></div>
  <div class="rating-bars">
    <div class="rating-bar-row">
      <span class="rating-bar-label">5 ★</span>
      <div class="rating-bar-track"><div class="rating-bar-fill" style="width:100%"></div></div>
      <span class="rating-bar-count">2</span>
    </div>
    <div class="rating-bar-row">
      <span class="rating-bar-label">4 ★</span>
      <div class="rating-bar-track"><div class="rating-bar-fill" style="width:0%"></div></div>
      <span class="rating-bar-count">0</span>
    </div>
    <div class="rating-bar-row">
      <span class="rating-bar-label">3 ★</span>
      <div class="rating-bar-track"><div class="rating-bar-fill" style="width:0%"></div></div>
      <span class="rating-bar-count">0</span>
    </div>
    <div class="rating-bar-row">
      <span class="rating-bar-label">2 ★</span>
      <div class="rating-bar-track"><div class="rating-bar-fill" style="width:0%"></div></div>
      <span class="rating-bar-count">0</span>
    </div>
    <div class="rating-bar-row">
      <span class="rating-bar-label">1 ★</span>
      <div class="rating-bar-track"><div class="rating-bar-fill" style="width:0%"></div></div>
      <span class="rating-bar-count">0</span>
    </div>
  </div>
  <div class="rating-divider"></div>
  <div class="rating-big">
    <div class="rating-big-number">2</div>
    <div class="rating-big-stars" style="font-size:1rem; letter-spacing:1px">verified reviews</div>
    <div class="rating-big-label">and growing</div>
  </div>
</div>

<!-- REVIEWS GRID -->
<section class="reviews-section reveal">
  <div class="reviews-grid">

    <!-- Featured review -->
    <div class="review-card featured">
      <div class="review-stars">★★★★★</div>
      <p class="review-text">
        "Super cute and looks AMAZING! Couldn't be happier with my purchase —
        the detail is incredible for something handmade."
      </p>
      <div class="review-meta">
        <div class="review-avatar">🌟</div>
        <div>
          <div class="review-author">Kameron H.</div>
          <div class="review-product">Verified Purchase</div>
        </div>
      </div>
    </div>

    <!-- Review 2 -->
    <div class="review-card">
      <div class="review-stars">★★★★★</div>
      <p class="review-text">
        "Miracale Design's handmade art is simply stunning! Each piece reflects
        true craftsmanship and creativity. I love supporting this small business
        from Virginia."
      </p>
      <div class="review-meta">
        <div class="review-avatar">🌸</div>
        <div>
          <div class="review-author">Emily R.</div>
          <div class="review-product">Verified Purchase</div>
        </div>
      </div>
    </div>

    <!-- Placeholder — encourage more reviews -->
    <div class="review-card" style="background: var(--parchment); border: 1.5px dashed rgba(28,26,23,0.15); box-shadow:none; align-items:center; justify-content:center; text-align:center; gap:0.6rem;">
      <div style="font-size:2.5rem">✍️</div>
      <div style="font-family:'Dancing Script',cursive; font-size:1.2rem; color:var(--ink-soft);">Be the next to share</div>
      <div style="font-size:0.82rem; color:var(--ink-soft); line-height:1.5;">Loved your piece? Leave a review below and help others discover Miracale Design.</div>
    </div>

  </div>
</section>

<!-- SUBMIT A REVIEW -->
<div class="submit-section reveal">
  <div class="submit-inner">
    <div>
      <h2 class="submit-title">Share your<br><em>experience</em></h2>
      <p class="submit-sub">
        Ordered something from Miracale Design? We'd love to hear about it.
        Your review helps other art lovers find their perfect piece —
        and it means the world to a small, handmade business.
      </p>
    </div>

    <form class="review-form" id="reviewForm" novalidate>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="reviewName">Your Name *</label>
          <input class="form-input" type="text" id="reviewName" name="name" placeholder="e.g. Jamie S." required />
        </div>
        <div class="form-group">
          <label class="form-label" for="reviewProduct">Product (optional)</label>
          <input class="form-input" type="text" id="reviewProduct" name="product" placeholder="e.g. Clay Cat" />
        </div>
      </div>

      <div class="form-group star-picker">
        <label class="form-label">Your Rating *</label>
        <div class="star-picker-row" id="starPicker">
          <button type="button" class="star-btn" data-val="1">★</button>
          <button type="button" class="star-btn" data-val="2">★</button>
          <button type="button" class="star-btn" data-val="3">★</button>
          <button type="button" class="star-btn" data-val="4">★</button>
          <button type="button" class="star-btn" data-val="5">★</button>
        </div>
        <input type="hidden" id="starInput" name="stars" value="0" />
      </div>

      <div class="form-group">
        <label class="form-label" for="reviewText">Your Review *</label>
        <textarea class="form-textarea" id="reviewText" name="review" placeholder="What did you love about your piece?" required></textarea>
      </div>

      <div class="form-feedback" id="formFeedback"></div>

      <button type="submit" class="form-submit" id="submitBtn">
        Submit Review
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
    </form>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="script.js"></script>
<script>
  // ── Star picker ──
  const starBtns = document.querySelectorAll('.star-btn');
  const starInput = document.getElementById('starInput');

  starBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const val = parseInt(btn.dataset.val);
      starInput.value = val;
      starBtns.forEach(b => {
        b.classList.toggle('active', parseInt(b.dataset.val) <= val);
      });
    });
    btn.addEventListener('mouseenter', () => {
      const val = parseInt(btn.dataset.val);
      starBtns.forEach(b => {
        b.style.color = parseInt(b.dataset.val) <= val
          ? 'var(--ochre)'
          : 'rgba(28,26,23,0.2)';
      });
    });
    btn.addEventListener('mouseleave', () => {
      const selected = parseInt(starInput.value);
      starBtns.forEach(b => {
        b.style.color = parseInt(b.dataset.val) <= selected
          ? 'var(--ochre)'
          : 'rgba(28,26,23,0.2)';
      });
    });
  });

  // ── Review form submit ──
  const form      = document.getElementById('reviewForm');
  const feedback  = document.getElementById('formFeedback');
  const submitBtn = document.getElementById('submitBtn');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    feedback.className = 'form-feedback';
    feedback.textContent = '';

    const stars = parseInt(starInput.value);
    if (!stars) {
      feedback.className = 'form-feedback error';
      feedback.textContent = 'Please select a star rating.';
      return;
    }

    submitBtn.disabled = true;
    submitBtn.textContent = 'Submitting…';

    try {
      const res  = await fetch('review-handler.php', {
        method: 'POST',
        body: new FormData(form),
      });
      const data = await res.json();

      feedback.className = `form-feedback ${data.success ? 'success' : 'error'}`;
      feedback.textContent = data.message;

      if (data.success) {
        form.reset();
        starInput.value = 0;
        starBtns.forEach(b => { b.classList.remove('active'); b.style.color = ''; });
      }
    } catch {
      feedback.className = 'form-feedback error';
      feedback.textContent = 'Something went wrong. Please try again.';
    } finally {
      submitBtn.disabled = false;
      submitBtn.textContent = 'Submit Review';
    }
  });
</script>
</body>
</html>