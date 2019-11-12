<?php include 'includes/session.php'; ?>
<?php if($_SESSION['user_type'] <> "admin"){
			header('location: home.php');
	}?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">
  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <h1>อัพโหลด FILE Update ลูกหนี้ค้างชำระเกินเงินประกัน</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Employees</li>
        <li class="active">Outstanding debtors</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
        function DateThai($strDate){
          $strYear = date("Y",strtotime($strDate))+543;
          $strMonth= date("n",strtotime($strDate));
          $strDay= date("j",strtotime($strDate));
          $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
          $strMonthThai=$strMonthCut[$strMonth];
          return "$strDay $strMonthThai $strYear";
      }
      function recordto_csvdebt1($conn,$reg){
        $bm = "SELECT right(bill_month,7) as bm, left(sap_code,1) as region FROM debtor where right(bill_month,4) = YEAR(CURRENT_DATE)+543 and left(sap_code,1) = '$reg' ORDER BY bm DESC LIMIT 1";
        $querybm = mysqli_query($conn,$bm);
        $fetchbm = mysqli_fetch_array($querybm);
        $mmm = substr($fetchbm['bm'],-7);
        $nnn = $fetchbm['region'];
        $id = "SELECT * FROM tbl_log_csv_debt1";
        $countid = mysqli_num_rows(mysqli_query($conn,$id)) + 1; 
        $current_timestamp = DateThai(date("Y-m-d"));
        $insert_log_file = "INSERT INTO tbl_log_csv_debt1(id,file_upload_timestamp,bill_month,region) VALUES('$countid','$current_timestamp','$mmm','$nnn')";
        mysqli_query($conn, $insert_log_file);// or trigger_error($conn->error."[$insert_log_file]")
    }
      if (isset($_POST["import"])) {
          $filenn = $_FILES["file"];
          $fileName = $_FILES["file"]["tmp_name"];
          if ($_FILES["file"]["size"] > 0) {
              $file = fopen($fileName, "r");              
              while (($column = fgetcsv($file, 0, "#","#")) !== FALSE) {
                  $timeupload = DateThai(date("Y-m-d"));
                  $sqlInsert = "INSERT into debtor(sap_code,dept_name,cus_number,cus_name,bill_month,outstanding_debt,bail,diff,timeupload)
                         values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "','" . $column[4] . "','" . $column[5] . "','" . $column[6] . "','" . $column[7] . "','" . $timeupload . "')";
                  mysqli_query($conn, $sqlInsert);                  
              }
              recordto_csvdebt1($conn);
          }
          echo "<meta http-equiv='refresh' content='0'>";
      }
      ?>
      <div class="row">
          <div class="col-md-6">
                    <form name="empIssue" id="empIssue" method="POST" class="text-center" enctype="multipart/form-data">
                        <div class="row form-group">
                        <div class="col-lg-6"><div align="center">
                            <input type="file" required name="empIssuefile" class="form-control-file btn btn-dark" id="empIssuefile" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                        </div></div>
                        <div class="col-lg-6"><div align="center">
                            <input type="submit" class="btn btn-success" value="อัพโหลดข้อมูล">
                            </div></div>
                        </div>
                    </form>
          </div>
          <div class="col-md-6">
            <form action="" method="post" name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
                  <div class="form-group"><div class="row">
                  <div class="col-lg-6">                    
                        <input type="file" class="custom-file-input" name="file" id="file" accept=".csv"></div>
                        <div class="col-lg-6">    
                        <button class="btn btn-primary" type="submit" id="submit" name="import">Upload</button>
                        </div>
                  </div></div>                              
            </form>
          </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <table id="outdebtor-grid" class="table table-bordered table-hover">
                <thead>
                  <th>รหัส SAP</th>
                  <th>ชื่อ กฟฟ</th>
                  <th>CA</th>
                  <th>ชื่อลูกค้า</th>
                  <th>บิลเดือน</th>
                  <th>หนี้คงค้าง</th>
                  <th>เงินประกัน</th>
                  <th>ผลต่าง</th>
                </thead>
                
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>  
  <?php include 'includes/footer.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
        $(function(){
            $('[id="empIssue"]').submit(function(event){
                event.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: './api/upload-data3.php',
                    method: 'POST',
                    data: formData,
                    async: true,
                    cache: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    processData: false,
                    beforeSend: function(){
                        $.blockUI({ message:'<h3>Uploading xlsx file...</h3>' });
                    },
                    success: function(response) {
                        alert(response);
                    },
                    error: function(response){
                        console.log('[error]', response);
                    },
                    complete: function() {
                        $.unblockUI();
                        location.reload();
                    }
                });
                return false;
            });
        });
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
});
    </script>
</body>
</html>
