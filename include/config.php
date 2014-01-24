<?php
$mysql_hostname = "localhost";
$mysql_user = "sfa";
$mysql_password = "SfaPwfBrA5w";
$mysql_database = "sfa_retail";
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) 
or die("Opps some thing went wrong");
mysql_select_db($mysql_database, $bd) or die("Opps some thing went wrong");

$timezone = "Africa/Lagos";
if(function_exists('date_default_timezone_set')) 
date_default_timezone_set($timezone);
?>