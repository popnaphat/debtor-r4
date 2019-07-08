<?php
date_default_timezone_set("Asia/Bangkok");
  require('./majorDebt/conn.php');
  require('./libs/utils/date_thai.php');
  require('./libs/utils/date_utils.php');
  require('./libs/utils/messages2.php');

  // line access token
  $access_token = 'CGBgbM7ECUjswllXeJ6MIegVud5ulkBjM0ZU+z0GIWkXUIPAm1JC9uUAsycDJHbIuHKcHrEr8GmeS1/2eVV4E/NBiutlQHAPLJXbz58Voa9uHdK3R8/E1qN0Ox0STooKId3oiFvpRAYT3my/ZkjA8QdB04t89/1O/w1cDnyilFU=';

  

  // count complaint 
  $fetch_notify_office = "SELECT * FROM peamember m 
  JOIN peaemp ON m.memberid = peaemp.empID 
  JOIN pea_office o ON LEFT(peaemp.dept_change_code,11) = LEFT(o.unit_code,11)
  GROUP BY m.memberid";
  $notify_office = mysqli_query($conn, $fetch_notify_office) or die($fetch_notify_office);
  if(mysqli_num_rows($notify_office) == 0){
    return;
  }
  // find maximum id
  $find_maximum_id = "SELECT * FROM tbl_log_notify";
  $log_object = mysqli_query($conn, $find_maximum_id) or die($find_maximum_id);
  $log_id = mysqli_num_rows($log_object);
  $getlast_row = "SELECT * FROM tbl_log_notify ORDER BY id DESC LIMIT 1";
  $query_lastrow = mysqli_query($conn, $getlast_row);
  $lastrow = mysqli_fetch_array($query_lastrow);
  $dayissues = substr($lastrow['notify_timestamp'],0,10);
  $today = DateThai(date("Y-m-d"));
      if($dayissues == date("Y-m-d")){
      echo "this script has been run for today.";
      }
      else{
      while($manager = $notify_office->fetch_assoc()){
      // auto increment with manual
      $log_id = $log_id + 1;
      // log push data
			$timestamp = date('Y-m-d H:i:s');
      $log_individual_notify = "INSERT INTO tbl_log_notify(id, manager_id, notify_timestamp) ".
                              "VALUES($log_id, ".$manager['memberid'].", '$timestamp')";
      mysqli_query($conn, $log_individual_notify) or die($log_individual_notify);
        //count employee each office
        $sql3 = "SELECT * from debtor 
        join pea_office on pea_office.unit_name like concat('%',right(debtor.dept_name, CHAR_LENGTH(debtor.dept_name)-4),'%') 
        WHERE region2 = "J" GROUP BY debtor.cus_number";
        $query3 = mysqli_query($conn,$sql3);
        $countemp = mysqli_num_rows($query3);
        
      $messages = getBubbleMessages($countemp, DateThai(date("Y-m-d")), $manager['dept_name'], $manager['dept_change_code']);
      /*$messages = [
        "type"=> "text",
        "text"=> "Individual Alert :\n\nรายชื่อพนักงานที่ครบกำหนดปรับระดับครั้งแรกของ ".$manager['dept_name']." \n\nประจำวันที่ ".$today
        ." \n\nhttps://allbackoffice.000webhostapp.com/hr/req_office1.php?REQ=".$manager['dept_name'].""
      ];*/

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
    return;
  }
