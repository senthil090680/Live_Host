<?php
session_start();
ob_start();
include('../include/header.php');
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
if($_REQUEST['uom2']!='')
{
	$var = @$_REQUEST['uom2'] ;
	$trimmed = trim($var);	
	$qry="SELECT * FROM `uom_conversion` where uom2 like '%".$trimmed."%'";
}
else
{ 
	$qry="SELECT * FROM `uom_conversion`"; 
}
$results=mysql_query($qry);
$num_rows= mysql_num_rows($results);			

$params			=	$uom2."&".$sortorder."&".$ordercol;

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
$id=$_REQUEST['id'];
if($_GET['id']!=''){
if($_POST['submit']=='Save'){
$sql  =  ("UPDATE uom_conversion SET 
          uom= '$uom', 
          uom2='$uom2',
		  uom_conversion='$uom_conversion'
		  WHERE id='$id'");
mysql_query($sql);
header("location:uomConversion.php?no=2");
}
}
elseif($_POST['submit']=='Save'){
	
		$sel="select * from uom_conversion where uom2='$uom2' AND uom_conversion ='$uom_conversion'";
		$sel_query=mysql_query($sel);
		$count=mysql_num_rows($sel_query);
		
		if ($count==0){
    	$sql="INSERT IGNORE INTO `uom_conversion`(`uom`,`uom2`,`uom_conversion`)
        values('$uom','$uom2','$uom_conversion')";
        mysql_query( $sql);
		
        header("location:uomConversion.php?no=1");
		
		}
		else {
		header("location:uomConversion.php?no=18");
		}
}

$list=mysql_query("select * from uom where id=1"); 
while($row = mysql_fetch_array($list)){ 
	$UOM_code = $row['UOM_code'];
	$UOM_description = $row['UOM_description'];
	} 

$id=$_GET['id'];
$list=mysql_query("select * from uom_conversion where id='$id'"); 
while($row = mysql_fetch_array($list)){ 
    $uom = $row['uom'];
	$uom2 = $row['uom2'];
	$uom_conversion = $row['uom_conversion'];
	} 


?>
<!------------------------------- Form -------------------------------------------------->
<style type="text/css">
#errormsgcol {
	display:none;
	width:40%;
	height:30px;
	background:#c1c1c1;
	margin-left:auto;
	margin-right:auto;
	border-radius:10px;
	padding-top:0px;
	-moz-border-radius:10px;
	-webkit-border-radius:10px;
	-ms-border-radius:10px;
	-o-border-radius:10px;
	text-align:center;
}

.myaligncol {
	 clear:both;
	padding-top:10px;
	margin:0 auto;
	color:#FF0000;
}

#closebutton {
  position:relative;
  top:-35px;
  right:-190px;
  border:none;
  background:url(../images/close_pop.png) no-repeat;
  color:transparent;
  
}
#mainareakd {
	width:100%;
	height:500px;
	background:#ebebeb;
}

#mytableu {
	background:#fff;
	width:95%;
	margin-left:auto;
	margin-right:auto;
	height:160px;
}

.headingsu{
	background:#a09e9e;
	width:95%;
	margin-left:auto;
	margin-right:auto;
	height:25px;
	padding-top:5px;
	border-radius:6px;
	font-weight:bold;
	font-size:14px;

  }
#containerpr {
	padding:0px;
	width:80%;
	margin-left:auto;
	margin-right:auto;
}  
</style>

<script type="text/javascript">

function uomcviewajaxsearch(page){  // For pagination and sorting of the SR search in view page
	var uom2 = $("input[name='uom2']").val();
	$.ajax({
		url : "uomcviewajax.php",
		type: "get",
		dataType: "text",
		data : { "uom2" : uom2, "page" : page },
		success : function(dataval) {
			var trimval		=	$.trim(dataval);
			//alert(trimval);
			$("#uomcid").html(trimval);
		}
	});
}

function uomcviewajax(page,params){   // For pagination and sorting of the SR view page
	var splitparam	=	params.split("&");
	var uom2	    =	splitparam[0];
	var sortorder	=	splitparam[1];
	var ordercol	=	splitparam[2];
	$.ajax({
		url : "uomcviewajax.php",
		type: "get",
		dataType: "text",
		data : {"uom2" : uom2, "sortorder" : sortorder, "ordercol" : ordercol, "page" : page },
		success : function(dataval) {
			var trimval		=	$.trim(dataval);
			//alert(trimval);
			$("#uomcid").html(trimval);
		}
	});
}


