<?php
date_default_timezone_set("Asia/Bangkok");
  require('./majorDebt/conn.php');
  require('./libs/utils/date_thai.php');
  require('./libs/utils/date_utils.php');
  require('./libs/utils/messages.php');

  set_time_limit ( 60 );
    // line access token
  $access_token = 'CGBgbM7ECUjswllXeJ6MIegVud5ulkBjM0ZU+z0GIWkXUIPAm1JC9uUAsycDJHbIuHKcHrEr8GmeS1/2eVV4E/NBiutlQHAPLJXbz58Voa9uHdK3R8/E1qN0Ox0STooKId3oiFvpRAYT3my/ZkjA8QdB04t89/1O/w1cDnyilFU=';

  // check holiday
  /*$todaytime = strtotime('today');
  $todaydate = date('Y-m-d', $todaytime);
  $fetch_holiday = "SELECT * FROM tbl_holiday WHERE status = 'A' AND holiday_date = '$todaydate'";
  $holiday_list = mysqli_query($conn, $fetch_holiday);

  if(isWeekend($todaydate) || mysqli_num_rows($holiday_list) > 0){
      return;
  }*/

  // count complaint 
  // $fetch_notify_office = "SELECT m.memberid,o.sap_code,o.dept_name,m.memberuser_id FROM peamember m 
  // JOIN peaemp ON m.memberid = peaemp.empID 
  // JOIN pea_office o ON LEFT(peaemp.dept_change_code,11) = LEFT(o.unit_code,11)
  // JOIN debtor on o.sap_code = debtor.sap_code 
  // GROUP BY m.memberid";
  $fetch_notify_office = "SELECT m.memberid,o.sap_code,o.dept_name,m.memberuser_id FROM peamember m 
  JOIN peaemp ON m.memberid = peaemp.empID 
  JOIN pea_office o ON LEFT(peaemp.dept_change_code,11) = LEFT(o.unit_code,11)
  JOIN (SELECT sap_code FROM debtor 
UNION
SELECT sap_code FROM debtor_kpi 
UNION
SELECT sap_code FROM debtor_kpi2 
UNION
SELECT sap_code FROM debtor_kpi3 
UNION
SELECT sap_code FROM debtor_kpi4 
UNION
SELECT sap_code FROM debtor_kpi5 ) sp ON o.sap_code = sp.sap_code GROUP BY m.memberid
";
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
  //$today = DateThai(date("Y-m-d"));
  // $crecord2 = "SELECT * FROM tbl_log_csv_debt1 ORDER BY id DESC LIMIT 1";
	// $crecord1 = mysqli_fetch_array(mysqli_query($conn,$crecord2));
  // $ccc = $crecord1['file_upload_timestamp'];
  // $drecord2 = "SELECT * FROM tbl_log_csv_debt2 ORDER BY id DESC LIMIT 1";
	// $drecord1 = mysqli_fetch_array(mysqli_query($conn,$drecord2));
  // $ddd = $drecord1['file_upload_timestamp'];
  
      if($dayissues == date("Y-m-d")){
      echo "this script has been run for today.";
      }
      else{
      while($manager = $notify_office->fetch_assoc()){
      // auto increment with manual
      $log_id = $log_id + 1;
      // log push data
			$timestamp = date('Y-m-d H:i:s');
      $log_individual_notify = "INSERT INTO tbl_log_notify(id, manager_id, notify_timestamp, view_stat) ".
                              "VALUES('$log_id', ".$manager['memberid'].", '$timestamp', 'N')";
      mysqli_query($conn, $log_individual_notify) or die($log_individual_notify);
        //count employee each office
        // $sql3 = "SELECT * from debtor 
        // join pea_office on pea_office.sap_code = debtor.sap_code 
        // WHERE debtor.sap_code = '".$manager['sap_code']."' GROUP BY debtor.cus_number";
        // $query3 = mysqli_query($conn,$sql3);
        // $countemp = mysqli_num_rows($query3);

        // $sql4 = "SELECT * from debtor_kpi 
        // join pea_office on pea_office.sap_code = debtor_kpi.sap_code 
        // WHERE debtor_kpi.sap_code = '".$manager['sap_code']."' GROUP BY debtor_kpi.cus_number";
        // $query4 = mysqli_query($conn,$sql4);
        // $countemp4 = mysqli_num_rows($query4);
        
      $messages = getBubbleMessages($log_id, $conn, $manager['dept_name'], $manager['sap_code']);
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

