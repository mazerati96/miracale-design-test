<?php
$adminPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<nav class="admin-nav">
  <div class="admin-nav-logo">
    <a href="dashboard.php" class="admin-logo-link">Miracale Design</a>
    <span class="admin-logo-sub">Admin Panel</span>
  </div>

  <ul class="admin-nav-links">
    <li>
      <a href="dashboard.php"
         class="admin-nav-link <?= $adminPage === 'dashboard' ? 'active' : '' ?>">
        <span class="nav-icon">🏠</span> Dashboard
      </a>
    </li>
    <li>
      <a href="posts.php"
         class="admin-nav-link <?= $adminPage === 'posts' ? 'active' : '' ?>">
        <span class="nav-icon">✏️</span> Blog Posts
      </a>
    </li>
    <li>
      <a href="portfolio.php"
         class="admin-nav-link <?= $adminPage === 'portfolio' ? 'active' : '' ?>">
        <span class="nav-icon">🖼️</span> Portfolio
      </a>
    </li>
    <li>
      <a href="events.php"
         class="admin-nav-link <?= $adminPage === 'events' ? 'active' : '' ?>">
        <span class="nav-icon">📅</span> Events
      </a>
    </li>
    <li>
      <a href="reviews.php"
         class="admin-nav-link <?= $adminPage === 'reviews' ? 'active' : '' ?>">
        <span class="nav-icon">⭐</span> Reviews
      </a>
    </li>
    <li class="nav-divider"></li>
    <li>
      <a href="../index.php" target="_blank" class="admin-nav-link">
        <span class="nav-icon">🌐</span> View Site
      </a>
    </li>
    <li>
      <a href="../shop.php" target="_blank" class="admin-nav-link">
        <span class="nav-icon">🛍️</span> Shop (Stripe)
      </a>
    </li>
    <li>
      <a href="https://dashboard.stripe.com" target="_blank"
         rel="noopener" class="admin-nav-link">
        <span class="nav-icon">💳</span> Stripe Dashboard
      </a>
    </li>
  </ul>

  <div class="admin-nav-footer">
    <div class="admin-nav-user">
      <div class="admin-nav-user-icon">🎨</div>
      <div>
        <div class="admin-nav-username"><?= htmlspecialchars(ADMIN_USERNAME) ?></div>
        <div class="admin-nav-role">Artist</div>
      </div>
    </div>
    <a href="logout.php" class="admin-logout-btn" title="Log out">⏻</a>
  </div>
</nav>