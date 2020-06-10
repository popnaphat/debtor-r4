<?php
    define("LINE_API","https://notify-api.line.me/api/notify");
    //$token = "ECKxt9T9iZ2YOjjS0ZHbDvZOQ1U9jqmL5HWcyUypNYs";
	$token = "640dzk9zGNy1OKmDbjAirntsQkuNnjoSMuEhoczdUxH";
    //$str = "\n\nUser IP Address - ". $_SERVER['REMOTE_ADDR']." Online now!";
	$str = 'https://games.shopee.co.th/universal-link/farm/share.html?skey=8ae6d87971d9dd9b85aa62e22a0f540a&schannel=copyLink';
	$chOne = curl_init(); 
	curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
	curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0); 
	curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt($chOne, CURLOPT_POST, 1); 
	curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=".$str); 
	$headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$token.'', );
	curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
	curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1); 
	$result = curl_exec($chOne); 

	//Result error 
	if(curl_error($chOne)) 
	{ 
		echo 'error:' . curl_error($chOne); 
	} 
	else { 
		$result_ = json_decode($result, true); 
		echo "status : ".$result_['status']; echo "message : ". $result_['message'];
	} 
	curl_close($chOne);   