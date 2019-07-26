<?php 
$access_token = 'CGBgbM7ECUjswllXeJ6MIegVud5ulkBjM0ZU+z0GIWkXUIPAm1JC9uUAsycDJHbIuHKcHrEr8GmeS1/2eVV4E/NBiutlQHAPLJXbz58Voa9uHdK3R8/E1qN0Ox0STooKId3oiFvpRAYT3my/ZkjA8QdB04t89/1O/w1cDnyilFU=';
$headers = array('Authorization: Bearer ' . $access_token);
      
$url = "https://api.line.me/v2/bot/message/quota/consumption";
//  Initiate curl

$cURL = curl_init();

curl_setopt($cURL, CURLOPT_URL, $url);
curl_setopt($cURL, CURLOPT_HTTPGET, true);
curl_setopt($cURL, CURLOPT_HTTPHEADER, $headers);
curl_setopt($cURL, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($cURL);
curl_close($cURL);

$json = json_decode($result, true);

echo $json['totalUsage'];
//$remain = 1000 - $numsend;
//echo $remain;
?>