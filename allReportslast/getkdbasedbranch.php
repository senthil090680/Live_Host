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

$branchstrval							=	getdbstr('id','branch');

// THIS IS WHEN THE SELECT BOX IS EMPTY WITHOUT ANY SELECTED OPTIONS, IT IS EITHER ARRAY WITH EMPTY VALUE IN O INDEX OR NULL VALUE STARTS HERE

//pre($_GET[codeval]);
//exit;
$arrsize		=	count($_GET[codeval]);
$arrvalue		=	1;
if($arrsize == '1') {
	//echo $arrsize;
	$arrvalue	=	$_GET[codeval][0];
}
//echo $arrvalue;
//exit;
if($arrvalue == '') {
	//echo "ldkd";
	//exit;

	$query_dsr 							=	"SELECT * FROM `branch`";
	$results_dsr						=	mysql_query($query_dsr) or die(mysql_error());
	?>
	<select class="dsrname" class="s9" name="branchcode" id="branchcode" multiple <?php if($srval == 'SRNOT') { ?> onChange="getbranchspecific();" <?php } elseif($srval == 'SRIN') { ?> onChange="getbranchspecificwithsr();" <?php } elseif($srval == 'SRINC') { ?> onChange="getbranchspecificsrsta();" <?php } elseif($srval == 'SRINCE') { ?> onChange="getbranchspecificsrinc();" <?php } elseif($srval == 'SRCOV') { ?> onChange="getbranchspecificsrpercent();" <?php } else if($srval == 'POSM') { ?> onChange="getbranchspecificposm();" <?php } elseif($srval == 'SRTRANS') { ?> onChange="getKDspecifictranslist();" <?php } ?> >
		<option value="">---BRANCH---</option>
		<option value="<?php echo $branchstrval; ?>" <?php //echo $asmstr. "==" . $asmidstrval;
		if(strstr($branchstr,$branchstrval)) { echo "selected"; } ?> > ALL</option>

		<?php while($info_branch = mysql_fetch_assoc($results_dsr)) { ?>
		<option value="<?php echo  $info_branch['id']; ?>" <?php if(!strstr($branchstr,$branchstrval)) { if(strstr($branchstr,$info_branch['id'])) { echo "selected"; } } if($branchcode == $info_branch['id']) { echo "selected"; } ?> > <?php echo  upperstate($info_branch['branch']); ?></option>
		<?php } ?> 
	</select> 
	<?php exit(0);
}

if($_GET[codeval] == 'null') {
	//echo "goodfd";
	//exit;	
	$query_dsr 							=	"SELECT * FROM `branch`";
	$results_dsr						=	mysql_query($query_dsr) or die(mysql_error());
	?>
	<select class="dsrname" class="s9" name="branchcode" id="branchcode" multiple <?php if($srval == 'SRNOT') { ?> onChange="getbranchspecific();" <?php } elseif($srval == 'SRIN') { ?> onChange="getbranchspecificwithsr();" <?php } elseif($srval == 'SRINC') { ?> onChange="getbranchspecificsrsta();" <?php } elseif($srval == 'SRINCE') { ?> onChange="getbranchspecificsrinc();" <?php } elseif($srval == 'SRCOV') { ?> onChange="getbranchspecificsrpercent();" <?php } else if($srval == 'POSM') { ?> onChange="getbranchspecificposm();" <?php } elseif($srval == 'SRTRANS') { ?> onChange="getKDspecifictranslist();" <?php } ?> >
		<option value="">---BRANCH---</option>
		<option value="<?php echo $branchstrval; ?>" <?php //echo $asmstr. "==" . $asmidstrval;
		if(strstr($branchstr,$branchstrval)) { echo "selected"; } ?> > ALL</option>

		<?php while($info_branch = mysql_fetch_assoc($results_dsr)) { ?>
		<option value="<?php echo  $info_branch['id']; ?>" <?php if(!strstr($branchstr,$branchstrval)) { if(strstr($branchstr,$info_branch['id'])) { echo "selected"; } } if($branchcode == $info_branch['id']) { echo "selected"; } ?> > <?php echo  upperstate($info_branch['branch']); ?></option>
		<?php } ?> 
	</select> 
	<?php exit(0);
}

// THIS IS WHEN THE SELECT BOX IS EMPTY WITHOUT ANY SELECTED OPTIONS, IT IS EITHER ARRAY WITH EMPTY VALUE IN O INDEX OR NULL VALUE ENDS HERE

$params=$kdcode;
if(isset($_GET[codeval]) && $_GET[codeval] !='') {
	$codevalstr		=	implode("','",$codeval);
		if($codevalstr != '') {			
			$nextrecval		=	"KD_Code IN ('".$codevalstr."')";
			$wherefordsr	=	"WHERE";
		} else {
			$nextrecval		=	"";
			$wherefordsr	=	"";
		}
} else {
	$nextrecval		=	"";
}
$where		=	"$nextrecval";

if(isset($_GET) && $_GET !='')
{
	$qry="SELECT * FROM `dsr` $wherefordsr $nextrecval";
}
else
{ 
	echo "Invalid Query";
	exit;
}
$results_dsr							=	mysql_query($qry) or die(mysql_error());
$num_rows								=	mysql_num_rows($results_dsr);

while($info = mysql_fetch_assoc($results_dsr)) {
	$RSMID[]		=	$info[RSM];
}

$rsmiduni								=	array_unique($RSMID);
$rsmidstr								=	implode("','",$rsmiduni);

$qry									=	"SELECT * FROM `rsm_sp` WHERE id IN ('".$rsmidstr."')";
$results_dsr							=	mysql_query($qry) or die(mysql_error());
$num_rows								=	mysql_num_rows($results_dsr);

while($info = mysql_fetch_assoc($results_dsr)) {
	$branch[]		=	$info[branch_id];
}

$branchuni								=	array_unique($branch);
$branchstr								=	implode("','",$branchuni);

//$query_branchnam 						=	"SELECT id,branch FROM branch WHERE id IN ('".$branchstr."')";
$query_branchnam 						=	"SELECT id,branch FROM branch";
$res_branch 							=	mysql_query($query_branchnam) or die(mysql_error());

?>
<select class="dsrname" name="branchcode" id="branchcode" multiple <?php if($srval == 'SRNOT') { ?> onChange="getbranchspecific();" <?php } elseif($srval == 'SRIN') { ?> onChange="getbranchspecificwithsr();" <?php } elseif($srval == 'SRINC') { ?> onChange="getbranchspecificsrsta();" <?php } elseif($srval == 'SRINCE') { ?> onChange="getbranchspecificsrinc();" <?php } elseif($srval == 'SRTRANS') { ?> onChange="getKDspecifictranslist();" <?php } ?> >
	<option value="">---BRANCH---</option>

	<option value="<?php echo $branchstrval; ?>" <?php //echo $asmstr. "==" . $asmidstrval;
	if(strstr($branchstr,$branchstrval)) { echo "selected"; } ?> > ALL</option>

	<?php while($info_branch = mysql_fetch_assoc($res_branch)) { ?>
	<option value="<?php echo  $info_branch['id']; ?>" <?php if(!strstr($branchstr,$branchstrval)) { if(strstr($branchstr,$info_branch['id'])) { echo "selected"; } } if($branchcode == $info_branch['id']) { echo "selected"; } ?> > <?php echo  upperstate($info_branch['branch']); ?></option>
	<?php } ?> 
</select> 
<?php exit(0);?>