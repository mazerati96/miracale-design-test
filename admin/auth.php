<?php
// admin/auth.php
// Include at the top of every admin page.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load admin config if not already loaded
if (!defined('ADMIN_USERNAME')) {
    $configPath = dirname(__DIR__) . '/config/admin.php';
    if (!file_exists($configPath)) {
        die('<p style="font-family:sans-serif; padding:2rem; color:#C9683A">
            <strong>Setup required:</strong> Upload
            <code>config/admin.php</code> to the server via Hostinger File Manager.
            Copy from <code>config/admin.example.php</code> and fill in your credentials.
        </p>');
    }
    require_once $configPath;
}

// ── Build the base URL dynamically ────────────────────────────────────────
// Works on any domain without hardcoding
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host     = $_SERVER['HTTP_HOST'] ?? 'localhost';
$baseUrl  = $protocol . '://' . $host;

// ── Check session validity ─────────────────────────────────────────────────
$isLoggedIn = (
    isset($_SESSION['admin_logged_in']) &&
    $_SESSION['admin_logged_in'] === true &&
    isset($_SESSION['admin_user']) &&
    $_SESSION['admin_user'] === ADMIN_USERNAME &&
    isset($_SESSION['admin_expires']) &&
    $_SESSION['admin_expires'] > time()
);

if (!$isLoggedIn) {
    session_unset();
    session_destroy();
    header('Location: ' . $baseUrl . '/login.php');
    exit;
}

// Refresh session expiry on every page load
$_SESSION['admin_expires'] = time() + ADMIN_SESSION_LIFETIME;