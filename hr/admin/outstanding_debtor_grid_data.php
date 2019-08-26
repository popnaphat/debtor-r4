<?php
include('./includes/conn.php');
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

//ฟิลด์ที่จะเอามาแสดงและค้นหา
$columns = array( 
// datatable column index  => database column name
	0 =>'empID', 
	1 => 'surname',
	2 => 'position',
	3 => 'dept_short'
);

// getting total number records without any search
$sql = "SELECT empID, surname, position, dept_short ";
$sql.=" FROM peaemp";
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT empID, pre_name, name, surname, position, dept_short ";
$sql.=" FROM peaemp WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( surname LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR pre_name LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR name LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR empID LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR dept_short LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR position LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["empID"];
	$nestedData[] = $row["pre_name"].''.$row["name"].' '.$row["surname"];
	$nestedData[] = $row["position"];
	$nestedData[] = $row["dept_short"];
	
	$data[] = $nestedData;
}



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
