<?php
include "../include/config.php";
$sql="select * from  brand  where brand ='". mysql_real_escape_string($_GET["val"])."'";
$results=mysql_query($sql);
$cnt=mysql_num_rows($results);
while($rs = mysql_fetch_array($results)) {
 $principalid =	$rs['principal'];
}
$sql="select * from  principal  where id = '".$principalid. "'";
$results=mysql_query($sql) or die(mysql_error());
$cnt=mysql_num_rows($results);
while($rs = mysql_fetch_array($results)) {
echo $rs[principal].'|'.$rs[id].'|';
}
?>
		   
          