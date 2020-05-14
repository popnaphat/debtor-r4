<?php
include('./includes/conn.php');
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

//ฟิลด์ที่จะเอามาแสดงและค้นหา
$columns = array( 
// datatable column index  => database column name
	0 => 'manager_id', 
	1 => 'notify_timestamp',
	2 => 'time_view',
	3 => 'dept_view',	
	4 => 'name',
	5 => 'surname',
	6 => 'pre_name',
	7 => 'dept_name',
	8 => 'position'
);

// getting total number records without any search
$sql = "SELECT * FROM tbl_log_notify ln LEFT JOIN peaemp pm ON ln.manager_id = pm.empID JOIN pea_office po ON LEFT(pm.dept_change_code,11) = LEFT(po.unit_code,11) GROUP BY ln.id";

$query=mysqli_query($conn, $sql);
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT * FROM tbl_log_notify ln LEFT JOIN peaemp pm ON ln.manager_id = pm.empID JOIN pea_office po ON LEFT(pm.dept_change_code,11) = LEFT(po.unit_code,11) GROUP BY ln.id";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( manager_id LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR notify_timestamp LIKE '%".$requestData['search']['value']."%' ";	
	$sql.=" OR time_view LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR dept_view LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR name LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR dept_name LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR position LIKE '%".$requestData['search']['value']."%' ";
	$sql.=" OR surname LIKE '%".$requestData['search']['value']."%' )";
	
}
$query=mysqli_query($conn, $sql);
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql);

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData['empcode'] = $row["manager_id"];
	$nestedData['nt'] = $row["notify_timestamp"];	
	$nestedData['tv'] = $row["time_view"];
	$nestedData['dv'] = $row["dept_view"];
	$nestedData['dn'] = $row["dept_name"];
	$nestedData['ps'] = $row["position"];
	$nestedData['ns'] = $row["pre_name"].''.$row["name"].'  '.$row["surname"];
	
	$data[] = $nestedData;
}



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format
