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
        รายชื่อการไฟฟ้า
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Employees</li>
        <li class="active">รายชื่อการไฟฟ้า</li>
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
            <!-- <div class="box-header with-border">
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
            </div> -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                  <th>รหัส15หลัก</th>
                  <th>รหัส SAP</th>
                  <th>ฝ่าย/กอง/กฟฟ</th>
                  <th>แผนก</th>
                  <th>ชั้น</th>
                  <th>ชื่อย่อ</th>
                  <th>เขต</th>
                  <th>แก้ไข/ลบ</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT * FROM pea_office";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      echo "
                        <tr>
                          <td>".$row['unit_code']."</td>
                          <td>".$row['sap_code']."</td>
                          <td>".$row['dept_name']."</td>
                          <td>".$row['unit_name']."</td>
                          <td>".$row['dept_class']."</td>
                          <td>".$row['short_name']."</td>
                          <td>".$row['region']."</td>
                          <td>
                          <button type='button' class='btn btn-success btn-sm btn-flat edit' data-id='".$row['unit_code']."' onclick='javascript:getRow(".$row['unit_code'].");'><i class='fa fa-edit'></i> Edit</button>
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
  <?php include 'includes/schedule_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
// $(function(){
//   $('.edit').click(function(e){
//     e.preventDefault();
//     $('#edit').modal('show');
//     var id = $(this).data('id');
//     getRow(id);
//   });

//   $('.delete').click(function(e){
//     e.preventDefault();
//     $('#delete').modal('show');
//     var id = $(this).data('id');
//     getRow(id);
//   });
// });

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'schedule_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('#timeid').val(response.unit_code);
      $('#sapcode').val(response.sap_code);
      $('#edit_deptname').val(response.dept_name);
      $('#edit_time_out').val(response.unit_name);
      $('#edit_deptclass').val(response.dept_class);
      $('#edit_short_name').val(response.short_name);
      $('#edit_region').val(response.region);
      $('#del_timeid').val(response.unit_code);
      $('#del_schedule').html(response.region+' - '+response.short_name);
      $('#edit').modal('show');
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
