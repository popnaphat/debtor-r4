<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$description = $_POST['description'];

		$check = "SELECT * FROM alert_date WHERE alert_date = '$description'";
		$q2 = mysqli_query($conn,$check);
		$q3 = mysqli_num_rows($q2);
		if($q3 < 1){
			$sql = "INSERT INTO alert_date (alert_date,alert_status) VALUES ('$description','รอแจ้งเตือน')";
			mysqli_query($conn,$sql);
			$_SESSION['success'] = 'alert date added successfully';
			}
		else{
			$_SESSION['error'] = 'That already exists';
		}
	}	
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: deduction.php');

?>