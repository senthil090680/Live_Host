<?php
session_start();
ob_start();
include('../include/header.php');
include("../include/ajax_pagination.php");
if(isset($_GET['logout'])){
session_destroy();
header("location:../index.php");
}
error_reporting(E_ALL && ~ E_NOTICE);
/*echo "<pre>";
print_r($_REQUEST);
echo "</pre>";*/
EXTRACT($_REQUEST);
$id=$_REQUEST['id'];
//echo $id;
//exit;
if($_REQUEST['UOM2']!='')
{
	$var = @$_REQUEST['UOM2'] ;
	$trimmed = trim($var);	
	$qry="SELECT * FROM `uom2` where UOM2 like '%".$trimmed."%'";
}
else
{ 
	$qry="SELECT *  FROM `uom2`"; 
}
$results=mysql_query($qry);
$num_rows= mysql_num_rows($results);			

$params			=	$UOM2."&".$sortorder."&".$ordercol;

/********************************pagination start***********************************/
$strPage = $_REQUEST[page];

$Per_Page = 8;   // Records Per Page

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
        $sql =("UPDATE uom2 SET 
        UOM2='$UOM2',
		UOM2_Description='$UOM2_Description'
	   	WHERE id = '$id'");
		mysql_query( $sql);
header("location:uom2.php?no=2&page=$page");
}

}
//Insert Data
elseif($_POST['submit']=='Save'){ ?>
<form action="" method="post" id="resubmitform">
<input type="hidden" name="UOM2" value="<?php echo $UOM2; ?>" />
<input type="hidden" name="UOM2_Description" value="<?php echo $UOM2_Description; ?>" />
<input type="hidden" name="no" value="9" />
</form>

<form action="" method="post" id="dataexists">
<input type="hidden" name="UOM2" value="<?php echo $UOM2; ?>" />
<input type="hidden" name="UOM2_Description" value="<?php echo $UOM2_Description; ?>" />
<input type="hidden" name="no" value="18" />
<input type="hidden" name="page" value="<?php echo $page; ?>" />
</form>

<?php
//Check mandatory field is not empty
if($UOM2=='' || $UOM2_Description =='')
{ ?>
<script type="text/javascript">
document.forms['resubmitform'].submit();
</script>
<?php //header("location:location.php?no=9");exit;
}
else{
$sel="select * from uom2 where UOM2 ='$UOM2'"; 
$sel_query=mysql_query($sel);
		if(mysql_num_rows($sel_query)==0) {
		$sql="INSERT INTO `uom2`(`UOM2`,`UOM2_Description`)values('$UOM2','$UOM2_Description')";
		mysql_query( $sql);
        header("location:uom2.php?no=1&page=$page");
		}
		else { ?>
        <script type="text/javascript">
		document.forms['dataexists'].submit();
		</script>
        <?php //header("location:location.php?no=18&page=$page");
		}
}
 }
