<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About — Miracale Design</title>
  <meta name="description" content="Meet the artist behind Miracale Design — handmade art and crafts made with love in Virginia." />
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
    .page-hero-title em { font-style: italic; color: var(--green); }
    .page-hero-sub {
      font-size: 1rem;
      color: var(--ink-soft);
      max-width: 480px;
      margin: 0 auto;
      line-height: 1.7;
    }

    /* ── STORY SECTION ── */
    .story-section {
      padding: 5rem 3rem;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 5rem;
      align-items: center;
    }
    .story-img-wrap {
      position: relative;
    }
    .story-img-frame {
      width: 100%;
      aspect-ratio: 4/5;
      border-radius: 20px;
      background: linear-gradient(135deg, var(--parchment), #e8d5b5);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      gap: 0.8rem;
      box-shadow: 0 16px 56px rgba(28,26,23,0.12);
      overflow: hidden;
    }
    .story-img-frame img {
      width: 100%; height: 100%;
      object-fit: cover;
      display: block;
    }
    .story-img-placeholder {
      font-size: 5rem;
    }
    .story-img-label {
      font-family: 'Dancing Script', cursive;
      font-size: 1.2rem;
      color: var(--ink-soft);
    }
    /* Floating accent card */
    .story-accent {
      position: absolute;
      bottom: -1.5rem;
      right: -1.5rem;
      background: var(--green);
      color: var(--white);
      border-radius: 16px;
      padding: 1.2rem 1.6rem;
      box-shadow: 0 8px 32px rgba(45,74,62,0.3);
      animation: floatBadge 4s ease-in-out infinite;
    }
    .story-accent-num {
      font-family: 'Cormorant Garamond', serif;
      font-size: 2.4rem;
      font-weight: 300;
      line-height: 1;
      color: var(--ochre);
    }
    .story-accent-label {
      font-size: 0.75rem;
      color: rgba(255,253,248,0.7);
      margin-top: 0.2rem;
      letter-spacing: 0.06em;
    }

    .story-eyebrow {
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: var(--terra);
      margin-bottom: 1rem;
    }
    .story-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(2.4rem, 3.5vw, 3.5rem);
      font-weight: 300;
      line-height: 1.12;
      color: var(--ink);
      margin-bottom: 1.6rem;
    }
    .story-title em { font-style: italic; color: var(--green); }
    .story-body {
      font-size: 0.97rem;
      line-height: 1.85;
      color: var(--ink-soft);
      margin-bottom: 1.2rem;
    }
    .story-sig {
      font-family: 'Dancing Script', cursive;
      font-size: 2rem;
      color: var(--terra);
      margin-top: 1.8rem;
    }

    /* ── VALUES ROW ── */
    .values-section {
      background: var(--parchment);
      padding: 5rem 3rem;
    }
    .values-header {
      text-align: center;
      margin-bottom: 3.5rem;
    }
    .values-eyebrow {
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: var(--terra);
      margin-bottom: 0.7rem;
    }
    .values-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(2rem, 3vw, 2.8rem);
      font-weight: 400;
      color: var(--ink);
    }
    .values-title em { font-style: italic; color: var(--green); }
    .values-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.5rem;
    }
    .value-card {
      background: var(--white);
      border-radius: 18px;
      padding: 2.2rem 1.8rem;
      text-align: center;
      box-shadow: 0 4px 20px rgba(28,26,23,0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .value-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 36px rgba(28,26,23,0.1);
    }
    .value-icon { font-size: 2.8rem; margin-bottom: 1rem; }
    .value-name {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.3rem;
      font-weight: 500;
      color: var(--ink);
      margin-bottom: 0.5rem;
    }
    .value-desc {
      font-size: 0.88rem;
      color: var(--ink-soft);
      line-height: 1.65;
    }

    /* ── CRAFT CATEGORIES ── */
    .crafts-section {
      padding: 5rem 3rem;
      background: var(--green);
      position: relative;
      overflow: hidden;
    }
    .crafts-section::before {
      content: '';
      position: absolute;
      width: 500px; height: 500px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(212,168,67,0.1), transparent 70%);
      top: -100px; right: -100px;
      pointer-events: none;
    }
    .crafts-header {
      text-align: center;
      margin-bottom: 3rem;
    }
    .crafts-eyebrow {
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: var(--ochre);
      margin-bottom: 0.7rem;
    }
    .crafts-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(2rem, 3vw, 2.8rem);
      font-weight: 300;
      color: var(--white);
    }
    .crafts-title em { font-style: italic; color: var(--ochre); }
    .crafts-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.2rem;
    }
    .craft-card {
      background: rgba(255,253,248,0.07);
      border: 1px solid rgba(255,253,248,0.1);
      border-radius: 16px;
      padding: 2rem 1.4rem;
      text-align: center;
      transition: background 0.3s, transform 0.3s;
    }
    .craft-card:hover {
      background: rgba(255,253,248,0.13);
      transform: translateY(-4px);
    }
    .craft-icon { font-size: 2.6rem; margin-bottom: 0.8rem; }
    .craft-name {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.15rem;
      font-weight: 500;
      color: var(--white);
      margin-bottom: 0.4rem;
    }
    .craft-desc {
      font-size: 0.78rem;
      color: rgba(255,253,248,0.55);
      line-height: 1.55;
    }

    /* ── CTA STRIP ── */
    .about-cta {
      padding: 5rem 3rem;
      text-align: center;
    }
    .about-cta-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(2rem, 3.5vw, 3rem);
      font-weight: 400;
      color: var(--ink);
      margin-bottom: 0.8rem;
    }
    .about-cta-title em { font-style: italic; color: var(--terra); }
    .about-cta-sub {
      font-size: 0.95rem;
      color: var(--ink-soft);
      margin-bottom: 2rem;
    }
    .about-cta-btns {
      display: flex;
      gap: 1rem;
      justify-content: center;
      flex-wrap: wrap;
    }

    @media (max-width: 900px) {
      .story-section { grid-template-columns: 1fr; gap: 3rem; padding: 4rem 1.5rem; }
      .story-accent { right: 1rem; }
      .values-section { padding: 4rem 1.5rem; }
      .values-grid { grid-template-columns: 1fr; }
      .crafts-section { padding: 4rem 1.5rem; }
      .crafts-grid { grid-template-columns: repeat(2, 1fr); }
      .page-hero { padding: 8rem 1.5rem 3rem; }
      .about-cta { padding: 4rem 1.5rem; }
    }
  </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<!-- PAGE HERO -->
