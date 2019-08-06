<?php
date_default_timezone_set("Asia/Bangkok");
  require('./majorDebt/conn.php');
  /*require('./libs/utils/date_thai.php');
  require('./libs/utils/date_utils.php');*/
  require('./libs/utils/messages.php');
  require('./libs/utils/messages2.php');
  require('./send_region.php');
  require('./send_manager.php');
  require('./pushnum.php');

  // sendtomanager();
  // sendtoregion();
  echo "ok200";
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
  // $ttn = getnumsend();
  // echo $ttn;
  ?>