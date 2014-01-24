<?php
session_start();
ob_start();
require_once('../include/header.php');
require_once "../include/ajax_pagination.php";
if(isset($_GET['logout'])){
	session_destroy();
	header("Location:../index.php");
}
error_reporting(E_ALL && ~ E_NOTICE);
/*echo "<pre>";
print_r($_REQUEST);
echo "</pre>";*/
EXTRACT($_REQUEST);
$id=$_REQUEST['id'];
//echo $id;
//exit;
if($_REQUEST['Product_code']!='')
{
	$var = @$_REQUEST['Product_code'] ;
	$trimmed = trim($var);	
	$qry="SELECT * FROM `kd_product` where Product_code like '%".$trimmed."%'";
}
else
{ 
	$qry="SELECT *  FROM `kd_product`"; 
}
$results=mysql_query($qry);
$num_rows= mysql_num_rows($results);			

$params			=	$Product_code."&".$sortorder."&".$ordercol;

/********************************pagination start***********************************/
$strPage = $_REQUEST[page];
//$params = $_REQUEST[params];

//if($_REQUEST[mode]=="Listing"){
//$Num_Rows = mysql_num_rows ($res_search);

########### pagins

$Per_Page = 15;   // Records Per Page

$Page = $strPage;
if(!$strPage)
{
	$Page=1;
}

$Prev_Page = $Page-1;
$Next_Page = $Page+1;

$Page_Start = (($Per_Page*$Page)-$Per_Page);
if($num_rows<=$Per_Page)
{
$Num_Pages =1;
}
else if(($num_rows % $Per_Page)==0)
{
$Num_Pages =($num_rows/$Per_Page) ;
}
else
{
$Num_Pages =($num_rows/$Per_Page)+1;
$Num_Pages = (int)$Num_Pages;
}
if($sortorder == "")
{
	$orderby	=	"ORDER BY kd_category DESC";
} else {
	$orderby	=	"ORDER BY $ordercol $sortorder";
}
$qry.=" $orderby LIMIT $Page_Start , $Per_Page";  //need to uncomment
//exit;
$results_dsr = mysql_query($qry) or die(mysql_error());
/********************************pagination***********************************/

?>

<script type="text/javascript">

function kdproductviewajaxsearch(page){  // For pagination and sorting of the SR search in view page
	var Product_code	=	$("input[name='Product_code']").val();
	$.ajax({
		url : "kdproductviewajax.php",
		type: "get",
		dataType: "text",
		data : { "Product_code" : Product_code, "page" : page },
		success : function(dataval) {
			var trimval		=	$.trim(dataval);
			//alert(trimval);
			$("#productid").html(trimval);
		}
	});
}

function kdproductviewajax(page,params){   // For pagination and sorting of the SR view page
	var splitparam		=	params.split("&");
	var Product_code    =	splitparam[0];
	var sortorder		=	splitparam[1];
	var ordercol		=	splitparam[2];
	$.ajax({
		url : "kdproductviewajax.php",
		type: "get",
		dataType: "text",
		data : { "Product_code" : Product_code, "sortorder" : sortorder, "ordercol" : ordercol, "page" : page },
		success : function(dataval) {
			var trimval		=	$.trim(dataval);
			//alert(trimval);
			$("#productid").html(trimval);
		}
	});
}
</script>
<style type="text/css">
#containerpr {
	padding:0px;
	width:80%;
	margin-left:auto;
	margin-right:auto;
}
</style>
<div id="mainarea">
<div class="mcf"></div>
<div><h2 align="center">KD Product</h2></div> 
<span style="float:left;">&nbsp;&nbsp;<input type="button" value="Back" class="buttons" onclick="window.location='kdProduct.php'"></span>
 <div id="search">
        <input type="text" name="Product_code" value="<?php echo $_REQUEST['Product_code']; ?>" autocomplete='off' placeholder='Search By P.Code'/>
        <input type="button" class="buttonsg" onclick="kdproductviewajaxsearch('<?php echo $Page; ?>');" value="GO"/>
 </div>
 <div class="clearfix"></div>
     	    <div id="productid">
            
			<div class="con" width="100%">
			<table width="100%">
			<thead>
			<tr>
             <th style="width:10%">KD Category</th>
				<?php //echo $sortorderby;
				if($sortorder == 'ASC') {
					$sortorderby = 'DESC';
				} elseif($sortorder == 'DESC') {
					$sortorderby = 'ASC';
				} else {
					$sortorderby = 'DESC';
				}
				$paramsval	=	$Product_code."&".$sortorderby."&Product_code"; ?>
             
<th nowrap="nowrap"  style="width:10%" class="rounded" onClick="kdproductviewajax('<?php echo $Page;?>','<?php echo $paramsval; ?>');">Code<img src="../images/sort.png" width="13" height="13" /></th>
            <th style="width:60%">Description</th>
            <th style="width:5%">UOM</th>
            <th align="right">Price</th>
 			</tr>
			</thead>
			<tbody>
			<?php
			if(!empty($num_rows)){
			$c=0;$cc=1;
			while($fetch = mysql_fetch_array($results_dsr)) {
			if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }
			$id= $fetch['id'];
		    $kd_cate= $fetch['kd_category'];
			?>
            <tr>
            <td><?php $kdc=mysql_query("select * from  kd_category  where id='$kd_cate'");
			$row=mysql_fetch_array($kdc);
			$kdcid=$row['id'];
			$kdcv=$row['kd_category'];
			if($kd_cate=$kdcv){echo $kdcv;}?></td>
            <td><?php echo $fetch['Product_code'];?></td>
            <td><?php echo $fetch['Product_description1'];?></td>
            <td><?php echo $fetch['UOM1']?></td>
            <td align="right"><?php echo number_format(trim($fetch['Price']));?></td>
             </tr>
			<?php $c++; $cc++; $slno++; }		 
			}else{  echo "<tr><td align='center' colspan='13'><b>No records found</b></td></tr>";}  ?>
			</tbody>
			</table>
			 </div>   
			 <div class="paginationfile" align="center">
			 <table>
			 <tr>
			 <th class="pagination" scope="col">          
			<?php 
			if(!empty($num_rows)){
				rendering_pagination_common($Num_Pages,$Page,$Prev_Page,$Next_Page,$params,'kdproductviewajax');   //need to uncomment
			} else { 
				echo "&nbsp;"; 
			} ?>      
			</th>
			</tr>
			</table>
		  </div>
	 </div>
        <div class="msg" align="center" <?php if($_GET['delID']!=''){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
        <form action="" method="post">
        <input type="submit" name="submit" id="submit" class="buttonsdel" value="ConfirmDelete" />&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='productMaster.php'"/>
        </form>
        </div>    

   <div class="mcf"></div>
    <?php include("../include/error.php"); ?>
</div>
<?php require_once('../include/footer.php');?>