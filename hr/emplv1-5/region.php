<!DOCTYPE html> 
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1" data-ajax="false" charset="utf-8">
		<title>รายชื่อพนักงานที่ครบกำหนดปรับระดับครั้งแรก</title>
		<link href="jquery.mobile.theme-1.0.min.css" rel="stylesheet" type="text/css"/>
		<link href="jquery.mobile.structure-1.0.min.css" rel="stylesheet" type="text/css"/>
		<script src="jquery-1.6.4.min.js" type="text/javascript"></script>
		<script src="jquery.mobile-1.0.min.js" type="text/javascript"></script>
	</head> 
	<body> 
	<?php
		require('conn.php');
		$NUMBER = $_GET['REQ'];
		//$NUMBER2 = $_GET['REQ2'];
		$sql = "SELECT region, left(DEPT_CHANGE_CODE,11) as dcc, dept_cover, dept_name, count(dept_cover) as deptNum from emplist join pea_office on emplist.DEPT_CHANGE_CODE = pea_office.unit_code WHERE region2 LIKE '$NUMBER' GROUP BY left(DEPT_CHANGE_CODE,11) ORDER BY dept_class ASC ,left(DEPT_CHANGE_CODE,11) ASC";
		$query = mysqli_query($conn,$sql) or die(mysqli_error($conn));
		//$mode1 = mysqli_num_rows($query);
		/*while($ofname = mysqli_fetch_array($query)){ 
			$ofname1 = $ofname["dept_name"];
		}*/

	?>
		<div data-role="page" id="page">
			<div data-role="header" data-theme="b">
				<h1>รายชื่อพนักงานที่ครบกำหนดปรับระดับครั้งแรก </h1>
			</div>
			<div data-role="content">
			<?php 
				if($NUMBER == "J"){
					$reg = "กฟต.1 เพชรบุรี";
				}
					else if($NUMBER == "K"){
						$reg = "กฟต.2 นครศรีธรรมราช";
					}
					else if($NUMBER == "L"){
						$reg = "กฟต.3 ยะลา";
					}
					else if($NUMBER == "C"){
						$reg = "สำนักงานใหญ่";
					}
				//$fetch_number_complaint = "SELECT * FROM TBL_COMPLAINT";
				echo "<b>รายชื่อพนักงานที่ครบกำหนดปรับระดับครั้งแรก สังกัด '".$reg."'</b><br/>";
			?>
			</div>
			<div data-role="content">	
				<ul data-role="listview">
				<?php
					mysqli_data_seek($query,0);
					$a = 1;
					while($result=mysqli_fetch_array($query)){
						echo "<li><a href ='req_office.php?REQ=".$result["dcc"]."'>".$a.".".$result["dept_cover"]."  จำนวน  ".$result["deptNum"]." คน</a></li>";;
						$a =$a +1;
					}
					$a = 0;
					mysqli_close($conn);
				?>
				</ul>
				<h2><a href="#" class="ui-btn" data-rel="back" > BACK</a></h2>
			</div>
			<div data-role="footer" data-theme="b">
				<h4>PEA REGION 4</h4>
			</div>
		</div>
	</body>
</html>
