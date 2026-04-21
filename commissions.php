<?php
// Read commission status from data file
$statusFile      = __DIR__ . '/data/commissions.json';
$commissionsOpen = true; // default to open
if (file_exists($statusFile)) {
    $decoded = json_decode(file_get_contents($statusFile), true);
    if (is_array($decoded) && isset($decoded['open'])) {
        $commissionsOpen = (bool)$decoded['open'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon-32x32.png" />
  <title>Commissions — Miracale Design</title>
  <meta name="description" content="Request a custom handmade piece from Miracale Design. Read the commission terms and submit your request." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Nunito:wght@300;400;500;600&family=Dancing+Script:wght@500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />
  <style>
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

    /* ── STATUS BANNER ── */
    .status-banner {
      margin: 0 3rem 1rem;
      border-radius: 14px;
      padding: 1rem 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.8rem;
      font-size: 0.9rem;
      font-weight: 600;
    }
    .status-banner.open {
      background: rgba(45,74,62,0.1);
      border: 1.5px solid rgba(45,74,62,0.2);
      color: var(--green);
    }
    .status-banner.closed {
      background: rgba(201,104,58,0.1);
      border: 1.5px solid rgba(201,104,58,0.2);
      color: var(--terra);
    }
    .status-dot {
      width: 10px; height: 10px;
      border-radius: 50%;
      flex-shrink: 0;
    }
    .status-banner.open .status-dot { background: var(--green); animation: pulse 2s infinite; }
    .status-banner.closed .status-dot { background: var(--terra); }
    .status-banner-text {
      flex: 1;
      line-height: 1.5;
    }
    @keyframes pulse {
      0%, 100% { opacity: 1; transform: scale(1); }
      50%       { opacity: 0.5; transform: scale(1.3); }
    }

    /* ── HOW IT WORKS ── */
    .how-section { padding: 4rem 3rem; }
    .how-header { text-align: center; margin-bottom: 3rem; }
    .how-eyebrow {
      font-size: 0.75rem; font-weight: 600; letter-spacing: 0.2em;
      text-transform: uppercase; color: var(--terra); margin-bottom: 0.7rem;
    }
    .how-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(2rem, 3vw, 2.8rem); font-weight: 400; color: var(--ink);
    }
    .how-title em { font-style: italic; color: var(--green); }
    .how-steps {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 1.5rem;
      position: relative;
    }
    .how-steps::before {
      content: '';
      position: absolute;
      top: 2rem; left: calc(12.5% + 1.5rem); right: calc(12.5% + 1.5rem);
      height: 1.5px;
      background: linear-gradient(to right, var(--parchment), var(--terra), var(--parchment));
    }
    .how-step { text-align: center; padding: 1.5rem 1rem; }
    .how-step-num {
      width: 44px; height: 44px;
      border-radius: 50%;
      background: var(--green);
      color: var(--white);
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.3rem; font-weight: 400;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 1rem;
      position: relative; z-index: 1;
      box-shadow: 0 4px 16px rgba(45,74,62,0.25);
    }
    .how-step-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.1rem; font-weight: 500; color: var(--ink); margin-bottom: 0.4rem;
    }
    .how-step-desc { font-size: 0.82rem; color: var(--ink-soft); line-height: 1.6; }

    /* ── TOS ── */
    .tos-section { background: var(--parchment); padding: 5rem 3rem; }
    .tos-inner { max-width: 760px; margin: 0 auto; }
    .tos-eyebrow {
      font-size: 0.75rem; font-weight: 600; letter-spacing: 0.2em;
      text-transform: uppercase; color: var(--terra); margin-bottom: 0.8rem;
    }
    .tos-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(2rem, 3vw, 2.6rem); font-weight: 400;
      color: var(--ink); margin-bottom: 2rem; line-height: 1.2;
    }
    .tos-title em { font-style: italic; color: var(--green); }
    .tos-block {
      background: var(--white);
      border-radius: 16px; padding: 2rem 2.2rem;
      margin-bottom: 1rem; border-left: 3px solid var(--terra);
    }
    .tos-block-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.15rem; font-weight: 600; color: var(--ink); margin-bottom: 0.5rem;
    }
    .tos-block-body { font-size: 0.88rem; color: var(--ink-soft); line-height: 1.75; }
    .tos-note {
      margin-top: 1.5rem; font-size: 0.82rem; color: var(--ink-soft);
      font-style: italic; text-align: center;
    }

    /* ── FORM ── */
    .form-section { padding: 5rem 3rem 6rem; }
    .form-section-header { text-align: center; margin-bottom: 3rem; }
    .form-section-eyebrow {
      font-size: 0.75rem; font-weight: 600; letter-spacing: 0.2em;
      text-transform: uppercase; color: var(--terra); margin-bottom: 0.7rem;
    }
    .form-section-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(2rem, 3vw, 2.8rem); font-weight: 400; color: var(--ink);
    }
    .form-section-title em { font-style: italic; color: var(--green); }
    .form-section-sub { font-size: 0.9rem; color: var(--ink-soft); margin-top: 0.5rem; }
    .google-form-wrap {
      max-width: 760px; margin: 0 auto;
      background: var(--white); border-radius: 20px;
      overflow: hidden; box-shadow: 0 8px 40px rgba(28,26,23,0.08);
      border: 1px solid rgba(28,26,23,0.07);
    }
    .google-form-wrap iframe { width: 100%; border: none; display: block; min-height: 900px; }
    .form-placeholder {
      padding: 4rem 2rem; text-align: center;
      background: linear-gradient(135deg, var(--parchment), #f0dfc0);
    }
    .form-placeholder-icon { font-size: 3rem; margin-bottom: 1rem; }
    .form-placeholder-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.5rem; font-weight: 400; color: var(--ink); margin-bottom: 0.5rem;
    }
    .form-placeholder-body {
      font-size: 0.88rem; color: var(--ink-soft); line-height: 1.7;
      max-width: 400px; margin: 0 auto 1.5rem;
    }

    /* Closed state — dims the form section */
    .commissions-closed-notice {
      max-width: 760px; margin: 0 auto;
      padding: 3rem 2rem; text-align: center;
      background: rgba(201,104,58,0.07);
      border: 1.5px solid rgba(201,104,58,0.2);
      border-radius: 20px;
    }
    .commissions-closed-notice-icon { font-size: 2.5rem; margin-bottom: 1rem; }
    .commissions-closed-notice-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.6rem; font-weight: 400; color: var(--ink); margin-bottom: 0.5rem;
    }
    .commissions-closed-notice-body {
      font-size: 0.9rem; color: var(--ink-soft); line-height: 1.7;
    }

    @media (max-width: 900px) {
      .page-hero { padding: 8rem 1.5rem 3rem; }
      .status-banner {
        margin: 0 1.5rem 1rem;
        padding: 0.9rem 1.1rem;
        font-size: 0.85rem;
        align-items: flex-start;
      }
      .status-dot { margin-top: 0.3rem; }
      .how-section { padding: 4rem 1.5rem; }
      .how-steps { grid-template-columns: repeat(2, 1fr); }
      .how-steps::before { display: none; }
      .tos-section { padding: 4rem 1.5rem; }
      .form-section { padding: 4rem 1.5rem 5rem; }
    }
  </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<!-- PAGE HERO -->
