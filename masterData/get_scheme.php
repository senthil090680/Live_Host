<?php
include "../include/config.php";
$sql="select * from  scheme_master  where Scheme_Description='". mysql_real_escape_string($_GET["val"])."'";
$results=mysql_query($sql);
$cnt=mysql_num_rows($results);
while($rs = mysql_fetch_array($results)) {
//echo $rs['Status_kd_product'].'|';
echo  $rs['Scheme_code'].'^'.$rs['Effective_from'].'^'.$rs['Effective_to'].'|';
}

?>
		   
          