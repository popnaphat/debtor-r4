<?php
    date_default_timezone_set("Asia/Bangkok");
    require('conn.php');
    $code = $_POST['code'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $userId = $_POST['userId'];
	$status = $_POST['status'];
	$empID = $_POST['empID'];
	$email = $_POST['email'];
	$cDate = date("Y-m-d H:i:s");
        if($status == 'A'){
            echo "ท่านได้ลงทะเบียนแล้ว";
        }
        else{
        $update = "UPDATE peaemp SET active_status = 'A' WHERE activation='$code'";
		$result1 = mysqli_query($conn,$update);
		$insert = "INSERT INTO peamember (memberid, memberuser_id, membername, membersurname, memberpea_email, datetime_regis) VALUES ('$empID', '$userId', '$name', '$surname', '$email', '$cDate')";
		$result2 = mysqli_query($conn,$insert);
        echo "ลงทะเบียนเสร็จสิ้น";
		
		$check = "SELECT pea_office.sap_code FROM peaemp LEFT JOIN pea_office ON peaemp.dept_change_code = pea_office.unit_code WHERE peaemp.empID = '$empID'";
		$qcheck = mysqli_query($conn,$check);
		$fcheck = mysqli_fetch_array($qcheck);
		$spc = $fcheck['sap_code'];

		if(substr($spc,1) == '00000'){
		
    	}
