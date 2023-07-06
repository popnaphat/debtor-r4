<?php
	session_start();
	include 'includes/conn.php';

	if(isset($_POST['login'])){
		$username = $_POST['username'];
		$password = $_POST['password'];

		$sql = "SELECT * FROM admin WHERE username = '$username'";
		$query = $conn->query($sql);

		if($query->num_rows < 1){
			$_SESSION['error'] = 'Cannot find account with the username';
		}
		else{
			$row = $query->fetch_assoc();
			if(password_verify($password, password_hash($row['password'], PASSWORD_DEFAULT))){
				$_SESSION['admin'] = $row['id'];
				$_SESSION['last_time'] = time();
				$_SESSION['user_type'] = $row['user_type'];
			}
			else{
				$_SESSION['error'] = 'Incorrect password '.$row['password'];
			}
		}
		
	}
	else{
		$_SESSION['error'] = 'Input admin credentials first';
	}

	header('location: index.php');

?>
