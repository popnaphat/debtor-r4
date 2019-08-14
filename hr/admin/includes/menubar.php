<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <!--div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo (!empty($user['photo'])) ? '../images/'.$user['photo'] : '../images/profile.jpg'; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $user['firstname'].' '.$user['lastname']; ?></p>
          <a><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div-->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">REPORTS</li>
        <li class=""><a href="home.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li class="header">MANAGE</li>
        
        <li><a href="attendance.php"><i class="fa fa-users"></i> <span>BOT MEMBER</span></a></li>
        <li><a href="request.php"><i class="fa fa-check-square-o"></i> <span>Request</span></a></li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-upload"></i>
            <span>Upload</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="employee.php"><i class="fa fa-id-badge"></i><span>พนักงานสายงาน ภาค 4</span></a></li>
            <li><a href="overtime.php"><i class="fa fa-user-o"></i><span>พนักงานที่ยังไม่ปรับระดับ</span></a></li>
            <li><a href="schedule.php"><i class="fa fa-building-o"></i><span>การไฟฟ้าทั้งหมด</span></a></li>
            <!--li><a href="cashadvance.php"><i class="fa fa-circle-o"></i> Cash Advance</a></li>
            <li><a href="schedule.php"><i class="fa fa-circle-o"></i> Schedules</a></li-->
          </ul>
        </li>
        <li><a href="cashadvance.php"><i class="fa fa-paper-plane-o"></i> <span>Detail & Go</span></a></li>
        <li><a href="deduction.php"><i class="fa fa-calendar-check-o"></i> <span>วันแจ้งเตือน</span></a></li>
        <li><a href="position.php"><i class="fa fa-suitcase"></i> <span>Activity log</span></a></li>
        <!--li class="header">PRINTABLES</li>
        <li><a href="payroll.php"><i class="fa fa-files-o"></i> <span>Payroll</span></a></li>
        <li><a href="schedule_employee.php"><i class="fa fa-clock-o"></i> <span>Schedule</span></a></li-->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
