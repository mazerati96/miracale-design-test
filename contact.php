<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact — Miracale Design</title>
  <meta name="description" content="Get in touch with Miracale Design — questions, custom orders, and commissions welcome." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Nunito:wght@300;400;500;600&family=Dancing+Script:wght@500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />
  <style>
    .page-hero {
      padding: 10rem 3rem 5rem;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    .page-hero-blob {
      position: absolute;
      border-radius: 50%;
      filter: blur(90px);
      pointer-events: none;
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
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.22em;
      text-transform: uppercase;
      color: var(--terra);
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.7rem;
    }
    .page-hero-eyebrow::before,
    .page-hero-eyebrow::after {
      content: '';
      display: inline-block;
      width: 32px; height: 1.5px;
      background: var(--terra);
      opacity: 0.5;
    }
    .page-hero-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(3rem, 5vw, 5rem);
      font-weight: 300;
      color: var(--ink);
      line-height: 1.1;
      margin-bottom: 1rem;
    }
    .page-hero-title em { font-style: italic; color: var(--green); }
    .page-hero-sub {
      font-size: 1rem;
      color: var(--ink-soft);
      max-width: 480px;
      margin: 0 auto;
      line-height: 1.7;
    }

    /* ── CONTACT LAYOUT ── */
    .contact-section {
      padding: 4rem 3rem 6rem;
      display: grid;
      grid-template-columns: 1fr 1.4fr;
      gap: 5rem;
      align-items: start;
    }

    /* Left info panel */
    .contact-info-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 2rem;
      font-weight: 400;
      color: var(--ink);
      margin-bottom: 0.5rem;
    }
    .contact-info-title em { font-style: italic; color: var(--terra); }
    .contact-info-sub {
      font-size: 0.92rem;
      color: var(--ink-soft);
      line-height: 1.75;
      margin-bottom: 2.5rem;
    }
    .contact-details {
      display: flex;
      flex-direction: column;
      gap: 1.2rem;
      margin-bottom: 2.5rem;
    }
    .contact-detail-row {
      display: flex;
      align-items: flex-start;
      gap: 1rem;
    }
    .contact-detail-icon {
      width: 40px; height: 40px;
      background: var(--parchment);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.1rem;
      flex-shrink: 0;
    }
    .contact-detail-label {
      font-size: 0.72rem;
      font-weight: 600;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--ink-soft);
      margin-bottom: 0.2rem;
    }
    .contact-detail-value {
      font-size: 0.9rem;
      color: var(--ink);
    }
    .contact-detail-value a {
      color: var(--ink);
      text-decoration: none;
      transition: color 0.2s;
    }
    .contact-detail-value a:hover { color: var(--terra); }

    /* Social links */
    .contact-socials-title {
      font-size: 0.72rem;
      font-weight: 600;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--ink-soft);
      margin-bottom: 0.8rem;
    }
    .contact-social-links {
      display: flex;
      flex-direction: column;
      gap: 0.6rem;
    }
    .contact-social-link {
      display: flex;
      align-items: center;
      gap: 0.7rem;
      font-size: 0.88rem;
      color: var(--ink-soft);
      text-decoration: none;
      transition: color 0.2s;
    }
    .contact-social-link:hover { color: var(--terra); }
    .social-icon {
      width: 34px; height: 34px;
      background: var(--parchment);
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      flex-shrink: 0;
      transition: background 0.2s;
    }
    .contact-social-link:hover .social-icon { background: rgba(201,104,58,0.12); }

    /* ── FORM ── */
    .contact-form-wrap {
      background: var(--white);
      border: 1px solid rgba(28,26,23,0.07);
      border-radius: 22px;
      padding: 2.8rem;
      box-shadow: 0 8px 40px rgba(28,26,23,0.07);
    }
    .form-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.6rem;
      font-weight: 400;
      color: var(--ink);
      margin-bottom: 0.3rem;
    }
    .form-subtitle {
      font-size: 0.85rem;
      color: var(--ink-soft);
      margin-bottom: 2rem;
    }
    .contact-form { display: flex; flex-direction: column; gap: 1.1rem; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .form-group { display: flex; flex-direction: column; gap: 0.4rem; }
    .form-label {
      font-size: 0.72rem;
      font-weight: 600;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--ink-soft);
    }
    .form-input,
    .form-select,
    .form-textarea {
      background: var(--cream);
      border: 1.5px solid rgba(28,26,23,0.1);
      border-radius: 10px;
      padding: 0.8rem 1rem;
      font-family: 'Nunito', sans-serif;
      font-size: 0.9rem;
      color: var(--ink);
      transition: border-color 0.2s, box-shadow 0.2s;
      outline: none;
      width: 100%;
    }
    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
      border-color: var(--green);
      box-shadow: 0 0 0 3px rgba(45,74,62,0.1);
    }
    .form-textarea { resize: vertical; min-height: 130px; }
    .form-select { appearance: none; cursor: pointer; }

    .form-submit {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      background: var(--green);
      color: var(--white);
      padding: 0.9rem 2rem;
      border-radius: 40px;
      font-family: 'Nunito', sans-serif;
      font-size: 0.88rem;
      font-weight: 600;
      letter-spacing: 0.06em;
      border: none;
      cursor: pointer;
      transition: background 0.25s, transform 0.2s, box-shadow 0.25s;
      box-shadow: 0 4px 20px rgba(45,74,62,0.25);
      width: 100%;
      margin-top: 0.4rem;
    }
    .form-submit:hover {
      background: var(--green-light);
      transform: translateY(-2px);
      box-shadow: 0 8px 28px rgba(45,74,62,0.3);
    }
    .form-submit:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
    .form-feedback {
      padding: 0.85rem 1.1rem;
      border-radius: 10px;
      font-size: 0.88rem;
      display: none;
    }
    .form-feedback.success {
      background: rgba(45,74,62,0.1);
      color: var(--green);
      border: 1px solid rgba(45,74,62,0.2);
      display: block;
    }
    .form-feedback.error {
      background: rgba(201,104,58,0.1);
      color: var(--terra);
      border: 1px solid rgba(201,104,58,0.2);
      display: block;
    }

    @media (max-width: 900px) {
      .page-hero { padding: 8rem 1.5rem 3rem; }
      .contact-section { grid-template-columns: 1fr; gap: 3rem; padding: 3rem 1.5rem 5rem; }
      .form-row { grid-template-columns: 1fr; }
      .contact-form-wrap { padding: 2rem 1.5rem; }
    }
  </style>
