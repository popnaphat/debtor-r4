<?php
    require('../libs/PHPExcel/Classes/PHPExcel.php');
    include('../libs/PHPExcel/Classes/PHPExcel/IOFactory.php');
    date_default_timezone_set('Asia/Bangkok');

    function getMainOfficeByOfficeCode($officeCode){
        switch(substr($officeCode, 0, 1)){
            case "J":
                return "กฟต.1";
                break;
            case "K":
                return "กฟต.2";
                break;
            case "L":
                return "กฟต.3";
                break;
            default:
                return "";
                break;
        }
    }

    function convertToStandardDate($raw_date){
        // $raw_date = d/m/Y H:m:s
        if(!isset($raw_date) || empty($raw_date)){
            return NULL;
        }
        $thaiDateTimeArray = explode(" ", $raw_date);
        $thaiDateWithSlash = $thaiDateTimeArray[0];
        $thaiDateArray = explode("/", $thaiDateWithSlash);
        $year = (int)($thaiDateArray[2]) - 543;
        $thaiDate = date_create_from_format('Y-m-d', $year."-".$thaiDateArray[1]."-".$thaiDateArray[0]);
        return $thaiDate;
    }

    function getDiffDate($sent_date, $settlement_date, $complaint_status){
        if($complaint_status == "ปิด"){
            $diff = $sent_date->diff($settlement_date);
        } else {
            $diff = $sent_date->diff(new DateTime('now'));
        }
        return ($diff->days + 1);
    }

    function getDataFromXLSXPath($xlsxPath){
        // load xlsx file with its path
        $inputFileType = PHPExcel_IOFactory::identify($xlsxPath);  
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);  
        $objReader->setReadDataOnly(true);  
        $objPHPExcel = $objReader->load($xlsxPath);  

        // set config -> activesheet, highestRow, highestColumn and get heading data
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        
        $headingsArray = $objWorksheet->rangeToArray('A1:'.$highestColumn.'1', null, true, true, true);
        $headingsArray = $headingsArray[1];

        // collect data within $namedDataArray
        $r = -1;
        $namedDataArray = array();
        for ($row = 2; $row <= $highestRow; ++$row) {
            ++$r;
            $dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row, null, true, true, true);
            foreach($headingsArray as $columnKey => $columnHeading) {
                $namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
        }
    }
        return $namedDataArray;
    }

    function uploadXLSXFile($conn, $file){
        $filename = $file['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $target_path = "../uploads-files/".basename(date('d-m-').(date("Y")+543)).".".$ext;
        $uploaded_result = @move_uploaded_file($file['tmp_name'], $target_path);
        if(!$uploaded_result) {
            die(error_get_last());
        }
        $current_timestamp = date("Y-m-d H:i:s");
        $insert_log_file = "INSERT INTO tbl_log_file(file_path, file_upload_timestamp) VALUES('$target_path', '$current_timestamp')";
        mysqli_query($conn, $insert_log_file) or trigger_error($conn->error."[$sql]");    
        return $target_path;
    }
    function uploadXLSXFile2($conn, $file){
        $filename = $file['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $target_path = "../uploads-files2/".basename(date('d-m-').(date("Y")+543)).".".$ext;
        $uploaded_result = @move_uploaded_file($file['tmp_name'], $target_path);
        if(!$uploaded_result) {
            die(error_get_last());
        }
        $current_timestamp = date("Y-m-d H:i:s");
        $insert_log_file = "INSERT INTO tbl_log_file2(file_path, file_upload_timestamp) VALUES('$target_path', '$current_timestamp')";
        mysqli_query($conn, $insert_log_file) or trigger_error($conn->error."[$sql]");    
        return $target_path;
    }

    function clearEmplistData($conn){
        $sql = "DELETE FROM emplist";
        mysqli_query($conn, $sql);
    }
    function clearPeaempData($conn){
        $sql = "DELETE FROM peaemp";
        mysqli_query($conn, $sql);
    }

    function insertEmplistData($conn, $namedDataArray){
        $count_emp = 0;
        foreach($namedDataArray as $row){
            $count_emp++;
            $empID = $row['รหัส'];
            $emp_prename = $row['PRE_NAME'];
            $emp_name = $row['ชื่อ'];
            $emp_surname = $row['นามสกุล'];
            $emp_position = $row['ตำแหน่ง'];
            $appointdate = date("Y-m-d",PHPExcel_Shared_Date::ExcelToPHP($row['บรรจุ']));
            $DEPT_SHORT = $row['DEPT_SHORT'];
            $DEPT_CHANGE_CODE = $row['DEPT_CHANGE_CODE'];
            $emp_lv = $row['ระดับ'];
            $Posidate = date("Y-m-d",PHPExcel_Shared_Date::ExcelToPHP($row['Posidate']));
            $emp_period = $row['ระยะเวลา'];
            $edu = $row['วุฒิการศึกษา'];
            // $number_of_day = getDiffDate($emp_surname, $appointdate, $edu);
            $AGE = $row['AGE'];
            $retireyear = $row['เกษียณ'];
            // check null
            // $emp_surname = isset($emp_surname) ? $emp_surname->format("Y-m-d"):NULL;
            // $emp_position = isset($emp_position) ? $emp_position->format("Y-m-d"):NULL;
            // $appointdate = isset($appointdate) ? $appointdate->format("Y-m-d"):NULL;

            $sql = "INSERT INTO emplist(id, empID, emp_prename, emp_name, emp_surname, emp_position, appointdate, DEPT_SHORT, DEPT_CHANGE_CODE, emp_lv, Posidate, emp_period, edu, AGE, retireyear) ".
                    "VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issssssssssssss",$count_emp, 
                    $empID,$emp_prename,$emp_name,
                    $emp_surname,$emp_position,$appointdate,
                    $DEPT_SHORT,$DEPT_CHANGE_CODE,$emp_lv,
                    $Posidate,$emp_period,$edu,$AGE,$retireyear);
            $stmt->execute();
        }
    }
    function insertPeaempData($conn, $namedDataArray){
        foreach($namedDataArray as $row){
            $empID = $row['รหัส'];
            $emp_prename = $row['PRE_NAME'];
            $emp_name = $row['ชื่อ'];
            $emp_surname = $row['นามสกุล'];
            $emp_position = $row['ตำแหน่ง'];
            $DEPT_SHORT = $row['DEPT_SHORT'];
            $DEPT_CHANGE_CODE = $row['DEPT_CHANGE_CODE'];
            // check null
            // $emp_surname = isset($emp_surname) ? $emp_surname->format("Y-m-d"):NULL;
            // $emp_position = isset($emp_position) ? $emp_position->format("Y-m-d"):NULL;
            // $appointdate = isset($appointdate) ? $appointdate->format("Y-m-d"):NULL;

            $sql = "INSERT INTO peaemp(empID, pre_name, name, surname, position, dept_short, dept_change_code) ".
                    "VALUES(?,?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", 
                    $empID,$emp_prename,$emp_name,
                    $emp_surname,$emp_position,
                    $DEPT_SHORT,$DEPT_CHANGE_CODE);
            $stmt->execute();
        }
    }
    /*function insertComplaintData($conn, $namedDataArray){
        $i = 0;
        foreach ($namedDataArray as $result) {
            $i++;
            $strSQL = "";
            $strSQL .= "INSERT INTO emplist "; //tabel ในดาต้าเบส  
            $strSQL .= "(id, empID, emp_prename, emp_name, emp_surname, emp_position, appointdate, DEPT_SHORT, DEPT_CHANGE_CODE,	emp_lv, Posidate, emp_period, edu, AGE, retireyear)"; //คอลัมในดาต้าเบส เรียงตามดาต้าเบส
            $strSQL .= "VALUES ";
            $strSQL .= "('".$result['รหัส']."','".$result['PRE_NAME']."'
            ,'".$result['ชื่อ']."','".$result['นามสกุล']."'
            ,'".$result['ตำแหน่ง']."','".$result['บรรจุ']."'
            ,'".$result['DEPT_SHORT']."','".$result['DEPT_CHANGE_CODE']."'
            ,'".$result['ระดับ']."','".$result['Posidate']."'
            ,'".$result['ระยะเวลา']."','".$result['วุฒิการศึกษา']."'
            ,'".$result['AGE']."','".$result['เกษียณ']."' )"; //คอลัมในดาต้าเบส เรียงตามดาต้าเบส
     
            mysqli_query($conn, $strSQL);
        }
    }*/

    function countEmplistData($conn){
        $sql = "SELECT COUNT(*) AS count_emp FROM emplist";
        $results = mysqli_query($conn, $sql) or trigger_error($conn->error."[$sql]");    
        $row = $results->fetch_assoc();
        return $row['count_emp']; 
    }
    function countPeaempData($conn){
        $sql = "SELECT COUNT(*) AS count_emp FROM peaemp";
        $results = mysqli_query($conn, $sql) or trigger_error($conn->error."[$sql]");    
        $row = $results->fetch_assoc();
        return $row['count_emp']; 
    }