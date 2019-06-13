<?php
	session_start();
	include 'includes/conn.php';

	if(!isset($_SESSION['admin']) || trim($_SESSION['admin']) == ''){
		header('location: index.php');
	}

	$sql = "SELECT * FROM admin WHERE id = '".$_SESSION['admin']."'";
	$query = $conn->query($sql);
	$user = $query->fetch_assoc();
	
	if(isset($_SESSION['admin'])){
		if((time() - $_SESSION['last_time'])>300){
			header('location:logout.php');
		}
		else{
			$_SESSION['last_time'] = time();
		}
	}
	
?>