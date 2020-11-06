<!DOCTYPE html> 
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1" data-ajax="false" charset="utf-8">
		<title>ข้อมูลพนักงานที่ครบหลักเกณฑ์การแต่งตั้งพนักงานแรกบรรจุ</title>
		<link href="jquery.mobile.theme-1.0.min.css" rel="stylesheet" type="text/css"/>
		<link href="jquery.mobile.structure-1.0.min.css" rel="stylesheet" type="text/css"/>
		<script src="jquery-1.6.4.min.js" type="text/javascript"></script>
		<script src="jquery.mobile-1.0.min.js" type="text/javascript"></script>
	</head> 
	<body> 
	<?php
		require('conn.php');
		function DateThai($strDate){
			$strYear = date("Y",strtotime($strDate))+543;
			$strMonth= date("n",strtotime($strDate));
			$strDay= date("j",strtotime($strDate));
			//$strHour= date("H",strtotime($strDate));
			//$strMinute= date("i",strtotime($strDate));
			//$strSeconds= date("s",strtotime($strDate));
			$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
			$strMonthThai=$strMonthCut[$strMonth];
			return "$strDay $strMonthThai $strYear";
		}
		$NUMBER = $_GET['REQ'];
		$crecord1 = mysqli_fetch_assoc(mysqli_query($conn,"SELECT file_upload_timestamp FROM tbl_log_file ORDER BY file_upload_timestamp DESC LIMIT 1"));
		$ccc = DateThai($crecord1['file_upload_timestamp']);
		$sql = "SELECT count(DISTINCT el.empID) as num, po.dept_name, po.sap_code, LEFT(el.DEPT_CHANGE_CODE,12) as dcc FROM emplist el LEFT JOIN pea_office po ON po.unit_code = el.DEPT_CHANGE_CODE WHERE region2 = '$NUMBER' GROUP BY LEFT(el.DEPT_CHANGE_CODE,12)";
		$query = mysqli_query($conn,$sql) or die(mysqli_error($conn));
	?>
		<div data-role="page" id="page">
			<div data-role="header" data-theme="b">
				<h1>ข้อมูลพนักงานที่ครบหลักเกณฑ์การแต่งตั้งพนักงานแรกบรรจุ</h1>
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
						// $mmm = "06/2562";
					}
					else if($NUMBER == "C"){
						$reg = "สำนักงานใหญ่";
					}
				//$fetch_number_complaint = "SELECT * FROM TBL_COMPLAINT";
				echo "<b>ข้อมูลพนักงานที่ครบหลักเกณฑ์การแต่งตั้งพนักงานแรกบรรจุ แยกตามสังกัดของ $reg ข้อมูล ณ วันที่ $ccc</b><br/>";
			?>
			</div>
			<div data-role="content">	
				<ul data-role="listview">
				<?php
					mysqli_data_seek($query,0);
					$a = 1;
					while($result=mysqli_fetch_array($query)){
						echo "<li><a href ='req_office.php?REQ=".$result["dcc"]."'>".$a.".".$result["dept_name"]."  จำนวน  ".$result["num"]." คน</a></li>";;
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
	<?php include("googleAna.php"); ?>
</html>
