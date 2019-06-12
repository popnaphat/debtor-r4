<?php

	$conn = new mysqli('localhost', 'id6587518_line2', '123456', 'id6587518_line2');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

?>