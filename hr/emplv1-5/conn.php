<?php
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$conn = new mysqli($server, $username, $password, $db);
mysqli_query($conn, "SET NAMES utf8");
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

?>
