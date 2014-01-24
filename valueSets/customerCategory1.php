<?php
session_start();
ob_start();
include('../include/header.php');
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
if($_REQUEST['category1']!='')
{
	$var = @$_REQUEST['category1'] ;
	$trimmed = trim($var);	
	$qry="SELECT * FROM `category1` where category1 like '%".$trimmed."%'";
}
else
{ 
	$qry="SELECT *  FROM `category1`"; 
}
$results=mysql_query($qry);
$num_rows= mysql_num_rows($results);			

$params			=	$category1."&".$sortorder."&".$ordercol;

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
$page=intval($_GET['page']);
$id=$_REQUEST['id'];
if($_GET['id']!=''){
if($_POST['submit']=='Save'){
$sql =("UPDATE category1 SET 
       category1='$category1'
       WHERE id = $id");
mysql_query( $sql);
header("location:customerCategory1.php?no=2&page=$page");
}
}
elseif($_POST['submit']=='Save'){
if($category1=='')
{
header("location:customerCategory1.php?no=9");exit;
}
else
{
$sel="select * from category1 where category1 ='$category1'";
$sel_query=mysql_query($sel);
		if(mysql_num_rows($sel_query)=='0') {
		$sql="INSERT INTO `category1`(`category1`)values('$category1')";
        mysql_query( $sql);
        header("location:customerCategory1.php?no=1&page=$page");
		}
		else {
		header("location:customerCategory1.php?no=18&page=$page");
	}
}

}

$id=$_GET['id'];
$list=mysql_query("select * from category1 where id= '$id'"); 
while($row = mysql_fetch_array($list)){ 
	$category1 = $row['category1'];
	} 


?>
<!------------------------------- Form -------------------------------------------------->
<script type="text/javascript">

function category1viewajaxsearch(page){  // For pagination and sorting of the SR search in view page
	var category1	=	$("input[name='category1']").val();
	$.ajax({
		url : "category1viewajax.php",
		type: "get",
		dataType: "text",
		data : { "category1" : category1, "page" : page },
		success : function(dataval) {
			var trimval		=	$.trim(dataval);
			//alert(trimval);
			$("#category1id").html(trimval);
		}
	});
}

function category1viewajax(page,params){   // For pagination and sorting of the SR view page
	var splitparam		=	params.split("&");
	var category1	        =	splitparam[0];
	var sortorder		=	splitparam[1];
	var ordercol		=	splitparam[2];
	$.ajax({
		url : "category1viewajax.php",
		type: "get",
		dataType: "text",
		data : { "category1" : category1, "sortorder" : sortorder, "ordercol" : ordercol, "page" : page },
		success : function(dataval) {
			var trimval		=	$.trim(dataval);
			//alert(trimval);
			$("#category1id").html(trimval);
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
<div align="center" class="headings">Customer Category1</div>
<div id="mytable" align="center">
<form action="" method="post" id="validation">
<table>
  <tr height="60px">
    <td class="pclr">Customer Category1*</td>
    <td><input type="text" name="category1" value="<?php echo $category1; ?>" autocomplete='off' maxlength="20"/></td>
   </tr>
 
<tr height="130px;" align="center">
<td colspan="10" >
<input type="submit" name="submit" id="submit" class="buttons" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="reset" name="reset" id="reset"  class="buttons" value="Clear" id="clear" onclick="return cat1Clear();" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/>
</td>
     </tr>
</table>
</form>
</div>
<?php include("../include/error.php");?>

<div class="mcf"></div>
<div id="container">
<div class="clearfix"></div>
 <div id="search">
        <input type="text" name="category1" value="<?php echo $_REQUEST['category1']; ?>" autocomplete='off' placeholder='Search By category1'/>
        <input type="button" class="buttonsg" onclick="category1viewajaxsearch('<?php echo $Page; ?>');" value="GO"/>
 </div>
 <div class="clearfix"></div>
        <?php
		if($_GET['delID']!=''){
	    $id = $_GET['delID'];
		$cat_sql="select a.*,b.* from customer as a,category1 as b where a.category1='$category1' AND b.id='$id'";
		$rescat=mysql_query($cat_sql);
		$cnt=mysql_num_rows($rescat);
		if($cnt=='1'){
        header("location:customerCategory1.php?no=32&page=$page"); 
		  }
		}
		if($_GET['delID']!=''){
		if($_POST['submit']=='ConfirmDelete'){
		$id = $_GET['delID'];
		$query = "DELETE FROM category1 WHERE id = $id";
        //Run the query
        $result = mysql_query($query) or die(mysql_error());
        header("location:customerCategory1.php?no=3&page=$page");
		}
		 }
		 
		?>  
	    <div id="category1id">  
	    <div class="con2" width="100%">
        <table id="sort" class="tablesorter" align="center" width="100%">
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
        $paramsval	=	$category1."&".$sortorderby."&category1"; ?>
        <th nowrap="nowrap" class="rounded" onClick="category1viewajax('<?php echo $Page;?>','<?php echo $paramsval; ?>');">Customer Category1<img src="../images/sort.png" width="13" height="13" /></th>
        
 	     <th align="right">Edit/Del</th>
		</tr>
		</thead>
		<tbody>
		<?php
		if(!empty($num_rows)){
		$c=0;$cc=1;
		while($fetch = mysql_fetch_array($results)) {
		if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }
		$id= $fetch['id'];
		?>
		<tr>
		<td><?php echo $fetch['category1'];?></td>
		<td align="right">
        <a href="customerCategory1.php?id=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']);?>"><img src="../images/user_edit.png" alt="" title="" width="11" height="11"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
<!--        <a href="customerCategory1.php?id=<?php echo $fetch['id'];?>&delID=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']);?>"><img src="../images/trash.png" alt="" title="" width="11" height="11" /></a>-->
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
				rendering_pagination_common($Num_Pages,$Page,$Prev_Page,$Next_Page,$params,'category1viewajax');   //need to uncomment
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
      <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='customerCategory1.php'"/>
        </form>
     </div>       
   </div>
</div>
</div>
<?php include('../include/footer.php'); ?>