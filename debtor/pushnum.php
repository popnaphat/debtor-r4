<?php 
$access_token = 'CGBgbM7ECUjswllXeJ6MIegVud5ulkBjM0ZU+z0GIWkXUIPAm1JC9uUAsycDJHbIuHKcHrEr8GmeS1/2eVV4E/NBiutlQHAPLJXbz58Voa9uHdK3R8/E1qN0Ox0STooKId3oiFvpRAYT3my/ZkjA8QdB04t89/1O/w1cDnyilFU=';
$headers = array('Authorization: Bearer ' . $access_token);


  function httpGet($url)
  {
      $ch = curl_init();  
   
      curl_setopt($ch,CURLOPT_URL,$url);
      curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
      curl_setopt($ch,CURLOPT_HTTPHEADER, $headers); 
      $output=curl_exec($ch);
   
      curl_close($ch);
      return $output;
  }
   
  echo httpGet("https://api.line.me/v2/bot/message/quota");
?>