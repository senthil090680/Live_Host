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
//echo $kdcode;
//exit;
if(isset($_GET[kdcode]) && $_GET[kdcode] !='') {
	$kdcodestr		=	implode("','",$kdcode);
	//$nextrecval		=	"WHERE KD_Code IN ('".$kdcodestr."')";	
} else {
	$nextrecval		=	"";
}
$where		=	"$nextrecval";

if(isset($_GET) && $_GET !='')
{
	$qry="SELECT * FROM `product` $where";
}
else
{ 
	echo "Invalid Query";
	exit;
}
$results_dsr = mysql_query($qry) or die(mysql_error());
$num_rows		=	mysql_num_rows($results_dsr);

?>

<select class="dsrname" style="width:570px;" name="prodcode" id="prodcode" multiple onChange="getprodspecific();">
	<option value="">----------------------------------------------Product-----------------------------------------</option>
	<?php
		if($num_rows > 0 ) {
			while($info		=	mysql_fetch_assoc($results_dsr)) { ?>
			<option value="<?php echo  $info['Product_code']; ?>" <?php if($prodcode == $info['Product_code']) { echo "selected"; } ?> > <?php echo  upperstate($info['Product_description1']); ?></option>
			<?php } 
		} ?> 		
</select>
<?php exit(0); ?>