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

$srstrval								=	getdbstr('DSR_Code','dsr');

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

	$query_asmnam 						=	"SELECT id,DSR_Code,DSRName FROM dsr";
	$res_asmnam							=	mysql_query($query_asmnam) or die(mysql_error());
	?>
	<select class="dsrname" name="srcode" id="srcode" multiple <?php if($srval == 'SRIN') { ?> onChange="getsrspecific();" <?php } elseif($srval == 'SRTRANS') { ?> onChange="getsrtranslist();" <?php } ?> >
	<option value="">---SR---</option>

	<option value="<?php echo $srstrval; ?>" <?php if(strstr($srstr,$srstrval)) { echo "selected"; } ?> > ALL</option>

	<?php while($info_sr = mysql_fetch_assoc($results_dsr)) { ?>
	<option value="<?php echo  $info_sr['DSR_Code']; ?>" <?php if(!strstr($srstr,$srstrval)) { if(strstr($srstr,$info_sr['DSR_Code'])) { echo "selected"; }  } if($srcode == $info_sr['DSR_Code']) { echo "selected"; } ?> > <?php echo  upperstate($info_sr['DSRName']); ?></option>
	<?php } ?> 
	</select> 
	<?php exit(0);
}

if($_GET[codeval] == 'null') {
	//echo "goodfd";
	//exit;
	$query_asmnam 						=	"SELECT id,DSR_Code,DSRName FROM dsr";
	$res_asmnam							=	mysql_query($query_asmnam) or die(mysql_error());
	?>
	<select class="dsrname" name="srcode" id="srcode" multiple <?php if($srval == 'SRIN') { ?> onChange="getsrspecific();" <?php } elseif($srval == 'SRTRANS') { ?> onChange="getsrtranslist();" <?php } ?> >
	<option value="">---SR---</option>

	<option value="<?php echo $srstrval; ?>" <?php if(strstr($srstr,$srstrval)) { echo "selected"; } ?> > ALL</option>

	<?php while($info_sr = mysql_fetch_assoc($results_dsr)) { ?>
	<option value="<?php echo  $info_sr['DSR_Code']; ?>" <?php if(!strstr($srstr,$srstrval)) { if(strstr($srstr,$info_sr['DSR_Code'])) { echo "selected"; }  } if($srcode == $info_sr['DSR_Code']) { echo "selected"; } ?> > <?php echo  upperstate($info_sr['DSRName']); ?></option>
	<?php } ?> 
</select>
	<?php exit(0);
}

// THIS IS WHEN THE SELECT BOX IS EMPTY WITHOUT ANY SELECTED OPTIONS, IT IS EITHER ARRAY WITH EMPTY VALUE IN O INDEX OR NULL VALUE ENDS HERE


$params=$kdcode;
if(isset($_GET[codeval]) && $_GET[codeval] !='') {
	$codevalstr		=	implode("','",$codeval);
	if($codevalstr != '') {
		$nextrecval		=	"WHERE KD_Code IN ('".$codevalstr."')";
	}
} else {
	$nextrecval		=	"";
}
$where		=	"$nextrecval";

if(isset($_GET) && $_GET !='')
{
	$qry="SELECT id,DSR_Code,DSRName FROM `dsr` $where";
}
else
{ 
	echo "Invalid Query";
	exit;
}

$results_dsr = mysql_query($qry) or die(mysql_error());
$num_rows		=	mysql_num_rows($results_dsr);

while($info = mysql_fetch_assoc($results_dsr)) {
	$srvalstr[]		=	$info[DSR_Code];
}

$srvaluni								=	array_unique($srvalstr);
$srstr								=	implode("','",$srvaluni);

$qry_sr			=	"SELECT id,DSR_Code,DSRName FROM `dsr`";
$results_dsr	=	mysql_query($qry_sr) or die(mysql_error());


/********************************pagination ends****************************/
?>
<select class="dsrname" name="srcode" id="srcode" multiple <?php if($srval == 'SRIN') { ?> onChange="getsrspecific();" <?php } elseif($srval == 'SRTRANS') { ?> onChange="getsrtranslist();" <?php } ?> >
	<option value="">---SR---</option>

	<option value="<?php echo $srstrval; ?>" <?php if(strstr($srstr,$srstrval)) { echo "selected"; } ?> > ALL</option>

	<?php while($info_sr = mysql_fetch_assoc($results_dsr)) { ?>
	<option value="<?php echo  $info_sr['DSR_Code']; ?>" <?php if(!strstr($srstr,$srstrval)) { if(strstr($srstr,$info_sr['DSR_Code'])) { echo "selected"; }  } if($srcode == $info_sr['DSR_Code']) { echo "selected"; } ?> > <?php echo  upperstate($info_sr['DSRName']); ?></option>
	<?php } ?> 
</select>   
<?php exit(0);?>