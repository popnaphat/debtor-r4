<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		$sql = "DELETE FROM peamember WHERE memberid = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Bot member deleted successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
		$sql2 = "UPDATE peaemp SET user_id ='', active_status ='', activation ='', bitly = '', pea_email ='', send_status = '' WHERE empID = '$id'";
		mysqli_query($conn,$sql2);
	}
	else{
		$_SESSION['error'] = 'Select item to delete first';
	}

	header('location: attendance.php');
	
?>
