<?php
include('../include/config.php');

//database query
$sql = @mysql_query("select * from scheme_master");

$rows = array();
while($r = mysql_fetch_assoc($sql)) {
  $rows[] = $r;
}

//echo result as json
echo json_encode($rows);
?>