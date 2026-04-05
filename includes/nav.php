<?php $current = basename($_SERVER['PHP_SELF'], '.php'); ?>

<style>
  /* ── NAV CORE ── */
  nav {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 100;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2.5rem;
    transition: background 0.4s, backdrop-filter 0.4s, box-shadow 0.4s;
  }
  nav.scrolled {
    background: rgba(253,246,236,0.94);
    backdrop-filter: blur(14px);
    box-shadow: 0 2px 24px rgba(44,37,27,0.07);
  }
  .nav-logo {
    font-family: 'Dancing Script', cursive;
    font-size: 1.5rem;
    color: var(--green, #2D4A3E);
    text-decoration: none;
    letter-spacing: 0.01em;
    flex-shrink: 0;
  }

  /* ── DESKTOP LINKS ── */
  .nav-links {
    display: flex;
    gap: 1.6rem;
    list-style: none;
    align-items: center;
    flex: 1;
    justify-content: center;
  }
  .nav-links a {
    font-family: 'Nunito', sans-serif;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--ink-soft, #4A4540);
    text-decoration: none;
    position: relative;
    transition: color 0.2s;
    white-space: nowrap;
  }
  .nav-links a::after {
    content: '';
    position: absolute;
    bottom: -3px; left: 0;
    width: 0; height: 1.5px;
    background: var(--terra, #C9683A);
    transition: width 0.3s ease;
  }
  .nav-links a:hover { color: var(--terra, #C9683A); }
  .nav-links a:hover::after { width: 100%; }
  .nav-links a.active { color: var(--terra, #C9683A); }
  .nav-links a.active::after { width: 100%; }

  /* ── SOCIAL ICONS (desktop) ── */
  .nav-socials {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    flex-shrink: 0;
  }
  .nav-social-btn {
    width: 32px; height: 32px;
    border-radius: 8px;
    background: rgba(28,26,23,0.05);
    display: flex; align-items: center; justify-content: center;
    text-decoration: none;
    color: var(--ink-soft, #4A4540);
    transition: background 0.2s, color 0.2s;
    font-size: 0.9rem;
  }
  .nav-social-btn:hover {
    background: var(--terra, #C9683A);
    color: white;
  }

  /* ── HAMBURGER ── */
  .nav-hamburger {
    display: none;
    flex-direction: column;
    gap: 5px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 4px;
    z-index: 110;
    margin-left: 1rem;
  }
  .nav-hamburger span {
    display: block;
    width: 24px; height: 2px;
    background: var(--ink, #1C1A17);
    border-radius: 2px;
    transition: all 0.3s;
  }

  /* ── MOBILE DRAWER ── */
  .nav-drawer {
    position: fixed;
    top: 0; right: -100%;
    width: min(320px, 88vw);
    height: 100vh;
    background: var(--white, #FFFDF8);
    z-index: 200;
    display: flex;
    flex-direction: column;
    padding: 2rem 1.8rem 2.5rem;
    transition: right 0.35s ease;
    box-shadow: -8px 0 48px rgba(28,26,23,0.14);
    overflow-y: auto;
  }
  .nav-drawer.open { right: 0; }

  .nav-drawer-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1.2rem;
    border-bottom: 1px solid rgba(28,26,23,0.07);
  }
  .nav-drawer-logo {
    font-family: 'Dancing Script', cursive;
    font-size: 1.4rem;
    color: var(--green, #2D4A3E);
    text-decoration: none;
  }
  .nav-drawer-close {
    background: none; border: none;
    font-size: 1.1rem; cursor: pointer;
    color: var(--ink-soft, #4A4540);
    width: 32px; height: 32px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.2s;
  }
  .nav-drawer-close:hover { background: rgba(28,26,23,0.06); }

  /* Drawer nav links */
  .nav-drawer-links {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 0;
    flex: 1;
  }
  .nav-drawer-links li a {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.85rem 0;
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.5rem;
    font-weight: 400;
    color: var(--ink, #1C1A17);
    text-decoration: none;
    border-bottom: 1px solid rgba(28,26,23,0.06);
    transition: color 0.2s;
  }
  .nav-drawer-links li a:hover,
  .nav-drawer-links li a.active { color: var(--terra, #C9683A); }
  .nav-drawer-links li a .drawer-arrow {
    font-size: 0.9rem;
    opacity: 0.3;
    transition: opacity 0.2s, transform 0.2s;
  }
  .nav-drawer-links li a:hover .drawer-arrow {
    opacity: 0.8;
    transform: translateX(3px);
  }

  /* Drawer social section */
  .nav-drawer-social-title {
    font-size: 0.7rem;
    font-weight: 600;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--ink-soft, #4A4540);
    opacity: 0.5;
    margin: 1.5rem 0 0.8rem;
  }
  .nav-drawer-socials {
    display: flex;
    gap: 0.7rem;
  }
  .nav-drawer-social-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.55rem 1rem;
    background: rgba(28,26,23,0.04);
    border-radius: 10px;
    text-decoration: none;
    font-family: 'Nunito', sans-serif;
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--ink-soft, #4A4540);
    transition: background 0.2s, color 0.2s;
  }
  .nav-drawer-social-btn:hover {
    background: rgba(201,104,58,0.1);
    color: var(--terra, #C9683A);
  }

  /* ── OVERLAY ── */
  .nav-overlay {
    position: fixed; inset: 0;
    background: rgba(28,26,23,0.4);
    z-index: 190;
    opacity: 0; pointer-events: none;
    transition: opacity 0.35s;
  }
  .nav-overlay.open { opacity: 1; pointer-events: all; }

  /* ── RESPONSIVE ── */
  @media (max-width: 1024px) {
    .nav-links { gap: 1.2rem; }
    .nav-links a { font-size: 0.7rem; }
  }
  @media (max-width: 860px) {
    nav { padding: 1rem 1.5rem; }
    .nav-links { display: none; }
    .nav-socials { display: none; }
    .nav-hamburger { display: flex; }
  }
</style>

<nav id="nav">
  <a href="index.php" class="nav-logo">Miracale Design</a>

  <ul class="nav-links">
    <li><a href="index.php"       class="<?= $current === 'index'       ? 'active' : '' ?>">Home</a></li>
    <li><a href="shop.php"        class="<?= $current === 'shop'        ? 'active' : '' ?>">Shop</a></li>
     <li><a href="commissions.php" class="<?= $current === 'commissions' ? 'active' : '' ?>">Commissions</a></li>
    
    <li><a href="blog.php"        class="<?= $current === 'blog'        ? 'active' : '' ?>">Blog</a></li>
   
    <li><a href="about.php"       class="<?= $current === 'about'       ? 'active' : '' ?>">About</a></li>
    <li><a href="portfolio.php"   class="<?= $current === 'portfolio'   ? 'active' : '' ?>">Portfolio</a></li>
    <li><a href="reviews.php"     class="<?= $current === 'reviews'     ? 'active' : '' ?>">Reviews</a></li>
    <li><a href="contact.php"     class="<?= $current === 'contact'     ? 'active' : '' ?>">Contact</a></li>
    <li><a href="login.php"       class="<?= $current === 'login'       ? 'active' : '' ?>">Artist Login</a></li>

  </ul>

  <!-- Social icons — update hrefs with real URLs -->
  <div class="nav-socials">
    <a href="#" class="nav-social-btn" aria-label="Facebook" target="_blank" rel="noopener">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
    </a>
    <a href="#" class="nav-social-btn" aria-label="Instagram" target="_blank" rel="noopener">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="0.5" fill="currentColor" stroke="none"/></svg>
    </a>
    <a href="#" class="nav-social-btn" aria-label="Discord" target="_blank" rel="noopener">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028c.462-.63.874-1.295 1.226-1.994a.076.076 0 0 0-.041-.106 13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.892.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z"/></svg>
    </a>
  </div>

  <button class="nav-hamburger" id="navHamburger" aria-label="Open menu">
    <span></span><span></span><span></span>
  </button>
</nav>

<!-- MOBILE DRAWER -->
<div class="nav-drawer" id="navDrawer">
  <div class="nav-drawer-header">
    <a href="index.php" class="nav-drawer-logo">Miracale Design</a>
    <button class="nav-drawer-close" id="navDrawerClose" aria-label="Close menu">✕</button>
  </div>

  <ul class="nav-drawer-links">
    <li><a href="index.php"       class="<?= $current === 'index'       ? 'active' : '' ?>">Home              <span class="drawer-arrow">→</span></a></li>
    <li><a href="shop.php"        class="<?= $current === 'shop'        ? 'active' : '' ?>">Shop              <span class="drawer-arrow">→</span></a></li>
    <li><a href="portfolio.php"   class="<?= $current === 'portfolio'   ? 'active' : '' ?>">Portfolio         <span class="drawer-arrow">→</span></a></li>
    <li><a href="blog.php"        class="<?= $current === 'blog'        ? 'active' : '' ?>">Blog              <span class="drawer-arrow">→</span></a></li>
    <li><a href="commissions.php" class="<?= $current === 'commissions' ? 'active' : '' ?>">Commissions       <span class="drawer-arrow">→</span></a></li>
    <li><a href="about.php"       class="<?= $current === 'about'       ? 'active' : '' ?>">About             <span class="drawer-arrow">→</span></a></li>
    <li><a href="reviews.php"     class="<?= $current === 'reviews'     ? 'active' : '' ?>">Reviews           <span class="drawer-arrow">→</span></a></li>
    <li><a href="contact.php"     class="<?= $current === 'contact'     ? 'active' : '' ?>">Contact           <span class="drawer-arrow">→</span></a></li>
  </ul>

  <div class="nav-drawer-social-title">Find us online</div>
  <div class="nav-drawer-socials">
    <a href="#" class="nav-drawer-social-btn" target="_blank" rel="noopener">
      📘 Facebook
    </a>
    <a href="#" class="nav-drawer-social-btn" target="_blank" rel="noopener">
      📸 Instagram
    </a>
    <a href="#" class="nav-drawer-social-btn" target="_blank" rel="noopener">
      💬 Discord
    </a>
  </div>
</div>

<div class="nav-overlay" id="navOverlay"></div>