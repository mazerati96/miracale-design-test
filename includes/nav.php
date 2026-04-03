<?php
// Determine current page for active nav state
$current = basename($_SERVER['PHP_SELF'], '.php');
?>
<nav id="nav">
  <a href="index.php" class="nav-logo">Miracale Design</a>
  <ul class="nav-links">
    <li><a href="index.php"    class="<?= $current === 'index'   ? 'active' : '' ?>">Home</a></li>
    <li><a href="shop.php"     class="<?= $current === 'shop'    ? 'active' : '' ?>">Shop</a></li>
    <li><a href="about.php"    class="<?= $current === 'about'   ? 'active' : '' ?>">About</a></li>
    <li><a href="reviews.php"  class="<?= $current === 'reviews' ? 'active' : '' ?>">Reviews</a></li>
    <li><a href="contact.php"  class="<?= $current === 'contact' ? 'active' : '' ?>">Contact</a></li>
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