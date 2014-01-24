<?php
include "../include/config.php";
$sql="select * from kd_category where kd_category ='".($_GET["val"])."'";
$results=mysql_query($sql);
$cnt=mysql_num_rows($results);
while($rs = mysql_fetch_array($results)) {
//echo $rs['KD_Code'].'|';
	 $kdcatid =	$rs['id'];
	 //echo $kdcatid;
}

$sql="select * from  kd  where  kd_category = '".$kdcatid. "'";
$results=mysql_query($sql) or die(mysql_error());
while($rs = mysql_fetch_array($results)) {
//echo $rs['KD_Code'].'|';
echo $rs[KD_Code].'|';
}
?>
		   
          