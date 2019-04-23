<?php

		$to="aanongnart.non@pea.co.th";
            $subject="Email verification for PEA HR LINE bot";
            $header .= "MIME-Version: 1.0"."\r\n";
            $header .= "Content-type: text/html; charset=UTF-8"."\r\n";
            $header .= 'From:กองจัดการงานทั่วไป ภาค 4 <dgop4.gad@gmail.com>'."\r\n";
            $body .="<html><body><div><div>สวัสดีคุณpop, </div>";
            $body .="<div style='padding-top:8px;'>กรุณายืนยันการลงทะเบียน PEA HR LINE bot</div><div style='padding-top:10px;'><a href='https://allbackoffice.000webhostapp.com/hr/activation.php?code=9998'><button>ยืนยันการลงทะเบียน</button></a></div></div>
            </body></html>";
            $flgSend = mail($to,$subject,$body,$header);
	if($flgSend)
	{
		echo "Mail sending.";
	}
	else
	{
		echo "Mail cannot sendlll";
	}
?>
