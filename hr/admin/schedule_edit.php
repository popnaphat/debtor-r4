<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$time_in = $_POST['deptname'];
		//$time_in = date('H:i:s', strtotime($time_in));
		$time_out = $_POST['deptclass'];
		//$time_out = date('H:i:s', strtotime($time_out));

		$sql = "UPDATE pea_office SET dept_name = '$time_in', dept_class = '$time_out' WHERE unit_code = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Schedule updated successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Fill up edit form first';
	}

	header('location:schedule.php');

?>