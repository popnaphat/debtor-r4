<?php
// If you are using Composer (recommended)
require 'vendor/autoload.php';

// If you are not using Composer
// require("path/to/sendgrid-php/sendgrid-php.php");
$q1 = "test@example.com";
$from = new SendGrid\Email(null, "$q1");
$subject = "เอ่อหวัดดี";
$to = new SendGrid\Email(null, "naphat.ana@pea.co.th");
$content = new SendGrid\Content("text/plain", "ส่งแบบ mail helper class");
$mail = new SendGrid\Mail($from, $subject, $to, $content);

$apiKey = getenv('SENDGRID_API_KEY');
$sg = new \SendGrid($apiKey);
$sg->client->mail()->send()->post($mail);
/*$response = $sg->client->mail()->send()->post($mail);
echo $response->statusCode();
echo $response->headers();
echo $response->body();
echo "ส่งแล้ว";*/