</head>
<body>

<?php include 'includes/nav.php'; ?>

<!-- PAGE HERO -->
<section class="page-hero">
  <div class="page-hero-blob page-hero-blob-1"></div>
  <div class="page-hero-blob page-hero-blob-2"></div>
  <div class="page-hero-eyebrow">Get in Touch</div>
  <h1 class="page-hero-title">Let's <em>talk</em></h1>
  <p class="page-hero-sub">
    Questions about an order, a custom request, or just want to say hi?
    Send a message and we'll get back to you soon.
  </p>
</section>

<!-- CONTACT SECTION -->
<section class="contact-section reveal">

  <!-- Left: info -->
  <div class="contact-info">
    <h2 class="contact-info-title">Say <em>hello</em></h2>
    <p class="contact-info-sub">
      Whether it's about a piece you spotted, a commission idea, or just
      a question — don't be shy. Every message gets a personal reply.
    </p>

    <div class="contact-details">
      <div class="contact-detail-row">
        <div class="contact-detail-icon">📧</div>
        <div>
          <div class="contact-detail-label">Email</div>
          <div class="contact-detail-value">
            <a href="mailto:miracaledesign2021@gmail.com">miracaledesign2021@gmail.com</a>
          </div>
        </div>
      </div>
      
      </div>
      <div class="contact-detail-row">
        <div class="contact-detail-icon">📍</div>
        <div>
          <div class="contact-detail-label">Location</div>
          <div class="contact-detail-value">Southwest Virginia, USA</div>
        </div>
      </div>
    </div>

    <div class="contact-socials-title">Find us online</div>
    <div class="contact-social-links">
      <a href="#" class="contact-social-link">
        <div class="social-icon">📘</div>
        Facebook
      </a>
      <a href="#" class="contact-social-link">
        <div class="social-icon">📸</div>
        Instagram
      </a>
      <a href="#" class="contact-social-link">
        <div class="social-icon">💬</div>
        Discord
      </a>
    </div>
  </div>

  <!-- Right: form -->
  <div class="contact-form-wrap">
    <div class="form-title">Send a message</div>
    <div class="form-subtitle">We'll reply within 1–2 business days.</div>

    <form class="contact-form" id="contactForm" novalidate>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="contactName">Your Name *</label>
          <input class="form-input" type="text" id="contactName" name="name" placeholder="Jane Smith" required />
        </div>
        <div class="form-group">
          <label class="form-label" for="contactEmail">Email *</label>
          <input class="form-input" type="email" id="contactEmail" name="email" placeholder="jane@email.com" required />
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="contactSubject">Subject</label>
        <select class="form-select" id="contactSubject" name="subject">
          <option value="">— Select a topic —</option>
          <option value="General Question">General Question</option>
          <option value="Order Inquiry">Order Inquiry</option>
          <option value="Commission Request">Commission Request</option>
          <option value="Custom Order">Custom Order</option>
          <option value="Other">Other</option>
        </select>
      </div>

      <div class="form-group">
        <label class="form-label" for="contactMessage">Message *</label>
        <textarea class="form-textarea" id="contactMessage" name="message" placeholder="What's on your mind?" required></textarea>
      </div>

      <div class="form-feedback" id="contactFeedback"></div>

      <button type="submit" class="form-submit" id="contactSubmit">
        Send Message
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
    </form>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
<script src="script.js"></script>
<script>
  const form     = document.getElementById('contactForm');
  const feedback = document.getElementById('contactFeedback');
  const submitBtn = document.getElementById('contactSubmit');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    feedback.className = 'form-feedback';
    submitBtn.disabled = true;
    submitBtn.textContent = 'Sending…';

    try {
      const res  = await fetch('contact-handler.php', { method: 'POST', body: new FormData(form) });
      const data = await res.json();
      feedback.className = `form-feedback ${data.success ? 'success' : 'error'}`;
      feedback.textContent = data.message;
      if (data.success) form.reset();
    } catch {
      feedback.className = 'form-feedback error';
      feedback.textContent = 'Something went wrong. Please email us directly.';
    } finally {
      submitBtn.disabled = false;
      submitBtn.textContent = 'Send Message';
    }
  });
</script>
</body>
</html>