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

<?php
require_once 'auth.php';

// Load data
$postsPath  = dirname(__DIR__) . '/data/posts.json';
$eventsPath = dirname(__DIR__) . '/data/events.json';

$posts  = file_exists($postsPath)  ? json_decode(file_get_contents($postsPath),  true) : array();
$events = file_exists($eventsPath) ? json_decode(file_get_contents($eventsPath), true) : array();

if (!is_array($posts))  $posts  = array();
if (!is_array($events)) $events = array();

$today       = date('Y-m-d');
$published   = 0;
$drafts      = 0;
foreach ($posts as $p) {
    if (!empty($p['published'])) $published++;
    else $drafts++;
}
$upcoming = 0;
foreach ($events as $e) {
    if (!empty($e['date']) && $e['date'] >= $today) $upcoming++;
}

// Recent posts (last 5)
$recentPosts = array_slice(array_reverse($posts), 0, 5);
?>

<?php include 'admin-nav.php'; ?>

<main class="admin-main">
  <div class="admin-container">

    <!-- Header -->
    <div class="admin-page-header">
      <div>
        <h1 class="admin-page-title">
          Good <?php
            $h = (int)date('H');
            echo $h < 12 ? 'morning' : ($h < 17 ? 'afternoon' : 'evening');
          ?>, <?= htmlspecialchars(ADMIN_USERNAME) ?> 🎨
        </h1>
        <p class="admin-page-sub">Here's what's going on with your site.</p>
      </div>
      <a href="../index.php" target="_blank" class="admin-btn admin-btn-ghost">
        View Site ↗
      </a>
    </div>

    <!-- Stats cards -->
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

    <!-- Quick actions -->
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
          <div class="quick-action-desc">Toggle open/closed status</div>
        </a>
        <a href="../shop.php" target="_blank" class="quick-action-card">
          <div class="quick-action-icon">🛍️</div>
          <div class="quick-action-label">Manage Shop</div>
          <div class="quick-action-desc">Add products in Stripe</div>
        </a>
      </div>
    </div>

    <!-- Recent posts -->
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
              <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($recentPosts as $post): ?>
              <tr>
                <td class="td-title"><?= htmlspecialchars($post['title']) ?></td>
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
                  <a href="posts.php?action=edit&id=<?= (int)$post['id'] ?>"
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

<script src="../script.js"></script>
</body>
</html>