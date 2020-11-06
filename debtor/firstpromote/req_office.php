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
		$reg = substr($NUMBER,0,1);
		$crecord1 = mysqli_fetch_assoc(mysqli_query($conn,"SELECT file_upload_timestamp FROM tbl_log_file ORDER BY file_upload_timestamp DESC LIMIT 1"));
		$ccc = DateThai($crecord1['file_upload_timestamp']);
		$sql = "SELECT *, TIMESTAMPDIFF( YEAR, appointdate, now() ) as _year
		, TIMESTAMPDIFF( MONTH, appointdate, now() ) % 12 as _month
		, FLOOR( TIMESTAMPDIFF( DAY, appointdate, now() ) % 30.4375 ) as _day FROM emplist el LEFT JOIN pea_office po ON po.unit_code = el.DEPT_CHANGE_CODE WHERE po.sap_code = '$NUMBER' ";
		
		$query = mysqli_query($conn,$sql) or die(mysqli_error($conn));
		
		$mode1 = mysqli_num_rows($query);
		while($ofname = mysqli_fetch_array($query)){ 
			$ofname1 = $ofname["dept_name"];
		}
	?>
		<div data-role="page" id="page">
			<div data-role="header" data-theme="b">
				<h1>ข้อมูลพนักงานที่ครบหลักเกณฑ์การแต่งตั้งพนักงานแรกบรรจุ</h1>
			</div>
			<div data-role="content">
			<?php 
			// if($reg == "L"){
			// 	$mmm = "06/2562";
			// }
				echo "<b>รายงานข้อมูลพนักงานที่ครบหลักเกณฑ์การแต่งตั้งพนักงานแรกบรรจุของ $ofname1 จำนวน $mode1 คน ข้อมูล ณ วันที่ $ccc</b><br/>";	
				mysqli_data_seek($query,0);
			?>
			</div>
			<?php
				//while($result_type = mysqli_fetch_array($query_type)){
					//echo '<div data-role="content">';
					//echo '<u><b>ด้าน'.$result_type["complaint_type"].'</b></u>';
					//echo '</div>';
					$aa = 1;
					while($result = mysqli_fetch_array($query)){
						//if($result["complaint_type"] == $result_type["complaint_type"]){
							echo '<div data-role="content">'; 
							//echo '<ul data-role="listview">';
							echo "<b>".$aa.".</b>".$result["emp_prename"]."".$result["emp_name"]."  ".$result["emp_surname"].", <b>รหัสพนักงาน:</b>".$result["empID"].", <b>ตำแหน่ง:</b>".$result["emp_position"].", <b>วันบรรจุ:</b>".$result["appointdate"].", <b>เป็นระยะเวลา:</b>".$result['_year']." ปี ".$result['_month']." เดือน ".$result['_day']." วัน, <b>สังกัด:</b>".$result["DEPT_SHORT"]."<br>";
							
							//echo "<li><a>".$aa.".".$result["cus_name"].", หมายเลขผู้ใช้ไฟ:".$result["cus_number"].", บิลเดือน:".$result["bill_month"].", หนี้ค้าง:".$result["outstanding_debt"]."บาท, เงินประกัน:".$result["bail"]." บาท, ส่วนที่เกิน:".$result["diff"]." บาท</a></li>";
							//echo '</ul>';
							echo '</div>';
						//}
						$aa = $aa+1;
					}
					mysqli_data_seek($query,0);
					$aa = 0;
					mysqli_close($conn);
				//}
			?>
			<div data-role="content">
				<h2><a href="#" class="ui-btn" data-rel="back" > BACK</a></h2>
			</div>  
			<div data-role="footer" data-theme="b">
				<h4>PEA REGION 4</h4>
			</div>
		</div>
	</body>
	<?php include("googleAna.php"); ?>
</html>
