<?php
   require('conn.php');
   require('./libs/utils/messages1.php');
   require('../sendgrid-php/vendor/autoload.php');
   $accessToken = "CGBgbM7ECUjswllXeJ6MIegVud5ulkBjM0ZU+z0GIWkXUIPAm1JC9uUAsycDJHbIuHKcHrEr8GmeS1/2eVV4E/NBiutlQHAPLJXbz58Voa9uHdK3R8/E1qN0Ox0STooKId3oiFvpRAYT3my/ZkjA8QdB04t89/1O/w1cDnyilFU=";//copy ข้อความ Channel access token ตอนที่ตั้งค่า
   $content = file_get_contents('php://input');  //อ่าน json เป็น string
   $arrayJson = json_decode($content, true); //แปลง json string เป็น php array

   function make_bitly_url($url,$login,$appkey,$format = 'xml',$version = '2.0.1')
   {
	//create the URL
	$bitly = 'http://api.bit.ly/shorten?version='.$version.'&longUrl='.urlencode($url).'&login='.$login.'&apiKey='.$appkey.'&format='.$format;
	//get the url
	//could also use cURL here
	$response = file_get_contents($bitly);
	
	//parse depending on desired format
      if(strtolower($format) == 'json')
      {
         $json = @json_decode($response,true);
         return $json['results'][$url]['shortUrl'];
      }
      else //xml
      {
         $xml = simplexml_load_string($response);
         return 'https://bit.ly/'.$xml->results->nodeKeyVal->hash;
      }
   }

   #ตัวอย่าง Message Type "Text + Sticker"
   if (!is_null($arrayJson['events'])) {
      // Loop through each event
      foreach ($arrayJson['events'] as $event) {
          // Reply only when message sent is in 'text' format
          if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            //รับข้อความจากผู้ใช้
            $message = $event['message']['text'];
            //รับ id ของผู้ใช้
            $id = $event['source']['userId'];
            //รับ displayName
            $replyToken = $event['replyToken'];

      $find_existing_regis = "SELECT * FROM peaemp WHERE user_id = '$id'";
      $query = mysqli_query($conn, $find_existing_regis);
      $count_existing = mysqli_num_rows($query);
      $res = mysqli_fetch_array($query);
      $s1 = $res['active_status'];
      $s2 = $res['name'];
      $s3 = $res['surname'];
      $s4 = $res['pea_email'];
      $s5 = $res['empID'];
      $select_id3 = "SELECT * FROM peamember WHERE memberid = '".$message."'";
      $query3 = mysqli_query($conn, $select_id3);
      $nums3 = mysqli_num_rows($query3);
      $res3 = mysqli_fetch_array($query3);
      $q1 = $res3['memberid'];
      $q2 = $res3['memberuser_id'];
      $q3 = $res3['membername'];
      $q4 = $res3['membersurname'];
      $select_id4 = "SELECT * FROM peamember WHERE memberuser_id = '".$id."'";
      $query4 = mysqli_query($conn, $select_id4);
      $nums4 = mysqli_num_rows($query4);
      $res4 = mysqli_fetch_array($query4);
      $r1 = $res4['membername'];
      $r2 = $res4['membersurname'];

         if($nums4 > 0 AND ($message > 99999 && $message < 999999)){
            $txtans = "คุณได้ลงทะเบียนแล้ว ในนาม $r1 $r2";
         }
         else if($nums3 > 0 AND $nums3 <> $nums4 AND ($message > 99999 && $message < 999999)){
            $txtans = "รหัสพนักงานนี้ได้ลงทะเบียนไปแล้ว";
         }
         else if($count_existing > 0 AND $s1 == "" AND $s4 <> "" AND $message == $s5) {
            $txtans = "กรุณายืนยันการลงทะเบียนทาง $s4";
         }
         else{
            $select_id = "SELECT * FROM peaemp WHERE empID = '".$message."'";
            $query2 = mysqli_query($conn, $select_id);
            $nums = mysqli_num_rows($query2);
            $result = mysqli_fetch_array($query2);
            $t = $result['name'];
            $t2 = $result['surname'];
            $t1 = $result['active_status'];
            $email = $result['pea_email'];
            $empid = $result['empID'];
            $activation=md5($email.time());
         
            if($nums == 1 AND $s1 == "" AND $count_existing == 0){
               $shorturl = make_bitly_url("https://southpea.herokuapp.com/hr/activation.php?code=$activation",'o_5cm7sdg39v','R_9e58931faa3c4f7aae9afa35cc2982f2','json');
               $sql_regis = "UPDATE peaemp SET user_id ='$id', activation ='$activation', bitly = '$shorturl' WHERE empID = '".$message."'";
               mysqli_query($conn, $sql_regis);
               $txtans = "คุณคือ$t $t2 รึเปล่า? ถ้าใช่กรุณากรอกอีเมล @pea.co.th ของคุณ";
            }
            else if($message > 99999 && $message < 999999 AND ctype_digit($message) AND $nums == 0){
               $txtans = "ไม่มีรหัสพนักงานนี้ในสายงานการไฟฟ้า ภาค 4";
            }
            else if($nums == 1 AND $s1 == "" AND $count_existing == 1){
               $shorturl = make_bitly_url("https://southpea.herokuapp.com/hr/activation.php?code=$activation",'o_5cm7sdg39v','R_9e58931faa3c4f7aae9afa35cc2982f2','json');
               $sql_del = "UPDATE peaemp SET user_id ='', activation ='', bitly = '', pea_email = '' WHERE user_id = '$id'";
               mysqli_query($conn, $sql_del);
               $sql_regis = "UPDATE peaemp SET user_id ='$id', activation ='$activation', bitly = '$shorturl' WHERE empID = '".$message."'";
               mysqli_query($conn, $sql_regis);
               $txtans = "คุณคือ$t $t2 รึเปล่า? ถ้าใช่กรุณากรอกอีเมล @pea.co.th ของคุณ";
            }         
            else if(substr($message,-10) == "@pea.co.th" AND $count_existing > 0){
               $sql_regis = "UPDATE peaemp SET pea_email = '$message' WHERE user_id = '".$id."'";
               mysqli_query($conn, $sql_regis);
                  $messages = getBubbleMessages1($s5,$message);
                  $url = 'https://api.line.me/v2/bot/message/reply';
                  $data = [
                        'replyToken' => $replyToken,
                        'messages' => [$messages],
                  ];
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
                  return; 
            } 
            else if($nums == 0){
               $txtans = "";
            }
         }
               $messages = [ 'type' => 'text', 'text' => $txtans];
               $url = 'https://api.line.me/v2/bot/message/reply';
               $data = [
                     'replyToken' => $replyToken,
                     'messages' => [$messages],
               ];
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
               return;
      mysqli_close($conn);
}
if($event['type'] == 'postback') {
   $replyToken = $event['replyToken'];
   $fullpostback = $event['postback']['data'];
   $postbackstatus = substr($fullpostback,0,strlen($fullpostback)-6);
   $postbackid = substr($fullpostback,-6);
      $select_id = "SELECT * FROM peaemp WHERE empID = '$postbackid'";
      $sql_id = mysqli_query($conn, $select_id);
      $empinfo = mysqli_fetch_array($sql_id);
      $p0 = $empinfo['user_id'];
      $p1 = $empinfo['name'];
      $p2 = $empinfo['surname'];
      $p3 = $empinfo['pea_email'];
      $p4 = $empinfo['bitly'];
      $p5 = substr($p4,7);
      $p6 = $empinfo['send_status'];
         if($postbackstatus == 'confirm' AND $p6 == ""){
		 	
	$from = new SendGrid\Email(null, "HRrg4@pea.co.th");
	$subject = "To K.$p1 please confirm LINE bot";
	$to = new SendGrid\Email(null, "$p3");
	$content = new SendGrid\Content("text/plain", "confirm register click: https://$p5");
	$mail = new SendGrid\Mail($from, $subject, $to, $content);
	$apiKey = getenv('SENDGRID_API_KEY');
	$sg = new \SendGrid($apiKey);
	$response = $sg->client->mail()->send()->post($mail);
		 
	echo $response->statusCode();
	echo $response->headers();
	echo $response->body();	 
		 
		 
        $send_update = "UPDATE peaemp SET send_status = 'A' WHERE empID = '$postbackid'";   
        mysqli_query($conn, $send_update);
         }
            //$sendmail = mail($to,$subject,$body,$header);
               /*if($sendmail){
                  $txtans = "รับคำขอลงทะเบียน PEA HR LINE bot แล้ว กรุณายืนยันการลงทะเบียนทางอีเมล $p3";
               }else{
                  $txtans = "ไม่สามารถส่ง email ยืนยันการลงทะเบียนได้ กรุณาลงทะเบียนใหม่ในภายหลัง";
               }
         }
         else if($postbackstatus == 'cancel'){
            $txtans = "ยกเลิกคำขอลงทะเบียน $postbackid";
         }
   $messages = [ 'type' => 'text', 'text' => $txtans];
	$url = 'https://api.line.me/v2/bot/message/reply';
	$data = [
				'replyToken' => $p0,
				'messages' => [$messages]
			];
	$post = json_encode($data);
	$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$result = curl_exec($ch);
   curl_close($ch);
   return;*/
}
}}
?>
