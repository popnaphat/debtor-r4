<?php
	include 'includes/session.php';
	include '../timezone.php';
	include '../../debtor/libs/utils/messages.php';
	include '../../debtor/libs/utils/messages2.php';
	include '../../debtor/libs/utils/messages3.php';
	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		$data = "SELECT * FROM peaemp e left join peaemail m on e.empID = m.empcode
		left JOIN pea_office o ON LEFT(e.dept_change_code,11) = LEFT(o.unit_code,11)
		WHERE e.empID = '$id' GROUP BY e.empID";
			$querydata = mysqli_query($conn, $data);
			$result = mysqli_fetch_array($querydata);
			$empID = $result['empID'];
			$userId = $result['user_id'];
			$name = $result['name'];
			$surname = $result['surname'];
			$email = $result['pea_email'];
			$sapcode = $result['sap_code'];
				$sapnum = substr($sapcode,1);
				$sapreg = substr($sapcode,0,1);
				if($sapreg == 'J'){
					$regionname = "กฟต.1 เพชรบุรี";
				}else if($sapreg == 'K'){
					$regionname = "กฟต.2 นครศรีธรรมราช";
				}else if($sapreg == 'L'){
					$regionname = "กฟต.3 ยะลา";
				}
			$cDate = date("Y-m-d H:i:s");
		$sql = "UPDATE peaemp SET send_status = 'A' ,active_status = 'A' WHERE empID = '$id'";
		$insert = "INSERT INTO peamember (memberid, memberuser_id, membername, membersurname, memberpea_email, datetime_regis) VALUES ('$empID', '$userId', '$name', '$surname', '$email', '$cDate')";
		if($conn->query($sql) AND $conn->query($insert)){
			if($sapcode == 'Z00000'){
				$selectcdb = "SELECT * FROM debtor";
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
               }
				$access_token = "CGBgbM7ECUjswllXeJ6MIegVud5ulkBjM0ZU+z0GIWkXUIPAm1JC9uUAsycDJHbIuHKcHrEr8GmeS1/2eVV4E/NBiutlQHAPLJXbz58Voa9uHdK3R8/E1qN0Ox0STooKId3oiFvpRAYT3my/ZkjA8QdB04t89/1O/w1cDnyilFU=";

				$data = [
						'to' => $userId,
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
			else if($sapnum == '00000' AND $sapreg <> 'Z'){
				$selectcdb = "SELECT * FROM debtor where left(sap_code,1) = '$sapreg'";
               $cdb = mysqli_query($conn,$selectcdb);
               $countdeb = mysqli_num_rows($cdb);
               
               $selectglr = "SELECT * FROM tbl_log_csv_debt1 where region = '$sapreg' ORDER BY id DESC LIMIT 1";
               $glr = mysqli_query($conn,$selectglr);
               $getlastrow = mysqli_fetch_array($glr);
               $dateupload = $getlastrow['file_upload_timestamp'];
   
               $selectcp = "SELECT dept_name, sap_code from debtor where left(sap_code,1) = '$sapreg' GROUP BY sap_code";
               $cp = mysqli_query($conn,$selectcp);
               $countpea = mysqli_num_rows($cp);
               ///////////////////////////////////////////////
               $selectcdb2 = "SELECT * FROM debtor_kpi where left(sap_code,1) = '$sapreg'";
               $cdb2 = mysqli_query($conn,$selectcdb2);
               $countdeb2 = mysqli_num_rows($cdb2);
               
               $selectglr2 = "SELECT * FROM tbl_log_csv_debt2 where region = '$sapreg' ORDER BY id DESC LIMIT 1";
               $glr2 = mysqli_query($conn,$selectglr2);
               $getlastrow2 = mysqli_fetch_array($glr2);
               $dateupload2 = $getlastrow2['file_upload_timestamp'];
   
               $selectcp2 = "SELECT dept_name, sap_code from debtor_kpi where left(sap_code,1) = '$sapreg' GROUP BY sap_code";
               $cp2 = mysqli_query($conn,$selectcp2);
               $countpea2 = mysqli_num_rows($cp2); 
               
               if($countdeb == 0){
                  $txtans = "คุณไม่มีเรื่องแจ้งเตือนสำหรับวันนี้";
                  $messages = [ 'type' => 'text', 'text' => $txtans];
               }
               else{
               $messages = getBubbleMessages2($countpea, $countdeb, $dateupload, $countpea2, $countdeb2, $dateupload2, $regionname, $sapreg);
               }
				$access_token = "CGBgbM7ECUjswllXeJ6MIegVud5ulkBjM0ZU+z0GIWkXUIPAm1JC9uUAsycDJHbIuHKcHrEr8GmeS1/2eVV4E/NBiutlQHAPLJXbz58Voa9uHdK3R8/E1qN0Ox0STooKId3oiFvpRAYT3my/ZkjA8QdB04t89/1O/w1cDnyilFU=";
				$data = [
						'to' => $userId,
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
			else if($sapnum <> '00000'){
				
				$selectcdb = "SELECT * FROM debtor where sap_code = '$sapcode'";
               $cdb = mysqli_query($conn,$selectcdb);
               $countdeb = mysqli_num_rows($cdb);
               
               $selectglr = "SELECT pea_office.dept_name FROM debtor join pea_office on pea_office.sap_code = debtor.sap_code where debtor.sap_code = '$sapcode' LIMIT 1";
               $glr = mysqli_query($conn,$selectglr);
               $getlastrow = mysqli_fetch_array($glr);               
               $dept_name = $getlastrow['dept_name'];

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
   
               if($countdeb == 0){
                  $txtans = "คุณไม่มีเรื่องแจ้งเตือนสำหรับวันนี้";
                  $messages = [ 'type' => 'text', 'text' => $txtans];
               }
               else{
               $messages = getBubbleMessages("xx",$countdeb, $dateupload,$countdeb2, $dateupload2, $dept_name, $sapcode);
               }

				$access_token = "CGBgbM7ECUjswllXeJ6MIegVud5ulkBjM0ZU+z0GIWkXUIPAm1JC9uUAsycDJHbIuHKcHrEr8GmeS1/2eVV4E/NBiutlQHAPLJXbz58Voa9uHdK3R8/E1qN0Ox0STooKId3oiFvpRAYT3my/ZkjA8QdB04t89/1O/w1cDnyilFU=";
				$data = [
						'to' => $userId,
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
			$_SESSION['success'] = "Member has been added.";
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
		$sql2 = "UPDATE peaemp SET direct_request = '' WHERE empID = '$id'";
		mysqli_query($conn,$sql2);
		mysqli_close();
	}
	else{
		$_SESSION['error'] = 'Select item to delete first';
	}

	header('location: request.php');
	
?>
