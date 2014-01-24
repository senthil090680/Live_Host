<?php
include "../include/config.php";
$sql="select * from  kd  where KD_Code='". mysql_real_escape_string($_GET["val"])."'";
$results=mysql_query($sql);
$cnt=mysql_num_rows($results);
while($rs = mysql_fetch_array($results)) {
echo $rs['KD_Name'].'|';
}
?>
		   
          