<section class="page-hero">
  <div class="page-hero-blob page-hero-blob-1"></div>
  <div class="page-hero-blob page-hero-blob-2"></div>
  <div class="page-hero-eyebrow">The Artist</div>
  <h1 class="page-hero-title">Made by hand,<br><em>from the heart</em></h1>
  <p class="page-hero-sub">
    Every piece from Miracale Design carries a little piece of the artist — her
    patience, her creativity, and her genuine love for making things by hand.
  </p>
</section>

<!-- STORY -->
<section class="story-section reveal">
  <div class="story-img-wrap">
    <div class="story-img-frame">
      <!-- Replace with: <img src="images/artist-photo.jpg" alt="The artist behind Miracale Design" /> -->
      <img src="assets/turtle.png" alt="The art behind Miracale Design" />
      <div class="story-img-label">The artist at work</div>
    </div>
    <div class="story-accent">
      <div class="story-accent-num">3+</div>
      <div class="story-accent-label">Years creating</div>
    </div>
  </div>

  <div class="story-text">
    <div class="story-eyebrow">Our Story</div>
    <h2 class="story-title">Art born from<br><em>passion &amp; patience</em></h2>
    <p class="story-body">
      Miracale Design started the way all the best things do — quietly, at a
      kitchen table, with a piece of clay and a lot of curiosity. What began
      as a personal creative outlet grew into something bigger: a small
      handmade business rooted in the hills of Virginia.
    </p>
    <p class="story-body">
      Every item is made entirely by hand — no molds, no mass production, no
      shortcuts. From the first sketch to the final detail, each piece gets
      the time and care it deserves. That's the Miracale Design promise.
    </p>
    <p class="story-body">
      Whether it's a clay animal that makes someone smile, a watercolor that
      captures a moment, or a keychain someone carries every day - the goal
      is always the same: make something worth keeping.
    </p>
    <div class="story-sig">Miracale Design</div>
  </div>
