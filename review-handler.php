<?php
// review-handler.php
header('Content-Type: application/json');

$artist_email = 'miracaledesign2021@gmail.com';
$reviewsFile  = __DIR__ . '/data/reviews.json';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(array('success' => false, 'message' => 'Method not allowed.'));
    exit;
}

$name    = trim(htmlspecialchars($_POST['name']    ?? ''));
$product = trim(htmlspecialchars($_POST['product'] ?? ''));
$review  = trim(htmlspecialchars($_POST['review']  ?? ''));
$stars   = (int)($_POST['stars'] ?? 0);

$errors = array();
if (empty($name))              $errors[] = 'Name is required.';
if (empty($review))            $errors[] = 'Review text is required.';
if ($stars < 1 || $stars > 5) $errors[] = 'Please select a star rating.';

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(array('success' => false, 'message' => implode(' ', $errors)));
    exit;
}

// ── Load existing reviews ──────────────────────────────────────────────────
$reviews = array();
if (file_exists($reviewsFile)) {
    $decoded = json_decode(file_get_contents($reviewsFile), true);
    if (is_array($decoded)) $reviews = $decoded;
}

// Next ID
$maxId = 0;
foreach ($reviews as $r) {
    if (!empty($r['id']) && (int)$r['id'] > $maxId) $maxId = (int)$r['id'];
}

$reviews[] = array(
    'id'       => $maxId + 1,
    'name'     => $name,
    'product'  => $product,
    'review'   => $review,
    'stars'    => $stars,
    'status'   => 'pending',
    'date'     => date('Y-m-d'),
    'featured' => false,
);

$saved = file_put_contents(
    $reviewsFile,
    json_encode($reviews, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
);

// ── Email artist ───────────────────────────────────────────────────────────
$starStr = str_repeat('★', $stars) . str_repeat('☆', 5 - $stars);
$subject = "[New Review] {$stars}/5 from {$name} — awaiting approval";
$body    =
    "New review submitted — log in to approve or reject it.\n\n" .
    "────────────────────────────\n" .
    "Name:    {$name}\n" .
    "Product: " . ($product ?: '(not specified)') . "\n" .
    "Rating:  {$starStr} ({$stars}/5)\n" .
    "────────────────────────────\n\n" .
    $review . "\n\n" .
    "────────────────────────────\n" .
    "Approve/reject at: https://miracaledesign.com/admin/reviews.php\n";

$headers = "From: noreply@miracaledesign.com\r\nReply-To: {$artist_email}";
mail($artist_email, $subject, $body, $headers);

if ($saved !== false) {
    echo json_encode(array(
        'success' => true,
        'message' => 'Thank you, ' . $name . '! Your review has been submitted and will appear once approved.'
    ));
} else {
    http_response_code(500);
    echo json_encode(array(
        'success' => false,
        'message' => 'Something went wrong. Please email us directly.'
    ));
}
exit;