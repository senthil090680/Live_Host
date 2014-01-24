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
if($_REQUEST['province']!='')
{
	$var = @$_REQUEST['province'] ;
	$trimmed = trim($var);	
	$qry="SELECT * FROM `province` where province like '%".$trimmed."%'";
}
else
{ 
	$qry="SELECT *  FROM `province`"; 
}
$results=mysql_query($qry);
$num_rows= mysql_num_rows($results);			

$params			=	$province."&".$sortorder."&".$ordercol;

/********************************pagination start***********************************/
$strPage = $_REQUEST[page];
//$params = $_REQUEST[params];

//if($_REQUEST[mode]=="Listing"){
//$Num_Rows = mysql_num_rows ($res_search);

########### pagins

$Per_Page =5;   // Records Per Page

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
$sql=("UPDATE  province SET 
       province='$province'
       WHERE id =$id"); 
     
mysql_query( $sql);
header("location:province.php?no=2&page=$page");
}
 }
elseif($_POST['submit']=='Save'){
if($province=='')
{
header("location:province.php?no=9");exit;
}
else{
$sel="select * from province where province ='$province'";
$sel_query=mysql_query($sel);
		if(mysql_num_rows($sel_query)=='0') {
		$sql="INSERT INTO `province`(`province`)values('$province')";
        mysql_query( $sql);
        header("location:province.php?no=1&page=$page");
		}
		else {
		header("location:province.php?no=18&page=$page");
		}
}		
}
$id=$_GET['id'];
$list=mysql_query("select * from  province where id='$id'"); 
while($row = mysql_fetch_array($list)){ 
	$province = $row['province'];
	} 

?>
<!------------------------------- Form -------------------------------------------------->
<script type="text/javascript">

function provinceviewajaxsearch(page){  // For pagination and sorting of the SR search in view page
	var province	=	$("input[name='province']").val();
	$.ajax({
		url : "provinceviewajax.php",
		type: "get",
		dataType: "text",
		data : { "province" : province, "page" : page },
		success : function(dataval) {
			var trimval		=	$.trim(dataval);
			//alert(trimval);
			$("#provinceid").html(trimval);
		}
	});
}

function provinceviewajax(page,params){   // For pagination and sorting of the SR view page
	var splitparam		=	params.split("&");
	var province	        =	splitparam[0];
	var sortorder		=	splitparam[1];
	var ordercol		=	splitparam[2];
	$.ajax({
		url : "provinceviewajax.php",
		type: "get",
		dataType: "text",
		data : { "province" : province, "sortorder" : sortorder, "ordercol" : ordercol, "page" : page },
		success : function(dataval) {
			var trimval		=	$.trim(dataval);
			//alert(trimval);
			$("#provinceid").html(trimval);
		}
	});
}
</script>

<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headings">Zone</div>
<div id="mytable" align="center">
<form action="" method="post" id="validation">
<table>
  <tr height="60px">
     <td class="pclr" width="100">Zone*</td>
     <td><input type="text" name="province" value="<?php echo $province; ?>" id="province" maxlength="50" autocomplete='off'/></td>
   </tr>
   <tr align="center" height="130px;">
       <td colspan="10">
       <input type="submit" name="submit" id="submit" class="buttons" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
       <input type="reset" name="reset" class="buttons" value="Clear" id="clear" onclick="return provinceClear();"/>&nbsp;&nbsp;&nbsp;&nbsp;
       <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/>
       </td>
      </tr>
</table>
</form>
</div>

 
<?php include("../include/error.php");?>


<div class="clearfix"></div>
<div id="container">

 <div id="search">
        <input type="text" name="province" value="<?php echo $_REQUEST['province']; ?>" autocomplete='off' placeholder='Search By Zone'/>
        <input type="button" class="buttonsg" onclick="provinceviewajaxsearch('<?php echo $Page; ?>');" value="GO"/>
 </div>
 <div class="clearfix"></div>
	   	<?php
		if($_GET['delID']!=''){
	    $id = $_GET['delID'];
		$cus_sql="select a.*,b.* from customer as a,province as b where a.province='$province' AND b.province='$id'";
		$resProvince=mysql_query($cus_sql);
		$cnt=mysql_num_rows($resProvince);
		if($cnt=='1'){
        header("location:province.php?no=23&page=$page"); 
		  }
		}
	    //Check Province is assigned to state	
		if($_GET['delID']!=''){
	    $id = $_GET['delID'];
		$id1 = $_GET['id'];
		$state_sql="select a.*,b.* from state as a,province as b where a.province_id='$id' AND b.province='$id'";
		$resProvince=mysql_query($state_sql);
		$cnt=mysql_num_rows($resProvince);
		if($cnt=='1'){
	     header("location:province.php?no=19&sta=ass&id=$id1&page=$page"); 
	    }
    	}	
		if($_POST['submit']=='ConfirmDelete'){
		$query1 =mysql_query("DELETE FROM province WHERE province ='$province'");
		$query=mysql_query("update state set province_id='Undefined' where province_id='$province'"); 
		header("location:province.php?no=3&page=$page");
		}
		?>  
        <div id="provinceid">
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
        $paramsval	=	$province."&".$sortorderby."&province"; ?>
        <th nowrap="nowrap" class="rounded" onClick="provinceviewajax('<?php echo $Page;?>','<?php echo $paramsval; ?>');">Zone<img src="../images/sort.png" width="13" height="13" /></th>
        <th nowrap="nowrap" align="right">Edit&nbsp;&nbsp;</th>
        </tr>
        </thead>
		<tbody>
		<?php
		if(!empty($num_rows)){
		$c=0;$cc=1;
		while($fetch = mysql_fetch_array($results)) {
		if($c % 2 == 0){ $cls =""; } else{ $cls ="class='odd'"; }
		$id= $fetch['id'];
		?>
        <tr>
        <td><?php echo $fetch['province'];?></td>
		<td align="right">
		<a href="province.php?id=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']) ;?>"><img src="../images/user_edit.png" alt="" title="" width="11" height="11"/></a>
       <!-- <a href="province.php?id=<?php echo $fetch['id'];?>&delID=<?php echo $fetch['province'];?>&page=<?php echo intval($_GET['page']) ;?>"><img src="../images/trash.png" alt="" title="" width="11" height="11" /></a>-->
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
				rendering_pagination_common($Num_Pages,$Page,$Prev_Page,$Next_Page,$params,'provinceviewajax');   //need to uncomment
			} else { 
				echo "&nbsp;"; 
			} ?>      
			</th>
			</tr>
			</table>
		  </div>
   <div class="msg" align="center" <?php if($_GET['delID']!=''|| $_GET['sta']=='ass'){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
    <form action="" method="post">
    <a href="province.php?delID=<?php echo $_GET['delID'];?>"><input type="submit" name="submit" id="submit" class="buttonsdel" value="ConfirmDelete" /></a>&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='province.php'"/>
    </form>
     </div>
</div>
</div>
</div>
<?php include('../include/footer.php'); ?>
