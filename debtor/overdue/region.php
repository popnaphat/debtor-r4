<!DOCTYPE html> 
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1" data-ajax="false" charset="utf-8">
		<title>ลูกหนี้ค่าไฟฟ้าเอกชนรายใหญ่ค้างชำระเกินกำหนด</title>
		<link href="jquery.mobile.theme-1.0.min.css" rel="stylesheet" type="text/css"/>
		<link href="jquery.mobile.structure-1.0.min.css" rel="stylesheet" type="text/css"/>
		<script src="jquery-1.6.4.min.js" type="text/javascript"></script>
		<script src="jquery.mobile-1.0.min.js" type="text/javascript"></script>
	</head> 
	<body> 
	<?php
		require('conn.php');
		$NUMBER = $_GET['REQ'];
			$dateupload = "SELECT bill_month FROM tbl_log_csv_debt2 where right(bill_month,4) = YEAR(CURRENT_DATE) and region = '$NUMBER' ORDER BY bill_month DESC LIMIT 1";
			$querydu = mysqli_query($conn,$dateupload);
			$fetchdu = mysqli_fetch_array($querydu);
			$mmm = $fetchdu['bill_month'];
			$crecord2 = "SELECT * FROM tbl_log_csv_debt2 ORDER BY id DESC LIMIT 1";
			$crecord1 = mysqli_fetch_array(mysqli_query($conn,$crecord2));
			$ccc = $crecord1['file_upload_timestamp'];
		//$NUMBER2 = $_GET['REQ2'];
		$sql = "SELECT count(DISTINCT cus_number) as num, pea_office.dept_name, debtor_kpi.sap_code from debtor_kpi join pea_office on pea_office.sap_code = debtor_kpi.sap_code where region2 LIKE '$NUMBER' GROUP BY debtor_kpi.sap_code";
		$query = mysqli_query($conn,$sql) or die(mysqli_error($conn));
		//$mode1 = mysqli_num_rows($query);
		/*while($ofname = mysqli_fetch_array($query)){ 
			$ofname1 = $ofname["dept_name"];
		}*/

	?>
		<div data-role="page" id="page">
			<div data-role="header" data-theme="b">
				<h1>ลูกหนี้ค่าไฟฟ้าเอกชนรายใหญ่ค้างชำระเกินกำหนด</h1>
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
				echo "<b>รายงานลูกหนี้ค่าไฟฟ้าเอกชนรายใหญ่ค้างชำระเกินกำหนด (บิลค้างชำระก่อนเดือน $mmm) แยกตามสังกัดของ $reg ข้อมูล ณ วันที่ $ccc</b><br/>";
			?>
			</div>
			<div data-role="content">	
				<ul data-role="listview">
				<?php
					mysqli_data_seek($query,0);
					$a = 1;
					while($result=mysqli_fetch_array($query)){
						$sql2 = "SELECT * from debtor_kpi where sap_code = '".$result['sap_code']."'";
						$query2 = mysqli_num_rows(mysqli_query($conn,$sql2));
						echo "<li><a href ='req_office.php?REQ=".$result["sap_code"]."'>".$a.".".$result["dept_name"]."  จำนวน  ".$result["num"]." ราย (".$query2." บิล)</a></li>";;
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
