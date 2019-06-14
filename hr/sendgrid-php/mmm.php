<?php
// If you are using Composer
require 'vendor/autoload.php';

// If you are not using Composer (recommended)
// require("path/to/sendgrid-php/sendgrid-php.php");

$request_body = json_decode('{
  "personalizations": [
    {
      "to": [
        {
          "email": "aanongnart.non@pea.co.th"
        }
      ],
      "subject": "ดีจ้าส่งผ่านapp heroku sendgrid"
    }
  ],
  "from": {
    "email": "dgop4.gad@gmail.com"
  },
  "content": [
    {
      "type": "text/plain",
      "value": "Hello, แขกกี้เด้อ"
    }
  ]
}');

$apiKey = getenv('SENDGRID_API_KEY');
$sg = new \SendGrid($apiKey);

$response = $sg->client->mail()->send()->post($request_body);
echo $response->statusCode();
echo $response->body();
echo $response->headers();
