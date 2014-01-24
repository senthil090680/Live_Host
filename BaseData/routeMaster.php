<?php
session_start();
ob_start();
require_once('../include/header.php');
include("../include/ajax_pagination.php");
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
if($_REQUEST['device_description']!='')
{
	$var = @$_REQUEST['device_description'] ;
	$trimmed = trim($var);	
	$qry="SELECT * FROM `route_master` where route_desc like '%".$trimmed."%' order by route_desc asc";
}
else
{ 
	$qry="SELECT * FROM `route_master`"; 
}
$results=mysql_query($qry);
$num_rows= mysql_num_rows($results);			

$params			=	$device_description."&".$sortorder."&".$ordercol;

/********************************pagination start***********************************/
$strPage = $_REQUEST[page];
//$params = $_REQUEST[params];

//if($_REQUEST[mode]=="Listing"){
//$Num_Rows = mysql_num_rows ($res_search);

########### pagins

$Per_Page =8;   // Records Per Page

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

?>
<style type="text/css">
#containerpr {
	padding:0px;
	width:80%;
	margin-left:auto;
	margin-right:auto;
}
</style>

<script type="text/javascript">

function rousearch(page){  // For pagination and sorting of the SR search in view page
	var route_desc	=$("input[name='route_desc']").val();
	$.ajax({
		url : "rouajax.php",
		type: "get",
		dataType: "text",
		data : { "route_desc" : route_desc, "page" : page },
		success : function(dataval) {
			var trimval		=	$.trim(dataval);
			//alert(trimval);
			$("#rouid").html(trimval);
		}
	});
}

function rouviewajax(page,params){   // For pagination and sorting of the SR view page
	var splitparam	=	params.split("&");
	var route_desc   	    =	splitparam[0];
	var sortorder	        =	splitparam[1];
	var ordercol	        =	splitparam[2];
	$.ajax({
		url : "rouajax.php",
		type: "get",
		dataType: "text",
		data : {"route_desc" : route_desc, "sortorder" : sortorder, "ordercol" : ordercol, "page" : page },
		success : function(dataval) {
			var trimval		=	$.trim(dataval);
			//alert(trimval);
			$("#rouid").html(trimval);
		}
	});
}
</script>

<div id="mainarea">
<div class="mcf"></div>
<div><h2 align="center">Route</h2></div> 
<span style="float:left;">&nbsp;&nbsp;&nbsp;<input type="button" name="kdproduct" value="Close" class="buttons" onclick="window.location='../include/empty.php'"></span>

 <div id="search">
        <input type="text" name="route_desc" value="<?php echo $_REQUEST['route_desc']; ?>" autocomplete='off' placeholder='Search By Route Desc'/>
        <input type="button" class="buttonsg" onclick="devsearch('<?php echo $Page; ?>');" value="GO"/>
 </div>
  <div class="clearfix"></div>
			<div id="rouid">
			<div class="con" width="100%">
			<table width="100%">
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
			  $paramsval	=	$route_desc."&".$sortorderby."&route_desc"; ?>
             
            <th>KD Name</th>
            <th>KD Code</th> 
            <th nowrap="nowrap" class="rounded" onClick="rouviewajax('<?php echo $Page;?>','<?php echo $paramsval;?>');">Route Description<img src="../images/sort.png" width="13" height="13" /></th>
            <th>Route Code</th> 
            <th>Location</th>
            <th>Distance</th>
          	</tr>
			</thead>
			<tbody>
			<?php
			if(!empty($num_rows)){
			$c=0;$cc=1;
			while($fetch = mysql_fetch_array($results_dsr)) {
			if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }
			$id= $fetch['id'];
            $city= $fetch['City'];
			$lga= $fetch['lga'];
			?>
			<tr>
			<td><?php echo $fetch['KD_Name'];?></td>
            <td><?php echo $fetch['KD_Code'];?></td>
            <td><?php echo $fetch['route_desc'];?></td>
            <td><?php echo $fetch['route_code'];?></td>
            <td><?php echo $fetch['location'];?>
            <td><?php echo $fetch['route_distance'];?></td>
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
				
				rendering_pagination_common($Num_Pages,$Page,$Prev_Page,$Next_Page,$params,'rouviewajax');   //need to uncomment
				
			} else { 
				echo "&nbsp;"; 
			} ?>      
			</th>
			</tr>
			</table>
		  </div>
        </div>
 </div>
<?php require_once('../include/footer.php');?>