function validate() {
	var UOM			     	=	$('#uom').val();
	var UOM2		        =	$('#uom2').val();
	var Conversion		   =	$('#Conversion').val();
	
	
	if(UOM == ''){
		$('.myaligncol').html('ERR : Enter UOM');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}
	
	if(UOM2 == ''){
		$('.myaligncol').html('ERR : Select UOM2');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}	
	
   	if(Conversion == ''){
		alert('Hi');
		$('.myaligncol').html('ERR : Select UOM Conversion');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}	
	
	
	 if(parseInt(Conversion) === 0) {
		$('.myaligncol').html("ERR : Entered value is Not Zero");
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
			$('#errormsgcol').hide();
		},5000);
		return false;
	 }
		 
	$('#errormsgcol').css('display','none');
	//return false;
}
</script>

<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headingsu">UOM Conversion</div>
<div id="mytableu" align="center">
<form action="#" method="post" onsubmit="return validate()">
<table width="80%">
  <tr height="80px">
     <td  class="align">&nbsp;UOM2 <br />(Cartons)</td>
    <td>
      <select name="uom2" id="uom2">
      <option value="">--- Select ---</option>
        <?php 
        // Get records from database (table "name_list"). 
        $list=mysql_query("select * from  uom2"); 
        
        // Show records by while loop. 
        while($row_list=mysql_fetch_assoc($list)){ 
        ?>
        <option value="<?php echo $row_list['UOM2_Description']; ?>" <?php if($row_list['UOM2_Description']==$uom2){ echo "selected"; } ?>><?php echo $row_list['UOM2_Description']; ?></option>
        <?php 
        // End while loop. 
        } 
        ?>
       </select>
     </td>
  
    <td  class="align">UOM1<br />(PCS)</td>
    <td><input type="text"  name="uom" id="uom" size="10" value="<?php echo $UOM_code ?> " readonly="readonly"/></td>
   
    <td  class="align">UOM CONVERSION</td>
    <td><input type="text" name="uom_conversion" id="Conversion" autocomplete='off' size="10" value="<?php echo $uom_conversion ?> "/></td>
   </tr>

   <tr height="70px;" align="center">
        <td colspan="10">
        <input type="submit" name="submit" id="submit" class="buttons" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="reset" name="reset" id="reset"  class="buttons" value="Clear" onclick="window.location='uomconversion.php'" />&nbsp;&nbsp;&nbsp;&nbsp;
       <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/></td>
        </tr>
</table>
</form>
</div>
<?php include("../include/error.php");?>
<div id="errormsgcol" style="display:none;clear:both;">
<h3 align="center" class="myaligncol"></h3><button id="closebutton">Close</button></div>
<div class="mcf"></div>   
<div id="containerpr">
 <div id="search">
        <input type="text" name="uom2" value="<?php echo $_REQUEST['uom2']; ?>" autocomplete='off' placeholder='Search By UOM2'/>
        <input type="button" class="buttonsg" onclick="uomcviewajaxsearch('<?php echo $Page; ?>');" value="GO"/>
 </div>
  <div class="clearfix"></div>
		<div id="uomcid">
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
			  $paramsval	=	$uom2."&".$sortorderby."&uom2"; ?>
              
<th nowrap="nowrap" class="rounded" onClick="uomcviewajax('<?php echo $Page;?>','<?php echo $paramsval;?>');">UOM2<img src="../images/sort.png" width="13" height="13" /></th>
<th>UOM1</th>
<th>Uom Conversion</th>
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
			<td><?php echo $fetch['uom2'];?></td>
            <td><?php echo $fetch['uom'];?></td>
            <td><?php echo $fetch['uom_conversion'];?></td>
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
				
				rendering_pagination_common($Num_Pages,$Page,$Prev_Page,$Next_Page,$params,'uomcviewajax');   //need to uncomment
				
			} else { 
				echo "&nbsp;"; 
			} ?>      
			</th>
			</tr>
			</table>
		  </div>
        </div>
        </div> 
 </div>
<?php include('../include/footer.php'); ?>