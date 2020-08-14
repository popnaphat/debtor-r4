<?php
$db = parse_url(getenv("DATABASE_URL"));
// $db["path"] = ltrim($db["path"], "/");
// echo $db['path'];
//print_r($db);
//$conn = pg_connect(getenv("DATABASE_URL"));
//print_r($conn);
$result = pg_query("SELECT * FROM peamember WHERE memberid = '251211'");
while($row = pg_fetch_assoc($result)){
print_r($row);
}
?>
