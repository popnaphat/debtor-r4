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
?>
<!DOCTYPE html> 
<html lang="th">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1" data-ajax="false">
		<meta charset="utf-8" >
		<title>ลูกหนี้ค่าไฟฟ้าเอกชนรายใหญ่ค้างชำระเกินเงินประกัน</title>
		<link rel="manifest" href="./images/manifest.json">
		<meta name="theme-color" content="#710E82">

		
		<link href="jquery.mobile.theme-1.0.min.css" rel="stylesheet" />
		<link href="jquery.mobile.structure-1.0.min.css" rel="stylesheet" />
		<script src="jquery-1.6.4.min.js" ></script>
		<script src="jquery.mobile-1.0.min.js" ></script>
		<!-- <script>
			$(function(){
				liff.init();
			});
		</script> -->
	</head> 
	<body> 
		<?php
			require('conn.php');
			$crecord1 = mysqli_fetch_assoc(mysqli_query($conn,"SELECT file_upload_timestamp FROM tbl_log_file ORDER BY file_upload_timestamp DESC LIMIT 1"));
			$ccc = DateThai($crecord1['file_upload_timestamp']);
			/*$NUMBER = $_GET['NUMBER'];
			$addpos = strpos($NUMBER,"@");
			$lengh = strlen($NUMBER);
			$lengh1 =$lengh-1;
			echo $NUMBER;
			// if($addpos == 0){
			$datenum = substr($NUMBER,$addpos+1,$lengh1);*/
			$sql = "SELECT po.region,po.region2,count(DISTINCT el.empID) AS num FROM emplist el LEFT JOIN pea_office po ON po.unit_code = el.DEPT_CHANGE_CODE GROUP BY po.region";
			// }
			$query = mysqli_query($conn,$sql);
		?>
		<div data-role="page" id="page">
			<div data-role="header" data-theme="b">
				<h1>ลูกหนี้ค่าไฟฟ้าเอกชนรายใหญ่ค้างชำระเกินเงินประกัน</h1>
			</div>
			<div data-role="content">
			<?php   
				echo "<b>ข้อมูลพนักงานที่ครบหลักเกณฑ์การแต่งตั้งพนักงานแรกบรรจุ ข้อมูล ณ วันที่ $ccc</b><br/>";	
			?>
			</div>
			<div data-role="content">
				<ul data-role="listview">
					<?php
						$a = 1;
						while($result=mysqli_fetch_array($query)){
							$reg = $result['region2'];
							echo "<li><a href ='region.php?REQ=".$result["region2"]."'>".$a.".".$result["region"]."  จำนวน  ".$result["num"]." คน </a></li>";
							$a =$a +1;
						}
						$a = 0;
						mysqli_close($conn);
					?>
				</ul>		
			</div>
			<div data-role="footer" data-theme="b">
				<h4>PEA REGION 4</h4>
			</div>
		</div>
		<!-- <script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script>
		<script src="liff-starter.js"></script> -->
	</body>
	<?php include("googleAna.php"); ?>
</html>
