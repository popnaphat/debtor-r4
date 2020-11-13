 <?php  
    require('./hr/sendgrid-php/sendgrid-php.php');
			$from = new SendGrid\Email(null, "rg4@pea.co.th");
            $content = new SendGrid\Content("text/html", "https://southpea.herokuapp.com/hr/activation.php?code=");
            $subject = "To sir please confirm LINE bot";
            $to = new SendGrid\Email(null, "$p3");
            $mail = new SendGrid\Mail($from, $subject, $to, $content);
            $apiKey = getenv('SENDGRID_API_KEY');
            $sg = new \SendGrid($apiKey);
            $sg->client->mail()->send()->post($mail);

			?>