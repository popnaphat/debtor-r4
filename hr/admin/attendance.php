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
        BOT MEMBER
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">BOT MEMBER</li>
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
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                  
                  <th>รหัสพนักงาน</th>
                  <th>ชื่อ - สกุล</th>
                  <th>ตำแหน่ง</th>
                  <th>สังกัด</th>
                  <th>PEA EMAIl</th>
                  <th>วันเวลาที่ลงทะเบียน</th>
                  <th>ลบสมาชิก</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT * FROM peamember mem JOIN peaemp emp ON mem.memberid = emp.empID ORDER BY mem.memberid ASC";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      echo "
                        <tr>
                          
                          <td>".$row['memberid']."</td>
                          <td>".$row['name'].' '.$row['surname']."</td>
                          <td>".$row['position']."</td>
                          <td>".$row['dept_short']."</td>
                          <td>".$row['memberpea_email']."</td>
                          <td>".$row['datetime_regis']."</td>
                          <td>
                            <button type='button' class='btn btn-danger btn-sm btn-flat delete' data-id='".$row['memberid']."' onclick='javascript:getRow(".$row['memberid'].");'><i class='fa fa-trash'></i> Delete</button>
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
  <?php include 'includes/attendance_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
  $('.edit').click(function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  /*$('.delete').click(function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });*/
});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'attendance_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.memberid').html(response.memberid);
      $('#del_attid').val(response.memberid);
      $('#del_employee_name').html(response.name+' '+response.surname);
      $('#delete').modal('show');
    }
  });
}
</script>
</body>
</html>
