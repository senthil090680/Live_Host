<?php
include "../include/config.php";
$sql="select * from  kd_product where Product_description1 ='". mysql_real_escape_string($_GET["val"])."'";
$results=mysql_query($sql);
$cnt=mysql_num_rows($results);
while($rs = mysql_fetch_array($results)) {
echo $rs[Price].'|'.$rs[id].'|';
}
?>