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
$params=$codeval;
if(isset($_GET[codeval]) && $_GET[codeval] !='') {
	$kdcodestr		=	implode("','",$codeval);
	//$nextrecval		=	"WHERE KD_Code IN ('".$kdcodestr."')";	
} else {
	$nextrecval		=	"";
}
$where		=	"$nextrecval";

if(isset($_GET) && $_GET !='')
{
	$qry="SELECT * FROM `dsr` $where";
}
else
{ 
	echo "Invalid Query";
	exit;
}
$results_dsr		=	mysql_query($qry) or die(mysql_error());
$num_rows			=	mysql_num_rows($results_dsr);			
?>
<select class="dsrname" name="srcode" id="srcode" multiple <?php if($srval == 'SRNOT') { ?> onChange="getKDspecific();" <?php } elseif($srval == 'SRIN') { ?> onChange="getKDspecificwithsr();" <?php } elseif($srval == 'SRTRANS') { ?> onChange="getKDspecifictranslist();" <?php } ?> >
	<option value="">---SR---</option>
	<?php while($info_sr = mysql_fetch_assoc($results_dsr)) { ?>
	<option value="<?php echo  $info_sr['DSR_Code']; ?>" <?php if($srcode == $info_sr['DSR_Code']) { echo "selected"; } ?> > <?php echo  upperstate($info_sr['DSRName']); ?></option>
	<?php } ?> 
</select>
<?php exit(0);?>