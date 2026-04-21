<?php
// ── ALL PHP LOGIC FIRST — before any HTML output ───────────────────────────
if (session_status() === PHP_SESSION_NONE) session_start();

$configPath = dirname(__DIR__) . '/config/admin.php';
if (!file_exists($configPath)) die('Config missing.');
require_once $configPath;

// Auth check — must happen before any HTML
if (empty($_SESSION['admin_logged_in']) ||
    $_SESSION['admin_user'] !== ADMIN_USERNAME ||
    $_SESSION['admin_expires'] < time()) {
    header('Location: /login.php');
    exit;
}

$reviewsFile = dirname(__DIR__) . '/data/reviews.json';

// ── Helpers ────────────────────────────────────────────────────────────────
function loadReviews($file) {
    if (!file_exists($file)) return array();
    $d = json_decode(file_get_contents($file), true);
    return is_array($d) ? $d : array();
}
function saveReviews($file, $reviews) {
    file_put_contents($file, json_encode(array_values($reviews), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// ── Handle POST actions ────────────────────────────────────────────────────
$feedback     = '';
$feedbackType = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reviews  = loadReviews($reviewsFile);
    $pAction  = $_POST['_action'] ?? '';
    $targetId = (int)($_POST['id'] ?? 0);

    if ($pAction === 'approve') {
        foreach ($reviews as &$r) {
            if ((int)$r['id'] === $targetId) { $r['status'] = 'approved'; break; }
        } unset($r);
        $feedback = 'Review approved and now visible on the site.';
    }

    if ($pAction === 'hide') {
        foreach ($reviews as &$r) {
            if ((int)$r['id'] === $targetId) { $r['status'] = 'hidden'; $r['featured'] = false; break; }
        } unset($r);
        $feedback = 'Review hidden from the site.';
    }

    if ($pAction === 'unhide') {
        foreach ($reviews as &$r) {
            if ((int)$r['id'] === $targetId) { $r['status'] = 'approved'; break; }
        } unset($r);
        $feedback = 'Review is now visible again.';
    }

    if ($pAction === 'feature') {
        foreach ($reviews as &$r) {
            $r['featured'] = ((int)$r['id'] === $targetId && $r['status'] === 'approved');
        } unset($r);
        $feedback = 'Review set as featured.';
    }

    if ($pAction === 'unfeature') {
        foreach ($reviews as &$r) {
            if ((int)$r['id'] === $targetId) { $r['featured'] = false; break; }
        } unset($r);
        $feedback = 'Review unfeatured.';
    }

    if ($pAction === 'delete') {
        $reviews = array_filter($reviews, function($r) use ($targetId) {
            return (int)$r['id'] !== $targetId;
        });
        $feedback = 'Review permanently deleted.';
    }

    saveReviews($reviewsFile, $reviews);
}

// ── Load and sort reviews ──────────────────────────────────────────────────
$reviews = loadReviews($reviewsFile);
usort($reviews, function($a, $b) {
    return strcmp($b['date'] ?? '', $a['date'] ?? '');
});

$totalCount = count($reviews);
$pendingCount = $approvedCount = $hiddenCount = 0;
foreach ($reviews as $r) {
    $s = $r['status'] ?? 'pending';
    if ($s === 'pending')  $pendingCount++;
    if ($s === 'approved') $approvedCount++;
    if ($s === 'hidden')   $hiddenCount++;
}

$activeFilter = $_GET['filter'] ?? 'all';
if (!in_array($activeFilter, array('all', 'pending', 'approved', 'hidden'))) {
    $activeFilter = 'all';
}
$filtered = $activeFilter === 'all'
    ? $reviews
    : array_values(array_filter($reviews, function($r) use ($activeFilter) {
        return ($r['status'] ?? 'pending') === $activeFilter;
    }));

// ── HTML OUTPUT STARTS HERE ────────────────────────────────────────────────
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon-32x32.png" />
  <title>Reviews — Miracale Design Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Nunito:wght@300;400;500;600&family=Dancing+Script:wght@500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../styles.css" />
  <link rel="stylesheet" href="admin.css" />
  <style>
    .review-cards { display: flex; flex-direction: column; gap: 1rem; }
    .review-card {
      background: white;
      border: 1px solid rgba(28,26,23,0.07);
      border-radius: 16px;
      padding: 1.5rem 1.8rem;
      display: grid;
      grid-template-columns: 1fr auto;
      gap: 1rem;
      align-items: start;
      box-shadow: 0 2px 12px rgba(28,26,23,0.04);
      transition: box-shadow 0.2s;
    }
    .review-card:hover { box-shadow: 0 6px 24px rgba(28,26,23,0.09); }
    .review-card.pending  { border-left: 3px solid var(--ochre, #D4A843); }
    .review-card.approved { border-left: 3px solid var(--green, #2D4A3E); }
    .review-card.hidden   { border-left: 3px solid rgba(28,26,23,0.2); opacity: 0.65; }
    .review-stars { color: var(--ochre, #D4A843); font-size: 1rem; letter-spacing: 1px; margin-bottom: 0.4rem; }
    .review-text {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.1rem; font-style: italic;
      color: var(--ink, #1C1A17); line-height: 1.55; margin-bottom: 0.6rem;
    }
    .review-meta { font-size: 0.78rem; color: var(--ink-soft, #4A4540); }
    .review-meta strong { color: var(--ink, #1C1A17); }
    .review-featured-badge {
      display: inline-flex; align-items: center; gap: 0.3rem;
      font-size: 0.68rem; font-weight: 700; letter-spacing: 0.08em;
      text-transform: uppercase;
      background: rgba(212,168,67,0.15); color: #8a6c1c;
      padding: 0.15rem 0.55rem; border-radius: 6px; margin-left: 0.5rem;
    }
    .review-actions {
      display: flex; flex-direction: column; gap: 0.5rem;
      flex-shrink: 0; align-items: flex-end;
    }
    .action-btn {
      padding: 0.4rem 0.9rem; border-radius: 8px;
      font-family: 'Nunito', sans-serif; font-size: 0.75rem;
      font-weight: 600; border: none; cursor: pointer;
      white-space: nowrap; transition: all 0.2s;
      text-align: center; min-width: 100px;
    }
    .action-btn.approve   { background: rgba(45,74,62,0.1);   color: var(--green, #2D4A3E); }
    .action-btn.approve:hover   { background: var(--green, #2D4A3E); color: white; }
    .action-btn.hide      { background: rgba(28,26,23,0.07);  color: var(--ink-soft, #4A4540); }
    .action-btn.hide:hover      { background: rgba(28,26,23,0.15); }
    .action-btn.unhide    { background: rgba(28,26,23,0.07);  color: var(--ink-soft, #4A4540); }
    .action-btn.unhide:hover    { background: rgba(28,26,23,0.15); }
    .action-btn.feature   { background: rgba(212,168,67,0.12); color: #8a6c1c; }
    .action-btn.feature:hover   { background: rgba(212,168,67,0.25); }
    .action-btn.unfeature { background: rgba(212,168,67,0.12); color: #8a6c1c; }
    .action-btn.unfeature:hover { background: rgba(212,168,67,0.25); }
    .action-btn.delete    { background: rgba(201,104,58,0.08); color: var(--terra, #C9683A); }
    .action-btn.delete:hover    { background: rgba(201,104,58,0.18); }
    .filter-tabs { display: flex; gap: 0.5rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
    .filter-tab {
      padding: 0.4rem 1rem; border-radius: 99px;
      border: 1.5px solid rgba(28,26,23,0.12);
      background: none; font-family: 'Nunito', sans-serif;
      font-size: 0.78rem; font-weight: 600; color: var(--ink-soft);
      cursor: pointer; transition: all 0.2s;
    }
    .filter-tab.active { background: var(--green); border-color: var(--green); color: white; }
    .filter-tab:hover:not(.active) { border-color: var(--terra); color: var(--terra); }
    .summary-bar { display: flex; gap: 1.5rem; margin-bottom: 2rem; flex-wrap: wrap; }
    .summary-item {
      background: white; border-radius: 12px;
      padding: 0.8rem 1.2rem; font-size: 0.82rem;
      color: var(--ink-soft); border: 1px solid rgba(28,26,23,0.07);
    }
    .summary-item strong {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.4rem; font-weight: 400;
      color: var(--ink); display: block; line-height: 1;
    }
  </style>
</head>
<body class="admin-body">

<?php include 'admin-nav.php'; ?>

<main class="admin-main">
  <div class="admin-container">

    <?php if ($feedback): ?>
      <div class="admin-feedback show <?= $feedbackType ?>"><?= htmlspecialchars($feedback) ?></div>
    <?php endif; ?>

    <div class="admin-page-header">
      <div>
        <h1 class="admin-page-title">Reviews</h1>
        <p class="admin-page-sub">Approve, hide, feature, or delete customer reviews.</p>
      </div>
      <a href="../reviews.php" target="_blank" class="admin-btn admin-btn-ghost">View Page ↗</a>
    </div>

    <div class="summary-bar">
      <div class="summary-item"><strong><?= $totalCount ?></strong>Total</div>
      <div class="summary-item"><strong style="color:#8a6c1c"><?= $pendingCount ?></strong>Pending</div>
      <div class="summary-item"><strong style="color:var(--green)"><?= $approvedCount ?></strong>Approved</div>
      <div class="summary-item"><strong><?= $hiddenCount ?></strong>Hidden</div>
    </div>

    <div class="filter-tabs">
      <?php foreach (array('all' => 'All', 'pending' => 'Pending', 'approved' => 'Approved', 'hidden' => 'Hidden') as $key => $label): ?>
        <a href="?filter=<?= $key ?>" style="text-decoration:none">
          <button class="filter-tab <?= $activeFilter === $key ? 'active' : '' ?>">
            <?= $label ?>
            <?php
              $c = $key === 'all' ? $totalCount : ($key === 'pending' ? $pendingCount : ($key === 'approved' ? $approvedCount : $hiddenCount));
              echo '(' . $c . ')';
            ?>
          </button>
        </a>
      <?php endforeach; ?>
    </div>

    <?php if (empty($filtered)): ?>
      <div class="admin-empty">
        <div class="admin-empty-icon">⭐</div>
        <p>No <?= $activeFilter !== 'all' ? $activeFilter . ' ' : '' ?>reviews yet.</p>
      </div>
    <?php else: ?>
    <div class="review-cards">
      <?php foreach ($filtered as $r):
        $status   = $r['status']   ?? 'pending';
        $featured = !empty($r['featured']);
        $stars    = (int)($r['stars'] ?? 5);
      ?>
      <div class="review-card <?= $status ?>">
        <div class="review-body">
          <div class="review-stars">
            <?= str_repeat('★', $stars) . str_repeat('☆', 5 - $stars) ?>
          </div>
          <div class="review-text">"<?= htmlspecialchars($r['review'] ?? '') ?>"</div>
          <div class="review-meta">
            <strong><?= htmlspecialchars($r['name'] ?? 'Anonymous') ?></strong>
            <?php if (!empty($r['product'])): ?>
              &nbsp;·&nbsp; <?= htmlspecialchars($r['product']) ?>
            <?php endif; ?>
            &nbsp;·&nbsp; <?= htmlspecialchars($r['date'] ?? '') ?>
            <?php if ($featured): ?>
              <span class="review-featured-badge">⭐ Featured</span>
            <?php endif; ?>
            &nbsp;·&nbsp;
            <?php if ($status === 'pending'): ?>
              <span class="badge badge-ochre">Pending approval</span>
            <?php elseif ($status === 'approved'): ?>
              <span class="badge badge-green">Approved</span>
            <?php else: ?>
              <span class="badge badge-grey">Hidden</span>
            <?php endif; ?>
          </div>
        </div>

        <div class="review-actions">
          <?php if ($status === 'pending'): ?>
            <form method="POST">
              <input type="hidden" name="_action" value="approve" />
              <input type="hidden" name="id" value="<?= (int)$r['id'] ?>" />
              <button class="action-btn approve" type="submit">✓ Approve</button>
            </form>
          <?php endif; ?>

          <?php if ($status === 'approved'): ?>
            <?php if ($featured): ?>
              <form method="POST">
                <input type="hidden" name="_action" value="unfeature" />
                <input type="hidden" name="id" value="<?= (int)$r['id'] ?>" />
                <button class="action-btn unfeature" type="submit">★ Unfeature</button>
              </form>
            <?php else: ?>
              <form method="POST">
                <input type="hidden" name="_action" value="feature" />
                <input type="hidden" name="id" value="<?= (int)$r['id'] ?>" />
                <button class="action-btn feature" type="submit">★ Feature</button>
              </form>
            <?php endif; ?>
          <?php endif; ?>

          <?php if ($status !== 'hidden'): ?>
            <form method="POST">
              <input type="hidden" name="_action" value="hide" />
              <input type="hidden" name="id" value="<?= (int)$r['id'] ?>" />
              <button class="action-btn hide" type="submit">○ Hide</button>
            </form>
          <?php else: ?>
            <form method="POST">
              <input type="hidden" name="_action" value="unhide" />
              <input type="hidden" name="id" value="<?= (int)$r['id'] ?>" />
              <button class="action-btn unhide" type="submit">◉ Show</button>
            </form>
          <?php endif; ?>

          <form method="POST" onsubmit="return confirm('Permanently delete this review?')">
            <input type="hidden" name="_action" value="delete" />
            <input type="hidden" name="id" value="<?= (int)$r['id'] ?>" />
            <button class="action-btn delete" type="submit">✕ Delete</button>
          </form>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

  </div>
</main>
</body>
</html>