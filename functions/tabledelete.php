<?php
include "../include/config.php";
$tableName = $_POST['tableName'];
$process = $_POST['process'];

if($process =="ub")
    $process = "upload";
else
    $process="download";

$query = "delete from data_transfer_table where TABLE_NAME = '" . $tableName . "' and TRANSFER_NAME ='" . $process . "'";
mysql_query($query);

echo ("Succesfully Deleted ");
?>