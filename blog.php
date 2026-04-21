<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon-32x32.png" />
  <title>Blog & Events — Miracale Design</title>
  <meta name="description" content="News, process stories, and upcoming craft fair events from Miracale Design in Virginia." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Nunito:wght@300;400;500;600&family=Dancing+Script:wght@500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />
  <style>
    /* ── PAGE HERO ── */
    .page-hero {
      padding: 10rem 3rem 5rem;
      text-align: center; position: relative; overflow: hidden;
    }
    .page-hero-blob {
      position: absolute; border-radius: 50%;
      filter: blur(90px); pointer-events: none;
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
      font-size: 0.75rem; font-weight: 600;
      letter-spacing: 0.22em; text-transform: uppercase;
      color: var(--terra); margin-bottom: 1rem;
      display: flex; align-items: center; justify-content: center; gap: 0.7rem;
    }
    .page-hero-eyebrow::before, .page-hero-eyebrow::after {
      content: ''; display: inline-block;
      width: 32px; height: 1.5px; background: var(--terra); opacity: 0.5;
    }
    .page-hero-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(3rem, 5vw, 5rem);
      font-weight: 300; color: var(--ink); line-height: 1.1; margin-bottom: 1rem;
    }
    .page-hero-title em { font-style: italic; color: var(--green); }
    .page-hero-sub {
      font-size: 1rem; color: var(--ink-soft);
      max-width: 480px; margin: 0 auto; line-height: 1.7;
    }

    /* ── TAB SWITCHER ── */
    .tab-bar {
      display: flex; justify-content: center;
      gap: 0; margin: 0 auto 4rem;
      max-width: 360px;
      background: var(--parchment);
      border-radius: 99px; padding: 5px;
    }
    .tab-btn {
      flex: 1; padding: 0.65rem 1.5rem;
      border: none; background: none;
      border-radius: 99px; cursor: pointer;
      font-family: 'Nunito', sans-serif;
      font-size: 0.82rem; font-weight: 600;
      letter-spacing: 0.06em; color: var(--ink-soft);
      transition: background 0.25s, color 0.25s;
    }
    .tab-btn.active {
      background: var(--green); color: var(--white);
      box-shadow: 0 3px 14px rgba(45,74,62,0.25);
    }

    /* ── SHARED LAYOUT ── */
    .blog-section,
    .events-section { padding: 0 3rem 6rem; }
    .events-section { display: none; }

    /* ── FEATURED POST ── */
    .featured-post {
      display: grid;
      grid-template-columns: 1.1fr 1fr;
      gap: 3rem; align-items: center;
      background: var(--white);
      border: 1px solid rgba(28,26,23,0.07);
      border-radius: 24px; overflow: hidden;
      margin-bottom: 3rem;
      box-shadow: 0 8px 40px rgba(28,26,23,0.07);
      transition: box-shadow 0.3s;
    }
    .featured-post:hover { box-shadow: 0 16px 56px rgba(28,26,23,0.12); }
    .featured-img {
      aspect-ratio: 4/3;
      background: linear-gradient(135deg, var(--parchment), #e8d5b5);
      display: flex; align-items: center; justify-content: center;
      flex-direction: column; gap: 0.6rem; overflow: hidden;
    }
    .featured-img img {
      width: 100%; height: 100%; object-fit: cover;
      transition: transform 0.5s;
    }
    .featured-post:hover .featured-img img { transform: scale(1.04); }
    .featured-img-placeholder { font-size: 4rem; }
    .featured-body { padding: 2.5rem 3rem 2.5rem 0; }
    .post-category-tag {
      display: inline-block;
      font-size: 0.68rem; font-weight: 700;
      letter-spacing: 0.14em; text-transform: uppercase;
      color: var(--white); background: var(--terra);
      padding: 0.22rem 0.65rem; border-radius: 6px; margin-bottom: 0.9rem;
    }
    .featured-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(1.6rem, 2.5vw, 2.4rem);
      font-weight: 400; color: var(--ink); line-height: 1.2; margin-bottom: 0.8rem;
    }
    .featured-excerpt {
      font-size: 0.92rem; color: var(--ink-soft);
      line-height: 1.75; margin-bottom: 1.4rem;
    }
    .post-meta {
      display: flex; align-items: center; gap: 1rem;
      font-size: 0.75rem; color: var(--ink-soft); margin-bottom: 1.4rem;
    }
    .post-meta-sep { opacity: 0.3; }
    .read-more-link {
      display: inline-flex; align-items: center; gap: 0.4rem;
      font-family: 'Nunito', sans-serif; font-size: 0.82rem;
      font-weight: 600; color: var(--green); text-decoration: none;
      border-bottom: 1.5px solid rgba(45,74,62,0.3); padding-bottom: 2px;
      transition: color 0.2s, border-color 0.2s;
    }
    .read-more-link:hover { color: var(--terra); border-color: var(--terra); }

    /* ── POSTS GRID ── */
    .posts-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.6rem;
    }
    .post-card {
      background: var(--white);
      border: 1px solid rgba(28,26,23,0.07);
      border-radius: 18px; overflow: hidden;
      transition: transform 0.3s, box-shadow 0.3s;
      display: flex; flex-direction: column;
    }
    .post-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 14px 44px rgba(28,26,23,0.1);
    }
    .post-card-img {
      aspect-ratio: 16/9;
      background: linear-gradient(135deg, var(--parchment), #e8d5b5);
      display: flex; align-items: center; justify-content: center; overflow: hidden;
    }
    .post-card-img img {
      width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;
    }
    .post-card:hover .post-card-img img { transform: scale(1.05); }
    .post-card-img-placeholder { font-size: 2.8rem; }
    .post-card-body {
      padding: 1.4rem 1.6rem 1.8rem; flex: 1; display: flex; flex-direction: column;
    }
    .post-card-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.25rem; font-weight: 500; color: var(--ink);
      margin: 0.5rem 0; line-height: 1.3;
    }
    .post-card-excerpt {
      font-size: 0.82rem; color: var(--ink-soft);
      line-height: 1.65; flex: 1; margin-bottom: 1rem;
    }

    /* ── POST MODAL ── */
    .post-modal {
      position: fixed; inset: 0;
      background: rgba(28,26,23,0.7);
      z-index: 500;
      display: flex; align-items: flex-start; justify-content: center;
      padding: 3rem 1.5rem;
      opacity: 0; pointer-events: none;
      transition: opacity 0.3s; overflow-y: auto;
    }
    .post-modal.open { opacity: 1; pointer-events: all; }
    .post-modal-inner {
      background: var(--white);
      border-radius: 24px; padding: 3rem;
      max-width: 720px; width: 100%; position: relative;
      box-shadow: 0 24px 80px rgba(28,26,23,0.2);
      transform: translateY(20px); transition: transform 0.3s;
    }
    .post-modal.open .post-modal-inner { transform: translateY(0); }
    .modal-close {
      position: absolute; top: 1.5rem; right: 1.5rem;
      width: 36px; height: 36px;
      background: var(--parchment); border: none; border-radius: 50%;
      font-size: 1rem; cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      transition: background 0.2s;
    }
    .modal-close:hover { background: var(--terra); color: white; }
    .modal-category {
      font-size: 0.7rem; font-weight: 700; letter-spacing: 0.14em;
      text-transform: uppercase; color: var(--terra); margin-bottom: 0.6rem;
    }
    .modal-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(1.8rem, 3vw, 2.6rem);
      font-weight: 400; color: var(--ink); line-height: 1.15; margin-bottom: 0.8rem;
    }
    .modal-meta {
      font-size: 0.78rem; color: var(--ink-soft);
      margin-bottom: 2rem; padding-bottom: 1.5rem;
      border-bottom: 1px solid rgba(28,26,23,0.08);
    }
    .modal-body { font-size: 0.97rem; color: var(--ink-soft); line-height: 1.9; }
    .modal-body p { margin-bottom: 1.2rem; }
    .modal-body p:last-child { margin-bottom: 0; }

    /* ── EVENTS ── */
    .events-header {
      display: flex; justify-content: space-between;
      align-items: flex-end; margin-bottom: 2.5rem; flex-wrap: wrap; gap: 1rem;
    }
    .events-heading {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(2rem, 3vw, 2.8rem); font-weight: 400; color: var(--ink);
    }
    .events-heading em { font-style: italic; color: var(--green); }
    .events-sub { font-size: 0.88rem; color: var(--ink-soft); margin-top: 0.3rem; }
    .events-list { display: flex; flex-direction: column; gap: 1.2rem; }
    .event-card {
      display: grid;
      grid-template-columns: auto 1fr auto;
      gap: 0 2rem; align-items: start;
      background: var(--white);
      border: 1px solid rgba(28,26,23,0.07);
      border-radius: 18px; padding: 1.8rem 2rem;
      box-shadow: 0 3px 16px rgba(28,26,23,0.05);
      transition: transform 0.3s, box-shadow 0.3s;
      position: relative; overflow: hidden;
    }
    .event-card::before {
      content: ''; position: absolute; left: 0; top: 0; bottom: 0;
      width: 4px; background: var(--terra); border-radius: 4px 0 0 4px;
    }
    .event-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 36px rgba(28,26,23,0.1);
    }
    .event-date-block { text-align: center; min-width: 60px; }
    .event-month {
      font-size: 0.68rem; font-weight: 700; letter-spacing: 0.12em;
      text-transform: uppercase; color: var(--terra);
    }
    .event-day {
      font-family: 'Cormorant Garamond', serif;
      font-size: 2.4rem; font-weight: 300; color: var(--ink); line-height: 1;
    }
    .event-year { font-size: 0.72rem; color: var(--ink-soft); margin-top: 0.1rem; }
    .event-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.35rem; font-weight: 500; color: var(--ink); margin-bottom: 0.3rem;
    }
    .event-location {
      font-size: 0.82rem; color: var(--terra); font-weight: 600;
      margin-bottom: 0.5rem;
    }
    .event-venue { font-size: 0.8rem; color: var(--ink-soft); margin-bottom: 0.5rem; }
    .event-desc { font-size: 0.85rem; color: var(--ink-soft); line-height: 1.65; }
    .event-cta { flex-shrink: 0; align-self: center; }
    .event-link-btn {
      display: inline-flex; align-items: center; gap: 0.4rem;
      padding: 0.55rem 1.1rem; border-radius: 99px;
      border: 1.5px solid var(--green); color: var(--green);
      font-family: 'Nunito', sans-serif; font-size: 0.78rem; font-weight: 600;
      text-decoration: none; transition: all 0.2s;
    }
    .event-link-btn:hover { background: var(--green); color: var(--white); }
    .event-multiday {
      display: inline-block; font-size: 0.68rem; font-weight: 600;
      letter-spacing: 0.06em;
      background: rgba(45,74,62,0.1); color: var(--green);
      padding: 0.15rem 0.55rem; border-radius: 6px; margin-left: 0.4rem;
    }
    .events-empty {
      text-align: center; padding: 4rem 2rem;
      background: var(--parchment); border-radius: 18px;
    }
    .events-empty-icon { font-size: 2.8rem; margin-bottom: 0.8rem; }
    .events-empty-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.6rem; font-weight: 400; color: var(--ink); margin-bottom: 0.4rem;
    }
    .events-empty-body { font-size: 0.88rem; color: var(--ink-soft); }

    /* ── EVENT MODAL ── */
    .event-modal {
      position: fixed; inset: 0;
      background: rgba(28,26,23,0.7);
      z-index: 500;
      display: flex; align-items: center; justify-content: center;
      padding: 2rem 1.5rem;
      opacity: 0; pointer-events: none;
      transition: opacity 0.3s;
    }
    .event-modal.open { opacity: 1; pointer-events: all; }
    .event-modal-inner {
      background: var(--white);
      border-radius: 24px; padding: 2.5rem;
      max-width: 560px; width: 100%;
      position: relative;
      box-shadow: 0 24px 80px rgba(28,26,23,0.2);
      transform: translateY(20px); transition: transform 0.3s;
      max-height: 90vh; overflow-y: auto;
    }
    .event-modal.open .event-modal-inner { transform: translateY(0); }
    .event-modal-close {
      position: absolute; top: 1.2rem; right: 1.2rem;
      width: 34px; height: 34px;
      background: var(--parchment); border: none; border-radius: 50%;
      font-size: 0.95rem; cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      transition: background 0.2s;
    }
    .event-modal-close:hover { background: var(--terra); color: white; }
    .event-modal-date-tag {
      display: inline-flex; align-items: center; gap: 0.5rem;
      font-size: 0.72rem; font-weight: 700; letter-spacing: 0.12em;
      text-transform: uppercase; color: var(--terra);
      margin-bottom: 0.8rem;
    }
    .event-modal-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 400;
      color: var(--ink); line-height: 1.2; margin-bottom: 1.5rem;
    }
    .event-modal-detail {
      display: flex; gap: 0.8rem; align-items: flex-start;
      margin-bottom: 1rem;
      font-size: 0.88rem; color: var(--ink-soft); line-height: 1.55;
    }
    .event-modal-detail-icon { font-size: 1rem; flex-shrink: 0; margin-top: 0.05rem; }
    .event-modal-detail strong { display: block; color: var(--ink); font-weight: 600; }
    .event-modal-desc {
      margin-top: 1.2rem; padding-top: 1.2rem;
      border-top: 1px solid rgba(28,26,23,0.07);
      font-size: 0.9rem; color: var(--ink-soft); line-height: 1.75;
    }
    .event-modal-actions {
      margin-top: 1.5rem; display: flex; gap: 0.8rem; flex-wrap: wrap;
    }

    /* Make event cards look clickable */
    .event-card { cursor: pointer; }
    .event-card:hover { transform: translateY(-3px); box-shadow: 0 10px 36px rgba(28,26,23,0.1); }

    @media (max-width: 900px) {
      .page-hero { padding: 8rem 1.5rem 3rem; }
      .blog-section, .events-section { padding: 0 1.5rem 5rem; }
      .featured-post { grid-template-columns: 1fr; }
      .featured-body { padding: 1.8rem; }
      .posts-grid { grid-template-columns: 1fr; }
      .event-card { grid-template-columns: auto 1fr; }
      .event-cta { display: none; }
    }
  </style>