<section class="page-hero">
  <div class="page-hero-blob page-hero-blob-1"></div>
  <div class="page-hero-blob page-hero-blob-2"></div>
  <div class="page-hero-eyebrow">Custom Work</div>
  <h1 class="page-hero-title">Commission<br><em>something special</em></h1>
  <p class="page-hero-sub">
    Want a piece made just for you? Commissions are open for clay sculptures,
    watercolor paintings, wood art, and custom keychains.
  </p>
</section>

<!-- STATUS BANNER — class and text driven by commissions.json -->
<div class="status-banner <?= $commissionsOpen ? 'open' : 'closed' ?> reveal">
  <div class="status-dot"></div>
  <span class="status-banner-text">
    <?php if ($commissionsOpen): ?>
      Commissions are currently <strong>open</strong> — submissions are being accepted!
    <?php else: ?>
      Commissions are currently <strong>closed</strong> — check back soon.
    <?php endif; ?>
  </span>
</div>

<!-- HOW IT WORKS -->
<section class="how-section reveal">
  <div class="how-header">
    <div class="how-eyebrow">The Process</div>
    <h2 class="how-title">How <em>commissions</em> work</h2>
  </div>
  <div class="how-steps">
    <div class="how-step">
      <div class="how-step-num">1</div>
      <div class="how-step-title">Submit a Request</div>
      <p class="how-step-desc">Fill out the commission form below with your idea, size preferences, and any reference images.</p>
    </div>
    <div class="how-step">
      <div class="how-step-num">2</div>
      <div class="how-step-title">Get a Quote</div>
      <p class="how-step-desc">We'll review your request and reply within a few days with a price and timeline estimate.</p>
    </div>
    <div class="how-step">
      <div class="how-step-num">3</div>
      <div class="how-step-title">Approve &amp; Pay</div>
      <p class="how-step-desc">Once you approve the quote, a deposit is required to begin work. The remainder is due on completion.</p>
    </div>
    <div class="how-step">
      <div class="how-step-num">4</div>
      <div class="how-step-title">Receive Your Art</div>
      <p class="how-step-desc">Your finished piece is carefully packaged and shipped directly to you with a tracking number.</p>
    </div>
  </div>
