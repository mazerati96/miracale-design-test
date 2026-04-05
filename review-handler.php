<?php
// review-handler.php
// Handles review form submissions and emails them to the artist for approval.

header('Content-Type: application/json');

// ── CONFIG ──────────────────────────────────────────────────────────────────
$artist_email = 'miracaledesign2021@gmail.com';
$site_name    = 'Miracale Design';
// ────────────────────────────────────────────────────────────────────────────

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

// Sanitize inputs
$name    = trim(htmlspecialchars($_POST['name']    ?? ''));
$product = trim(htmlspecialchars($_POST['product'] ?? ''));
$review  = trim(htmlspecialchars($_POST['review']  ?? ''));
$stars   = (int) ($_POST['stars'] ?? 0);

// Validate
$errors = [];
if (empty($name))              $errors[] = 'Name is required.';
if (empty($review))            $errors[] = 'Review text is required.';
if ($stars < 1 || $stars > 5) $errors[] = 'Please select a star rating.';

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

// Build star string
$star_string = str_repeat('★', $stars) . str_repeat('☆', 5 - $stars);

// Build email body
$subject = "New Review Submitted — {$site_name}";
$body    = "A new review has been submitted on {$site_name}.\n\n"
         . "──────────────────────────────\n"
         . "Name:    {$name}\n"
         . "Product: " . ($product ?: '(not specified)') . "\n"
         . "Rating:  {$star_string} ({$stars}/5)\n"
         . "──────────────────────────────\n\n"
         . "Review:\n{$review}\n\n"
         . "──────────────────────────────\n"
         . "Add this review to reviews.php when approved.\n";

$headers  = "From: noreply@miracaledesign.com\r\n";
$headers .= "Reply-To: {$artist_email}\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

$sent = mail($artist_email, $subject, $body, $headers);

if ($sent) {
    echo json_encode(['success' => true, 'message' => 'Thank you! Your review has been submitted for approval.']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Something went wrong. Please try emailing us directly.']);
}
exit;