</section>

<!-- VALUES -->
<section class="values-section reveal">
  <div class="values-header">
    <div class="values-eyebrow">What we stand for</div>
    <h2 class="values-title">The <em>heart</em> of every piece</h2>
  </div>
  <div class="values-grid">
    <div class="value-card">
      <div class="value-icon">🤲</div>
      <div class="value-name">Truly Handmade</div>
      <p class="value-desc">
        Every single piece is made by hand, start to finish. No factories,
        no outsourcing — just skill, time, and care.
      </p>
    </div>
    <div class="value-card">
      <div class="value-icon">✨</div>
      <div class="value-name">One of a Kind</div>
      <p class="value-desc">
        Because each piece is handcrafted individually, no two are ever
        exactly the same. You're getting something truly unique.
      </p>
    </div>
    <div class="value-card">
      <div class="value-icon">🌿</div>
      <div class="value-name">Made with Love</div>
      <p class="value-desc">
        Art made without passion is just product. Every Miracale Design
        piece carries a genuine piece of the artist's heart.
      </p>
    </div>
  </div>
</section>

<!-- CRAFTS -->
<section class="crafts-section reveal">
  <div class="crafts-header">
    <div class="crafts-eyebrow">The Collection</div>
    <h2 class="crafts-title">What <em>Miracale</em> makes</h2>
  </div>
  <div class="crafts-grid">
    <div class="craft-card">
      <img src="assets/clay-figures.png" alt="clay art" style="width:100%; height:100%; object-fit:fill; display:block;"/>
     <!-- <div class="craft-name">Clay Animals</div>
      <p class="craft-desc">Hand-sculpted figures, each with their own little personality.</p> -->
    </div>
    <div class="craft-card">
       <img src="assets/watercolors.png" alt="watercolors" style="width:100%; height:100%; object-fit:fill; display:block;"/>
      <!-- <div class="craft-name">Watercolors</div>
      <p class="craft-desc">Original painted pieces — landscapes, portraits, and more.</p> -->
    </div>
    <div class="craft-card">
       <img src="assets/jiji.png" alt="wood art" style="width:100%; height:100%; object-fit:fill; display:block;"/>
      <!-- <div class="craft-name">Wood Art</div>
      <p class="craft-desc">Carved and textured works that bring nature indoors.</p> -->
    </div>
    <div class="craft-card">
       <img src="assets/keychains.png" alt="clay keychains" style="width:100%; height:100%; object-fit:fill; display:block;"/>
      <!-- <div class="craft-name">Keychains</div>
      <p class="craft-desc">Carry a little handmade art with you wherever you go.</p> -->
    </div>
  </div>
</section>

<!-- CTA -->
<section class="about-cta reveal">
  <h2 class="about-cta-title">Ready to find something<br><em>special?</em></h2>
  <p class="about-cta-sub">Browse the shop, request a commission, or just say hello.</p>
  <div class="about-cta-btns">
    <a href="shop.php" class="btn-primary">
      Visit the Shop
      <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </a>
    <a href="commissions.php" class="btn-ghost">
      Request a Commission
      <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M2 6h8M7 3l3 3-3 3" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </a>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
<script src="script.js"></script>
</body>
</html>