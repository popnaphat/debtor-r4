<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		$data = "SELECT * FROM peaemp e left join peaemail m on e.empID = m.empcode WHERE e.empID = '$id'";
			$querydata = mysqli_query($conn, $data);
			$result = mysqli_fetch_array($querydata);
			$empID = $result['empID'];
			$userId = $result['user_id'];
			$name = $result['name'];
			$surname = $result['surname'];
			$email = $result['pea_email'];
			$cDate = date("Y-m-d H:i:s");
		$sql = "UPDATE peaemp SET send_status = 'A' ,active_status = 'A' WHERE empID = '$id'";
		$insert = "INSERT INTO peamember (memberid, memberuser_id, membername, membersurname, memberpea_email, datetime_regis) VALUES ('$empID', '$userId', '$name', '$surname', '$email', '$cDate')";
		if($conn->query($sql) AND $conn->query($insert)){
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
