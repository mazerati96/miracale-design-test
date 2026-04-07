<?php
// admin/toggle-commissions.php
// Called via POST from the dashboard to flip commission open/closed status.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Auth check — must be logged in
$configPath = dirname(__DIR__) . '/config/admin.php';
if (!file_exists($configPath)) {
    http_response_code(403); exit('Forbidden');
}
require_once $configPath;

$loggedIn = (
    isset($_SESSION['admin_logged_in']) &&
    $_SESSION['admin_logged_in'] === true &&
    defined('ADMIN_USERNAME') &&
    isset($_SESSION['admin_user']) &&
    $_SESSION['admin_user'] === ADMIN_USERNAME &&
    isset($_SESSION['admin_expires']) &&
    $_SESSION['admin_expires'] > time()
);

if (!$loggedIn || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(403); exit('Forbidden');
}

// Read current status
$statusFile = dirname(__DIR__) . '/data/commissions.json';
$current    = ['open' => true]; // default to open if file missing

if (file_exists($statusFile)) {
    $decoded = json_decode(file_get_contents($statusFile), true);
    if (is_array($decoded)) $current = $decoded;
}

// Flip it
$current['open'] = !$current['open'];

// Save it
file_put_contents($statusFile, json_encode($current));

// Redirect back to dashboard with a status message
$newStatus = $current['open'] ? 'open' : 'closed';
header('Location: dashboard.php?commissions=' . $newStatus);
exit;