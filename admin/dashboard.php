<?php
// Force errors to display no matter what server settings say
@ini_set('display_errors', 1);
@ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ── STEP 1: Session check (before requiring auth.php) ─────────────────────
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo '<pre style="font-family:monospace; font-size:13px; padding:1rem; background:#f9f6f2; border-bottom:1px solid #ddd">';
echo '<strong>Miracale Design Admin — Diagnostics</strong>' . "\n\n";

echo '1. PHP Version: ' . phpversion() . "\n";
echo '2. Session ID: ' . session_id() . "\n";
echo '3. Session data: ';
print_r($_SESSION);
echo "\n";

// ── STEP 2: Config file check ─────────────────────────────────────────────
$configPath = dirname(__DIR__) . '/config/admin.php';
echo '4. Config file exists: ' . (file_exists($configPath) ? 'YES ✓' : 'NO ✗ — upload config/admin.php via File Manager') . "\n";

if (file_exists($configPath)) {
    require_once $configPath;
    echo '5. ADMIN_USERNAME defined: ' . (defined('ADMIN_USERNAME') ? 'YES (' . ADMIN_USERNAME . ') ✓' : 'NO ✗') . "\n";
    echo '6. ADMIN_PASSWORD_HASH defined: ' . (defined('ADMIN_PASSWORD_HASH') ? 'YES ✓' : 'NO ✗') . "\n";
}

// ── STEP 3: Session validity ──────────────────────────────────────────────
$loggedIn = (
    isset($_SESSION['admin_logged_in']) &&
    $_SESSION['admin_logged_in'] === true &&
    defined('ADMIN_USERNAME') &&
    isset($_SESSION['admin_user']) &&
    $_SESSION['admin_user'] === ADMIN_USERNAME &&
    isset($_SESSION['admin_expires']) &&
    $_SESSION['admin_expires'] > time()
);
echo '7. Logged in: ' . ($loggedIn ? 'YES ✓' : 'NO ✗') . "\n";
if (isset($_SESSION['admin_expires'])) {
    echo '   Session expires: ' . date('Y-m-d H:i:s', $_SESSION['admin_expires']) . "\n";
    echo '   Current time:    ' . date('Y-m-d H:i:s', time()) . "\n";
}

// ── STEP 4: Data files ────────────────────────────────────────────────────
$postsPath  = dirname(__DIR__) . '/data/posts.json';
$eventsPath = dirname(__DIR__) . '/data/events.json';
echo '8. posts.json exists: '  . (file_exists($postsPath)  ? 'YES ✓' : 'NO ✗ — create data/posts.json with content []') . "\n";
echo '9. events.json exists: ' . (file_exists($eventsPath) ? 'YES ✓' : 'NO ✗ — create data/events.json with content []') . "\n";

// ── STEP 5: Includes ──────────────────────────────────────────────────────
echo '10. admin-nav.php exists: ' . (file_exists(__DIR__ . '/admin-nav.php') ? 'YES ✓' : 'NO ✗') . "\n";
echo '11. admin.css exists: '     . (file_exists(__DIR__ . '/admin.css')     ? 'YES ✓' : 'NO ✗') . "\n";

echo '</pre>';

if (!$loggedIn) {
    echo '<p style="font-family:sans-serif; padding:1rem; color:#C9683A">
        ⚠️ You are NOT logged in. <a href="../login.php">Go to login →</a>
    </p>';
    exit;
}

// ── If everything checks out, show the real dashboard ─────────────────────
echo '<p style="font-family:sans-serif; padding:1rem; color:#2D4A3E; background:#f0f9f5; border:1px solid #c3e6cb; margin:1rem">
    ✅ All checks passed — loading real dashboard below...
</p>';

// Load data
$posts  = array();
$events = array();
if (file_exists($postsPath))  { $d = json_decode(file_get_contents($postsPath),  true); if (is_array($d)) $posts  = $d; }
if (file_exists($eventsPath)) { $d = json_decode(file_get_contents($eventsPath), true); if (is_array($d)) $events = $d; }

$today     = date('Y-m-d');
$published = 0; $drafts = 0;
foreach ($posts as $p) { if (!empty($p['published'])) $published++; else $drafts++; }
$upcoming = 0;
foreach ($events as $e) { if (!empty($e['date']) && $e['date'] >= $today) $upcoming++; }
$recentPosts = array_slice(array_reverse($posts), 0, 5);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard — Miracale Design</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Nunito:wght@300;400;500;600&family=Dancing+Script:wght@500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../styles.css" />
  <link rel="stylesheet" href="admin.css" />
