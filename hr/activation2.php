<?php
    date_default_timezone_set("Asia/Bangkok");
	require('conn.php');
	require('./libs/utils/messages.php');
    $code = $_POST['code'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $userId = $_POST['userId'];
	$status = $_POST['status'];
	$empID = $_POST['empID'];
	$email = $_POST['email'];
	$cDate = date("Y-m-d H:i:s");
        if($status == 'A'){
            echo "ท่านได้ลงทะเบียนแล้ว";
        }
        else{
        $update = "UPDATE peaemp SET active_status = 'A' WHERE activation='$code'";
		$result1 = mysqli_query($conn,$update);
		$insert = "INSERT INTO peamember (memberid, memberuser_id, membername, membersurname, memberpea_email, datetime_regis) VALUES ('$empID', '$userId', '$name', '$surname', '$email', '$cDate')";
		$result2 = mysqli_query($conn,$insert);
        echo "ลงทะเบียนเสร็จสิ้น";

		$accessToken = "CGBgbM7ECUjswllXeJ6MIegVud5ulkBjM0ZU+z0GIWkXUIPAm1JC9uUAsycDJHbIuHKcHrEr8GmeS1/2eVV4E/NBiutlQHAPLJXbz58Voa9uHdK3R8/E1qN0Ox0STooKId3oiFvpRAYT3my/ZkjA8QdB04t89/1O/w1cDnyilFU=";
		$texts = "คุณ $name $surname ลงทะเบียนเสร็จสิ้น";
		$messages = [ 'type' => 'text', 'text' => $texts];
		
		$data = [
			  'to' => $userId,
			  'messages' => [$messages]
		];
		$url = 'https://api.line.me/v2/bot/message/push';
		$post = json_encode($data);
		$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $accessToken);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
        curl_close($ch);
    }
