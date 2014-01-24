<?php
set_time_limit (0);
error_reporting(0);
include "../include/config.php";
$kd = $_GET['kd'];
$extra = "";
if ($kd) {
    $extra = " where KD_Code = '" . $kd . "'";
}
$query = "SELECT * FROM kd" . $extra;
$result = mysql_query($query); // collection of base list

$processDate = date('Y-m-d H:i:s');
$totalCount = 0; // total count of sub process
$errorCount = 0; // Error count of sub process
$processStatus = "On Progress";
$query = "insert into data_transfer_process values ('','2','" . $processStatus . "','" . $processDate . "','" . $processDate . "','admin','" . $processDate . "','admin')";
mysql_query($query);
$processID = mysql_insert_id();


$query = "select * from host_information";
$host_infos = mysql_query($query);

while ($host_info = mysql_fetch_array($host_infos)) {
    $hostIP = $host_info['Host_IP'];
    $hostURL = $host_info['Host_Url'];
}

$hostPath = $hostIP . "_";
if ($hostURL != "") {
    $hostPath .= $hostURL . "_";
}


while ($row = mysql_fetch_array($result)) {

    $createDate = date('Y-m-d H:i:s');

    $query = "select * from base_information where KD_Code ='" . $row['KD_Code'] . "'";
    $listIPadd = mysql_query($query);
    while ($baselistIPadd = mysql_fetch_array($listIPadd)) {
        $baseIPadd = $baselistIPadd['Base_IP'];
        $basePath = $baselistIPadd['Base_Url'];
    }
    $baseloc = $baseIPadd . "_";
    if ($basePath != "") {
        $baseloc .= $basePath . "_";
    }
    // echo $baseloc;
    $ping = pingDomain($baseIPadd);
    $transferHdrID = updateLogHDR($row['KD_Code'], $status, $createDate, $processID);
    if ($ping > -1) {         // If base system avaible
        
        purge($row['KD_Code']);
        $query = "SELECT * FROM data_transfer_table where ACTIVE_FLAG='Y' AND TRANSFER_NAME = 'upload'";
        $tables = mysql_query($query);
        while ($tablenames = mysql_fetch_array($tables)) {

            $query = "SELECT * FROM  `data_transfer_transaction_hdr` 
                     WHERE  `TRANSFER_NAME` =  'Upload from Base'
                     AND  `SOURCE` =  '" . $row['KD_Code'] . "' AND STATUS = 'Completed' ORDER BY  `TRANSFER_HDR_ID` DESC  LIMIT 0,1";

            $hdrs = mysql_query($query);
            while ($hdr = mysql_fetch_array($hdrs)) {
                $hdrValue = $hdr['TRANSFER_HDR_ID'];
            }


            $query = "SELECT * FROM  `data_transfer_transaction` 
                      WHERE  `TRANSFER_HDR_ID` =  '" . $hdrValue . "'
                      AND  `TABLE_NAME` =  '" . $tablenames['TABLE_NAME'] . "' AND  `STATUS` =  'completed'";

            $timelist = mysql_query($query);
            while ($times = mysql_fetch_array($timelist)) {
                $time = $times['CREATION_DATE'];
            }
            $editedTime = str_replace(" ", "*", $time);

            $time = $editedTime;
            $totalCount++;
            $tableName = $tablenames['TABLE_NAME'];
			$type = $tablenames['TYPE'];
            invoke($baseloc, $tableName, $row['KD_Code'], $type, $time);
            $status = "Completed";
            updateLog($row['KD_Code'], $tableName, $status, $createDate, $transferHdrID);
        }
    } else {                  //base system offline
        while ($tablenames = mysql_fetch_array($tables)) {

            $tableName = $tablenames['TABLE_NAME'];
            $status = "Error";
            updateLog($row['KD_Code'], $tableName, $status, $createDate, $transferHdrID);
            $errorCount++;
        }
    }

    updateStatus($transferHdrID, $status);
}
if ($errorCount == 0) {
	
    $processStatus = "Completed Succesfully";
	
} else if ($errorCount == $totalCount) {
	
    $processStatus = "Completed Error";
	
} else {
    $processStatus = "Completed Partially";
}


$query = "update data_transfer_process set STATUS = '" . $processStatus . "' where PROCESS_ID = '" . $processID . "'";
mysql_query($query);

echo ("Process Completed . Please check Log for more details ");

/**
 * Updating Process status on log
 * @param type $kdCode
 * @param type $tableName
 * @param type $status
 * @param type $createDate
 * @param type $transferHdrID
 */
function updateLog($kdCode, $tableName, $status, $createDate, $transferHdrID) {


    $updateDate = date('Y-m-d H:i:s');

    //$transferHdrID = mysql_insert_id();
    $query = "Insert into data_transfer_transaction values ('','" . $transferHdrID . "','" . $tableName . "','" . $status . "','" . $createDate . "','admin','" . $updateDate . "','admin')";
    mysql_query($query);
}

/**
 * Insert process status on Header
 * @param type $kdCode
 * @param type $status
 * @param type $createDate
 * @param type $processID
 * @return type $transferHdrId 
 */
function updatelogHDR($kdCode, $status, $createDate, $processID) {


    $updateDate = date('Y-m-d H:i:s');
    $query = "Insert into data_transfer_transaction_hdr values('','" . $processID . "','Upload from Base','" . $kdCode . "','Host','" . $createDate . "','" . $updateDate . "','" .    $status . "','" . $createDate . "','admin','" . $updateDate . "','admin')";
    mysql_query($query);
    $transferHdrID = mysql_insert_id();
    return $transferHdrID;
}

/**
 *  Updating Log Files 
 * @param type $transferHdrID
 * @param type $status
 */
function updateStatus($transferHdrID, $status) {

    $query = "UPDATE data_transfer_transaction_hdr SET STATUS = '" . $status . "' WHERE TRANSFER_HDR_ID = '" . $transferHdrID . "'";
    mysql_query($query);
}

/**
 * Invoking Base scripts to transfer Files
 * @param type $ip  =>  remote base IP
 * @param type $tableName => table name to be transfered
 * @param type $KdCode => KD code of the base
 * 
 */
function invoke($ip, $tableName, $KdCode, $type, $time) {
   
    $ip = str_replace("_", "/", $ip);
    global $hostPath;
    $url = "http://" . $ip . "functions/send.php?tn=" . $tableName . "&ip=" . $hostPath . "&kdCode=" . $KdCode . "&baseIP=" .$ip . "&type=" . $type. "&time=" . $time;
	
	//echo $url;exit;
	
    $cu = curl_init();
    curl_setopt($cu, CURLOPT_URL, $url);
    curl_exec($cu);
    curl_close($cu);
}

/**
  Pinging Base System

 *  KD = IP address of base system
 * */
function pingDomain($KD) {
    $starttime = microtime(true);
    $file = fsockopen($KD, 80, $errno, $errstr, 10);
    $stoptime = microtime(true);
    $status = 0;

    if (!$file)
        $status = -1;  // Not working
    else {
        fclose($file);
        $status = ($stoptime - $starttime) * 1000;
        $status = floor($status);
    }
    return $status;
}

function purge($kdCode)
{
    
    $filePath = "Tabledownload//" . $kdCode;
    $path = $filePath . "_" . date("Y-m-d");

    $filePath = str_replace("_", "//", $path);
    
    $files = glob($filePath.'/*'); 
    foreach($files as $file){ 
    if(is_file($file))
    unlink($file); 
}
    
    
    
}
?>