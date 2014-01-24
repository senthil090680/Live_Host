<?php
session_start();
ob_start();
include('../include/header.php');
require_once("../include/ajax_pagination.php");
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
if($_REQUEST['brand']!='')
{
	$var = @$_REQUEST['brand'] ;
	$trimmed = trim($var);	
	$qry="SELECT * FROM `brand` where brand like '%".$trimmed."%'";
}
else
{ 
	$qry="SELECT *  FROM `brand`"; 
}
$results=mysql_query($qry);
$num_rows= mysql_num_rows($results);			

$params			=	$brand."&".$sortorder."&".$ordercol;

/********************************pagination start***********************************/
$strPage = $_REQUEST[page];
//$params = $_REQUEST[params];

//if($_REQUEST[mode]=="Listing"){
//$Num_Rows = mysql_num_rows ($res_search);

########### pagins

$Per_Page = 5;   // Records Per Page

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
	$orderby	=	"ORDER BY id DESC";
} else {
	$orderby	=	"ORDER BY $ordercol $sortorder";
}
$qry.=" $orderby LIMIT $Page_Start , $Per_Page";  //need to uncomment
//exit;
$results_dsr = mysql_query($qry) or die(mysql_error());
/********************************pagination***********************************/

EXTRACT($_POST);
$page=intval($_GET['page']);
$id=$_REQUEST['id'];
if($_GET['id']!=''){
if($_POST['submit']=='Save'){
$sql =("UPDATE brand SET 
       brand='$brand',
	   principal='$principal',
	   product_category='$product_category'
       WHERE id = $id");
mysql_query( $sql);
header("location:brand.php?no=2&page=$page");
}
}
elseif($_POST['submit']=='Save'){
if($brand=='')
{
header("location:brand.php?no=9");exit;
}
else
{
	    $sql="INSERT INTO `brand`(`brand`,`principal`,`product_category`)values('$brand','$principal','$product_category')";
        mysql_query( $sql);
        header("location:brand.php?no=1&page=$page");
  }

}

$id=$_GET['id'];
$list=mysql_query("select * from brand where id= '$id'"); 
while($row = mysql_fetch_array($list)){ 
	$brand = $row['brand'];
	$principal = $row['principal'];
	$product_category = $row['product_category'];
	} 


?>
<!------------------------------- Form -------------------------------------------------->
<script type="text/javascript">

function brandviewajaxsearch(page){  // For pagination and sorting of the SR search in view page
	var brand	=	$("input[name='brand']").val();
	$.ajax({
		url : "brandviewajax.php",
		type: "get",
		dataType: "text",
		data : { "brand" : brand, "page" : page },
		success : function(dataval) {
			var trimval		=	$.trim(dataval);
			//alert(trimval);
			$("#brandid").html(trimval);
		}
	});
}

function brandviewajax(page,params){   // For pagination and sorting of the SR view page
	var splitparam		=	params.split("&");
	var brand	        =	splitparam[0];
	var sortorder		=	splitparam[1];
	var ordercol		=	splitparam[2];
	$.ajax({
		url : "brandviewajax.php",
		type: "get",
		dataType: "text",
		data : { "brand" : brand, "sortorder" : sortorder, "ordercol" : ordercol, "page" : page },
		success : function(dataval) {
			var trimval		=	$.trim(dataval);
			//alert(trimval);
			$("#brandid").html(trimval);
		}
	});
}
</script>

<style type="text/css">
#mytablebr{
background:#fff;
width:40%;
margin-left:auto;
margin-right:auto;
height:200px;
}
</style>

<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headings">Brand</div>
<div id="mytablebr" align="center">
<form action="" method="post" id="validation">
<table>
   <tr height="40px">
   <td>Principal</td>
   <td class="align">
    <?php
        $list=mysql_query("select * from  principal order by  principal asc");
        // Show records by while loop.
	   // End while loop.
        ?>
       <select name= "principal">
        <option value="">--- Select ---</option>
		<?php
		while($row_list=mysql_fetch_assoc($list)){
		?>
       <option value="<?php echo $row_list['id']; ?>" <?php if($row_list['id']== $principal){ echo "selected"; } ?>><?php echo $row_list['principal']; ?></option>

        <?php  } ?>
        </select>  
        </td>
        </tr>
        
       <tr height="40px">
   <td>Product Category</td>
   <td class="align">
    <?php
        $list=mysql_query("select * from  product_category order by product_category asc");
        // Show records by while loop.
	   // End while loop.
        ?>
       <select name= "product_category">
        <option value="">--- Select ---</option>
		<?php
		while($row_list=mysql_fetch_assoc($list)){
		?>
       <option value="<?php echo $row_list['id']; ?>" <?php if($row_list['id']== $product_category){ echo "selected"; } ?>><?php echo $row_list['product_category']; ?></option>

        <?php  } ?>
        </select>  
        </td>
        </tr>
        
        
  <tr height="40px">
    <td class="pclr">Brand*</td>
    <td><input type="text" name="brand" value="<?php echo $brand; ?>" autocomplete='off' maxlength="50"/></td>
   </tr>
 
