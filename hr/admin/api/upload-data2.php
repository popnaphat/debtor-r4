<?php
    date_default_timezone_set("Asia/Bangkok");
    require('../includes/conn.php');
    require('../libs/utils/utils.php');
    //require('../libs/log/log_individuals.php');

    $target_path = uploadXLSXFile2($conn, $_FILES['empIssuefile']);
    $namedDataArray = getDataFromXLSXPath($target_path);
    clearPeaempData($conn);
    insertPeaempData($conn, $namedDataArray);
    $number_complaint = countPeaempData($conn);
    echo "ได้เพิ่มข้อมูลแล้วทั้งหมด ".$number_complaint." ข้อมูล";
    
    // check complaint have to notify and log its
    //clearOfficeNotify($conn);
    //logOfficeToNotify($conn);
