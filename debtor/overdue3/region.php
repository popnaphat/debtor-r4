<?php 
$curyear = date("Y")+543;
?>
<!DOCTYPE html> 
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1" data-ajax="false" charset="utf-8">
		<title>ลูกหนี้ค่าไฟฟ้าเอกชนรายย่อยที่มีบิลค้างชำระเกิน 2 เดือนหรือไม่ต่อเนื่อง</title>
		<link href="jquery.mobile.theme-1.0.min.css" rel="stylesheet" type="text/css"/>
		<link href="jquery.mobile.structure-1.0.min.css" rel="stylesheet" type="text/css"/>
		<script src="jquery-1.6.4.min.js" type="text/javascript"></script>
		<script src="jquery.mobile-1.0.min.js" type="text/javascript"></script>
	</head> 
	<body> 
	<?php
		require('conn.php');
		
		$NUMBER = $_GET['REQ'];
			$dateupload = "SELECT bill_month FROM tbl_log_csv_debt4 where region = '$NUMBER' AND right(bill_month,4) = (SELECT MAX(RIGHT(bill_month,4)) FROM tbl_log_csv_debt4 where region = '$NUMBER') ORDER BY left(bill_month,2) DESC LIMIT 1";
			$querydu = mysqli_query($conn,$dateupload);
			$fetchdu = mysqli_fetch_array($querydu);
			$mmm = $fetchdu['bill_month'];
			$crecord2 = "SELECT * FROM tbl_log_csv_debt4 ORDER BY id DESC LIMIT 1";
			$crecord1 = mysqli_fetch_array(mysqli_query($conn,$crecord2));
			$ccc = $crecord1['file_upload_timestamp'];
		//$NUMBER2 = $_GET['REQ2'];
		//$sql = "SELECT count(DISTINCT cus_number) as num, pea_office.dept_name, debtor_kpi3.sap_code from debtor_kpi3 join pea_office on pea_office.sap_code = debtor_kpi3.sap_code where region2 LIKE '$NUMBER' GROUP BY debtor_kpi3.sap_code";
		$sql = "SELECT sap_code , count(DISTINCT cus_number) as num FROM debtor_kpi3 WHERE LEFT(sap_code,1) LIKE '$NUMBER' GROUP BY sap_code";
		$query = mysqli_query($conn,$sql) or die(mysqli_error($conn));
		//$mode1 = mysqli_num_rows($query);
		/*while($ofname = mysqli_fetch_array($query)){ 
			$ofname1 = $ofname["dept_name"];
		}*/

	?>
		<div data-role="page" id="page">
			<div data-role="header" data-theme="b">
				<h1>ลูกหนี้ค่าไฟฟ้าเอกชนรายย่อยที่มีบิลค้างชำระเกิน 2 เดือนหรือไม่ต่อเนื่อง</h1>
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
				echo "<b>รายงานลูกหนี้ค่าไฟฟ้าเอกชนรายย่อยที่มีบิลค้างชำระเกิน 2 เดือนหรือไม่ต่อเนื่อง (บิลเดือนล่าสุด $mmm) แยกตามสังกัดของ $reg เพียงวันที่ $ccc</b><br/>";
			?>
			</div>
			<div data-role="content">	
				<ul data-role="listview">
				<?php
					mysqli_data_seek($query,0);
					$a = 1;
					while($result=mysqli_fetch_array($query)){
						$sql2 = "SELECT * from debtor_kpi3 where sap_code = '".$result['sap_code']."'";
						$query2 = mysqli_num_rows(mysqli_query($conn,$sql2));
						$sql3 = mysqli_fetch_assoc(mysqli_query($conn,"SELECT dept_name FROM pea_office WHERE sap_code = '".$result['sap_code']."' LIMIT 1"));
						echo "<li><a href ='req_office.php?REQ=".$result["sap_code"]."'>".$a.".".$sql3["dept_name"]."  จำนวน  ".$result["num"]." ราย (".$query2." บิล)</a></li>";;
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
