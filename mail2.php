<?php
$to = "aanongnart.non@pea.co.th";
$subject = "HTML email";

$message = "77777";

// Always set content-type when sending HTML email


// More headers
$headers = "From: webmaster@example.com";


$aa = mail($to,$subject,$message,$headers);
if($aa){
echo "send success";
}
else{
echo "send false";
}
?>
