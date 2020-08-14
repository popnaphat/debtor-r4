<?php
$db = parse_url(getenv("DATABASE_URL"));
// $db["path"] = ltrim($db["path"], "/");
// echo $db['path'];
print_r($db);
?>
