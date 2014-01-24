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

$productstrval							=	getdbstr('Product_code','product');


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

	$query_prod 							=	"SELECT id,Product_description1,Product_code FROM product";
	$res_prod								=	mysql_query($query_prod) or die(mysql_error());
	?>
	<select class="dsrname" style="width:570px;" name="prodcode" id="prodcode" multiple onChange="getprodspecific();">
	<option value="">----------------------------------------------Product-----------------------------------------</option>

	<option value="<?php echo $productstrval; ?>" <?php if(strstr($Prod_Codestr,$productstrval)) { echo "selected"; } ?> > ALL</option>

	<?php
		while($info		=	mysql_fetch_assoc($res_prod)) { ?>
		<option value="<?php echo  $info['Product_code']; ?>" <?php if(!strstr($Prod_Codestr,$productstrval)) { if(strstr($Prod_Codestr,$info['Product_code'])) { echo "selected"; }  }  if($prodcode == $info['Product_code']) { echo "selected"; } ?> > <?php echo  upperstate($info['Product_description1']); ?></option>
		<?php } ?>
	</select> 
	<?php exit(0);
}

if($_GET[codeval] == 'null') {
	//echo "goodfd";
	//exit;
	$query_prod 							=	"SELECT id,Product_description1,Product_code FROM product";
	$res_prod								=	mysql_query($query_prod) or die(mysql_error());
	?>
	<select class="dsrname" style="width:570px;" name="prodcode" id="prodcode" multiple onChange="getprodspecific();">
	<option value="">----------------------------------------------Product-----------------------------------------</option>

	<option value="<?php echo $productstrval; ?>" <?php if(strstr($Prod_Codestr,$productstrval)) { echo "selected"; } ?> > ALL</option>

	<?php
		while($info		=	mysql_fetch_assoc($res_prod)) { ?>
		<option value="<?php echo  $info['Product_code']; ?>" <?php if(!strstr($Prod_Codestr,$productstrval)) { if(strstr($Prod_Codestr,$info['Product_code'])) { echo "selected"; }  }  if($prodcode == $info['Product_code']) { echo "selected"; } ?> > <?php echo  upperstate($info['Product_description1']); ?></option>
		<?php } ?>
	</select> 
	<?php exit(0);
}

// THIS IS WHEN THE SELECT BOX IS EMPTY WITHOUT ANY SELECTED OPTIONS, IT IS EITHER ARRAY WITH EMPTY VALUE IN O INDEX OR NULL VALUE ENDS HERE


$params=$kdcode;
//echo $kdcode;
//exit;
if(isset($_GET[codeval]) && $_GET[codeval] !='') {
	$codevalstr		=	implode("','",$codeval);
	if($codevalstr != '') {
		$nextrecval		=	"WHERE brand IN ('".$codevalstr."')";	
	}
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
$results_dsr						=	mysql_query($qry) or die(mysql_error());
$num_rows							=	mysql_num_rows($results_dsr);

while($info							=	mysql_fetch_assoc($results_dsr)) {
	$Prod_Code[]						=	$info[Product_code];
}
//debugerr($brand);
$Prod_Codeuni							=	array_unique($Prod_Code);
//debugerr($Prod_Codeuni);
$Prod_Codestr							=	implode("','",$Prod_Codeuni);
//$KD_Codestr;
//$query_kdnam 						=	"SELECT id,KD_Code,KD_Name FROM kd WHERE KD_Code IN ('".$KD_Codestr."')";
$query_kdnam 						=	"SELECT id,Product_description1,Product_code FROM product";
$res_prod	 						=	mysql_query($query_kdnam) or die(mysql_error());
$rowcnt_kdnam						=	mysql_num_rows($res_prod);

?>

<select class="dsrname" style="width:570px;" name="prodcode" id="prodcode" multiple onChange="getprodspecific();">
	<option value="">----------------------------------------------Product-----------------------------------------</option>

	<option value="<?php echo $productstrval; ?>" <?php if(strstr($Prod_Codestr,$productstrval)) { echo "selected"; } ?> > ALL</option>

	<?php
		while($info		=	mysql_fetch_assoc($res_prod)) { ?>
		<option value="<?php echo  $info['Product_code']; ?>" <?php if(!strstr($Prod_Codestr,$productstrval)) { if(strstr($Prod_Codestr,$info['Product_code'])) { echo "selected"; }  }  if($prodcode == $info['Product_code']) { echo "selected"; } ?> > <?php echo  upperstate($info['Product_description1']); ?></option>
		<?php } ?>
	</select>
<?php exit(0); ?>