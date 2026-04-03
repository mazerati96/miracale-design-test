<?php $current = basename($_SERVER['PHP_SELF'], '.php'); ?>

<style>
  /* ── NAV DRAWER — critical hiding styles, self-contained ── */
  .nav-hamburger {
    display: none;
    flex-direction: column;
    gap: 5px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 4px;
    z-index: 110;
  }
  .nav-hamburger span {
    display: block;
    width: 24px;
    height: 2px;
    background: var(--ink, #1C1A17);
    border-radius: 2px;
    transition: all 0.3s;
  }
  .nav-drawer {
    position: fixed;
    top: 0;
    right: -100%;          /* hidden offscreen by default */
    width: min(320px, 85vw);
    height: 100vh;
    background: var(--white, #FFFDF8);
    z-index: 200;
    padding: 3rem 2rem;
    transition: right 0.35s ease;
    box-shadow: -8px 0 40px rgba(28,26,23,0.12);
  }
  .nav-drawer.open { right: 0; }
  .nav-drawer-close {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    background: none;
    border: none;
    font-size: 1.2rem;
    cursor: pointer;
    color: var(--ink-soft, #4A4540);
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
    color: var(--ink, #1C1A17);
    text-decoration: none;
    border-bottom: 1px solid rgba(28,26,23,0.07);
    transition: color 0.2s;
  }
  .nav-drawer-links a:hover { color: var(--terra, #C9683A); }
  .nav-overlay {
    position: fixed;
    inset: 0;
    background: rgba(28,26,23,0.35);
    z-index: 190;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.35s;
  }
  .nav-overlay.open {
    opacity: 1;
    pointer-events: all;
  }
  .nav-links a.active { color: var(--terra, #C9683A); }
  .nav-links a.active::after { width: 100%; }
  @media (max-width: 900px) {
    .nav-hamburger { display: flex; }
    .nav-links { display: none; }
  }
</style>

<nav id="nav">
  <a href="index.php" class="nav-logo">Miracale Design</a>
  <ul class="nav-links">
    <li><a href="index.php"   class="<?= $current === 'index'   ? 'active' : '' ?>">Home</a></li>
    <li><a href="shop.php"    class="<?= $current === 'shop'    ? 'active' : '' ?>">Shop</a></li>
    <li><a href="about.php"   class="<?= $current === 'about'   ? 'active' : '' ?>">About</a></li>
    <li><a href="reviews.php" class="<?= $current === 'reviews' ? 'active' : '' ?>">Reviews</a></li>
    <li><a href="contact.php" class="<?= $current === 'contact' ? 'active' : '' ?>">Contact</a></li>
  </ul>
  <button class="nav-hamburger" id="navHamburger" aria-label="Open menu">
    <span></span><span></span><span></span>
  </button>
</nav>

<!-- Mobile drawer -->
<div class="nav-drawer" id="navDrawer">
  <button class="nav-drawer-close" id="navDrawerClose" aria-label="Close menu">✕</button>
  <ul class="nav-drawer-links">
    <li><a href="index.php">Home</a></li>
    <li><a href="shop.php">Shop</a></li>
    <li><a href="about.php">About</a></li>
    <li><a href="reviews.php">Reviews</a></li>
    <li><a href="contact.php">Contact</a></li>
  </ul>
</div>
<div class="nav-overlay" id="navOverlay"></div>