<?php
include "../include/config.php";
$kdSpecific = $_POST['kdSpecific'];
$aod = $_POST['aod'];
$tableNames = $_POST['tableName'];
$transfer = $_POST['transfer'];
$access = $_POST['access'];


if ($transfer == "db")

    $transfer = "download";
else
    $transfer = "upload";
foreach ($tableNames as $tableName)
{
$query = "select * from data_transfer_table where TABLE_NAME ='" . $tableName . "' AND TRANSFER_NAME='" . $transfer . "'";
$result = mysql_query($query);
$count = mysql_num_rows($result);

if ($count == 0) {
    $query = "insert into data_transfer_table values('" . $transfer . "','" . $tableName . "','" . $aod . "','" . $access . "','" . $kdSpecific . "',now(),'admin',now(),'admin','')";
    mysql_query($query);
  
} else {
	
    echo "Failed : Table Name Already exists";
}

}

  echo "Succesfully saved .";
?>