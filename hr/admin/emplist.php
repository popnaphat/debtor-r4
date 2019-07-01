<!DOCTYPE html> 
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1" data-ajax="false" charset="utf-8">
		<title>รายชื่อพนักงานที่ครบกำหนดปรับระดับครั้งแรก</title>
		<link href="assets/usertheme/jquery.mobile.theme-1.0.min.css" rel="stylesheet" type="text/css"/>
		<link href="assets/usertheme/jquery.mobile.structure-1.0.min.css" rel="stylesheet" type="text/css"/>
		<script src="assets/usertheme/jquery-1.6.4.min.js" type="text/javascript"></script>
		<script src="assets/usertheme/jquery.mobile-1.0.min.js" type="text/javascript"></script>
	</head> 
	<body> 
	<?php
		require('./includes/conn.php');
		$NUMBER = $_GET['REQ'];
		//$NUMBER2 = $_GET['REQ2'];

		$sql = "SELECT dept_cover,emp_prename,emp_name,emp_surname,emp_position,short_name
    , TIMESTAMPDIFF( YEAR, appointdate, now() ) as _year
    , TIMESTAMPDIFF( MONTH, appointdate, now() ) % 12 as _month
    , FLOOR( TIMESTAMPDIFF( DAY, appointdate, now() ) % 30.4375 ) as _day
		from emplist join pea_office on emplist.DEPT_CHANGE_CODE = pea_office.unit_code WHERE left(DEPT_CHANGE_CODE,11) LIKE '%".$NUMBER."%'";
		//$sql_type = "SELECT * FROM tbl_complaint WHERE office_name LIKE '%".$NUMBER."%' AND number_of_day>=".$NUMBER2." AND complaint_status <> 'ปิด' GROUP BY complaint_type";
		$query = mysqli_query($conn,$sql) or die(mysqli_error($conn));
		//$query_type = mysqli_query($conn,$sql_type);
		$mode1 = mysqli_num_rows($query);
		while($ofname = mysqli_fetch_array($query)){ 
			$ofname1 = $ofname["dept_cover"];
		}
	?>
		<div data-role="page" id="page">
			<div data-role="header" data-theme="b">
				<h1>รายชื่อพนักงานที่ครบกำหนดปรับระดับ</h1>
			</div>
			<div data-role="content">
			<?php 
				echo "พนักงานที่ครบกำหนดปรับระดับครั้งแรกของ  ".$ofname1." จำนวน ".$mode1."  คน";	
				mysqli_data_seek($query,0);
			?>
			</div>
			<?php
				//while($result_type = mysqli_fetch_array($query_type)){
					//echo '<div data-role="content">';
					//echo '<u><b>ด้าน'.$result_type["complaint_type"].'</b></u>';
					//echo '</div>';
					$a = 1;
					while($result = mysqli_fetch_array($query)){
						//if($result["complaint_type"] == $result_type["complaint_type"]){
							echo '<div data-role="content">'; 
							//echo '<ul data-role="listview">';
							echo "<li><a>".$a.".".$result["emp_prename"]."".$result["emp_name"]." ".$result["emp_surname"]."  ".$result["emp_position"]."  สังกัด:".$result["short_name"]." ระยะเวลาครองตำแหน่ง:".$result["_year"]." ปี ".$result["_month"]." เดือน ".$result["_day"]." วัน</a></li>";
							//echo '</ul>';
							echo '</div>';
						$a = $a +1;
						//}
					}
					$a = 0;
					mysqli_close($conn);
				//}
			?>
			<!--div data-role="content">
				<h2><a href="#" class="ui-btn" data-rel="back" > BACK</a></h2>
			</div-->  
			<div data-role="footer" data-theme="b">
				<h4>PEA REGION 4</h4>
			</div>
		</div>
	</body>
</html>
