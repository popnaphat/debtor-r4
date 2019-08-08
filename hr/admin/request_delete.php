<?php
	include 'includes/session.php';
	include '../timezone.php';
	include '../../debtor/libs/utils/messages2.php';
	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		$data = "SELECT * FROM peaemp e left join peaemail m on e.empID = m.empcode left join (SELECT m.memberid, o.sap_code FROM peamember m 
		JOIN peaemp ON m.memberid = peaemp.empID 
		JOIN pea_office o ON LEFT(peaemp.dept_change_code,11) = LEFT(o.unit_code,11)
		GROUP BY m.memberid) sub on e.empID = sub.memberid WHERE e.empID = '$id'";
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
			if($sapnum == '00000'){
				/*$selectcdb = "SELECT * FROM debtor where left(sap_code,1) = '$sapreg'";
				$cdb = mysqli_query($conn,$selectcdb);
				$countdeb = mysqli_num_rows($cdb);
				
				$selectglr = "SELECT * FROM debtor where left(sap_code,1) = '$sapreg' LIMIT 1";
				$glr = mysqli_query($conn,$selectglr);
				$getlastrow = mysqli_fetch_array($glr);
				$dateupload = $getlastrow['timeupload'];

				$selectcp = "SELECT dept_name, sap_code from debtor where left(sap_code,1) = '$sapreg' GROUP BY sap_code";
				$cp = mysqli_query($conn,$selectcp);
				$countpea = mysqli_num_rows($cp); 
				
				$messages = getBubbleMessages($countpea, $countdeb, $dateupload, $regionname, $sapreg);*/
				$access_token = "CGBgbM7ECUjswllXeJ6MIegVud5ulkBjM0ZU+z0GIWkXUIPAm1JC9uUAsycDJHbIuHKcHrEr8GmeS1/2eVV4E/NBiutlQHAPLJXbz58Voa9uHdK3R8/E1qN0Ox0STooKId3oiFvpRAYT3my/ZkjA8QdB04t89/1O/w1cDnyilFU=";
				$texts = "คุณ $name $surname ลงทะเบียนเสร็จสิ้น";
				$messages = [ 'type' => 'text', 'text' => $texts];
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
			$_SESSION['success'] = 'Member has been added.';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
		$sql2 = "UPDATE peaemp SET direct_request = '' WHERE empID = '$id'";
		mysqli_query($conn,$sql2);
		
	}
	else{
		$_SESSION['error'] = 'Select item to delete first';
	}

	header('location: request.php');
	
?>
