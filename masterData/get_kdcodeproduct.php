<?php
include "../include/config.php";
$sql="select * from kd_product where kd_category='". mysql_real_escape_string($_GET["val"])."'";
$results=mysql_query($sql);
$cnt=mysql_num_rows($results);
while($rs = mysql_fetch_array($results)) {
//echo $rs['Status_kd_product'].'|';
echo $rs['KD_Code'].'^'.$rs['Product_code'].'|';
}

?>
		   
          