</section>

<!-- TERMS OF SERVICE -->
<section class="tos-section reveal">
  <div class="tos-inner">
    <div class="tos-eyebrow">Before You Submit</div>
    <h2 class="tos-title">Commission <em>terms &amp; policies</em></h2>

    <div class="tos-block">
      <div class="tos-block-title">💰 Pricing &amp; Deposits</div>
      <p class="tos-block-body">All commissions are priced individually based on size, complexity, and materials. A 50% non-refundable deposit is required before work begins. The remaining balance is due upon completion before shipping.</p>
    </div>
    <div class="tos-block">
      <div class="tos-block-title">🕐 Turnaround Time</div>
      <p class="tos-block-body">Most commissions take 2–4 weeks depending on complexity and current queue length. Rush orders may be available for an additional fee — ask when submitting. You'll receive progress updates throughout the process.</p>
    </div>
    <div class="tos-block">
      <div class="tos-block-title">🔄 Revisions</div>
      <p class="tos-block-body">One round of minor revisions is included. Major changes to the original concept after work has begun may incur additional charges. Please be as detailed as possible in your initial request.</p>
    </div>
    <div class="tos-block">
      <div class="tos-block-title">🚫 Cancellations &amp; Refunds</div>
      <p class="tos-block-body">Deposits are non-refundable once work has begun. If you need to cancel before work starts, please contact us as soon as possible. Completed pieces are non-refundable but we'll always work to make it right.</p>
    </div>
    <div class="tos-block">
      <div class="tos-block-title">📦 Shipping</div>
      <p class="tos-block-body">Commissions are shipped via USPS Priority Mail with tracking. Shipping costs are calculated at completion and added to the final invoice. International shipping is available — additional fees apply.</p>
    </div>
    <div class="tos-block">
      <div class="tos-block-title">©️ Ownership &amp; Rights</div>
      <p class="tos-block-body">Miracale Design retains the right to photograph and share all commissioned work for portfolio and promotional purposes. The physical piece belongs to you; reproduction rights remain with the artist.</p>
    </div>

    <p class="tos-note">
      By submitting a commission request, you agree to the above terms.
      Questions? <a href="contact.php" style="color:var(--terra)">Contact us first.</a>
    </p>
  </div>
</section>

<!-- COMMISSION FORM — hidden with a notice when commissions are closed -->
<section class="form-section reveal">
  <div class="form-section-header">
    <div class="form-section-eyebrow">Ready to start?</div>
    <h2 class="form-section-title">Submit your <em>request</em></h2>
    <p class="form-section-sub">Fill out the form below and we'll be in touch within 2–3 business days.</p>
  </div>

  <?php if (!$commissionsOpen): ?>
    <!-- Shown when commissions are closed -->
    <div class="commissions-closed-notice">
      <div class="commissions-closed-notice-icon">🔒</div>
      <div class="commissions-closed-notice-title">Commissions are closed right now</div>
      <p class="commissions-closed-notice-body">
        We're not accepting new requests at this time. Follow us on social media
        or check back soon — we'll update this page as soon as we reopen.<br><br>
        In the meantime, <a href="contact.php" style="color:var(--terra)">send us a message</a>
        and we'll let you know when spots open up.
      </p>
    </div>

  <?php else: ?>
    <!-- Shown when commissions are open -->
    <div class="google-form-wrap">
      <!--
        INSTRUCTIONS: Replace the src below with your Google Form embed URL.
        In Google Forms: Send → Embed → copy the iframe src URL.
        It looks like: https://docs.google.com/forms/d/e/XXXXX/viewform?embedded=true
      -->
      

      <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSehZSCEDirLtcyCk_KAVVfk_0v8tciq-K5rGT_BMLKQZN4H0w/viewform?embedded=true" width="640" height="2438" frameborder="0" marginheight="0" marginwidth="0">Loading…</iframe>
    
      
    </div>
  <?php endif; ?>

</section>

<?php include 'includes/footer.php'; ?>
<script src="script.js"></script>
</body>
</html>