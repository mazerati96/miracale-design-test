<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Order Cancelled — Miracale Design</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Nunito:wght@300;400;500;600&family=Dancing+Script:wght@500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />
  <style>
    .cancel-page {
      min-height: 100vh;
      display: flex; align-items: center; justify-content: center;
      padding: 6rem 2rem; position: relative; overflow: hidden;
    }
    .cancel-blob {
      position: absolute; border-radius: 50%; pointer-events: none;
      width: 480px; height: 480px;
      background: radial-gradient(circle, rgba(201,104,58,0.1), transparent 70%);
      top: -80px; right: -80px; filter: blur(80px);
      animation: drift 9s ease-in-out infinite alternate;
    }
    .cancel-card {
      background: var(--white);
      border: 1px solid rgba(28,26,23,0.07);
      border-radius: 28px; padding: 3.5rem 3rem;
      max-width: 480px; width: 100%; text-align: center;
      box-shadow: 0 20px 64px rgba(28,26,23,0.08);
      position: relative; z-index: 2;
      animation: fadeUp 0.8s ease both;
    }
    .cancel-icon {
      width: 72px; height: 72px;
      background: linear-gradient(135deg, var(--parchment), #e8d5b5);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 1.8rem; font-size: 2rem;
    }
    .cancel-eyebrow {
      font-size: 0.72rem; font-weight: 600; letter-spacing: 0.18em;
      text-transform: uppercase; color: var(--terra); margin-bottom: 0.6rem;
    }
    .cancel-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 2.4rem; font-weight: 300; color: var(--ink);
      line-height: 1.15; margin-bottom: 1rem;
    }
    .cancel-title em { font-style: italic; color: var(--green); }
    .cancel-body {
      font-size: 0.92rem; color: var(--ink-soft);
      line-height: 1.75; margin-bottom: 2rem;
    }
    .cancel-actions {
      display: flex; gap: 0.8rem; justify-content: center; flex-wrap: wrap;
    }
  </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<section class="cancel-page">
  <div class="cancel-blob"></div>
  <div class="cancel-card">
    <div class="cancel-icon">🛒</div>
    <div class="cancel-eyebrow">No Worries</div>
    <h1 class="cancel-title">Your order was<br><em>not completed</em></h1>
    <p class="cancel-body">
      You cancelled the checkout — that's totally fine! Nothing was charged.
      Your piece is still waiting for you if you change your mind, or feel
      free to keep browsing.
    </p>
    <div class="cancel-actions">
      <a href="shop.php" class="btn-primary">
        Back to Shop
        <svg width="13" height="13" viewBox="0 0 14 14" fill="none"><path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
      <a href="contact.php" class="btn-ghost">Have a question?</a>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
<script src="script.js"></script>
</body>
</html>