</head>
<body>

<?php
// ── Load data from JSON ───────────────────────────────────────────────────
$postsJson  = __DIR__ . '/data/posts.json';
$eventsJson = __DIR__ . '/data/events.json';

$allPosts  = file_exists($postsJson)
    ? json_decode(file_get_contents($postsJson), true)
    : array();
$allEvents = file_exists($eventsJson)
    ? json_decode(file_get_contents($eventsJson), true)
    : array();

if (!is_array($allPosts))  $allPosts  = array();
if (!is_array($allEvents)) $allEvents = array();

$today = date('Y-m-d');

// Filter published posts
$posts = array();
foreach ($allPosts as $p) {
    if (!empty($p['published']) && $p['published'] === true) {
        $posts[] = $p;
    }
}

// Sort posts newest first
usort($posts, function($a, $b) {
    return strcmp($b['date'], $a['date']);
});

// Filter upcoming events
$events = array();
foreach ($allEvents as $e) {
    if ($e['date'] >= $today) {
        $events[] = $e;
    }
}

// Sort events soonest first
usort($events, function($a, $b) {
    return strcmp($a['date'], $b['date']);
});

$featuredPost   = !empty($posts) ? $posts[0] : null;
$remainingPosts = count($posts) > 1 ? array_slice($posts, 1) : array();

