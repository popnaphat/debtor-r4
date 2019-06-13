<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">
  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      อัพโหลด FILE พนักงานแรกบรรจุ
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Employees</li>
        <li class="active">Overtime</li>
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
      ?>
      <form name="firstlv" id="firstlv" method="POST" class="text-center" enctype="multipart/form-data">
                        <div class="row form-group">
                            <div class="col-md-2"><div align="center">
                            <input type="file" required name="firstlvfile" class="form-control-file btn btn-dark" id="firstlvfile" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                            </div></div>
                            <div class="col-md-2"><div align="center">
                            <input type="submit" class="btn btn-success" value="อัพโหลดข้อมูล">
                            </div></div>
                        </div>
                    </form>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                  <th>รหัส</th>
                  <th>ชื่อ - สกุล</th>
                  <th>ตำแหน่ง</th>
                  <th>สังกัด</th>
                  <th>วันบรรจุ</th>
                  <th>ระยะเวลาที่ครองตำแหน่ง</th>
                  <th>ปลายทาง</th>
                  <th>ลบชื่อพนักงาน</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT empID,dept_cover,emp_prename,emp_name,emp_surname,emp_position,DEPT_SHORT,appointdate, DEPT_CHANGE_CODE,region
                    , TIMESTAMPDIFF( YEAR, appointdate, now() ) as _year
                    , TIMESTAMPDIFF( MONTH, appointdate, now() ) % 12 as _month
                    , FLOOR( TIMESTAMPDIFF( DAY, appointdate, now() ) % 30.4375 ) as _day
                     FROM emplist em JOIN pea_office po ON po.unit_code = em.DEPT_CHANGE_CODE ORDER BY em.empID ASC";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      echo "
                        <tr>
                          <td>".$row['empID']."</td>
                          <td>".$row['emp_prename'].''.$row['emp_name'].' '.$row['emp_surname']."</td>
                          <td>".$row['emp_position']."</td>
                          <td>".$row['DEPT_SHORT']."</td>
                          <td>".$row['appointdate']."</td>
                          <td>".$row['_year']." ปี ".$row['_month']." เดือน ".$row['_day']." วัน</td>
                          <td>
                          ".$row['dept_cover'].' '.$row['region']."
                          </td>
                          <td>
                            <button type='button' class='btn btn-danger btn-sm btn-flat delete' data-id='".$row['empID']."' onclick='javascript:getRow(".$row['empID'].");'><i class='fa fa-trash'></i> Delete</button>
                          </td>
                        </tr>
                      ";
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
    
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/overtime_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
        $(function(){
            $('[id="firstlv"]').submit(function(event){
                event.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: './api/upload-data.php',
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
    
$(function(){
  $('.edit').click(function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  // $('.delete').click(function(e){
  //   e.preventDefault();
  //   $('#delete').modal('show');
  //   var id = $(this).data('id');
  //   console.log('delete trigger on ',id);
  //   getRow(id);
  // });
});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'overtime_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.memberid').html(response.empID);
      $('#del_attid').val(response.empID);
      $('#del_employee_name').html(response.emp_name+' '+response.emp_surname);
      $('#delete').modal('show');
    },
    error: function(error){

    }, 
    complete: function(data){

    }
  });
}
</script>
</body>
</html>
