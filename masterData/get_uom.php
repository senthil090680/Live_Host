<?php
include "../include/config.php";
$sql="select * from  uom_conversion where uom2 ='".($_GET["val"])."'";
$results=mysql_query($sql);
while($rs = mysql_fetch_array($results)) {
echo $rs['uom_conversion'].'^'.$rs['uom2'].'|';
//echo $rs['uom_conversion'].'|';
}
?>
		   
