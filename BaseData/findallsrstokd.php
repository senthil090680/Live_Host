<?php
session_start();
ob_start();
require_once "../include/config.php";
require_once "../include/ajax_pagination.php";
if(isset($_REQUEST['logout'])){
	session_destroy();
	header("Location:../index.php");
}
extract($_REQUEST);

$KD_Code			=	getKDCode($KD_ID,'KD_Code','id');
if(isset($_REQUEST[KD_ID]) && $_REQUEST[KD_ID] !='') {
	$nextrecval		=	"WHERE KD_Code = '$KD_Code'";
} else {
	$nextrecval		=	"";
}
$where		=	"$nextrecval";

if(isset($_REQUEST) && $_REQUEST !='')
{
	$qry_DSR="SELECT id,DSR_Code,DSRName FROM `dsr` $where";
}
else
{ 
	echo "Invalid Query";
	exit;
}
//echo $qry;
//exit;

$res_DSR		=	mysql_query($qry_DSR);
$row_DSR		=	mysql_num_rows($res_DSR);			

?>
<select name="<?php echo $DSR_NAME; ?>" id="<?php echo $DSR_NAME; ?>" class="<?php echo $CLASSNAM; ?>">
	<option value="">--- Select ---</option>
	<?php if($row_DSR > 0) {
	while($row_DSR = mysql_fetch_array($res_DSR)) { ?>
	<option value="<?php echo $row_DSR['id']?>" <?php if($row_DSR['DSR_Code']==$fetch['id']){ ?> selected <?php } ?> ><?php echo $row_DSR['DSRName'];?></option>
	<?php } 	// while loop
	} //if loop ?>
</select>
<?php exit(0); ?>