// ── Date helpers ───────────────────────────────────────────────────────────
function niceDate($date) {
    return date('F j, Y', strtotime($date));
}
function shortMonth($date) {
    return strtoupper(date('M', strtotime($date)));
}
function dayNum($date) {
    return date('j', strtotime($date));
}
function yearNum($date) {
    return date('Y', strtotime($date));
}
?>

<?php include 'includes/nav.php'; ?>

<!-- PAGE HERO -->
<section class="page-hero">
  <div class="page-hero-blob page-hero-blob-1"></div>
  <div class="page-hero-blob page-hero-blob-2"></div>
  <div class="page-hero-eyebrow">From the Studio</div>
  <h1 class="page-hero-title">Blog &amp; <em>Events</em></h1>
  <p class="page-hero-sub">
    Stories from the studio, sneak peeks at new work, and a calendar of
    upcoming craft fairs and markets where you can find us in person.
  </p>
</section>

<!-- TAB BAR -->
<div class="tab-bar">
  <button class="tab-btn active" id="tabBlog" onclick="switchTab('blog')">
    ✏️ Blog (<?= count($posts) ?>)
  </button>
  <button class="tab-btn" id="tabEvents" onclick="switchTab('events')">
    📅 Events (<?= count($events) ?>)
  </button>
</div>

