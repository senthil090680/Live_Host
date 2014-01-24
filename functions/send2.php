<?php
set_time_limit(0);
error_reporting(0);
include("../include/config.php");

//pre($_GET);

//ini_set("display_errors",true);
//error_reporting(E_ALL);

$tableName = $_GET['tn'];
$IP = $_GET['ip'];
//$KD_Code = $_GET['KD_Code'];
$Kdcode = $_GET['KD_Code'];
$ping = $_GET['ping'];
$type = $_GET['type'];
$time = $_GET['time'];
$kdSpecific = $_GET['kdSpecific'];
//$succesDate = new DateTime($time);
$IP = str_replace("_", "/", $IP);
if (!$tableName) {
    echo("Error Message : missing Table Name ");
  } 
else
  {
   $data = "";
   if ($type == "full")  //Full mode Process
    {
     $query = "SELECT * FROM " . $tableName . " Where 1 ";
    }
    if ($type == "slu") // Insert Mode Process
    {
    if (!$time)
	
        $query = "SELECT * FROM " . $tableName . " Where 1";
		
    else{
            $editedTime=  str_replace("*"," ",$time);
            $time = $editedTime;
           // echo $time;
            $query = "SELECT * FROM " . $tableName . " Where   AUDIT_DATE_TIME > '" . $time . "' ";
      }
    }
    
    if($tableName == "product")
    {
     $tempQuery = "select Product_code from kd_product where KD_Code = '" . $Kdcode . "'";
     //echo $tempQuery;
     $tempResult = mysql_query($tempQuery);
     $data1 ="'";
     while ($rowData = mysql_fetch_array($tempResult)) {
                $data1 .= $rowData['Product_code'];
                $data1 .="','";
                
            }
        
        $data1 = substr($data1, 0, -2);
         //echo $data;
        $query .= " and Product_code in (" . $data1. ")";
        
            
    }
    
    
    if($kdSpecific == "Y" && $tableName != "product")
    {
        
        $query .= " and KD_Code = '" . $Kdcode  . "'";
       
    }


    $result = mysql_query($query);
    while ($row = mysql_fetch_array($result)) {

        for ($i = 0; $i < mysql_num_fields($result); $i++) {
             if ($i == 3 && $tableName == "parameters") {
                $data .= " ";
                $data .= ", ";
            }
            $data .= $row[$i];
            if ($i < (mysql_num_fields($result) - 1))
                $data .= ", ";
        }
        $data .= "\n";
    }


    //$path = "Host_functions_Table_" . $KD_Code;
	
	$curdate = date("Y-m-d");
	
	$path ="Host/functions/Table/$Kdcode/$curdate";
	
    //$path = $path . "_" . date("Y-m-d");
	
	// $filePath = str_replace("_", "//", $path);
	
	//chmod($filePath,0777);
	
	$pathkd = "..//..//Host//functions//Table//$Kdcode//$curdate//";

    if (!is_dir($pathkd)) {
		
		$mode = 0777;
		
        mkdir($pathkd,$mode,true);
    }
	
    $date = new DateTime();
   
   writeCsv($pathkd.$tableName . "@" . $date->getTimestamp() . ".csv", $data);

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
    if ($ping > 0) {     //if Base system online
	   
	   /*echo $hostPath."<br>";
	   echo $tableName."<br>";
	   echo $date->getTimestamp()."<br>"; 
	   echo $path."<br>";
	   exit;*/

       $data = array($hostPath, $tableName . "@" . $date->getTimestamp(), $path);
       $message= invoke($IP, "functions/load", $data, $type,$kdSpecific);
        echo $message;
    }
}


function invoke($ip, $path, $data, $type,$kdSpecific) {
   
    //pre($data);
    $url = "http://" . $ip . $path . ".php?remip=" . $data[0] . "&table=" . $data[1] . "&path=" . $data[2] . "&type=" . $type ."&kdSpecific=" .$kdSpecific;
    //echo $url;
	//exit;
    
	$cu = curl_init();
    curl_setopt($cu, CURLOPT_URL, $url);
    curl_setopt($cu,CURLOPT_RETURNTRANSFER,true);
    $data =   curl_exec($cu);
    curl_close($cu);
    return $data;
}

/*
  Function writeCsv :

  fileName = File name to be written.
  records = Records to be written on CSV file.

 */

function writeCsv($fileName, $records) {

    $fp = fopen($fileName, 'w+');
    $write = fputs($fp, $records);
    fclose($fp);
}

?>