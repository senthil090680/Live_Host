<?php
include "../include/config.php";
// DB Connection
//Getting list of tables to be created .
$query = "SELECT * FROM data_transfer_table where ACTIVE_FLAG='Y' AND TRANSFER_NAME = 'download'";
$tables = mysql_query( $query);

//List of Base 
$query = "SELECT * FROM kd";
$result = mysql_query( $query);

while ( $table = mysql_fetch_array($tables)) {
    while ($base=mysql_fetch_array($result)) {
        writecsvManual($table['TABLE_NAME'], $base['KD_Code'],$table['TYPE'],$table['KD_SPECIFIC']);
    }
}

echo "CSV files for listed Tabled are Succesfully created.";


/**

  Creating Csv files.

  tableName : Table Name to be created.
  KD_Code : To which base , Files are generated.


 */
function writecsvManual($tableName, $KD_Code,$type,$kdSpecific) {
    
     $query = "SELECT * FROM  `data_transfer_transaction_hdr` 
               WHERE  `TRANSFER_NAME` =  'Download to Base'
               AND  `DESTINATION` =  '" . $KD_Code . "' AND STATUS = 'Completed' ORDER BY  `TRANSFER_HDR_ID` DESC 
               LIMIT 0,1";

            $hdrs = mysql_query($query);
           while ($hdr = mysql_fetch_array($hdrs)) {
                $hdrValue = $hdr['TRANSFER_HDR_ID'];
            }

            $query = "SELECT * FROM  `data_transfer_transaction` 
                      WHERE  `TRANSFER_HDR_ID` =  '" . $hdrValue . "'
                      AND  `TABLE_NAME` =  '" . $tableName . "'
                      AND  `STATUS` =  'completed'";

            $timelist = mysql_query($query);
            while ($times = mysql_fetch_array($timelist)) {
                $time = $times['CREATION_DATE'];
            }
    
    
    


  if ($type == "full")  //Full mode Process
        $query = "SELECT * FROM " . $tableName . " Where 1 ";
    if ($type == "slu") // Insert Mode Process
    {
      if (!$time)
        $query = "SELECT * FROM " . $tableName;
    else{
            $editedTime=  str_replace("*"," ",$time);
            $time = $editedTime;
           // echo $time;
            $query = "SELECT * FROM " . $tableName . " Where '" . $time . "' < AUDIT_DATE_TIME";
            
    }
    }
    if($kdSpecific == "Y")
    {
        $query .= " and KD_Code = '" . $KD_Code  . "'";
    }
    


    $result = mysql_query($query);

    $data = "";

    while ($row = mysql_fetch_array($result)) {

        for ($i = 0; $i < mysql_num_fields($result); $i++) {
            $data .= $row[$i];
            $data .= ", ";
        }

        $data .= "\n";
    }

    $path = "Host_functions_Table_" . $KD_Code;
    $filePath = str_replace("_", "//", $path);
    if (!is_dir("..//..//" . $filePath . "//" . date("Y-m-d"))) {
         mkdir("..//..//" . $filePath . "//" . date("Y-m-d"));
    }
    $filePath = $filePath . "//" . date("Y-m-d");

    $date = new DateTime();
    writeCsv("..//..//" . $filePath . "//" . $tableName . "_" . $date->getTimestamp() . ".csv", $data);
}

function writeCsv($fileName, $records) {
    $fp = fopen($fileName, 'w+');
    $write = fputs($fp, $records);
    fclose($fp);
}

?>