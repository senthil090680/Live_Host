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
if($_REQUEST['branch']!='')
{
	$var = @$_REQUEST['branch'] ;
	$trimmed = trim($var);	
	$qry="SELECT * FROM `branch` where branch like '%".$trimmed."%'";
}
else
{ 
	$qry="SELECT *  FROM `branch`"; 
}
$results=mysql_query($qry);
$num_rows= mysql_num_rows($results);			

$params			=	$branch."&".$sortorder."&".$ordercol;

/********************************pagination start***********************************/
$strPage = $_REQUEST[page];
//$params = $_REQUEST[params];

//if($_REQUEST[mode]=="Listing"){
//$Num_Rows = mysql_num_rows ($res_search);

########### pagins

$Per_Page = 6;   // Records Per Page

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
$sql =("UPDATE branch SET 
       branch='$branch'
       WHERE id = $id");
mysql_query( $sql);
header("location:branch.php?no=2&page=$page");
}
}
elseif($_POST['submit']=='Save'){
if($branch=='')
{
header("location:branch.php?no=9");exit;
}
else
{
$sel="select * from branch where branch ='$branch'";
$sel_query=mysql_query($sel);
		if(mysql_num_rows($sel_query)=='0') {
		$sql="INSERT INTO `branch`(`branch`)values('$branch')";
        mysql_query( $sql);
        header("location:branch.php?no=1&page=$page");
		}
		else {
		header("location:branch.php?no=18&page=$page");
	}
}

}

$id=$_GET['id'];
$list=mysql_query("select * from branch where id= '$id'"); 
while($row = mysql_fetch_array($list)){ 
	$branch = $row['branch'];
	} 


?>
<!------------------------------- Form -------------------------------------------------->
<style type="text/css">
#containerpr {
	padding:0px;
	width:80%;
	margin-left:auto;
	margin-right:auto;
}
</style>



<script type="text/javascript">

function branchviewajaxsearch(page){  // For pagination and sorting of the SR search in view page
	var branch	=	$("input[name='branch']").val();
	$.ajax({
		url : "branchviewajax.php",
		type: "get",
		dataType: "text",
		data : { "branch" : branch, "page" : page },
		success : function(dataval) {
			var trimval		=	$.trim(dataval);
			//alert(trimval);
			$("#branchid").html(trimval);
		}
	});
}

function branchviewajax(page,params){   // For pagination and sorting of the SR view page
	var splitparam		=	params.split("&");
	var branch	        =	splitparam[0];
	var sortorder		=	splitparam[1];
	var ordercol		=	splitparam[2];
	$.ajax({
		url : "branchviewajax.php",
		type: "get",
		dataType: "text",
		data : { "branch" : branch, "sortorder" : sortorder, "ordercol" : ordercol, "page" : page },
		success : function(dataval) {
			var trimval		=	$.trim(dataval);
			//alert(trimval);
			$("#branchid").html(trimval);
		}
	});
}
</script>


<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headings">Branch</div>
<div id="mytable" align="center">
<form action="" method="post" id="validation">
<table>
  <tr height="60px">
    <td class="pclr">Branch*</td>
    <td><input type="text" name="branch" value="<?php echo $branch; ?>" autocomplete='off' maxlength="50"/></td>
   </tr>
 
<tr height="130px;" align="center">
<td colspan="10" >
<input type="submit" name="submit" id="submit" class="buttons" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="reset" name="reset"  class="buttons" value="Clear" id="clear" onclick="return branchclr();" />&nbsp;&nbsp;&nbsp;&nbsp;
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
        <input type="text" name="branch" value="<?php echo $_REQUEST['branch']; ?>" autocomplete='off' placeholder='Search By Branch'/>
        <input type="button" class="buttonsg" onclick="branchviewajaxsearch('<?php echo $Page; ?>');" value="GO"/>
 </div>
<div class="clearfix"></div>

        <?php
		if($_GET['delID']!=''){
		if($_POST['submit']=='ConfirmDelete'){
		$id = $_GET['delID'];
		$query = "DELETE FROM branch WHERE id = $id";
        //Run the query
        $result = mysql_query($query) or die(mysql_error());
        header("location:branch.php?no=3&page=$page");
		}
		 }
		?>
        <div id="branchid">  
		<div class="con2">
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
				$paramsval	=	$branch."&".$sortorderby."&branch"; ?>
				<th nowrap="nowrap" class="rounded" onClick="branchviewajax('<?php echo $Page;?>','<?php echo $paramsval; ?>');">Branch<img src="../images/sort.png" width="13" height="13" /></th>
		
		<th align="right">Edit&nbsp;&nbsp;</th>
		</tr>
		</thead>
        <tbody>
        <?php
        if(!empty($num_rows)){
        $c=0;$cc=1;
        while($fetch = mysql_fetch_array($results_dsr)) {
        if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }
        ?>
        <tr>
        <td><?php echo $fetch['branch'];?></td>
        <td align="right">
        <a href="branch.php?id=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']);?>"><img src="../images/user_edit.png" alt="" title="" width="11" height="11"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
        <!-- <a href="branch.php?id=<?php echo $fetch['id'];?>&delID=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']);?>"><img src="../images/trash.png" alt="" title="" width="11" height="11" /></a>-->
        </td>
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
				rendering_pagination_common($Num_Pages,$Page,$Prev_Page,$Next_Page,$params,'branchviewajax');   //need to uncomment
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
      <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='branch.php'"/>
        </form>
     </div>       
   </div>
</div>
</div>
<?php include('../include/footer.php'); ?>