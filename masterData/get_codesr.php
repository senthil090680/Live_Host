<?php
include "../include/config.php";
$sql="select * from sr  where SR_Code='". mysql_real_escape_string($_GET["val"])."'";
$results=mysql_query($sql);
$cnt=mysql_num_rows($results);
while($rs = mysql_fetch_array($results)) {
//echo $rs['KD_Code'].'|';
echo $rs['SR_Name']. '^'.$rs['SR_Code'].'^'.$rs['Contact_Number'].'^'.$rs['email_id'].'|';
}

?>
		   
          