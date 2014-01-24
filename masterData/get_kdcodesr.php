<?php
include "../include/config.php";
$sql="select * from asm_sp  where DSRName ='". mysql_real_escape_string($_GET["val"])."'";
$results=mysql_query($sql);
$cnt=mysql_num_rows($results);
while($rs = mysql_fetch_array($results)) {
//echo $rs['KD_Code'].'|';
	$rsmid		=	$rs['RSM'];
}
//echo $rsmid;
$sql="select * from rsm_sp  where id = '".$rsmid. "'";
$results=mysql_query($sql) or die(mysql_error());
$cnt=mysql_num_rows($results);
while($rs = mysql_fetch_array($results)) {
//echo $rs['KD_Code'].'|';
echo $rs[DSRName].'|'.$rs[id].'|';
}

?>
		   
          