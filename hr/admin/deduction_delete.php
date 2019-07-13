<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];

		$check = "SELECT * FROM alert_date WHERE seq = '$id'";
		$q2 = mysqli_query($conn,$check);
		$q3 = mysqli_fetch_assoc($q2);
		if($q3['alert_status'] == 'รอแจ้งเตือน'){
			$sql = "DELETE FROM alert_date WHERE seq = '$id'";
			mysqli_query($conn,$sql);
			$_SESSION['success'] = 'This date deleted successfully';
		}
		else{
			$_SESSION['error'] = 'การแจ้งเตือนนี้ได้ส่งไปแล้ว ไม่สามารถลบได้';
		}
	}
	else{
		$_SESSION['error'] = 'Select item to delete first';
	}

	header('location: deduction.php');
	
?>