<!-- ══ BLOG TAB ══ -->
<div class="blog-section" id="blogSection">

  <?php if ($featuredPost): ?>
  <article class="featured-post reveal">
    <div class="featured-img">
      <?php if (!empty($featuredPost['image'])): ?>
        <img src="<?= htmlspecialchars($featuredPost['image']) ?>"
             alt="<?= htmlspecialchars($featuredPost['title']) ?>" loading="lazy" />
      <?php else: ?>
        <div class="featured-img-placeholder">✍️</div>
      <?php endif; ?>
    </div>
    <div class="featured-body">
      <span class="post-category-tag"><?= htmlspecialchars($featuredPost['category']) ?></span>
      <h2 class="featured-title"><?= htmlspecialchars($featuredPost['title']) ?></h2>
      <div class="post-meta">
        <span><?= niceDate($featuredPost['date']) ?></span>
        <span class="post-meta-sep">·</span>
        <span><?= htmlspecialchars($featuredPost['author']) ?></span>
      </div>
      <p class="featured-excerpt"><?= htmlspecialchars($featuredPost['excerpt']) ?></p>
      <a href="#" class="read-more-link"
         onclick="openPost(<?= (int)$featuredPost['id'] ?>); return false;">
        Read the full post
        <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M2 6h8M7 3l3 3-3 3" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
    </div>
  </article>
  <?php endif; ?>

  <?php if (!empty($remainingPosts)): ?>
  <div class="posts-grid reveal">
    <?php foreach ($remainingPosts as $post): ?>
    <article class="post-card">
      <div class="post-card-img">
        <?php if (!empty($post['image'])): ?>
          <img src="<?= htmlspecialchars($post['image']) ?>"
               alt="<?= htmlspecialchars($post['title']) ?>" loading="lazy" />
        <?php else: ?>
          <div class="post-card-img-placeholder">🎨</div>
        <?php endif; ?>
      </div>
      <div class="post-card-body">
        <span class="post-category-tag"><?= htmlspecialchars($post['category']) ?></span>
        <h3 class="post-card-title"><?= htmlspecialchars($post['title']) ?></h3>
        <p class="post-card-excerpt"><?= htmlspecialchars($post['excerpt']) ?></p>
        <div class="post-meta" style="margin-bottom:1rem">
          <span><?= niceDate($post['date']) ?></span>
        </div>
        <a href="#" class="read-more-link"
           onclick="openPost(<?= (int)$post['id'] ?>); return false;">
          Read more
          <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M2 6h8M7 3l3 3-3 3" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
      </div>
    </article>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <?php if (empty($posts)): ?>
  <div style="text-align:center; padding:5rem 2rem;">
    <div style="font-size:3rem; margin-bottom:1rem">✍️</div>
    <div style="font-family:'Cormorant Garamond',serif; font-size:1.8rem; color:var(--ink); margin-bottom:0.5rem">No posts yet</div>
    <p style="font-size:0.9rem; color:var(--ink-soft)">Check back soon — stories from the studio are on the way.</p>
  </div>
  <?php endif; ?>

