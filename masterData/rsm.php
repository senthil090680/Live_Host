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
if($_REQUEST['DSRName']!='')
{
	$var = @$_REQUEST['DSRName'] ;
	$trimmed = trim($var);	
	$qry="SELECT * FROM `rsm_sp` where DSRName like '%".$trimmed."%'";
}
else
{ 
	$qry="SELECT *  FROM `rsm_sp`"; 
}
$results=mysql_query($qry);
$num_rows= mysql_num_rows($results);			

$params			=	$DSRName."&".$sortorder."&".$ordercol;

/********************************pagination start***********************************/
$strPage = $_REQUEST[page];

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
$page=intval($_REQUEST['page']);
$id=$_REQUEST['id'];
if($_GET['id']!=''){
if($_POST['submit']=='Save'){
$date=date("Y-m-d");	
$sql=("UPDATE rsm_sp SET 
          branch_id='$branch_id',
		  Date='$date',
          DSR_Code='$DSR_Code',
		  DSRName='$DSRName',
		  Contact_Number='$Contact_Number',
		  email_id='$email_id'
		  WHERE id = '$id'");
 
mysql_query( $sql);
header("location:rsm.php?no=2&page=$page");
}
}
elseif($_POST['submit']=='Save'){?>
<form action="" method="post" id="resubmitform">
<input type="hidden" name="branch_id" value="<?php echo $branch_id; ?>" />
<input type="hidden" name="DSR_Code" value="<?php echo $DSR_Code; ?>" />
<input type="hidden" name="DSRName" value="<?php echo $DSRName; ?>" />
<input type="hidden" name="Contact_Number" value="<?php echo $Contact_Number; ?>" />
<input type="hidden" name="email_id" value="<?php echo $email_id; ?>" />
<input type="hidden" name="no" value="9" />
 
</form>
<form action="" method="post" id="dataexists">
<input type="hidden" name="branch_id" value="<?php echo $branch_id; ?>" />
<input type="hidden" name="DSR_Code" value="<?php echo $DSR_Code; ?>" />
<input type="hidden" name="DSRName" value="<?php echo $DSRName; ?>" />
<input type="hidden" name="Contact_Number" value="<?php echo $Contact_Number; ?>" />
<input type="hidden" name="email_id" value="<?php echo $email_id; ?>" />
<input type="hidden" name="no" value="18" />
<input type="hidden" name="page" value="<?php echo $page; ?>" />
</form>

<form action="" method="post" id="email">
<input type="hidden" name="branch_id" value="<?php echo $branch_id; ?>" />
<input type="hidden" name="DSR_Code" value="<?php echo $DSR_Code; ?>" />
<input type="hidden" name="DSRName" value="<?php echo $DSRName; ?>" />
<input type="hidden" name="Contact_Number" value="<?php echo $Contact_Number; ?>" />
<input type="hidden" name="email_id" value="<?php echo $email_id; ?>" />
<input type="hidden" name="no" value="11" />
<input type="hidden" name="page" value="<?php echo $page; ?>" />
</form>

<?php	
if($DSRName==''  || $Contact_Number=='')
{?>

<script type="text/javascript">
document.forms['resubmitform'].submit();
</script>

<?php //header("location:SalesRep.php?no=9");exit;
}

else if(!filter_var($email_id, FILTER_VALIDATE_EMAIL))
{?>

<script type="text/javascript">
document.forms['email'].submit();
</script>

<?php //header("location:DSRName.php?no=11&page=$page");
}
else{
$sel="select * from rsm_sp where DSR_Code ='$DSR_Code'";
$sel_query=mysql_query($sel);
$date=date("Y-m-d");
		if(mysql_num_rows($sel_query)=='0') {
        echo $sql="INSERT INTO `rsm_sp`(`DSR_Code`,`Date`,`branch_id`,`DSRName`,`Contact_Number`,`email_id`)
        values('$DSR_Code','$date','$branch_id','$DSRName','$Contact_Number','$email_id')";
		mysql_query( $sql);
	    header("location:rsm.php?no=1&page=$page");
		}
		else {?>
        <script type="text/javascript">
		document.forms['dataexists'].submit();
		</script>
        <?php
		//header("location:SalesRep.php?no=18&page=$page");
		}
    }

}
$id=$_GET['id'];
$list=mysql_query("select * from rsm_sp where id= '$id'"); 
while($row = mysql_fetch_array($list)){ 
   	$branch_id = $row['branch_id'];
	$DSR_Code = $row['DSR_Code'];
	$DSRName = $row['DSRName'];
	$Contact_Number	=$row['Contact_Number'];
	$email_id	=$row['email_id'];
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
 #mytableproduc_pro {
	background:#fff;
	width:80%;
	margin-left:auto;
	margin-right:auto;
	height:200px;
}


.headingspro{
	background:#a09e9e;
	width:80%;
	margin-left:auto;
	margin-right:auto;
	height:25px;
	padding-top:5px;
	border-radius:6px;
	font-weight:bold;
	font-size:14px;
} 

.con2 {
	width:80%;
	text-align:left;
	border-collapse:collapse;
	background:#a09e9e;
	margin-left:auto;
	margin-right:auto;
	border-radius:10px;
}

.con2 th {
	width:22%;
	padding:2px 5px 0 5px;
	font-weight:bold;
	font-size:13px;
	color:#000;
}
.con2 td{
	padding:2px 5px 0 5px;
	background:#fff;
	border-collapse:collapse;
	color: #000;
	font-size:13px;
}
.con2 tbody tr:hover td {
	background: #c1c1c1;
}
  
</style>

<script type="text/javascript">

function validatersm() {
	var DSRName				=	$('#DSRName').val();
	var Branchid			=	$('#branch_id').val();
	var RSM					=	$('#rsm').val();
	var Contactnumber       =   $('#contact_Number').val();
	var amtpat	= /^[0-9.]+$/;
	
   if(DSRName == ''){
		$('.myaligncol').html('ERR : Enter Name');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}
 
 
  if(Branchid == ''){
		$('.myaligncol').html('ERR : Select Branch Id');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}

 
  if(Contactnumber == ''){
		$('.myaligncol').html('ERR : Enter Contact Number');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}


  if(!amtpat.test($("#contact_Number").val())){
			$('.myaligncol').html('ERR : Enter Only Numeric Contact No!');
			$('#errormsgcol').css('display','block');
			setTimeout(function() {
				$('#errormsgcol').hide();
			},5000);
			return false;
		}
  if(email_id == ''){
		$('.myaligncol').html('ERR : Enter Email Id');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}
	if(RSM = ''){
     $('.myaligncol').html('ERR : Enter Superavisor');
	 $('#errormsgcol').css('display','block');
	 setTimeout(function() {
	  $('#errormsgcol').hide();
		 },5000);
		 return false;
		}
  
	$('#errormsgcol').css('display','none');
	//return false;
}

function rsmsearch(page){  // For pagination and sorting of the SR search in view page
	var DSRName=$("input[name='DSRName']").val();
	$.ajax({
		url : "rsmajax.php",
		type: "get",
		dataType: "text",
		data : { "DSRName" : DSRName, "page" : page },
		success : function(dataval) {
			var trimval		=	$.trim(dataval);
			//alert(trimval);
			$("#rsmid").html(trimval);
		}
	});
}

function rsmviewajax(page,params){   // For pagination and sorting of the SR view page
	var splitparam		=	params.split("&");
	var DSRName         =	splitparam[0];
	var sortorder		=	splitparam[1];
	var ordercol		=	splitparam[2];
	$.ajax({
		url : "rsmajax.php",
		type: "get",
		dataType: "text",
		data : { "DSRName" : DSRName, "sortorder" : sortorder, "ordercol" : ordercol, "page" : page },
		success : function(dataval) {
			var trimval		=	$.trim(dataval);
			//alert(trimval);
			$("#rsmid").html(trimval);
		}
	});
}
</script>

<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headingspro"  style="padding-right:10px;">RSM</div>
<div id="mytableproduc_pro" align="center" style="padding-right:10px;">
<div class="mcf"></div>
<form action="" method="post" onsubmit="return validatersm()">
<table>
    <tr height="40">
    <td class="pclr align" width="100">Name*</td>
    <td colspan="10"><input type="text" name="DSRName"  id="DSRName" size="80" value="<?php echo $DSRName; ?>" autocomplete='off' maxlength="50" /></td>
    </tr>
    
    <tr height="40">
    
      <td class="align">Branch*</td>
       <td>
		<?php
        $list=mysql_query("select * from host_information");
        ?>
        <select name="branch_id" id="branch_id">
        <option value="">--- Select ---</option>
		<?php
		while($row_list=mysql_fetch_assoc($list)){
		$branch_id=$row_list['branch_id'];
		?>
        <option value="<?php echo $row_list['branch_id']; ?>" <?php if($row_list['branch_id']==$branch_id){ echo "selected"; } ?>><?php $sambr=mysql_query("select * from  branch where id = '$branch_id'");
        $row=mysql_fetch_array($sambr);
        $branid=$row['id'];
		$branchv=$row['branch'];
		if($branid=$branch_id){echo $branchv;} ?></option>
        <?php  } ?>
        </select>
         </td>
    
    
    
    
    <td class="align" style="text-transform:uppercase">Code</td>
    	<?php
		 if(!isset($_GET[id]) && $_GET[id] == '') {
			$srid					=	"SELECT DSR_Code FROM rsm_sp ORDER BY id DESC";			
			$srold					=	mysql_query($srid) or die(mysql_error());
			$srcnt					=	mysql_num_rows($srold);
			//$srcnt					=	0; // comment if live
			if($srcnt > 0) {
				$row_sr					  =	 mysql_fetch_array($srold);
				$srnumber	  =	$row_sr['DSR_Code'];

				$getsrno						=	abs(str_replace("RSM",'',strstr($srnumber,"RSM")));
				$getsrno++;
				if($getsrno < 10) {
					$createdcode	=	"00".$getsrno;
				} else if($getsrno < 100) {
					$createdcode	=	"0".$getsrno;
				} else {
					$createdcode	=	$getsrno;
				}

				$DSR_Code				=	"RSM".$createdcode;
			} else {
				$DSR_Code				=	"RSM001";
			}
		}
	?>
    <td><input type="text" name="DSR_Code" size="5"  readonly="readonly" value="<?php echo $DSR_Code; ?>"  maxlength="50" autocomplete='off'/></td>
    
        
    <td class="align" width="100">Contact Number*</td>
    <td><input type="text" name="Contact_Number" id="contact_Number" size="15" value="<?php echo $Contact_Number; ?>" maxlength="20" autocomplete='off'/>
    </td>     
    </tr>
     
    <tr height="40">
    <td class="align">Email ID*</td>
    <td colspan="10" width="100"><input type="text"  id="email_id" name="email_id" size="80" value="<?php echo $email_id; ?>" maxlength="50" autocomplete='off'/>
    </td>
    </tr>

    <tr height="70px"align="center">
    <td colspan="10">
    <input type="submit" name="submit" id="submit" class="buttons" value="Save"/>&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="reset" name="reset"  class="buttons" value="Clear" id="clear" onclick="window.location='rsm.php'" />&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/></td>
    </tr>
</table>
</form>
</div>
<div class="mcf"></div> 
<?php include("../include/error.php");?>
<div id="errormsgcol" style="display:none;clear:both;">
<h3 align="center" class="myaligncol"></h3><button id="closebutton">Close</button></div>
 <div id="search">
        <input type="text" name="DSRName" value="<?php echo $_REQUEST['DSRName']; ?>" autocomplete='off' placeholder='Search By Name'/>
        <input type="button" class="buttonsg" onclick="rsmsearch('<?php echo $Page; ?>');" value="GO"/>
 </div>
<div class="mcf"></div>      

        <?php
		if($_GET['delID']!=''){
	    $id = $_GET['delID'];
		$cat_sql="select a.*,b.* from rsm_sp as a,asm_sp as b where a.DSRName='$DSRName' AND b.id='$id'";
		$rescat=mysql_query($cat_sql);
		$cnt=mysql_num_rows($rescat);
		if($cnt=='1'){
        header("location:rsm.php?no=52&page=$page"); 
		  }
		}
		if($_GET['delID']!=''){
		$page=intval($_GET['page']);	
		if($_POST['submit']=='ConfirmDelete'){
		$id = $_GET['delID'];
		$query = "DELETE FROM rsm_sp WHERE id = $id";
        //Run the query
        $result = mysql_query($query) or die(mysql_error());
        header("location:rsm.php?no=3&page=$page");
		}
		 }
		 
		?> 
         <div class="clearfix"></div>
      	<div id="rsmid">
		<div class="con2">
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
        $paramsval	=	$DSRName."&".$sortorderby."&DSRName"; ?>
        
        <th nowrap="nowrap" class="rounded" onClick="rsmviewajax('<?php echo $Page;?>','<?php echo $paramsval; ?>');">Name<img src="../images/sort.png" width="13" height="13" /></th>
        <th>Code</th>
        <th>Email Id</th>
        <th>Branch</th>
        <th>Contact Number</th>
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
		$KD_Name=$fetch['KD_Name'];
		$branch=$fetch['branch_id'];
		?>
		<tr>
        <td><?php echo $fetch['DSRName'];?></td>
		<td><?php echo $fetch['DSR_Code'];?></td>
		<td><?php echo $fetch['email_id'];?></td>
        <td><?php
		$sambr=mysql_query("select * from  branch where id= '$branch'");
        $row=mysql_fetch_array($sambr);
       	$branchv=$row['branch'];
		if($branch=$branchv){echo $branchv;}
		?></td>
		<td><?php echo $fetch['Contact_Number'];?></td>
       	<td align="right" width="100"><a href="rsm.php?id=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']) ;?>"><img src="../images/user_edit.png" alt="" title="" width="11" height="11"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="rsm.php?id=<?php echo $fetch['id'];?>&delID=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']) ;?>"><img src="../images/trash.png" alt="" title="" width="11" height="11" /></a>
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
        
        rendering_pagination_common($Num_Pages,$Page,$Prev_Page,$Next_Page,$params,'rsmviewajax');   //need to uncomment
        
        } else { 
        echo "&nbsp;"; 
        } ?>      
        </th>
        </tr>
        </table>
        </div>
    <div class="msg" align="center" <?php if($_GET['delID']!=''){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
    <form action="" method="post">
    <input type="submit" name="submit" id="submit" class="buttonsdel" value="ConfirmDelete" />&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='rsm.php'"/>
    </form>
    </div>         
   </div>
</div>

<?php include('../include/footer.php'); ?>