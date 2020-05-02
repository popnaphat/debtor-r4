<?php
 
$curl = curl_init();
 
curl_setopt_array($curl, array(
CURLOPT_URL => "https://opend.data.go.th/opend-search/vir_3250_1584586227/query?dsname=vir_3250_1584586227&path=vir_3250_1584586227&loadAll=1&type=json&limit=100&offset=0",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 30,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => "GET",
CURLOPT_HTTPHEADER => array(
"api-key: uqGqYYPRbQcNcnilpIfyOVTNBfvMG3QT"
)
));
 
$response = curl_exec($curl);
$err = curl_error($curl);
 
curl_close($curl);
 
if ($err) {
echo "cURL Error #:" . $err;
} else {
echo $response;
}
?>