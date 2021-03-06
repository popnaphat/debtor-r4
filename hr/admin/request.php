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
        Direct request
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Direct request</li>
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
                  <th>PEA EMAIL</th>
                  <th>ยืนยันสมาชิก</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT * FROM peaemp e left join peaemail m on e.empID = m.empcode WHERE e.direct_request = 'A' ";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      echo "
                        <tr>
                          
                          <td>".$row['empID']."</td>
                          <td>".$row['pre_name'].''.$row['name'].' '.$row['surname']."</td>
                          <td>".$row['position']."</td>
                          <td>".$row['dept_short']."</td>
                          <td>".$row['pea_email']."</td>
                          <td>
                            <button type='button' class='btn btn-success btn-sm btn-flat delete' data-id='".$row['empID']."' onclick='javascript:getRow(".$row['empID'].");'><i class='fa fa-thumbs-up'></i> Approve</button>
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
  <?php include 'includes/request_modal.php'; ?>
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
    url: 'request_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.memberid').html(response.empID);
      $('#del_attid').val(response.empID);
      $('#del_employee_name').html(response.pre_name+''+response.name+' '+response.surname);
      $('#delete').modal('show');
    }
  });
}
</script>
</body>
</html>
