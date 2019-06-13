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
        ปลายทาง
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">ปลายทาง</li>
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
            <!--div class="box-header with-border">
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
            </div-->
            <div class="box-body">
              <table id='example1' class="table table-bordered table-hover">
                <thead>
                  <th class="hidden"></th>
                  <th>ฝ่าย/กอง/กฟฟ</th>
                  <th>เขต</th>
                  <th>จำนวน(คน)</th>
                  <th>รายชื่อผู้รับ</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT region, left(DEPT_CHANGE_CODE,11) as dcc, dept_name, count(dept_name) as empnum from emplist join pea_office on emplist.DEPT_CHANGE_CODE = pea_office.unit_code  GROUP BY left(DEPT_CHANGE_CODE,11) ORDER BY DEPT_CHANGE_CODE ASC, region ASC";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      echo "
                        <tr>
                          <td class='hidden'></td>
                          <td>".$row['dept_name']."</td>
                          <td>".$row['region']."</td>
                          <td>".$row['empnum']."</td>                          
                          <td>                            
                            <button type='button' class='btn btn-success' onclick='editTopic(".$row['dcc'].");'><span class='fa fa-paper-plane-o'></span> View list</button>
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
  <?php include 'includes/cashadvance_modal.php'; ?>
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

  $('.delete').click(function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });
});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'cashadvance_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      console.log(response);
      $('.date').html(response.date_advance);
      $('.employee_name').html(response.firstname+' '+response.lastname);
      $('.caid').val(response.caid);
      $('#edit_amount').val(response.amount);
    }
  });
}
            function editTopic(topicId){
                var newwindow = window.open("req_office1.php?REQ="+topicId, "", "width=500,height=650,left=10,top=10,titlebar=no,toolbar=no,menubar=no,location=no,directories=no,status=no");
                if (window.focus) {
                    newwindow.focus();
                }
                return false;
            }
            
</script>
</body>
</html>
