<?php
// contact.php - handles contact form submission

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.html');
    exit;
}

// Get and trim the inputs
$name     = trim($_POST['name'] ?? '');
$company  = trim($_POST['company'] ?? '');
$email    = trim($_POST['email'] ?? '');
$phone    = trim($_POST['phone'] ?? '');
$service  = trim($_POST['service'] ?? '');
$message  = trim($_POST['message'] ?? '');

// Basic required-field validation
if ($name === '' || $email === '' || $message === '') {
    header('Location: contact.html?status=error');
    exit;
}

// Where the enquiry should land
$to      = 'sibusiso.mashita@gmail.com';   // <-- THIS is your inbox
$subject = 'New enquiry from Marang SHEQ website';

// Build email body
$bodyLines = [
    "You have received a new enquiry from the website contact form.",
    "",
    "Name:    {$name}",
    "Company: {$company}",
    "Email:   {$email}",
    "Phone:   {$phone}",
    "Service: {$service}",
    "",
    "Message:",
    $message,
];

$body = implode("\r\n", $bodyLines);

// Email headers
// Use an address on YOUR domain as the From (helps with spam filters)
$headers   = [];
$headers[] = 'From: Website Enquiries <no-reply@marangsheq.co.za>';
$headers[] = 'Reply-To: ' . $email;
$headers[] = 'X-Mailer: PHP/' . phpversion();

$sent = @mail($to, $subject, $body, implode("\r\n", $headers));

if ($sent) {
    header('Location: contact.html?status=ok');
} else {
    header('Location: contact.html?status=error');
}
exit;
