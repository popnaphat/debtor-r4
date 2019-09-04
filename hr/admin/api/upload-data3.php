<?php
    date_default_timezone_set("Asia/Bangkok");
    require('../includes/conn.php');
    require('../libs/utils/utils.php');
    function recordto_csvdebt1($conn){
        $reg = array("J","K","L");
        foreach($reg as $row){
        $bm = "SELECT right(bill_month,7) as bm, left(sap_code,1) as region FROM debtor where right(bill_month,4) = YEAR(CURRENT_DATE)+543 and left(sap_code,1) = '$row' ORDER BY bill_month DESC LIMIT 1";
        $querybm = mysqli_query($conn,$bm);
        $fetchbm = mysqli_fetch_array($querybm);
        $mmm = substr($fetchbm['bm'],-7);
        $nnn = $fetchbm['region'];
        $id = "SELECT * FROM tbl_log_csv_debt1";
        $countid = mysqli_num_rows(mysqli_query($conn,$id)) + 1; 
        $current_timestamp = DateThai(date("Y-m-d"));
        $insert_log_file = "INSERT INTO tbl_log_csv_debt1(id,file_upload_timestamp,bill_month,region) VALUES('$countid','$current_timestamp','$mmm','$nnn')";
        mysqli_query($conn, $insert_log_file) or trigger_error($conn->error."[$insert_log_file]");
        }
    }

    $target_path = uploadXLSXFile4($conn, $_FILES['empIssuefile']);
    $namedDataArray = getDataFromXLSXPath($target_path);
    recordto_csvdebt1($conn);
    clearDebtorData($conn);
    insertDebtorData($conn, $namedDataArray);
    $number_debtor = countDebtorData($conn);
    echo "ได้เพิ่มข้อมูลแล้วทั้งหมด ".$number_debtor." ข้อมูล";