$id=$_GET['id'];
$list=mysql_query("select * from  uom2 where id= '$id'"); 
while($row = mysql_fetch_array($list)){ 
	$UOM2 = $row['UOM2'];
	$UOM2_Description = $row['UOM2_Description'];
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


.con {
	width:40%;
	text-align:left;
	border-collapse:collapse;
	background:#a09e9e;
	margin-left:auto;
	margin-right:auto;
	border-radius:10px;
}
.con th,.con2 th,.con3 th {
	width:22%;
	padding:2px 5px 0 5px;
	font-weight:bold;
	font-size:13px;
	color:#000;
}
.con td,.con2 td,.con3 td  {
	padding:2px 5px 0 5px;
	background:#fff;
	border-collapse:collapse;
	color: #000;
	font-size:13px;
}
.con tbody tr:hover td,.con2 tbody tr:hover td,.con3 tbody tr:hover td {
	background: #c1c1c1;
}
</style>
<script type="text/javascript">

function uomsearch(page){  // For pagination and sorting of the SR search in view page
	var UOM2=$("input[name='UOM2']").val();
	$.ajax({
		url : "uomajax.php",
		type: "get",
		dataType: "text",
		data : { "UOM2" : UOM2, "page" : page },
		success : function(dataval) {
			var trimval		=	$.trim(dataval);
			//alert(trimval);
			$("#uomid").html(trimval);
		}
	});
}

function uomviewajax(page,params){   // For pagination and sorting of the SR view page
	var splitparam		=	params.split("&");
	var UOM2            =	splitparam[0];
	var sortorder		=	splitparam[1];
	var ordercol		=	splitparam[2];
	$.ajax({
		url : "uomajax.php",
		type: "get",
		dataType: "text",
		data : { "UOM2" : UOM2, "sortorder" : sortorder, "ordercol" : ordercol, "page" : page },
		success : function(dataval) {
			var trimval		=	$.trim(dataval);
			//alert(trimval);
			$("#uomid").html(trimval);
		}
	});
}
</script>

<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headings">UOM2</div>
<div id="mytable" align="center">
<form action="#" method="post" id="validation">
<table>
    <tr  height="50px">
    <td  class="pclr align">UOM2*</td>
   <td><input type="text" name="UOM2" value="<?php echo $UOM2; ?>" id="UOM2"  maxlength="50" autocomplete='off'/></td>
   </tr>
  <tr>
    <td>UOM2 Description*</td>
    <td><input type="text" name="UOM2_Description" value="<?php echo $UOM2_Description; ?>" id="UOM2_Description"  maxlength="50" autocomplete='off'/></td>
   </tr>
   
   <tr align="center" height="100px;">
        <td colspan="10"><input type="submit" name="submit" id="submit" class="buttons" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="reset" name="reset" id="Clear"  class="buttons" value="Clear" onclick='window.location='uom2.php''/>&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/></td>
      </tr>
</table>
</form>
</div>
   <div class="clearfix"></div>     
 <div id="search" style="padding-right:300px">
        <input type="text" name="UOM2" value="<?php echo $_REQUEST['UOM2']; ?>" autocomplete='off' placeholder='Search By UOM2'/>
        <input type="button" class="buttonsg" onclick="uomsearch('<?php echo $Page; ?>');" value="GO"/></div>
<?php include("../include/error.php");?>

	    <?php
		if($_GET['delID']!=''){
	    $id = $_GET['delID'];
		$cat_sql="select a.*,b.* from route_master as a,location as b where a.location='$location' AND b.id='$id'";
		$rescat=mysql_query($cat_sql);
		$cnt=mysql_num_rows($rescat);
		if($cnt=='1'){
        header("location:location.php?no=42&page=$page"); 
		  }
		}
		if($_GET['delID']!=''){
		if($_POST['submit']=='ConfirmDelete'){
		$id = $_GET['delID'];
		$query = "DELETE FROM uom2 WHERE id = $id";
        //Run the query
        $result = mysql_query($query) or die(mysql_error());
        header("location:uom2.php?no=3&page=$page");
		}
		 }
		 
		?>  
        <div class="clearfix"></div>       
    	<div id="uomid">
        <div class="con">
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
		    	$paramsval	=	$UOM2."&".$sortorderby."&UOM2"; ?>
            
<th nowrap="nowrap" class="rounded" onClick="uomviewajax('<?php echo $Page;?>','<?php echo $paramsval; ?>');">UOM2<img src="../images/sort.png" width="13" height="13" /></th>
            <th>UOM2 Description</th>
			</tr>
		</thead>
		<tbody>
		<?php
        if(!empty($num_rows)){
        $c=0;$cc=1;
        while($fetch = mysql_fetch_array($results_dsr)) {
        if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }
        $id= $fetch['id'];
        $kd_category= $fetch['kd_category'];
        ?>
        <tr>
        <tr>
        <td><?php echo $fetch['UOM2'];?></td>
        <td><?php echo $fetch['UOM2_Description'];?></td>
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
        
        rendering_pagination_common($Num_Pages,$Page,$Prev_Page,$Next_Page,$params,'uomviewajax');   //need to uncomment
        
        } else { 
        echo "&nbsp;"; 
        } ?>      
        </th>
        </tr>
        </table>
        </div>
   </div>
</div>
<?php include('../include/footer.php'); ?>