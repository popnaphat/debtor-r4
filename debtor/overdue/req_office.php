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
		$reg = substr($NUMBER,0,1);
		//$NUMBER2 = $_GET['REQ2'];
		$dateupload = "SELECT bill_month FROM tbl_log_csv_debt2 where right(bill_month,4) = YEAR(CURRENT_DATE) and region = '$reg' ORDER BY bill_month DESC LIMIT 1";
			$querydu = mysqli_query($conn,$dateupload);
			$fetchdu = mysqli_fetch_array($querydu);
			$mmm = $fetchdu['bill_month'];
			$crecord2 = "SELECT * FROM tbl_log_csv_debt2 ORDER BY id DESC LIMIT 1";
			$crecord1 = mysqli_fetch_array(mysqli_query($conn,$crecord2));
			$ccc = $crecord1['file_upload_timestamp'];
		
		$sql = "SELECT * from debtor_kpi where sap_code = '$NUMBER'";
		$query = mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$mode2 = mysqli_num_rows($query);
		
		$sql2 = "SELECT * from debtor_kpi k join pea_office o on o.sap_code = k.sap_code where k.sap_code = '$NUMBER' GROUP BY k.cus_number";
		$query2 = mysqli_query($conn,$sql2) or die(mysqli_error($conn));
		
		$mode1 = mysqli_num_rows($query2);
		while($ofname = mysqli_fetch_array($query2)){ 
			$ofname1 = $ofname["dept_name"];
		}
	?>
		<div data-role="page" id="page">
			<div data-role="header" data-theme="b">
				<h1>ลูกหนี้ค่าไฟฟ้าเอกชนรายใหญ่ค้างชำระเกินกำหนด</h1>
			</div>
			<div data-role="content">
			<?php 
				echo "<b>รายงานลูกหนี้ค่าไฟฟ้าเอกชนรายใหญ่ค้างชำระเกินกำหนด (บิลค้างชำระก่อนเดือน $mmm) ของ $ofname1 จำนวน $mode1 ราย $mode2 บิล ข้อมูล ณ วันที่ $ccc</b><br/>";	
				mysqli_data_seek($query,0);
			?>
			</div>
			<?php
					$aa = 1;
					while($result = mysqli_fetch_array($query)){
							echo '<div data-role="content">'; 
							echo "<b>".$aa.".</b>".$result["cus_name"].", <b>หมายเลขผู้ใช้ไฟ:</b>".$result["cus_number"].", <b>สายการอ่านหน่วย:</b>".$result["line_code"].", <b>บิลเดือน:</b>".$result["bill_month"].", <b>ประเภทเอกสาร:</b>".$result["doc_type"].", <b>หนี้ค้าง:</b>".$result["outstanding_debt"]."บาท, <b>เบอร์:</b>".$result["cus_tel"]."<br>";
							echo '</div>';						
						$aa = $aa+1;
					}
					mysqli_data_seek($query,0);
					$aa = 0;
					mysqli_close($conn);				
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
