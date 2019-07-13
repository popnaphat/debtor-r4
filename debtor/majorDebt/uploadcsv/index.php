<?php
require('../conn.php');

if (isset($_POST["import"])) {
    
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        $sqlDelete = "DELETE FROM debtor_copy1";
        $delete = mysqli_query($conn,$sqlDelete);
        $file = fopen($fileName, "r");
        
        while (($column = fgetcsv($file, 10000, "#","#")) !== FALSE) {
            
            $sqlInsert = "INSERT into debtor_copy1 (sap_code,dept_name,cus_number,cus_name,bill_month,outstanding_debt,bail,diff)
                   values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "','" . $column[4] . "','" . $column[5] . "','" . $column[6] . "','" . $column[7] . "')";
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
    
        $sqlDelete = "DELETE FROM debtor_copy1";
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
    $("#frmCSVImport").on("sss", function () {
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

            <form class="form-horizontal" action="" method="post"
                name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
                <div class="input-row">
                    <label class="col-md-6 control-label">Choose CSV
                        File</label> <input type="file" name="file"
                        id="file" accept=".csv">
                    <button type="submit" id="submit" name="import"
                        class="btn-submit">Import</button>
                    <label class="col-md-6 control-label"><button type="sss" id="sss" name="clear"
                        class="btn-danger">Clear</button></label>
                    <br />

                </div>

            </form>

        </div>
               <?php
            $sqlSelect = "SELECT * FROM debtor_copy1";
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