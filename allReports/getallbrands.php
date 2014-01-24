<?php
session_start();
ob_start();
require_once "../include/config.php";
require_once "../include/ajax_pagination.php";
//require_once "../include/ps_pagination.php";
if(isset($_GET['logout'])){
	session_destroy();
	header("Location:../index.php");
}
extract($_GET);
$params=$kdcode;
if(isset($_GET[kdcode]) && $_GET[kdcode] !='') {
	$kdcodestr		=	implode("','",$kdcode);
	//$nextrecval		=	"WHERE KD_Code IN ('".$kdcodestr."')";	
} else {
	$nextrecval		=	"";
}
$where		=	"$nextrecval";

if(isset($_GET) && $_GET !='')
{
	$qry="SELECT * FROM `brand` $where";
}
else
{ 
	echo "Invalid Query";
	exit;
}
$results_dsr		=	mysql_query($qry) or die(mysql_error());
$num_rows			=	mysql_num_rows($results_dsr);			

?>
<select class="dsrname" name="brandcode" id="brandcode" multiple onChange="getbrandspecific();">
	<option value="">---Brand---</option>
	<?php if($num_rows > 0 ) { 
		while($info = mysql_fetch_assoc($results_dsr)){?>
		<option value="<?php echo  $info['id']; ?>" <?php if($brandcode == $info['id']) { echo "selected"; } ?> > <?php echo  upperstate($info['brand']); ?></option>
	<?php }
	} ?> 
</select>
<?php exit(0);?>