</head>
<body class="admin-body">

<?php include 'admin-nav.php'; ?>

<main class="admin-main">
  <div class="admin-container">

    <div class="admin-page-header">
      <div>
        <h1 class="admin-page-title">
          <?php
            $h = (int)date('H');
            if ($h < 12) echo 'Good morning';
            elseif ($h < 17) echo 'Good afternoon';
            else echo 'Good evening';
          ?>, <?= htmlspecialchars(ADMIN_USERNAME) ?> 🎨
        </h1>
        <p class="admin-page-sub">Here's what's going on with your site.</p>
      </div>
      <a href="../index.php" target="_blank" class="admin-btn admin-btn-ghost">View Site ↗</a>
    </div>

    <div class="stat-grid">
      <div class="stat-card">
        <div class="stat-icon">✏️</div>
        <div class="stat-number"><?= $published ?></div>
        <div class="stat-label">Published Posts</div>
        <a href="posts.php" class="stat-link">Manage →</a>
      </div>
      <div class="stat-card">
        <div class="stat-icon">📝</div>
        <div class="stat-number"><?= $drafts ?></div>
        <div class="stat-label">Drafts</div>
        <a href="posts.php" class="stat-link">Manage →</a>
      </div>
      <div class="stat-card">
        <div class="stat-icon">📅</div>
        <div class="stat-number"><?= $upcoming ?></div>
        <div class="stat-label">Upcoming Events</div>
        <a href="events.php" class="stat-link">Manage →</a>
      </div>
      <div class="stat-card">
        <div class="stat-icon">⭐</div>
        <div class="stat-number">5.0</div>
        <div class="stat-label">Review Rating</div>
        <a href="../reviews.php" target="_blank" class="stat-link">View →</a>
      </div>
    </div>

    <div class="admin-section">
      <h2 class="admin-section-title">Quick Actions</h2>
      <div class="quick-actions">
        <a href="posts.php?action=new" class="quick-action-card">
          <div class="quick-action-icon">✍️</div>
          <div class="quick-action-label">New Blog Post</div>
          <div class="quick-action-desc">Write and publish a new post</div>
        </a>
        <a href="events.php?action=new" class="quick-action-card">
          <div class="quick-action-icon">📍</div>
          <div class="quick-action-label">Add Event</div>
          <div class="quick-action-desc">Add an upcoming craft fair</div>
        </a>
        <a href="../commissions.php" target="_blank" class="quick-action-card">
          <div class="quick-action-icon">🎨</div>
          <div class="quick-action-label">Commission Status</div>
          <div class="quick-action-desc">Toggle open/closed</div>
        </a>
        <a href="https://dashboard.stripe.com/products" target="_blank"
           rel="noopener" class="quick-action-card">
          <div class="quick-action-icon">🛍️</div>
          <div class="quick-action-label">Manage Shop</div>
          <div class="quick-action-desc">Add products in Stripe</div>
        </a>
      </div>
    </div>

    <div class="admin-section">
      <div class="admin-section-header">
        <h2 class="admin-section-title">Recent Posts</h2>
        <a href="posts.php" class="admin-text-link">View all →</a>
      </div>
      <?php if (empty($recentPosts)): ?>
        <div class="admin-empty">
          <div class="admin-empty-icon">✏️</div>
          <p>No posts yet. <a href="posts.php?action=new">Write your first post →</a></p>
        </div>
      <?php else: ?>
        <div class="admin-table-wrap">
          <table class="admin-table">
            <thead>
              <tr><th>Title</th><th>Category</th><th>Date</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
              <?php foreach ($recentPosts as $post): ?>
              <tr>
                <td class="td-title"><?= htmlspecialchars($post['title'] ?? '') ?></td>
                <td><?= htmlspecialchars($post['category'] ?? '—') ?></td>
                <td><?= htmlspecialchars($post['date'] ?? '—') ?></td>
                <td>
                  <?php if (!empty($post['published'])): ?>
                    <span class="badge badge-green">Published</span>
                  <?php else: ?>
                    <span class="badge badge-grey">Draft</span>
                  <?php endif; ?>
                </td>
                <td>
                  <a href="posts.php?action=edit&id=<?= (int)($post['id'] ?? 0) ?>"
                     class="admin-table-link">Edit</a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>

  </div>
</main>
</body>
</html>