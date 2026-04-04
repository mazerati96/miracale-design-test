<?php
// admin/auth.php
// Include this at the top of every admin page.
// Checks for a valid session and redirects to login if not found.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load admin config if not already loaded
if (!defined('ADMIN_USERNAME')) {
    $configPath = dirname(__DIR__) . '/config/admin.php';
    if (!file_exists($configPath)) {
        die('<p style="font-family:sans-serif;padding:2rem">
            <strong>Setup required:</strong> Copy
            <code>config/admin.example.php</code> to
            <code>config/admin.php</code> and set your credentials.
        </p>');
    }
    require_once $configPath;
}

// Check session validity
$isLoggedIn = (
    isset($_SESSION['admin_logged_in']) &&
    $_SESSION['admin_logged_in'] === true &&
    isset($_SESSION['admin_user']) &&
    $_SESSION['admin_user'] === ADMIN_USERNAME &&
    isset($_SESSION['admin_expires']) &&
    $_SESSION['admin_expires'] > time()
);

if (!$isLoggedIn) {
    // Clear any stale session data
    session_unset();
    session_destroy();
    // Redirect to login, remembering where they were trying to go
    $redirect = urlencode($_SERVER['REQUEST_URI']);
    header('Location: ' . dirname(__DIR__) . '/login.php?redirect=' . $redirect);

    // Fallback in case dirname gives wrong path on some hosts
    header('Location: /login.php?redirect=' . $redirect);
    exit;
}

// Refresh session expiry on activity
$_SESSION['admin_expires'] = time() + ADMIN_SESSION_LIFETIME;