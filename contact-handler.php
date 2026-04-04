<?php
// contact-handler.php
header('Content-Type: application/json');

$artist_email = 'miracaledesign2021@gmail.com';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

$name    = trim(htmlspecialchars($_POST['name']    ?? ''));
$email   = trim(htmlspecialchars($_POST['email']   ?? ''));
$subject = trim(htmlspecialchars($_POST['subject'] ?? 'General Question'));
$message = trim(htmlspecialchars($_POST['message'] ?? ''));

$errors = [];
if (empty($name))                      $errors[] = 'Name is required.';
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email is required.';
if (empty($message))                   $errors[] = 'Message is required.';

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

$mail_subject = "[Miracale Design] {$subject} from {$name}";
$body =
    "You have a new message via the Miracale Design contact form.\n\n" .
    "──────────────────────────────\n" .
    "Name:    {$name}\n" .
    "Email:   {$email}\n" .
    "Subject: {$subject}\n" .
    "──────────────────────────────\n\n" .
    "Message:\n{$message}\n\n" .
    "──────────────────────────────\n" .
    "Reply directly to this email to respond.\n";

$headers  = "From: noreply@miracaledesign.com\r\n";
$headers .= "Reply-To: {$email}\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

$sent = mail($artist_email, $mail_subject, $body, $headers);

if ($sent) {
    echo json_encode(['success' => true, 'message' => "Thanks {$name}! Your message has been sent. We'll be in touch soon."]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Message could not be sent. Please email us directly at miracaledesign2021@gmail.com']);
}
exit;