<?php 
//function getnumsend(){
$access_token = 'CGBgbM7ECUjswllXeJ6MIegVud5ulkBjM0ZU+z0GIWkXUIPAm1JC9uUAsycDJHbIuHKcHrEr8GmeS1/2eVV4E/NBiutlQHAPLJXbz58Voa9uHdK3R8/E1qN0Ox0STooKId3oiFvpRAYT3my/ZkjA8QdB04t89/1O/w1cDnyilFU=';
      
$json = '{
    "size": {
      "width": 2500,
      "height": 843
    },
    "selected": true,
    "name": "Rich Menu 1",
    "chatBarText": "คลิกบอลที่ชอบ",
    "areas": [
      {
        "bounds": {
          "x": 1114,
          "y": 351,
          "width": 330,
          "height": 350
        },
        "action": {
          "type": "message",
          "text": "6"
        }
      },
    ]
  }';
 $data = json_decode($json);
 $url = 'https://api.line.me/v2/bot/richmenu';
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
//echo "<br>";
//$remain = 1000 - $json['totalUsage'];
//echo $remain;
?>