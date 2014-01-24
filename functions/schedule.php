<?php
error_reporting(0);
set_time_limit(0);
include "../include/config.php";
$processDate = date('Y-m-d H:i:s');
$totalCount = 0; // total count of sub process
$errorCount = 0; // Error count of sub process
$processStatus = "On Progress";
$query = "insert into data_transfer_process values ('','1','" . $processStatus . "','" . $processDate . "','" . $processDate . "','admin','" . $processDate . "','admin')";
mysql_query($query);
$processID = mysql_insert_id();
$query = "select * from host_information";
$host_infos = mysql_query($query);

while ($host_info = mysql_fetch_array($host_infos)) {
    $hostIP = $host_info['Host_IP'];
    $hostURL = $host_info['Host_Url'];
}

$hostPath = $hostIP . "/";

if ($hostURL != "") {
    $hostPath .= $hostURL . "/";
}

$query = "SELECT * FROM kd";
$result = mysql_query($query);

while ($row = mysql_fetch_array($result)) {
	
	$kdCode = $row['KD_Code'];

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
    $status = "pending";
    $transferHdrID = updateLogHDR($row['KD_Code'], $status, $createDate, $processID);
	
    if ($ping > -1) {
        
        $hdrCounter = 0;
        purge($row['KD_Code']);
         
         
$query = "SELECT * FROM data_transfer_table where ACTIVE_FLAG='Y' AND TRANSFER_NAME = 'download'";
$tables = mysql_query($query);

        while ($tablenames = mysql_fetch_array($tables)) {

            $query = "SELECT * FROM  `data_transfer_transaction_hdr` WHERE  `TRANSFER_NAME` =  'Download to Base' AND  `DESTINATION` =  '" . $row['KD_Code'] . "' AND STATUS = 'Completed' ORDER BY  `TRANSFER_HDR_ID` DESC  LIMIT 0,1";

            $hdrs = mysql_query($query);
            while ($hdr = mysql_fetch_array($hdrs)) {
                $hdrValue = $hdr['TRANSFER_HDR_ID'];
            }
            
         $query = "SELECT *  FROM  `data_transfer_transaction` WHERE  `TRANSFER_HDR_ID` =  '" . $hdr['TRANSFER_HDR_ID'] . "' AND  `TABLE_NAME` =  '" . $tablenames['TABLE_NAME'] . "' AND  `STATUS` =  'completed'";

            $timelist = mysql_query($query);
			
            while($times = mysql_fetch_array($timelist)) {
                $time = $times['CREATION_DATE'];
            }
			//exit;
            $editedTime = str_replace("", "*", $time);
			
			if($time != '') {
				$time = $editedTime;
			} else {
				$time = str_replace("","*",date('Y-m-d H:i:s'));
			}

			//echo $time;
			//exit;

            $kdSpecific = $tablenames['KD_SPECIFIC'];

    
            $hdrCounter++;
            $totalCount++;
            $tableName = $tablenames['TABLE_NAME'];
            $type = $tablenames['TYPE'];
           
            $message = invoke($baseloc, $row['KD_Code'], $tableName, $ping, $type, $time, $kdSpecific);
            $status = $message;
             
            if ($status == "Error") {
                $errorCount++;
            }

           
            updateLog($row['KD_Code'], $tableName, $status, $createDate, $transferHdrID);
            updateStatus($transferHdrID, $status);
            
        }
		
        if ($hdrCounter == 0) {
            $query = "Delete from data_transfer_transaction_hdr where TRANSFER_HDR_ID='" . $transferHdrID . "'";
            mysql_query($query);
        }
		 }
		 else {
			 
            while ($tablenames = mysql_fetch_array($tables)) {
            $query = "SELECT * FROM  `data_transfer_transaction_hdr` WHERE  `TRANSFER_NAME` =  'Download to Base' AND  `DESTINATION` =  '" . $row['KD_Code'] . "' AND STATUS = 'Completed' ORDER BY  `TRANSFER_HDR_ID` DESC LIMIT 0,1";

            $hdrs = mysql_query($query);
            while ($hdr = mysql_fetch_array($hdrs)) {
                $hdrValue = $hdr['TRANSFER_HDR_ID'];
            }

            $query = "SELECT * FROM  `data_transfer_transaction` WHERE  `TRANSFER_HDR_ID` =  '" . $hdr['TRANSFER_HDR_ID'] . "' AND  `TABLE_NAME` =  '" . $tablenames['TABLE_NAME'] . "' AND  `STATUS` =  'completed'";

            $timelist = mysql_query($query);
            while ($times = mysql_fetch_array($timelist)) {
                $time = $times['CREATION_DATE'];
            }
      
            $hdrCounter++;
           
		   
            $tableName = $tablenames['TABLE_NAME'];
            $status = "Error";
            updateLog($row['KD_Code'], $tableName, $status, $createDate, $transferHdrID);
            $errorCount++;
            updateStatus($transferHdrID, $status);
            //  }
        }
        if ($hdrCounter == 0) {
            $query = "Delete from data_transfer_transaction_hdr where TRANSFER_HDR_ID='" . $transferHdrID . "'";
            mysql_query($query);
        }
    }
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

function updateLog($kdCode, $tableName, $status, $createDate, $transferHdrID) {


    $query = "Insert into data_transfer_transaction values ('','" . $transferHdrID . "','" . $tableName . "','" . $status . "','" . $createDate . "','admin','" . $updateDate . "','admin')";
    mysql_query($query);
}

function updatelogHDR($kdCode, $status, $createDate, $processID) {

    $updateDate = date('Y-m-d H:i:s');
    $query = "Insert into data_transfer_transaction_hdr values('','" . $processID . "','Download to Base','Host','" . $kdCode . "','" . $createDate . "','" . $updateDate . "','" . $status . "','" . $createDate . "','admin','" . $updateDate . "','admin')";
    mysql_query($query);
    $transferHdrID = mysql_insert_id();
    return $transferHdrID;
}

function updateStatus($transferHdrID, $status) {

    $query = "UPDATE data_transfer_transaction_hdr SET STATUS = '" . $status . "' WHERE TRANSFER_HDR_ID = '" . $transferHdrID . "'";
    mysql_query($query);
}

function invoke($ip, $KD_Code, $tableName, $ping, $type, $time, $kdSpecific) {
    global $hostPath;
	
	 //$time = date('Y-m-d H:i:s');
	
    $url = "http://" . $hostPath . "Host/functions/send.php?tn=" . $tableName . "&ip=" . $ip . "&KD_Code=" . $KD_Code . "&ping=" . $ping . "&type=" . $type . "&kdSpecific=" . $kdSpecific . "&time=" . $time;
	
    //echo $url;exit;
   
    $cu = curl_init();
    curl_setopt($cu, CURLOPT_URL, $url);
    curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($cu);
    curl_close($cu);
    return $data;
}

function pingDomain($kdCode) {
    $starttime = microtime(true);
    $file = fsockopen($kdCode, 80, $errno, $errstr, 10);
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

function purge($kdCode) {

    $path = "Table_" . $kdCode;
    $path = $path . "_" . date("Y-m-d");

    $filePath = str_replace("_", "//", $path);

    $files = glob($filePath . '/*');
    foreach ($files as $file) {
        if (is_file($file))
		chmod($file);
        unlink($file);
    }
}

?>