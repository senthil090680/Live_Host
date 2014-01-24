<?php
set_time_limit(0);
error_reporting(0 );
include "../include/config.php";
//$remIp = $_GET['remip'];   // Specifies Remote Host Ip. sfa.fmclgrp.com/FMCLVVE/ 
$remIp = "sfa.fmclgrp.com_RetailKd_Base_"; //sfa.fmclgrp.com/Base/FMCLVVE/
$table = $_GET['table'];  //Specifies Table Name  //Table @ csv
$path = $_GET['path']; // Specifies Remote path. FMCLVVE_functions_UploadtoHost_
$kdCode = $_GET['kdCode'];
$type = $_GET['type'];
$tableName = explode("@", $table);
$remIp = str_replace("_", "/", $remIp);
$path = str_replace("_", "/", $path);

// DB Connection


if ($fp = fopen("http://" . $remIp .  $path . "/" . $table . ".csv", 'r')) {
    $content = '';
    // keep reading until there's nothing left 
    while ($line = fread($fp, 1024)) {
        $content .= $line;
    }
    $curdate = date("Y-m-d");
	$directory = "..//..//Host//functions//Tabledownload//$kdCode//$curdate//";  //Creates Folder Path
	
	
    if (!is_dir($directory)) {
		
		  $mode = 0777;

          mkdir($directory, $mode,true); 
    }
    
	//$filePath = $filePath . "//" . date("Y-m-d");
    //$filePath = "..//..//FMCLHOST//functions//Tabledownload//".$kdCode. "//". date("Y-m-d");
	
	//echo  $filePath;
	
	//chmod($filePath,0777);

    writeCsv($directory.$table .".csv", $content);

    $content_lines = explode("\n", $content);


    
    $redo = explode(",",$content_lines[0]);
   
        $query = "select * from " . $tableName[0] . " where KD_Code='" .$kdCode . "' ";
        $resultredo = mysql_query($query);
         
    if (mysql_num_rows($resultredo) != 0)
    {
         $query = "delete from " . $tableName[0] . " where KD_Code='" . $kdCode . "' ";
         $return=   mysql_query($query);
          if($return == false)
          {
             // echo "delete Error " . $tableName[0] . " ";
          }
    }

    foreach ($content_lines as $line) {
        //echo $line;
        //echo "<br>";
        $contentDatas = explode(",", $line);
		//print_r($contentDatas);
		
        $firstRecord = "";
       	$queryData = "";
        $flag = false;
        $idcount =0;
        $kd_Code="";
        foreach ($contentDatas as $contentData) {
            if($idcount == 1) //Denotes the id of array value
            {
                $kd_Code=$contentData; //Which give KD code
            }
            if ($flag == false) {
                $firstRecord = $contentData; //which gives number
                $flag = true;
            } else {
                     $queryData .= $contentData;
                     $queryData .=",";
            }
            $idcount++;
          }

        if ($firstRecord) {
        $query = "select * from " . $tableName[0] . " where KD_Code='" . $kd_Code . "' ";
        $result = mysql_query($query);
        if (mysql_num_rows($result) == 0) {
             $queryData = substr($queryData, 0,-5);
			 $queryData = "''," . $queryData;
			 $queryvalue = trim($queryData);
			 $query = "Insert into " . $tableName[0] . " values(" . $queryvalue . ")";
          $return=  mysql_query($query);
          if($return == false)
          {
            //  echo $query;
             // echo "Insert Error " . $tableName[0] . " ";
          }
            // echo $query;
        } //else {
// 
//         $queryData = substr($queryData, 2, -3);
//         $queryData = "''" . $queryData;
//		 
//        echo $query = "Insert into " . $tableName[0] . " values(" . $queryData . "')";
//           $return = mysql_query($query);
//            if($return == false)
//          {
//            //  echo "Insert2 Error" . $tableName[0] . " ";
//          }
//           //  echo $query;
//            
//        }
    }
   }
}

function writeCsv($fname, $content) {
    $fp = fopen($fname, 'w+');
    $write = fputs($fp, $content);
    fclose($fp);
}

?>