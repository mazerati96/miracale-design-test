<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load config
$configPath = dirname(__DIR__) . '/config/admin.php';
if (!file_exists($configPath)) {
    die('Configuration file missing. Upload config/admin.php via File Manager.');
}
require_once $configPath;

// Auth check
$loggedIn = (
    isset($_SESSION['admin_logged_in']) &&
    $_SESSION['admin_logged_in'] === true &&
    defined('ADMIN_USERNAME') &&
    isset($_SESSION['admin_user']) &&
    $_SESSION['admin_user'] === ADMIN_USERNAME &&
    isset($_SESSION['admin_expires']) &&
    $_SESSION['admin_expires'] > time()
);

if (!$loggedIn) {
    header('Location: ../login.php');
    exit;
}

// Load commission status
$statusFile      = dirname(__DIR__) . '/data/commissions.json';
$commissionsOpen = true; // default to open
if (file_exists($statusFile)) {
    $decoded = json_decode(file_get_contents($statusFile), true);
    if (is_array($decoded) && isset($decoded['open'])) {
        $commissionsOpen = (bool)$decoded['open'];
    }
}

// Flash message from toggle redirect
$toggledTo = $_GET['commissions'] ?? null; // 'open' or 'closed'

// Load data
$postsPath   = dirname(__DIR__) . '/data/posts.json';
$eventsPath  = dirname(__DIR__) . '/data/events.json';
$reviewsPath = dirname(__DIR__) . '/data/reviews.json';

$posts   = array();
$events  = array();
$reviews = array();
if (file_exists($postsPath))   { $d = json_decode(file_get_contents($postsPath),   true); if (is_array($d)) $posts   = $d; }
if (file_exists($eventsPath))  { $d = json_decode(file_get_contents($eventsPath),  true); if (is_array($d)) $events  = $d; }
if (file_exists($reviewsPath)) { $d = json_decode(file_get_contents($reviewsPath), true); if (is_array($d)) $reviews = $d; }

$today     = date('Y-m-d');
$published = 0; $drafts = 0;
foreach ($posts as $p) { if (!empty($p['published'])) $published++; else $drafts++; }
$upcoming = 0;
foreach ($events as $e) { if (!empty($e['date']) && $e['date'] >= $today) $upcoming++; }

// Review stats
$pendingReviews  = 0;
$approvedReviews = 0;
$totalStars      = 0;
foreach ($reviews as $r) {
    $status = $r['status'] ?? 'pending';
    if ($status === 'pending')  $pendingReviews++;
    if ($status === 'approved') { $approvedReviews++; $totalStars += (int)($r['stars'] ?? 5); }
}
$avgRating = $approvedReviews > 0 ? round($totalStars / $approvedReviews, 1) : 0;

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
  <style>
    .commission-card-open   { border-top: 3px solid #2D4A3E !important; }
    .commission-card-closed { border-top: 3px solid #C9683A !important; }
    .commission-status-pill {
      display: inline-block;
      font-size: 0.68rem; font-weight: 700;
      letter-spacing: 0.08em; text-transform: uppercase;
      padding: 0.2rem 0.55rem; border-radius: 6px;
      margin-top: 0.3rem;
    }
    .pill-open   { background: rgba(45,74,62,0.12);  color: #2D4A3E; }
    .pill-closed { background: rgba(201,104,58,0.12); color: #C9683A; }
    .flash-notice {
      margin: 0 0 1.5rem;
      padding: 0.75rem 1.1rem;
      border-radius: 10px;
      font-size: 0.85rem; font-weight: 600;
    }
    .flash-open   { background: rgba(45,74,62,0.1);  color: #2D4A3E; border: 1.5px solid rgba(45,74,62,0.2); }
    .flash-closed { background: rgba(201,104,58,0.1); color: #C9683A; border: 1.5px solid rgba(201,104,58,0.2); }
  </style>
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

    <?php if ($toggledTo === 'open'): ?>
      <div class="flash-notice flash-open">✅ Commissions are now <strong>open</strong> — the site has been updated.</div>
    <?php elseif ($toggledTo === 'closed'): ?>
      <div class="flash-notice flash-closed">🔒 Commissions are now <strong>closed</strong> — the site has been updated.</div>
    <?php endif; ?>

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
      <div class="stat-card" style="<?= $pendingReviews > 0 ? 'border-top: 3px solid #D4A843;' : '' ?>">
        <div class="stat-icon">⭐</div>
        <div class="stat-number"><?= $pendingReviews ?></div>
        <div class="stat-label">
          Pending Reviews
          <?php if ($pendingReviews > 0): ?>
            <span style="display:block; margin-top:0.2rem; font-size:0.68rem; font-weight:700; color:#8a6c1c; text-transform:uppercase; letter-spacing:0.08em;">● Needs attention</span>
          <?php endif; ?>
        </div>
        <a href="reviews.php" class="stat-link">
          <?= $approvedReviews ?> approved<?= $avgRating > 0 ? ' · ' . $avgRating . ' avg' : '' ?> →
        </a>
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

        <!-- Commission toggle — styled as a card but submits a POST form -->
        <form method="POST" action="toggle-commissions.php" style="display:contents">
          <button type="submit"
                  class="quick-action-card <?= $commissionsOpen ? 'commission-card-open' : 'commission-card-closed' ?>"
                  style="background:none; border:none; cursor:pointer; text-align:left; font-family:inherit;">
            <div class="quick-action-icon"><?= $commissionsOpen ? '🟢' : '🔴' ?></div>
            <div class="quick-action-label">Commission Status</div>
            <div class="quick-action-desc">
              Click to <?= $commissionsOpen ? 'close' : 'open' ?> commissions
            </div>
            <span class="commission-status-pill <?= $commissionsOpen ? 'pill-open' : 'pill-closed' ?>">
              Currently <?= $commissionsOpen ? 'Open' : 'Closed' ?>
            </span>
          </button>
        </form>

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