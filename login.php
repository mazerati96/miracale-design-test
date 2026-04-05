<?php
// ── ALL PHP LOGIC FIRST — must come before any HTML output ────────────────



if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load config
$configPath = __DIR__ . '/config/admin.php';
$configured = file_exists($configPath);
if ($configured) require_once $configPath;

$error     = '';
$loggedOut = isset($_GET['logged_out']);
$redirectTo = isset($_GET['redirect']) ? $_GET['redirect'] : 'admin/dashboard.php';

// Already logged in? Redirect straight to dashboard (before any HTML)
if ($configured &&
    isset($_SESSION['admin_logged_in']) &&
    $_SESSION['admin_logged_in'] === true &&
    isset($_SESSION['admin_expires']) &&
    $_SESSION['admin_expires'] > time()) {
    header('Location: /admin/dashboard.php');
    exit;
}

// Handle POST login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $configured) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Rate-limit: max 5 attempts per 15 minutes per IP
    $ipKey    = 'login_attempts_' . md5($_SERVER['REMOTE_ADDR'] ?? '');
    $attempts = $_SESSION[$ipKey] ?? 0;
    $lockout  = $_SESSION[$ipKey . '_time'] ?? 0;

    if ($attempts >= 5 && (time() - $lockout) < 900) {
        $error = 'Too many attempts. Please wait 15 minutes and try again.';
    } elseif ($username === ADMIN_USERNAME &&
              password_verify($password, ADMIN_PASSWORD_HASH)) {
        // Success — regenerate session and store auth data
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user']      = ADMIN_USERNAME;
        $_SESSION['admin_expires']   = time() + ADMIN_SESSION_LIFETIME;
        // Clear rate-limit attempts
        unset($_SESSION[$ipKey], $_SESSION[$ipKey . '_time']);
        // Absolute redirect so it works on all Hostinger hosts
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host     = $_SERVER['HTTP_HOST'] ?? 'localhost';
        header('Location: ' . $protocol . '://' . $host . '/admin/dashboard.php');
        exit;
    } else {
        // Failed — increment counter
        $_SESSION[$ipKey]           = $attempts + 1;
        $_SESSION[$ipKey . '_time'] = time();
        $error = 'Incorrect username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Artist Login — Miracale Design</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Nunito:wght@300;400;500;600&family=Dancing+Script:wght@500;600&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --cream: #FDF6EC; --parchment: #F5E6CC; --green: #2D4A3E;
      --green-light: #4A7A67; --terra: #C9683A; --ochre: #D4A843;
      --ink: #1C1A17; --ink-soft: #4A4540; --white: #FFFDF8;
    }
    body {
      background: var(--cream); font-family: 'Nunito', sans-serif;
      min-height: 100vh; display: flex; align-items: center;
      justify-content: center; padding: 2rem; position: relative;
      overflow: hidden;
    }
    .bg-blob {
      position: fixed; border-radius: 50%;
      filter: blur(90px); pointer-events: none;
    }
    .bg-blob-1 {
      width: 500px; height: 500px;
      background: radial-gradient(circle, rgba(45,74,62,0.1), transparent 70%);
      top: -100px; right: -100px;
    }
    .bg-blob-2 {
      width: 400px; height: 400px;
      background: radial-gradient(circle, rgba(201,104,58,0.09), transparent 70%);
      bottom: -80px; left: -80px;
    }

    /* ── CARD ── */
    .login-card {
      background: var(--white);
      border: 1px solid rgba(28,26,23,0.07);
      border-radius: 24px;
      padding: 3rem 2.8rem;
      width: 100%; max-width: 420px;
      box-shadow: 0 20px 64px rgba(28,26,23,0.1);
      position: relative; z-index: 2;
    }
    .login-logo {
      font-family: 'Dancing Script', cursive;
      font-size: 1.8rem; color: var(--green);
      text-decoration: none; display: block;
      text-align: center; margin-bottom: 0.3rem;
    }
    .login-eyebrow {
      text-align: center; font-size: 0.72rem;
      font-weight: 600; letter-spacing: 0.16em;
      text-transform: uppercase; color: var(--ink-soft);
      opacity: 0.55; margin-bottom: 2.2rem;
    }
    .login-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: 2rem; font-weight: 400;
      color: var(--ink); text-align: center;
      margin-bottom: 2rem; line-height: 1.2;
    }
    .login-title em { font-style: italic; color: var(--terra); }

    /* ── FORM ── */
    .login-form { display: flex; flex-direction: column; gap: 1rem; }
    .form-group { display: flex; flex-direction: column; gap: 0.4rem; }
    .form-label {
      font-size: 0.72rem; font-weight: 600;
      letter-spacing: 0.1em; text-transform: uppercase; color: var(--ink-soft);
    }
    .form-input {
      background: var(--cream);
      border: 1.5px solid rgba(28,26,23,0.1);
      border-radius: 10px; padding: 0.8rem 1rem;
      font-family: 'Nunito', sans-serif; font-size: 0.95rem;
      color: var(--ink); outline: none; width: 100%;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-input:focus {
      border-color: var(--green);
      box-shadow: 0 0 0 3px rgba(45,74,62,0.1);
    }
    .password-wrap { position: relative; }
    .password-toggle {
      position: absolute; right: 0.9rem; top: 50%;
      transform: translateY(-50%);
      background: none; border: none; cursor: pointer;
      color: var(--ink-soft); font-size: 1rem; padding: 0;
      transition: color 0.2s;
    }
    .password-toggle:hover { color: var(--terra); }

    .login-btn {
      width: 100%; padding: 0.9rem;
      background: var(--green); color: var(--white);
      border: none; border-radius: 40px; cursor: pointer;
      font-family: 'Nunito', sans-serif; font-size: 0.9rem;
      font-weight: 600; letter-spacing: 0.06em;
      margin-top: 0.5rem;
      transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
      box-shadow: 0 4px 20px rgba(45,74,62,0.25);
    }
    .login-btn:hover {
      background: var(--green-light);
      transform: translateY(-2px);
      box-shadow: 0 8px 28px rgba(45,74,62,0.3);
    }
    .login-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

    /* Feedback */
    .login-error {
      background: rgba(201,104,58,0.1);
      border: 1.5px solid rgba(201,104,58,0.25);
      border-radius: 10px; padding: 0.75rem 1rem;
      font-size: 0.85rem; color: var(--terra);
      text-align: center; display: none;
    }
    .login-error.show { display: block; }
    .login-success {
      background: rgba(45,74,62,0.1);
      border: 1.5px solid rgba(45,74,62,0.2);
      border-radius: 10px; padding: 0.75rem 1rem;
      font-size: 0.85rem; color: var(--green);
      text-align: center; display: none;
    }
    .login-success.show { display: block; }

    .back-link {
      display: block; text-align: center; margin-top: 1.8rem;
      font-size: 0.8rem; color: var(--ink-soft); text-decoration: none;
      transition: color 0.2s;
    }
    .back-link:hover { color: var(--terra); }
  </style>
</head>
<body>

<div class="bg-blob bg-blob-1"></div>
<div class="bg-blob bg-blob-2"></div>

<div class="login-card">
  <a href="index.php" class="login-logo">Miracale Design</a>
  <div class="login-eyebrow">Artist Portal</div>
  <h1 class="login-title">Welcome <em>back</em></h1>

  <?php if ($loggedOut): ?>
    <div class="login-success show">You've been logged out successfully.</div>
  <?php endif; ?>

  <?php if (!$configured): ?>
    <div class="login-error show">
      Setup required: copy <code>config/admin.example.php</code> →
      <code>config/admin.php</code> and set your credentials.
    </div>
  <?php endif; ?>

  <?php if ($error): ?>
    <div class="login-error show"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form class="login-form" method="POST" action="login.php<?= $redirectTo !== 'admin/dashboard.php' ? '?redirect=' . urlencode($redirectTo) : '' ?>">
    <div class="form-group">
      <label class="form-label" for="username">Username</label>
      <input class="form-input" type="text" id="username" name="username"
             autocomplete="username" required
             value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" />
    </div>

    <div class="form-group">
      <label class="form-label" for="password">Password</label>
      <div class="password-wrap">
        <input class="form-input" type="password" id="password"
               name="password" autocomplete="current-password" required />
        <button type="button" class="password-toggle" id="togglePw"
                aria-label="Show/hide password">👁</button>
      </div>
    </div>

    <button type="submit" class="login-btn" <?= !$configured ? 'disabled' : '' ?>>
      Sign In
    </button>
  </form>

  <a href="index.php" class="back-link">← Back to site</a>
</div>

<script>
  var pw     = document.getElementById('password');
  var toggle = document.getElementById('togglePw');
  toggle.addEventListener('click', function() {
    pw.type = pw.type === 'password' ? 'text' : 'password';
    toggle.textContent = pw.type === 'password' ? '👁' : '🙈';
  });
</script>
</body>
</html>