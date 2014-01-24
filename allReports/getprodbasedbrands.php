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

$brandstrval							=	getdbstr('id','brand');

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

	$query_brand 							=	"SELECT id,brand from brand";
	$res_brand								=	mysql_query($query_brand) or die(mysql_error());
	?>
	<select class="dsrname" name="brandcode" id="brandcode" multiple onChange="getbrandspecific ();">
	<option value="">---Brand---</option>

	<option value="<?php echo $brandstrval; ?>" <?php if(strstr($brandstr,$brandstrval)) { echo "selected"; } ?> > ALL</option>

	<?php if($rowcnt_brandnam > 0 ) { 
		while($info = mysql_fetch_assoc($res_brand)){?>
		<option value="<?php echo  $info['id']; ?>" <?php if(!strstr($brandstr,$brandstrval)) { if(strstr($brandstr,$info['id'])) { echo "selected"; }  }  if($brandcode == $info['id']) { echo "selected"; } ?> > <?php echo  upperstate($info['brand']); ?></option>
	<?php }
	} ?> 
</select> 
	<?php exit(0);
}

if($_GET[codeval] == 'null') {
	//echo "goodfd";
	//exit;
	$query_prod 							=	"SELECT id,brand from brand";
	$res_prod								=	mysql_query($query_prod) or die(mysql_error());
	?>
	<select class="dsrname" name="brandcode" id="brandcode" multiple onChange="getbrandspecific ();">
	<option value="">---Brand---</option>

	<option value="<?php echo $brandstrval; ?>" <?php if(strstr($brandstr,$brandstrval)) { echo "selected"; } ?> > ALL</option>

	<?php if($rowcnt_brandnam > 0 ) { 
		while($info = mysql_fetch_assoc($res_brand)){?>
		<option value="<?php echo  $info['id']; ?>" <?php if(!strstr($brandstr,$brandstrval)) { if(strstr($brandstr,$info['id'])) { echo "selected"; }  }  if($brandcode == $info['id']) { echo "selected"; } ?> > <?php echo  upperstate($info['brand']); ?></option>
	<?php }
	} ?> 
</select>
	<?php exit(0);
}

// THIS IS WHEN THE SELECT BOX IS EMPTY WITHOUT ANY SELECTED OPTIONS, IT IS EITHER ARRAY WITH EMPTY VALUE IN O INDEX OR NULL VALUE ENDS HERE

$params=$kdcode;
if(isset($_GET[codeval]) && $_GET[codeval] !='') {
	$codevalstr		=	implode("','",$codeval);
	$nextrecval		=	"WHERE Product_code IN ('".$codevalstr."')";	
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
$results_dsr		=	mysql_query($qry) or die(mysql_error());
$num_rows			=	mysql_num_rows($results_dsr);			

while($info = mysql_fetch_assoc($results_dsr)) {
	$brand[]		=	$info[brand];
}
//debugerr($brand);
$branduni								=	array_unique($brand);
//debugerr($branduni);
$brandstr								=	implode("','",$branduni);
$query_brandnam 						=	"SELECT id,brand FROM brand";
$res_brandnam 							=	mysql_query($query_brandnam) or die(mysql_error());
$rowcnt_brandnam						=	mysql_num_rows($res_brandnam);
?>
<select class="dsrname" name="brandcode" id="brandcode" multiple onChange="getbrandspecific ();">
	<option value="">---Brand---</option>

	<option value="<?php echo $brandstrval; ?>" <?php if(strstr($brandstr,$brandstrval)) { echo "selected"; } ?> > ALL</option>

	<?php if($rowcnt_brandnam > 0 ) { 
		while($info = mysql_fetch_assoc($res_brandnam)){?>
		<option value="<?php echo  $info['id']; ?>" <?php if(!strstr($brandstr,$brandstrval)) { if(strstr($brandstr,$info['id'])) { echo "selected"; }  }  if($brandcode == $info['id']) { echo "selected"; } ?> > <?php echo  upperstate($info['brand']); ?></option>
	<?php }
	} ?> 
</select>
<?php exit(0);?>