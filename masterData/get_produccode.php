<?php
include "../include/config.php";
$sql="select * from  product  where Product_description1='". mysql_real_escape_string($_GET["val"])."'";
$results=mysql_query($sql);
$cnt=mysql_num_rows($results);
while($rs = mysql_fetch_array($results)) {
//echo $rs['Status_kd_product'].'|';
echo $rs['Product_code'].'^'.$rs['Product_description1'].'^'.$rs['UOM1'].'|';
}

?>
		   
          