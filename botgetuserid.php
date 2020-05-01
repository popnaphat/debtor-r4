<?php
   require('conn.php');
   require('./hr/libs/utils/messages1.php');
   require('./hr/sendgrid-php/sendgrid-php.php');
   require('./debtor/libs/utils/messages.php');
   require('./debtor/libs/utils/messages2.php');
   require('./debtor/libs/utils/messages3.php');
   //require('./debtor/libs/utils/messages4.php');
   require('./debtor/timezone.php');
   $accessToken = "CGBgbM7ECUjswllXeJ6MIegVud5ulkBjM0ZU+z0GIWkXUIPAm1JC9uUAsycDJHbIuHKcHrEr8GmeS1/2eVV4E/NBiutlQHAPLJXbz58Voa9uHdK3R8/E1qN0Ox0STooKId3oiFvpRAYT3my/ZkjA8QdB04t89/1O/w1cDnyilFU=";//copy ข้อความ Channel access token ตอนที่ตั้งค่า
   $content = file_get_contents('php://input');  //อ่าน json เป็น string
   $arrayJson = json_decode($content, true); //แปลง json string เป็น php array

  /*function make_bitly_url($url,$login,$appkey,$format = 'xml',$version = '2.0.1')
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
   }*/

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

      $find_existing_regis = "SELECT * FROM peaemp e left join peaemail m on e.empID = m.empcode WHERE user_id = '$id'";
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
      $r0 = $res4['memberid'];
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
         else if(strtolower($message) == "help"){
            $txtans = "การลงทะเบียนบอททำได้ 2 วิธี\nวิธีที่ 1.พิมพ์ pea ตามด้วยรหัสพนักงาน เช่น pea505093\nวิธีที่ 2.พิมพ์รหัสพนักงานแล้วทำตามคำแนะนำของบอท";
         }
         
         
         // else if($nums4 > 0 AND strtolower($message) == "qwerty"){
         //    $messages = getBubbleMessages4("14", "4 ก.ย.62", "บ้านละลม", "J01303");
         //          $data = [
         //             'replyToken' => $replyToken,
         //             'messages' => [$messages]
         //          ];
         //          $url = 'https://api.line.me/v2/bot/message/reply';
         //          $post = json_encode($data);
         //          $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $accessToken);
         //          $ch = curl_init($url);
         //          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
         //          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         //          curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
         //          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
         //          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
         //          $result = curl_exec($ch);
         //          curl_close($ch);
         //          return;
         // }
         else if($nums4 > 0 AND trim(strtolower($message)) == "vqr"){
            $data = "SELECT * FROM peaemp e left join peaemail m on e.empID = m.empcode
            left JOIN pea_office o ON LEFT(e.dept_change_code,11) = LEFT(o.unit_code,11)
            WHERE e.empID = '$r0' GROUP BY e.empID";
            $querydata = mysqli_query($conn, $data);
            $result = mysqli_fetch_array($querydata);
            $empID = $result['empID'];            
            $name = $result['name'];
            $surname = $result['surname'];
            $email = $result['pea_email'];
            $sapcode = $result['sap_code'];
            $dept_name =$result['dept_name'];
               $sapnum = substr($sapcode,1);
               $sapreg = substr($sapcode,0,1);
               if($sapreg == 'J'){
                  $regionname = "กฟต.1 เพชรบุรี";
               }else if($sapreg == 'K'){
                  $regionname = "กฟต.2 นครศรีธรรมราช";
               }else if($sapreg == 'L'){
                  $regionname = "กฟต.3 ยะลา";
               }
               $messages = '{
                  "type": "text",
                  "text": "Hello Quick Reply!",
                  "quickReply": {
                    "items": [
                      {
                        "type": "action",
                        "action": {
                          "type": "cameraRoll",
                          "label": "Camera Roll"
                        }
                      },
                      {
                        "type": "action",
                        "action": {
                          "type": "camera",
                          "label": "Camera"
                        }
                      },
                      {
                        "type": "action",
                        "action": {
                          "type": "location",
                          "label": "Location"
                        }
                      },
                      {
                        "type": "action",
                        "imageUrl": "https://cdn1.iconfinder.com/data/icons/mix-color-3/502/Untitled-1-512.png",
                        "action": {
                          "type": "message",
                          "label": "Message",
                          "text": "Hello World!"
                        }
                        },
                      {
                        "type": "action",
                        "action": {
                          "type": "postback",
                          "label": "Postback",
                          "data": "action=buy&itemid=123",
                          "displayText": "Buy"
                        }
                        },
                      {
                        "type": "action",
                        "imageUrl": "https://icla.org/wp-content/uploads/2018/02/blue-calendar-icon.png",
                        "action": {
                          "type": "datetimepicker",
                          "label": "Datetime Picker",
                          "data": "storeId=12345",
                          "mode": "datetime",
                          "initial": "2018-08-10t00:00",
                          "max": "2018-12-31t23:59",
                          "min": "2018-08-01t00:00"
                        }
                      }
                    ]
                  }
                }';
               $msg = json_decode($messages);
               $data = [
                     'replyToken' => $replyToken,
                     'messages' => [$msg]
                  ];
                  $url = 'https://api.line.me/v2/bot/message/reply';
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
         else if($nums4 > 0 AND trim(strtolower($message)) == "myalert"){
            $data = "SELECT * FROM peaemp e left join peaemail m on e.empID = m.empcode
            left JOIN pea_office o ON LEFT(e.dept_change_code,11) = LEFT(o.unit_code,11)
            WHERE e.empID = '$r0' GROUP BY e.empID";
            $querydata = mysqli_query($conn, $data);
            $result = mysqli_fetch_array($querydata);
            $empID = $result['empID'];            
            $name = $result['name'];
            $surname = $result['surname'];
            $email = $result['pea_email'];
            $sapcode = $result['sap_code'];
            $dept_name =$result['dept_name'];
               $sapnum = substr($sapcode,1);
               $sapreg = substr($sapcode,0,1);
               if($sapreg == 'J'){
                  $regionname = "กฟต.1 เพชรบุรี";
               }else if($sapreg == 'K'){
                  $regionname = "กฟต.2 นครศรีธรรมราช";
               }else if($sapreg == 'L'){
                  $regionname = "กฟต.3 ยะลา";
               }

            if($sapcode == 'Z00000'){
               /*$selectcdb = "SELECT * FROM debtor";
               $cdb = mysqli_query($conn,$selectcdb);
               $countdeb = mysqli_num_rows($cdb);
               
               $selectglr = "SELECT * FROM tbl_log_csv_debt1 ORDER BY id DESC LIMIT 1";
               $glr = mysqli_query($conn,$selectglr);
               $getlastrow = mysqli_fetch_array($glr);
               $dateupload = $getlastrow['file_upload_timestamp'];
   
               $selectcp = "SELECT * from debtor GROUP BY sap_code";
               $cp = mysqli_query($conn,$selectcp);
               $countpea = mysqli_num_rows($cp);
               ///////////////////////////////////////
               $selectcdb2 = "SELECT * FROM debtor_kpi";
               $cdb2 = mysqli_query($conn,$selectcdb2);
               $countdeb2 = mysqli_num_rows($cdb2);
               
               $selectglr2 = "SELECT * FROM tbl_log_csv_debt2 ORDER BY id DESC LIMIT 1";
               $glr2 = mysqli_query($conn,$selectglr2);
               $getlastrow2 = mysqli_fetch_array($glr2);
               $dateupload2 = $getlastrow2['file_upload_timestamp'];
   
               $selectcp2 = "SELECT * from debtor_kpi GROUP BY sap_code";
               $cp2 = mysqli_query($conn,$selectcp2);
               $countpea2 = mysqli_num_rows($cp2);
               
               if($countdeb == 0 AND $countdeb2 == 0){
                  $txtans = "คุณไม่มีเรื่องแจ้งเตือนสำหรับวันนี้";
                  $messages = [ 'type' => 'text', 'text' => $txtans];
               }
               else{
               $messages = getBubbleMessages3($countpea, $countdeb, $dateupload,$countpea2, $countdeb2, $dateupload2);
               }*/
               $messages = getBubbleMessages3($conn);
               
               $data = [
                     'replyToken' => $replyToken,
                     'messages' => [$messages]
                  ];
                  $url = 'https://api.line.me/v2/bot/message/reply';
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
            else if($sapnum == '00000' AND $sapreg <> 'Z'){
               // $selectcdb = "SELECT * FROM debtor where left(sap_code,1) = '$sapreg'";
               // $cdb = mysqli_query($conn,$selectcdb);
               // $countdeb = mysqli_num_rows($cdb);
               
               // $selectglr = "SELECT * FROM tbl_log_csv_debt1 where region = '$sapreg' ORDER BY id DESC LIMIT 1";
               // $glr = mysqli_query($conn,$selectglr);
               // $getlastrow = mysqli_fetch_array($glr);
               // $dateupload = $getlastrow['file_upload_timestamp'];
   
               // $selectcp = "SELECT dept_name, sap_code from debtor where left(sap_code,1) = '$sapreg' GROUP BY sap_code";
               // $cp = mysqli_query($conn,$selectcp);
               // $countpea = mysqli_num_rows($cp);
               // ///////////////////////////////////////////////
               // $selectcdb2 = "SELECT * FROM debtor_kpi where left(sap_code,1) = '$sapreg'";
               // $cdb2 = mysqli_query($conn,$selectcdb2);
               // $countdeb2 = mysqli_num_rows($cdb2);
               
               // $selectglr2 = "SELECT * FROM tbl_log_csv_debt2 where region = '$sapreg' ORDER BY id DESC LIMIT 1";
               // $glr2 = mysqli_query($conn,$selectglr2);
               // $getlastrow2 = mysqli_fetch_array($glr2);
               // $dateupload2 = $getlastrow2['file_upload_timestamp'];
   
               // $selectcp2 = "SELECT dept_name, sap_code from debtor_kpi where left(sap_code,1) = '$sapreg' GROUP BY sap_code";
               // $cp2 = mysqli_query($conn,$selectcp2);
               // $countpea2 = mysqli_num_rows($cp2); 
               
               // if($countdeb == 0){
               //    $txtans = "คุณไม่มีเรื่องแจ้งเตือนสำหรับวันนี้";
               //    $messages = [ 'type' => 'text', 'text' => $txtans];
               // }
               // else{
               // $messages = getBubbleMessages2($countpea, $countdeb, $dateupload, $countpea2, $countdeb2, $dateupload2,$regionname, $sapreg);
               // }
               $messages = getBubbleMessages2($conn, $regionname, $sapreg);

               $data = [
                     'replyToken' => $replyToken,
                     'messages' => [$messages]
                  ];
                  $url = 'https://api.line.me/v2/bot/message/reply';
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
            else if($sapnum <> '00000'){
                           
               // $selectglr = "SELECT pea_office.dept_name FROM debtor join pea_office on pea_office.sap_code = debtor.sap_code where debtor.sap_code = '$sapcode' LIMIT 1";
               // $glr = mysqli_query($conn,$selectglr);
               // $getlastrow = mysqli_fetch_array($glr);               
               // $dept_name = $getlastrow['dept_name'];

               /*$selectcdb = "SELECT * FROM debtor where sap_code = '$sapcode'";
               $cdb = mysqli_query($conn,$selectcdb);
               $countdeb = mysqli_num_rows($cdb);

               $selectcp = "SELECT * FROM tbl_log_csv_debt1 where region = '$sapreg' ORDER BY id DESC LIMIT 1";
               $cp = mysqli_query($conn,$selectcp);
               $getlastrowcp = mysqli_fetch_array($cp);
               $dateupload = $getlastrowcp['file_upload_timestamp'];
               //////////////////////////////////
               $selectcdb2 = "SELECT * FROM debtor_kpi where sap_code = '$sapcode'";
               $cdb2 = mysqli_query($conn,$selectcdb2);
               $countdeb2 = mysqli_num_rows($cdb2);

               $selectcp2 = "SELECT * FROM tbl_log_csv_debt2 where region = '$sapreg' ORDER BY id DESC LIMIT 1";
               $cp2 = mysqli_query($conn,$selectcp2);
               $getlastrowcp2 = mysqli_fetch_array($cp2);
               $dateupload2 = $getlastrowcp2['file_upload_timestamp'];
   
               if($countdeb == 0 AND $countdeb2 == 0){
                  $txtans = "คุณไม่มีเรื่องแจ้งเตือนสำหรับวันนี้";
                  $messages = [ 'type' => 'text', 'text' => $txtans];
               }
               else{
               $messages = getBubbleMessages("xx",$countdeb, $dateupload,$countdeb2, $dateupload2, $dept_name, $sapcode);
               }*/
               $messages = getBubbleMessages("xx", $conn, $dept_name, $sapcode);
               
               $data = [
                     'replyToken' => $replyToken,
                     'messages' => [$messages]
                  ];
                  $url = 'https://api.line.me/v2/bot/message/reply';
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
         }
         //////
         else if($nums4 > 0 AND strtolower(substr($message,0,2)) == "dt"){
            $peaname = trim(substr($message,2));
            ///permission check
            $data = "SELECT * FROM peaemp e left join peaemail m on e.empID = m.empcode
            left JOIN pea_office o ON LEFT(e.dept_change_code,11) = LEFT(o.unit_code,11)
            WHERE e.empID = '$r0' GROUP BY e.empID";
            $querydata = mysqli_query($conn, $data);
            $result = mysqli_fetch_array($querydata);
            $empID = $result['empID'];
            //$userId = $result['user_id'];
            $name = $result['name'];
            $surname = $result['surname'];
            $email = $result['pea_email'];
            $sapcode = $result['sap_code'];
               $sapnum = substr($sapcode,1);
               $sapreg = substr($sapcode,0,1);

            if($sapnum == '00000' AND $sapreg <> 'Z'){
               // $lastpea1 = "SELECT * FROM debtor WHERE left(sap_code,1) LIKE concat('%','$sapreg','%') AND dept_name LIKE concat('%','$peaname','%') limit 1";
               // $lastpea2 = mysqli_query($conn, $lastpea1);
               // $lastpea3 = mysqli_fetch_array($lastpea2);
               // $pn = $lastpea3['dept_name'];
               // $sc = $lastpea3['sap_code'];
               // $findpea1 = "SELECT * FROM debtor WHERE left(sap_code,1) LIKE concat('%','$sapreg','%') AND sap_code = '$sc'";
               // $findpea2 = mysqli_query($conn, $findpea1);
               // $findpea3 = mysqli_num_rows($findpea2);
               // ////
               // $overdue1 = "SELECT * FROM debtor_kpi WHERE left(sap_code,1) LIKE concat('%','$sapreg','%') AND dept_name LIKE concat('%','$peaname','%') limit 1";
               // $overdue2 = mysqli_query($conn, $overdue1);
               // $overdue3 = mysqli_fetch_array($overdue2);
               // $zz = $overdue3['dept_name'];
               // $zzz = $overdue3['sap_code'];
               // $od1 = "SELECT * FROM debtor_kpi WHERE left(sap_code,1) LIKE concat('%','$sapreg','%') AND sap_code = '$zzz'";
               // $od2 = mysqli_query($conn, $od1);
               // $od3 = mysqli_num_rows($od2);
               /////
               $choose = "SELECT * FROM flexmsghead";
               $choose_query = mysqli_query($conn,$choose);
               $number = 1;
               ///get search result
               $overdue1 = "SELECT * FROM pea_office WHERE left(sap_code,1) LIKE concat('%','$sapreg','%') AND dept_name LIKE concat('%','$peaname','%') AND sap_code NOT LIKE concat('%','00000','%') limit 1";
               $overdue2 = mysqli_query($conn, $overdue1);
               $overdue3 = mysqli_fetch_array($overdue2);
               $zz = $overdue3['dept_name'];
               $zzz = $overdue3['sap_code'];
               $txtans = "";
               if(mysqli_num_rows($overdue2) > 0){
               while($eachhd = $choose_query->fetch_assoc()){

                  $selectcdb = "SELECT * FROM ".$eachhd['tblname_db']." where sap_code = '$zzz' ";
                  $cdb = mysqli_query($conn,$selectcdb);
                  $countdeb = mysqli_num_rows($cdb);

                     $txtans .= "$number.".$eachhd['tblname_th']."ของ$zz มี $countdeb บิล ";
                  if($countdeb > 0){
                     $txtans .= "คลิก>>".$eachhd['center_url']."/req_office.php?REQ=$zzz ";
                  }
                  $txtans .= "\n";
                  $number++;
               }
            }
               else{
                  $txtans = "ไม่มี กฟฟ.นี้อยู่ในความดูแลของกฟข.ที่ท่านสังกัด";
               }
               // else if($findpea3 <> 0 AND $od3 == 0){
               //    $txtans = "$pn มีลูกหนี้ค่าไฟฟ้าเอกชนรายใหญ่ค้างชำระเกินเงินประกัน $findpea3 ราย คลิก>>https://southpea.herokuapp.com/debtor/majorDebt/req_office.php?REQ=$sc";
               // }
               // else if($findpea3 == 0 AND $od3 <> 0){
               //    $txtans = "$zz มีลูกหนี้ค่าไฟฟ้าเอกชนรายใหญ่ค้างชำระเกินกำหนด $od3 ราย คลิก>>https://southpea.herokuapp.com/debtor/overdue/req_office.php?REQ=$zzz";
               // }
               // else if($findpea3 <> 0 AND $od3 <> 0){
               //    $txtans = "1.$pn มีลูกหนี้ค่าไฟฟ้าเอกชนรายใหญ่ค้างชำระเกินเงินประกัน $findpea3 ราย คลิก>>https://southpea.herokuapp.com/debtor/majorDebt/req_office.php?REQ=$sc \n2.$zz มีลูกหนี้ค่าไฟฟ้าเอกชนรายใหญ่ค้างชำระเกินกำหนด $od3 ราย คลิก>>https://southpea.herokuapp.com/debtor/overdue/req_office.php?REQ=$zzz";
               // }
            }
            else if($sapcode == 'Z00000'){               
               // $lastpea1 = "SELECT * FROM debtor WHERE dept_name LIKE concat('%','$peaname','%') limit 1";
               // $lastpea2 = mysqli_query($conn, $lastpea1);
               // $lastpea3 = mysqli_fetch_array($lastpea2);
               // $pn = $lastpea3['dept_name'];
               // $sc = $lastpea3['sap_code'];
               // $findpea1 = "SELECT * FROM debtor WHERE sap_code = '$sc'";
               // $findpea2 = mysqli_query($conn, $findpea1);
               // $findpea3 = mysqli_num_rows($findpea2);
               // ///
               // $overdue1 = "SELECT * FROM debtor_kpi WHERE dept_name LIKE concat('%','$peaname','%') limit 1";
               // $overdue2 = mysqli_query($conn, $overdue1);
               // $overdue3 = mysqli_fetch_array($overdue2);
               // $zz = $overdue3['dept_name'];
               // $zzz = $overdue3['sap_code'];
               // $od1 = "SELECT * FROM debtor_kpi WHERE sap_code = '$zzz'";
               // $od2 = mysqli_query($conn, $od1);
               // $od3 = mysqli_num_rows($od2);

               // if($findpea3 == 0 AND $od3 == 0){
               //    $txtans = "กฟฟ.นี้ไม่มีลูกหนี้ค่าไฟฟ้าเอกชนรายใหญ่ค้างชำระ";
               // }
               // else if($findpea3 <> 0 AND $od3 == 0){
               //    $txtans = "$pn มีลูกหนี้ค่าไฟฟ้าเอกชนรายใหญ่ค้างชำระเกินเงินประกัน $findpea3 ราย คลิก>>https://southpea.herokuapp.com/debtor/majorDebt/req_office.php?REQ=$sc";
               // }
               // else if($findpea3 == 0 AND $od3 <> 0){
               //    $txtans = "$zz มีลูกหนี้ค่าไฟฟ้าเอกชนรายใหญ่ค้างชำระเกินกำหนด $od3 ราย คลิก>>https://southpea.herokuapp.com/debtor/overdue/req_office.php?REQ=$zzz";
               // }
               // else if($findpea3 <> 0 AND $od3 <> 0){
               //    $txtans = "1.$pn มีลูกหนี้ค่าไฟฟ้าเอกชนรายใหญ่ค้างชำระเกินเงินประกัน $findpea3 ราย คลิก>>https://southpea.herokuapp.com/debtor/majorDebt/req_office.php?REQ=$sc \n2.$zz มีลูกหนี้ค่าไฟฟ้าเอกชนรายใหญ่ค้างชำระเกินกำหนด $od3 ราย คลิก>>https://southpea.herokuapp.com/debtor/overdue/req_office.php?REQ=$zzz";
               // }
               $choose = "SELECT * FROM flexmsghead";
               $choose_query = mysqli_query($conn,$choose);
               $number = 1;
               ///get search result
               $overdue1 = "SELECT * FROM pea_office WHERE dept_name LIKE concat('%','$peaname','%') AND sap_code NOT LIKE concat('%','00000','%') limit 1";
               $overdue2 = mysqli_query($conn, $overdue1);
               $overdue3 = mysqli_fetch_array($overdue2);
               $zz = $overdue3['dept_name'];
               $zzz = $overdue3['sap_code'];
               $txtans = "";
               if(mysqli_num_rows($overdue2) > 0){
               while($eachhd = $choose_query->fetch_assoc()){

                  $selectcdb = "SELECT * FROM ".$eachhd['tblname_db']." where sap_code = '$zzz' ";
                  $cdb = mysqli_query($conn,$selectcdb);
                  $countdeb = mysqli_num_rows($cdb);

                     $txtans .= "$number.".$eachhd['tblname_th']."ของ$zz มี $countdeb บิล ";
                  if($countdeb > 0){
                     $txtans .= "คลิก>>".$eachhd['center_url']."/req_office.php?REQ=$zzz ";
                  }
                     $txtans .= "\n";
                  $number++;
               }
            }
            else{
               $txtans = "ไม่มีชื่อ กฟฟ.นี้";
            }
            }
            else if($sapnum <> '00000'){
               $txtans = "ท่านมีสิทธิเข้าถึงข้อมูลเฉพาะการไฟฟ้าต้นสังกัดเท่านั้น";
            }
         }
         else if($nums4 > 0 AND trim(strtolower($message)) == "debtorall"){
            // $data = "SELECT * FROM peaemp e left join peaemail m on e.empID = m.empcode
            // left JOIN pea_office o ON LEFT(e.dept_change_code,11) = LEFT(o.unit_code,11)
            // WHERE e.empID = '$r0' GROUP BY e.empID";
            // $querydata = mysqli_query($conn, $data);
            // $result = mysqli_fetch_array($querydata);
            // $empID = $result['empID'];
            // $name = $result['name'];
            // $surname = $result['surname'];
            // $email = $result['pea_email'];
            // $sapcode = $result['sap_code'];
            //    $sapnum = substr($sapcode,1);
            //    $sapreg = substr($sapcode,0,1);
            // if($sapnum == '00000' AND $sapreg <> 'Z'){
            //    $sql = "SELECT count(DISTINCT cus_number) as num, debtor.dept_name, debtor.sap_code from debtor join pea_office on pea_office.sap_code = debtor.sap_code where region2 LIKE '$sapreg' GROUP BY debtor.sap_code";
            //    $query = mysqli_query($conn,$sql) or die(mysqli_error($conn));
            //    $a = 1;
            //    $txtans = "ลูกหนี้ค่าไฟฟ้าเอกชนรายใหญ่ค้างชำระเกินเงินประกัน\n";
				// 	while($result=mysqli_fetch_array($query)){
				// 		$txtans .= $a.".".$result["dept_name"]." จำนวน ".$result["num"]." ราย >> https://southpea.herokuapp.com/debtor/majorDebt/req_office.php?REQ=".$result["sap_code"]."\n";
				// 		$a =$a +1;
				// 	}
				// 	$a = 0;
				// 	mysqli_close($conn);
            // }
            $txtans = "ค้นหาข้อมูลลูกหนี้ของแต่ละการไฟฟ้า\nพิมพ์ dt ตามด้วย ชื่อกฟฟ เช่น dtตรัง";
         }
         else{
            $select_id = "SELECT * FROM peaemp e left join peaemail m on e.empID = m.empcode WHERE e.empID = '".$message."'";
            $query2 = mysqli_query($conn, $select_id);
            $nums = mysqli_num_rows($query2);
            $result = mysqli_fetch_array($query2);
            $t = $result['name'];
            $t2 = $result['surname'];
            $t1 = $result['active_status'];
            $email = $result['pea_email'];
            $empid = $result['empID'];
            $activation=md5($email.time());
         
            if($nums == 1 AND $t1 == "" AND $count_existing == 0){
               //$shorturl = make_bitly_url("https://southpea.herokuapp.com/hr/activation.php?code=$activation",'o_5cm7sdg39v','R_9e58931faa3c4f7aae9afa35cc2982f2','json');
               //$sql_regis = "UPDATE peaemp SET user_id ='$id', activation ='$activation', bitly = '$shorturl' WHERE empID = '".$message."'";
               $sql_regis = "UPDATE peaemp SET user_id ='$id', activation ='$activation' WHERE empID = '".$message."'";
               mysqli_query($conn, $sql_regis);
               //$txtans = "คุณคือ$t $t2 รึเปล่า? ถ้าใช่กรุณากรอกอีเมล @pea.co.th ของคุณ";
               $messages = getBubbleMessages1($empid,$email);
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
            else if($message > 99999 && $message < 999999 AND ctype_digit($message) AND $nums == 0){
               $txtans = "ไม่มีรหัสพนักงานนี้ในสายงานการไฟฟ้า ภาค 4";
            }
            else if($nums == 1 AND $t1 == "" AND $count_existing == 1){
               //$shorturl = make_bitly_url("https://southpea.herokuapp.com/hr/activation.php?code=$activation",'o_5cm7sdg39v','R_9e58931faa3c4f7aae9afa35cc2982f2','json');
               //$sql_del = "UPDATE peaemp SET user_id ='', activation ='', bitly = '', pea_email = '' WHERE user_id = '$id'";
               $sql_del = "UPDATE peaemp SET user_id ='', activation ='' WHERE user_id = '$id'";
               mysqli_query($conn, $sql_del);
               //$sql_regis = "UPDATE peaemp SET user_id ='$id', activation ='$activation', bitly = '$shorturl' WHERE empID = '".$message."'";
               $sql_regis = "UPDATE peaemp SET user_id ='$id', activation ='$activation' WHERE empID = '".$message."'";
               mysqli_query($conn, $sql_regis);
               //$txtans = "คุณคือ$t $t2 รึเปล่า? ถ้าใช่กรุณากรอกอีเมล @pea.co.th ของคุณ";
               $messages = getBubbleMessages1($empid,$email);
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
            else if(strtolower(substr($message,0,3)) == "pea" AND substr($message,3,6) > 99999 AND substr($message,3,6) < 999999 AND ctype_digit(substr($message,3,6))){
               $empid = substr($message,3,6);
               $select_id3 = "SELECT * FROM peamember WHERE memberid = '".$empid."'";
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

               if($nums4 > 0){
                  $txtans = "คุณได้ลงทะเบียนแล้ว ในนาม $r1 $r2";
               }
               else if($nums3 > 0 AND $nums3 <> $nums4){
                  $txtans = "รหัสพนักงานนี้ได้ลงทะเบียนไปแล้ว";
               }
               else{
               $sql_del = "UPDATE peaemp SET user_id ='', activation ='', direct_request = '' WHERE user_id = '".$id."'";
               mysqli_query($conn, $sql_del);   
               $sql_regis = "UPDATE peaemp SET user_id ='$id', activation ='$activation', direct_request ='A' WHERE empID = '".$empid."'";
               mysqli_query($conn, $sql_regis);
               $txtans = "กำลังดำเนินการลงทะเบียน...";
               }
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
   //$replyToken = $event['replyToken'];
   $pbuserid = $event['source']['userId'];
   $pbdata = $event['postback']['data'];
   //$pbunix = $event['timestamp'];
   $postbackstatus = substr($pbdata,0,strlen($pbdata)-6);
   $postbackid = substr($pbdata,-6);

      $select_id = "SELECT * FROM peaemp e left join peaemail m on e.empID = m.empcode WHERE e.empID = '$postbackid'";
      $sql_id = mysqli_query($conn, $select_id);
      $empinfo = mysqli_fetch_array($sql_id);
      $p0 = $empinfo['user_id'];
      $p1 = $empinfo['name'];
      $p2 = $empinfo['surname'];
      $p3 = $empinfo['pea_email'];
      $p4 = $empinfo['bitly'];
      $p5 = substr($p4,7);
      $p6 = $empinfo['send_status'];
      $p7 = $empinfo['activation'];
         
         if($postbackstatus == 'confirm' AND $p6 == ""){
		 	
            $from = new SendGrid\Email(null, "botrg4@pea.co.th");
            $content = new SendGrid\Content("text/html", "https://southpea.herokuapp.com/hr/activation.php?code=".$p7);
            $subject = "To K.$p1 please confirm LINE bot";
            $to = new SendGrid\Email(null, "$p3");
            //$content = "confirm register click: https://$p5";
            $mail = new SendGrid\Mail($from, $subject, $to, $content);
            $apiKey = getenv('SENDGRID_API_KEY');
            $sg = new \SendGrid($apiKey);
            $sg->client->mail()->send()->post($mail);

            $send_update = "UPDATE peaemp SET send_status = 'A' WHERE empID = '$postbackid'";   
            mysqli_query($conn, $send_update);
            mysqli_close($conn);
         }
         else if(substr($postbackstatus,0,2) <> 'xx' AND substr($postbackstatus,-4) == 'debt'){
            $pbid = substr($postbackstatus,0,strlen($postbackstatus)-4);
            $viewtime = date("Y-m-d H:i:s");
            $checkviewstat = "SELECT view_stat FROM tbl_log_notify WHERE id = '$pbid'";
            $checkviewstat2 = mysqli_fetch_array(mysqli_query($conn,$checkviewstat));
            $cvs = $checkviewstat2['view_stat'];   
            if($cvs == 'N'){
               $viewlogupdate = "UPDATE tbl_log_notify SET time_view = '$viewtime',dept_view = '$postbackid',view_stat = 'Y' WHERE id = '$pbid'";
               mysqli_query($conn, $viewlogupdate);
            }
            mysqli_close($conn);
         }         
}

}}