</div><!-- /blog-section -->


<!-- ══ EVENTS TAB ══ -->
<div class="events-section" id="eventsSection">

  <div class="events-header">
    <div>
      <h2 class="events-heading">Upcoming <em>events</em></h2>
      <p class="events-sub">Find Miracale Design in person at these upcoming craft fairs and markets.</p>
    </div>
  </div>

  <?php if (!empty($events)): ?>
  <div class="events-list reveal">
    <?php foreach ($events as $event): ?>
    <?php
      // Build the full date string for the modal
      $dateStr = date('F j, Y', strtotime($event['date']));
      if (!empty($event['end_date'])) {
          $dateStr .= ' – ' . date('F j, Y', strtotime($event['end_date']));
      }
      $eventJson = htmlspecialchars(json_encode(array(
          'title'       => $event['title']       ?? '',
          'date'        => $dateStr,
          'location'    => $event['location']    ?? '',
          'venue'       => $event['venue']       ?? '',
          'address'     => $event['address']     ?? '',
          'description' => $event['description'] ?? '',
          'link'        => $event['link']        ?? '',
          'multiday'    => !empty($event['end_date']),
      )), ENT_QUOTES);
    ?>
    <div class="event-card" onclick="openEventModal(<?= $eventJson ?>)">
      <div class="event-date-block">
        <div class="event-month"><?= shortMonth($event['date']) ?></div>
        <div class="event-day"><?= dayNum($event['date']) ?></div>
        <div class="event-year"><?= yearNum($event['date']) ?></div>
      </div>
      <div class="event-info">
        <h3 class="event-title">
          <?= htmlspecialchars($event['title']) ?>
          <?php if (!empty($event['end_date'])): ?>
            <span class="event-multiday">
              Multi-day &middot; ends <?= date('M j', strtotime($event['end_date'])) ?>
            </span>
          <?php endif; ?>
        </h3>
        <div class="event-location">📍 <?= htmlspecialchars($event['location']) ?></div>
        <?php if (!empty($event['venue'])): ?>
          <div class="event-venue"><?= htmlspecialchars($event['venue']) ?></div>
        <?php endif; ?>
        <?php if (!empty($event['description'])): ?>
          <div class="event-desc"><?= htmlspecialchars($event['description']) ?></div>
        <?php endif; ?>
      </div>
      <div class="event-cta" onclick="event.stopPropagation()">
        <?php if (!empty($event['link'])): ?>
          <a href="<?= htmlspecialchars($event['link']) ?>"
             class="event-link-btn" target="_blank" rel="noopener">
            View event &rarr;
          </a>
        <?php else: ?>
          <a href="contact.php" class="event-link-btn">Ask a question &rarr;</a>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <?php else: ?>
  <div class="events-empty">
    <div class="events-empty-icon">📅</div>
    <div class="events-empty-title">No upcoming events scheduled</div>
    <p class="events-empty-body">Check back soon — new dates are added regularly.</p>
  </div>
  <?php endif; ?>

