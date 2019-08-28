<?php
include('./includes/conn.php');
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

//ฟิลด์ที่จะเอามาแสดงและค้นหา
$columns = array( 
// datatable column index  => database column name
	0 =>'sap_code', 
	1 => 'dept_name',
	2 => 'cus_number',
	3 => 'cus_name',
	4 => 'bill_month',
	5 => 'outstanding_debt',
	6 => 'bail',
	7 => 'diff'
);

// getting total number records without any search
$sql = "SELECT * ";
$sql.=" FROM debtor";
$query=mysqli_query($conn, $sql) or die("outstanding_debtor_grid_data.php: get debtor");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT sap_code,dept_name,cus_number,cus_name,bill_month";
$sql.=" FROM debtor WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( sap_code LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR dept_name LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR cus_number LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR cus_name LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR bill_month LIKE '".$requestData['search']['value']."%' ";
}
$query=mysqli_query($conn, $sql) or die("outstanding_debtor_grid_data.php: get debtor");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("outstanding_debtor_grid_data.php: get debtor");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["sap_code"];
	$nestedData[] = $row["dept_name"];
	$nestedData[] = $row["cus_number"];
	$nestedData[] = $row["cus_name"];
	$nestedData[] = $row["bill_month"];
	$nestedData[] = $row["outstanding_debt"];
	$nestedData[] = $row["bail"];
	$nestedData[] = $row["diff"];
	
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
