<?php
include "../include/config.php";
$kdSpecific = $_POST['kdSpecific'];
$aod = $_POST['aod'];
$tableName = $_POST['tableName'];
$transfer = $_POST['transfer'];
$access = $_POST['access'];


if ($transfer == "db")
    $transfer = "download";
else
    $transfer = "upload";


if ($kdSpecific == "true")
    $kdSpecific = "Y";
else
    $kdSpecific = "N";


if ($aod == "true")
    $aod = "Y";
else
    $aod = "N";

$query = "update data_transfer_table set TRANSFER_NAME='" . $transfer . "', TABLE_NAME='" . $tableName . "',ACTIVE_FLAG='" . $aod . "',TYPE='" . $access . "',KD_SPECIFIC='" . $kdSpecific . "',LAST_UPDATE_DATE= now(),LAST_UPDATED_BY= 'admin' where TABLE_NAME='" . $tableName . "' and TRANSFER_NAME ='" . $transfer . "'";
mysql_query($query);
echo "Succesfully Added.";
?>