</div><!-- /events-section -->


<!-- POST MODAL -->
<div class="post-modal" id="postModal" onclick="handleModalClick(event)">
  <div class="post-modal-inner" id="postModalInner">
    <button class="modal-close" onclick="closePost()">&#x2715;</button>
    <div class="modal-category" id="modalCategory"></div>
    <h2 class="modal-title"    id="modalTitle"></h2>
    <div class="modal-meta"    id="modalMeta"></div>
    <div class="modal-body"    id="modalBody"></div>
  </div>
</div>


<?php include 'includes/footer.php'; ?>
<script src="script.js"></script>

<!-- EVENT MODAL -->
<div class="event-modal" id="eventModal" onclick="handleEventModalClick(event)">
  <div class="event-modal-inner" id="eventModalInner">
    <button class="event-modal-close" onclick="closeEventModal()">&#x2715;</button>
    <div class="event-modal-date-tag" id="eventModalDate"></div>
    <h2 class="event-modal-title" id="eventModalTitle"></h2>
    <div id="eventModalDetails"></div>
    <div class="event-modal-actions" id="eventModalActions"></div>
  </div>
</div>
<script>
// ── Tab switcher ──
function switchTab(tab) {
  var blogSection   = document.getElementById('blogSection');
  var eventsSection = document.getElementById('eventsSection');
  var tabBlog       = document.getElementById('tabBlog');
  var tabEvents     = document.getElementById('tabEvents');

  if (tab === 'blog') {
    blogSection.style.display   = '';
    eventsSection.style.display = 'none';
    tabBlog.classList.add('active');
    tabEvents.classList.remove('active');
  } else {
    blogSection.style.display   = 'none';
    eventsSection.style.display = 'block';
    tabBlog.classList.remove('active');
    tabEvents.classList.add('active');
  }
}

