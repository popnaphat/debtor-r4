<?php
date_default_timezone_set("Asia/Bangkok");
  require('./majorDebt/conn.php');
  require('./libs/utils/date_thai.php');
  require('./libs/utils/date_utils.php');
  require('./libs/utils/messages.php');
  
    // line access token
  $access_token = 'CGBgbM7ECUjswllXeJ6MIegVud5ulkBjM0ZU+z0GIWkXUIPAm1JC9uUAsycDJHbIuHKcHrEr8GmeS1/2eVV4E/NBiutlQHAPLJXbz58Voa9uHdK3R8/E1qN0Ox0STooKId3oiFvpRAYT3my/ZkjA8QdB04t89/1O/w1cDnyilFU=';

  $fetch_notify_office = "SELECT * FROM peamember WHERE memberid = '505122'";
  $notify_office = mysqli_query($conn, $fetch_notify_office) or die($fetch_notify_office);
  
      while($manager = $notify_office->fetch_assoc()){

      $messages = [
        "type"=> "text",
        "text"=> "(!)(!)ขอความกรุณาผู้ใช้งานทำแบบสำรวจความพึงพอใจของผู้ใช้งาน LINE ALERT BOT ครั้งที่ 1 \nคลิก(pencil)(pencil)>>https://forms.gle/ZDCyN9r766onBy6L8",
        "type"=> "sticker",
        "packageId"=> "11539",
        "stickerId"=> "52114115"
      ];
      $data = [
        'to' => $manager['memberuser_id'],
        'messages' => [$messages]
      ];
      $url = 'https://api.line.me/v2/bot/message/push';
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
    }
    echo "this script run successful.";
 
  
?>
