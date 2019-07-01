<!DOCTYPE html> 
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1" data-ajax="false" charset="utf-8">
		<title>รายชื่อปลายทาง</title>
		<link href="assets/usertheme/jquery.mobile.theme-1.0.min.css" rel="stylesheet" type="text/css"/>
		<link href="assets/usertheme/jquery.mobile.structure-1.0.min.css" rel="stylesheet" type="text/css"/>
		<script src="assets/usertheme/jquery-1.6.4.min.js" type="text/javascript"></script>
		<script src="assets/usertheme/jquery.mobile-1.0.min.js" type="text/javascript"></script>
	</head> 
	<body> 
	<?php
		require('./includes/conn.php');
		$NUMBER = $_GET['REQ'];
		$nnnn = substr("$NUMBER", 0, -1);

		$sql = "SELECT * FROM peaemp JOIN emplist ON LEFT(peaemp.dept_change_code,11) = LEFT(emplist.DEPT_CHANGE_CODE,11) WHERE	peaemp.position REGEXP 'อฝ|รฝ|อก|รก|ชก|ผจก|รจก' AND LEFT(peaemp.dept_change_code,10) LIKE '%".$nnnn."%' GROUP BY peaemp.empID ORDER BY left(peaemp.DEPT_CHANGE_CODE,11) ASC , peaemp.empID ASC ";
		$query = mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$mode1 = mysqli_num_rows($query);
		$sql2 = "SELECT * FROM pea_office WHERE unit_code = CONCAT('".$nnnn."','00000')";
		$query2 = mysqli_query($conn,$sql2) or die(mysqli_error($conn));
		while($ofname = mysqli_fetch_array($query2)){ 
			$ofname1 = $ofname["dept_cover"];
		}
	?>
		<div data-role="page" id="page">
			<div data-role="header" data-theme="b">
				<h1>รายชื่อปลายทาง</h1>
			</div>
			<div data-role="content">
			<?php 
				echo "ปลายทาง  ".$ofname1." ส่งให้ ".$mode1." คน";	
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
							echo "<li><a>".$a.".".$result["pre_name"]."".$result["name"]." ".$result["surname"]."  ".$result["position"]."  สังกัด:".$result["dept_short"]."</a></li>";
							//echo '</ul>';
							echo '</div>';
						//}
						$a++;
					}
					mysqli_data_seek($query,0);
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