<tr height="60px;" align="center">
<td colspan="10" >
<input type="submit" name="submit" id="submit" class="buttons" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="reset" name="reset"  class="buttons" value="Clear" id="clear" onclick="return brandclr();" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/>
</td>
     </tr>
</table>
</form>
</div>



<?php include("../include/error.php");?>
<div id="container">
<div class="clearfix"></div>
 <div id="search">
        <input type="text" name="brand" value="<?php echo $_REQUEST['brand']; ?>" autocomplete='off' placeholder='Search By brand'/>
        <input type="button" class="buttonsg" onclick="brandviewajaxsearch('<?php echo $Page; ?>');" value="GO"/>
 </div>

  <div class="clearfix"></div>
        <?php
		if($_GET['delID']!=''){
		if($_POST['submit']=='ConfirmDelete'){
		$id = $_GET['delID'];
		$query = "DELETE FROM brand WHERE id = $id";
        //Run the query
        $result = mysql_query($query) or die(mysql_error());
        header("location:brand.php?no=3&page=$page");
		}
		 }
		?> 
       	<div id="brandid"> 
		<div class="con" width="100%">
        <table align="center" width="100%">
        <thead>
        <tr>
        <?php //echo $sortorderby;
        if($sortorder == 'ASC') {
        $sortorderby = 'DESC';
        } elseif($sortorder == 'DESC') {
        $sortorderby = 'ASC';
        } else {
        $sortorderby = 'DESC';
        }
        $paramsval	=	$brand."&".$sortorderby."&brand"; ?>
        <th nowrap="nowrap" class="rounded" onClick="brandviewajax('<?php echo $Page;?>','<?php echo $paramsval; ?>');">Brand<img src="../images/sort.png" width="13" height="13" /></th>
        <th nowrap="nowrap">Principal</th>	
        <th nowrap="nowrap">Product Category</th>	
        <th nowrap="nowrap" align="right">Edit&nbsp;&nbsp;&nbsp;</th>	
        </tr>
		</thead>
		<tbody>
		<?php
        if(!empty($num_rows)){
        $c=0;$cc=1;
        while($fetch = mysql_fetch_array($results_dsr)) {
        if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }
        $principal= $fetch['principal'];
        $product_category= $fetch['product_category'];
        ?>
        <tr>
        <td><?php echo $fetch['brand'];?></td>
        <td>
        <?php
        $princi=mysql_query("select * from  principal where id='$principal'");
        $row=mysql_fetch_array($princi);
        $princid=$row['id'];
        $princv=$row['principal'];
        if($principal=$princv){echo $princv;}?>
        </td>
        <td>
        <?php
        $pro=mysql_query("select * from  product_category where id='$product_category'");
        $row=mysql_fetch_array($pro);
        $proid=$row['id'];
        $procv=$row['product_category'];
        if($product_category=$procv){echo $procv;}?>
        </td>
		<td align="right">
        <a href="brand.php?id=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']);?>"><img src="../images/user_edit.png" alt="" title="" width="11" height="11"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
       <!-- <a href="brand.php?id=<?php echo $fetch['id'];?>&delID=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']);?>"><img src="../images/trash.png" alt="" title="" width="11" height="11" /></a>-->
        </td>
        </tr>
		<?php $c++; $cc++; }		 
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
        rendering_pagination_common($Num_Pages,$Page,$Prev_Page,$Next_Page,$params,'brandviewajax');   //need to uncomment
        } else { 
        echo "&nbsp;"; 
        } ?>      
        </th>
        </tr>
        </table>
       </div>
       
   <div class="msg" align="center" <?php if($_GET['delID']!=''){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
   <form action="#" method="post">
     <input type="submit" name="submit" id="submit" class="buttonsdel" value="ConfirmDelete" />&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='brand.php'"/>
        </form>
     </div>
            
   </div>
</div>
</div>
<?php include('../include/footer.php'); ?>