<?php
require('./libs/database/connect-db.php');
	$code = $_GET['code'];
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Confirm register PEA HR LINE bot</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- css -->
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.css" />
        <!-- js -->
        <script src="./assets/jquery/jquery-3.3.1.min.js"></script>
        <script src="./assets/bootstrap/js/bootstrap.js"></script>
        <script src="./assets/blockUI/jquery.blockUI.js"></script>
        <script src="./assets/jqueryScrollTableBody/jqueryScrollTableBody.js"></script>
</head>
<body>
	<?php 
		
		$check = "SELECT * FROM peaemp WHERE activation='$code'";
		$querycheck = mysqli_query($conn, $check);
		$checknum = mysqli_num_rows($querycheck);
		$res = mysqli_fetch_array($querycheck);
		$name = $res['name'];
		$surname = $res['surname'];
		$userId = $res['user_id'];
        $status = $res['active_status'];
        $empID = $res['empID'];
        $email = $res['pea_email'];
		if($checknum == 0){
			$texts = "รหัสพนักงานนี้ได้ลงทะเบียนไปแล้ว";
			echo $texts;
			return ;
		}
	?>
	<div class="container-fluid">
		<form name="confirm123" id="confirm123" method="post" >
		<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
					<label><?php echo "ยืนยันการลงทะเบียนของคุณ$name $surname"; ?></label>
					<div class="form-group">
                            <input class="btn btn-success" type="submit" name="submit" value="ยืนยันการลงทะเบียน" />
                            <input class="btn btn-danger" onclick='window.close();' type="button" value="ปิด" />
                    </div></div></div></div>
		</form>
	</div>
	<script>
            $('[id="confirm123"]').submit(function(event){
                event.preventDefault();
                var formData = new FormData();
                formData.append('code', '<?=$code ?>');
				formData.append('name', '<?=$name ?>');
				formData.append('surname', '<?=$surname ?>');
				formData.append('userId', '<?=$userId ?>');
				formData.append('status', '<?=$status ?>');
                formData.append('empID', '<?=$empID ?>');
                formData.append('email', '<?=$email ?>');
                $.ajax({
                    url: './activation2.php',
                    method: 'POST',
                    data: formData,
                    async: true,
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
                 
                        $.blockUI({ message:'<h3>LOADING...</h3>' });
                    },
                    success: function(response) {
                        alert(response);
                        window.close();
                    }
                });
                return false;
            });
    </script>
</body>
</html>