// ── Post data passed from PHP ──
var posts = <?php
  $jsData = array();
  foreach ($posts as $p) {
    $jsData[] = array(
      'id'       => (int)$p['id'],
      'title'    => $p['title'],
      'category' => $p['category'],
      'author'   => $p['author'],
      'date'     => niceDate($p['date']),
      'body'     => $p['body'],
    );
  }
  echo json_encode($jsData);
?>;

// ── Post modal ──
function openPost(id) {
  var post = null;
  for (var i = 0; i < posts.length; i++) {
    if (posts[i].id === id) { post = posts[i]; break; }
  }
  if (!post) return;

  document.getElementById('modalCategory').textContent = post.category;
  document.getElementById('modalTitle').textContent    = post.title;
  document.getElementById('modalMeta').textContent     = post.date + ' \u00b7 ' + post.author;
  document.getElementById('modalBody').innerHTML       = post.body;

  document.getElementById('postModal').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closePost() {
  document.getElementById('postModal').classList.remove('open');
  document.body.style.overflow = '';
}

function handleModalClick(e) {
  if (e.target === document.getElementById('postModal')) closePost();
}

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closePost();
});

if (window.location.hash === '#events') switchTab('events');
</script>
<script>
// ── Event modal ──
function openEventModal(e) {
  document.getElementById('eventModalDate').textContent = '📅 ' + e.date;
  document.getElementById('eventModalTitle').textContent = e.title;

  var details = '';

  if (e.location) {
    details += '<div class="event-modal-detail">' +
      '<span class="event-modal-detail-icon">📍</span>' +
      '<div><strong>Location</strong>' + escHtml(e.location) + '</div>' +
      '</div>';
  }
  if (e.venue) {
    details += '<div class="event-modal-detail">' +
      '<span class="event-modal-detail-icon">🏛️</span>' +
      '<div><strong>Venue</strong>' + escHtml(e.venue) + '</div>' +
      '</div>';
  }
  if (e.address) {
    details += '<div class="event-modal-detail">' +
      '<span class="event-modal-detail-icon">🗺️</span>' +
      '<div><strong>Address</strong>' + escHtml(e.address) +
        '<br><a href="https://maps.google.com/?q=' + encodeURIComponent(e.address) +
        '" target="_blank" rel="noopener" style="font-size:0.8rem;color:var(--terra);font-weight:600;">Open in Maps →</a>' +
      '</div></div>';
  }
  if (e.description) {
    details += '<div class="event-modal-desc">' + escHtml(e.description) + '</div>';
  }

  document.getElementById('eventModalDetails').innerHTML = details;

  var actions = '';
  if (e.link) {
    actions += '<a href="' + escHtml(e.link) + '" class="btn-primary" target="_blank" rel="noopener" ' +
      'style="font-size:0.85rem;padding:0.7rem 1.5rem;">' +
      'View Event Page →</a>';
  }
  actions += '<a href="contact.php" class="btn-ghost" style="font-size:0.85rem;">Ask a question →</a>';
  document.getElementById('eventModalActions').innerHTML = actions;

  document.getElementById('eventModal').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeEventModal() {
  document.getElementById('eventModal').classList.remove('open');
  document.body.style.overflow = '';
}

function handleEventModalClick(e) {
  if (e.target === document.getElementById('eventModal')) closeEventModal();
}

function escHtml(str) {
  var d = document.createElement('div');
  d.textContent = str;
  return d.innerHTML;
}

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeEventModal();
});
</script>
</body>
</html>