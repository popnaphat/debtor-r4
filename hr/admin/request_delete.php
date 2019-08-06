<?php
	include 'includes/session.php';
	include '../timezone.php';
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
			$cDate = date("Y-m-d H:i:s");
		$sql = "UPDATE peaemp SET send_status = 'A' ,active_status = 'A' WHERE empID = '$id'";
		$insert = "INSERT INTO peamember (memberid, memberuser_id, membername, membersurname, memberpea_email, datetime_regis) VALUES ('$empID', '$userId', '$name', '$surname', '$email', '$cDate')";
		if($conn->query($sql) AND $conn->query($insert)){
			$_SESSION['success'] = 'Member has been added.';
			if(substr($sapcode,1) == '00000'){
			////
			}
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
