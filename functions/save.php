<?php
include "../include/config.php";
$process = $_POST['process'];
$option = $_POST['option'];
$frequency = $_POST['frequency'];
$sd = $_POST['sd'];
$st = $_POST['st'];


if ($frequency == "Hourly")
    $hour = "1";

if ($frequency == "2Hours")
    $hour = "2";

if ($frequency == "4Hours")
    $hour = "4";


if ($process == "db")
    $transfername = "Download to Base";

if ($process == "ub")
    $transfername = "Upload from Base";


if ($sd == "")
    $sdate = date('H:i:s');


if ($st == "")
    $stime = date('H:i:s');

if ($option != "auto") {
    $sd = "";
    $st = "";
    $day = "";
    $frequency = "";
}


//$query="truncate table data_transfer_configuration";
//mysql_query($con,$query);

if ($process == "db") {
    $query = "Delete  from data_transfer_configuration where CONFIGURATION_ID = '1'";
    mysql_query( $query);
    $query = "Insert into data_transfer_configuration values('1','" . $transfername . "','" . $option . "','" . $frequency . "','" . $stime . "',' " . $sdate . "','" . date('Y-m-d H:i:s') . "','admin','" . date('Y-m-d H:i:s') . "','admin')";
    mysql_query( $query);
} else {
    $query = "Delete  from data_transfer_configuration where CONFIGURATION_ID = '2'";
    mysql_query( $query);
    $query = "Insert into data_transfer_configuration values('2','" . $transfername . "','" . $option . "','" . $frequency . "','" . $stime . " ','" . $sdate . "','" . date('Y-m-d H:i:s') . "','admin','" . date('Y-m-d H:i:s') . "','admin')";
    mysql_query( $query);
}

if ($option == "auto") {
    createcron($frequency, $sd, $st, $process);
    echo "Succesfully updated. Process will Run Between  " . $sd . " " . $st;
}

if ($option == "ondemand") {
    echo "Succesfully updated . Please use the link specified to process onDemand";
    deleteCron($process);
}

if ($option == "manual") {
    echo "Updated succesfully . Please use the Generated csv Manually";
    deleteCron($process);
}

$result = exec("cmd.exe /c auto.bat");

function createcron($frequency, $sd, $st, $process) {
    global $serverName, $userName, $password, $serverPath;

    //echo $frequency;


    if ($frequency == "Hourly")
        $freqCode = " /sc Hourly /mo 1";
    elseif ($frequency == "2Hours")
        $freqCode = " /sc Hourly /mo 2";
    elseif ($frequency == "4Hours")
        $freqCode = " /sc Hourly /mo 4";





    if ($process == "db") {
        $batFile = "cron.bat";
        $tn = "KD_cronDownload";
    } else {
        $batFile = "cronupload.bat";
        $tn = "KD_cronUpload";
    }

    $delCode = "schtasks /delete /tn " . $tn . "  /f " . "\n";

    $reCode = 'schtasks /create /s ' . $serverName . ' /RU ' . $userName . ' /RP ' . $password . ' /tn ' . $tn . ' /tr "' . $serverPath . '//Host//functions//' . $batFile . '" ' . $freqCode;
    $code = $delCode . $reCode;
    $fp = fopen("auto.bat", 'w+');
    $write = fputs($fp, $code);
    fclose($fp);
}

function deleteCron($process) {
    if ($process == "db")
        $tn = "KD_cronDownload";
    else
        $tn = "KD_cronUpload";



    $delCode = "schtasks /delete /tn " . $tn . " /f " . "\n";
    $fp = fopen("auto.bat", 'w+');
    $write = fputs($fp, $delCode);
    fclose($fp);
}

?>