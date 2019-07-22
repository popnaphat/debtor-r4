<?php
require('../conn.php');
require('../../timezone.php');
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
function uploadCSVFile($conn, $file){
    $filename = $file['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $target_path = "./filecsv/".basename(date('d-m-').(date("Y")+543)).".".$ext;
    $uploaded_result = @move_uploaded_file($file['tmp_name'], $target_path);
    if(!$uploaded_result) {
        die(error_get_last());
    }
    
    $current_timestamp = date("Y-m-d H:i:s");
    $insert_log_file = "INSERT INTO tbl_log_csv_debt1(file_path, file_upload_timestamp) VALUES('$target_path', '$current_timestamp')";
    mysqli_query($conn, $insert_log_file) or trigger_error($conn->error."[$sql]");    
    return $target_path;
}

if (isset($_POST["import"])) {
    $filenn = $_FILES["file"];
    $fileName = $_FILES["file"]["tmp_name"];
    if ($_FILES["file"]["size"] > 0) {
        $file = fopen($fileName, "r");
        uploadCSVFile($conn,$filenn);
        while (($column = fgetcsv($file, 10000, "#","#")) !== FALSE) {
            $timeupload = DateThai(date("Y-m-d"));
            $sqlInsert = "INSERT into debtor(sap_code,dept_name,cus_number,cus_name,bill_month,outstanding_debt,bail,diff,timeupload)
                   values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "','" . $column[4] . "','" . $column[5] . "','" . $column[6] . "','" . $column[7] . "','" . $timeupload . "')";
            $result = mysqli_query($conn, $sqlInsert);
            
            if (! empty($result)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }
        }
    }
}
if (isset($_POST["clear"])) {
    
        $sqlDelete = "DELETE FROM debtor";
        $result = mysqli_query($conn,$sqlDelete);
            
            if (! empty($result)) {
                $type = "success";
                $message = "The Database has been clear";
            } else {
                $type = "error";
                $message = "Problem in clear Database";
            }
        
    
}
?>
<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="jquery-3.2.1.min.js"></script>

<style>
body {
	font-family: Arial;
	width: 1200px;
}

.outer-scontainer {
	background: #F0F0F0;
	border: #e0dfdf 1px solid;
	padding: 20px;
	border-radius: 2px;
}

.input-row {
	margin-top: 0px;
	margin-bottom: 20px;
}

.btn-submit {
	background: #333;
	border: #1d1d1d 1px solid;
	color: #f0f0f0;
	font-size: 0.9em;
	width: 100px;
	border-radius: 2px;
	cursor: pointer;
}

.outer-scontainer table {
	border-collapse: collapse;
	width: 100%;
}

.outer-scontainer th {
	border: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

.outer-scontainer td {
	border: 1px solid #dddddd;
	padding: 8px;
	text-align: left;
}

#response {
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 2px;
    display:none;
}

.success {
    background: #c7efd9;
    border: #bbe2cd 1px solid;
}

.error {
    background: #fbcfcf;
    border: #f3c6c7 1px solid;
}

div#response.display-block {
    display: block;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $("#frmCSVImport").on("submit", function () {

	    $("#response").attr("class", "");
        $("#response").html("");
        var fileType = ".csv";
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
        if (!regex.test($("#file").val().toLowerCase())) {
        	    $("#response").addClass("error");
        	    $("#response").addClass("display-block");
            $("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
            return false;
        }
        return true;
    });
    $("#frmCSVClear").on("submit", function () {

	    $("#response").attr("class", "");
        $("#response").html("");
         
        return true;
    });

});
</script>
</head>

<body>
    <h2>Import CSV file into debtorTBL using PHP</h2>
    
    <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
    <div class="outer-scontainer">
        <div class="row">

            <form class="form-row col-md-6" action="" method="post"
                name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
                <div class="input-row">
                    <label class="col control-label">Choose CSV
                        File</label> <input type="file" name="file"
                        id="file" accept=".csv">
                    <button type="submit" id="submit" name="import"
                        class="col btn-submit">Import</button>
                </div>
                <br/>
            </form>
            <form class="form-row col-md-6" action="" method="post"
                name="frmCSVClear" id="frmCSVClear" enctype="multipart/form-data">
                    <button type="submit" id="submit" name="clear"
                        class="btn-submit">Clear</button>
                    <br/>
            </form>
            
        </div>
               <?php
            $sqlSelect = "SELECT * FROM debtor";
            $result = mysqli_query($conn, $sqlSelect);
            
            if (mysqli_num_rows($result) > 0) {
                ?>
            <table id='userTable'>
            <thead>
                <tr>
                    <th>sapcode</th>
                    <th>กฟฟ</th>
                    <th>CA</th>
                    <th>ชื่อลูกค้า</th>
                    <th>บิลเดือน</th>
                    <th>หนี้ค้างชำระ</th>
                    <th>เงินประกัน</th>
                    <th>เงินส่วนต่าง</th>

                </tr>
            </thead>
<?php
                
                while ($row = mysqli_fetch_array($result)) {
                    ?>
                    
                <tbody>
                <tr>
                    <td><?php  echo $row['sap_code']; ?></td>
                    <td><?php  echo $row['dept_name']; ?></td>
                    <td><?php  echo $row['cus_number']; ?></td>
                    <td><?php  echo $row['cus_name']; ?></td>
                    <td><?php  echo $row['bill_month']; ?></td>
                    <td><?php  echo $row['outstanding_debt']; ?></td>
                    <td><?php  echo $row['bail']; ?></td>
                    <td><?php  echo $row['diff']; ?></td>
                </tr>
                    <?php
                }
                ?>
                </tbody>
        </table>
        <?php } ?>
    </div>

</body>

</html>