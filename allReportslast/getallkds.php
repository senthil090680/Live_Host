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
	$qry="SELECT * FROM `kd` $where";
}
else
{ 
	echo "Invalid Query";
	exit;
}
$results_dsr		=	mysql_query($qry) or die(mysql_error());
$num_rows			=	mysql_num_rows($results_dsr);			

?>
<select class="dsrname" name="kdcode" id="kdcode" multiple <?php if($srval == 'SRNOT') { ?> onChange="getKDspecific();" <?php } elseif($srval == 'SRIN') { ?> onChange="getKDspecificwithsr();" <?php } elseif($srval == 'SRTRANS') { ?> onChange="getKDspecifictranslist();" <?php } ?> >
	<option value="">---KD---</option>
	<?php while($info = mysql_fetch_assoc($results_dsr)){?>
	<option value="<?php echo  $info['KD_Code']; ?>" <?php if($kdcode == $info['KD_Code']) { echo "selected"; } ?> > <?php echo  upperstate($info['KD_Name']); ?></option>
	<?php }?> 
</select>
<?php exit(0);?>