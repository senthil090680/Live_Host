<?php
session_start();
ob_start();
include('../include/header.php');
include "../include/ps_pagination.php";
if(isset($_GET['logout'])){
session_destroy();
header("Location:../index.php");
}
EXTRACT($_POST);
$page=intval($_REQUEST['page']);
$id=$_REQUEST['id'];
if($_GET['id']!=''){
if($_POST['submit']=='Save'){
$Effective_from=date("Y-m-d",strtotime($Effective_from));	
$Effective_to=date("Y-m-d",strtotime($Effective_to));	
$sql = ("UPDATE scheme_master SET 
          Scheme_code= '$Scheme_code', 
          Scheme_Description='$Scheme_Description', 
		  Effective_from='$Effective_from',
          Effective_to='$Effective_to'
		  WHERE id = '$id'");
mysql_query( $sql);
header("location:scheme.php?no=2&page=$page");
 }
}
elseif($_POST['submit']=='Save'){?>
<form action="" method="post" id="resubmitform">
<input type="hidden" name="Scheme_code" value="<?php echo $Scheme_code; ?>" />
<input type="hidden" name="Scheme_Description" value="<?php echo $Scheme_Description; ?>" />
<input type="hidden" name="Effective_from" value="<?php echo $Effective_from; ?>" />
<input type="hidden" name="Effective_to" value="<?php echo $Effective_to; ?>" />
<input type="hidden" name="no" value="9" />
 
</form>
<form action="" method="post" id="dataexists">
<input type="hidden" name="Scheme_code" value="<?php echo $Scheme_code; ?>" />
<input type="hidden" name="Scheme_Description" value="<?php echo $Scheme_Description; ?>" />
<input type="hidden" name="Effective_from" value="<?php echo $Effective_from; ?>" />
<input type="hidden" name="Effective_to" value="<?php echo $Effective_to; ?>" />
<input type="hidden" name="no" value="18" />
<input type="hidden" name="page" value="<?php echo $page; ?>" />
</form>
<?php

//Check mandatory field is not empty
if($Scheme_code=='' || $Scheme_Description=='' || $Effective_from=='' || $Effective_to=='')
{?>
<script type="text/javascript">
document.forms['resubmitform'].submit();
</script>
<?php  //header("location:scheme.php?no=9");exit;
}
else{
		$sel="select * from scheme_master where Scheme_code ='$Scheme_code'";
		$sel_query=mysql_query($sel);
		$Effective_from=date("Y-m-d",strtotime($Effective_from));	
		$Effective_to=date("Y-m-d",strtotime($Effective_to));
	/* 	if(($Effective_from) < ($Effective_to)){
		echo "Date should be less"; */
		if(mysql_num_rows($sel_query)=='0'){
    	$sql="INSERT INTO `scheme_master`(`Scheme_code`,`Scheme_Description`,`Effective_from`,`Effective_to`)
		values('$Scheme_code','$Scheme_Description','$Effective_from','$Effective_to')";
		mysql_query( $sql);
		header("location:scheme.php?no=1&page=$page");
		}
		else { ?>
        <script type="text/javascript">
		document.forms['dataexists'].submit();
		</script>
        <?php //header("location:scheme.php?no=18");
		}
}
 }
$id=$_GET['id'];
$list=mysql_query("select * from scheme_master where id= '$id'"); 
while($row = mysql_fetch_array($list)){ 
	$Scheme_code = $row['Scheme_code'];
	$Scheme_Description = $row['Scheme_Description'];
	$Effective_from = $row['Effective_from'];
	$Effective_to = $row['Effective_to'];
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
</style>

<script type="text/javascript">
function schemevalidate() {
 	
	var Schemedescription			=	$("#Scheme_Description").val();
	var fromdateval					=	$("#fromdate").val();
	var todateval					=	$("#todate").val();
	
	var dt1		=	parseInt(fromdateval.substring(8, 10), 10);
	var mon1	=	(parseInt(fromdateval.substring(5, 7), 10)) - 1;
	var yr1		=	parseInt(fromdateval.substring(0, 4), 10);
	var date1	=	new Date(yr1, mon1, dt1);

	var dt2 = parseInt(todateval.substring(8, 10), 10);
	var mon2 = (parseInt(todateval.substring(5, 7), 10)) - 1;
	var yr2 = parseInt(todateval.substring(0, 4), 10);
	var date2		=	new Date(yr2, mon2, dt2);
	//alert(currdate);
 
   	var date1	=	new Date(yr1, mon1, dt1);
		
		if(Schemedescription =='') {
		//alert(reportby);
		$('.myaligncol').html("ERR : Enter Scheme Desc");
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
		}
		
		if(date1 > date2) {
		$('.myaligncol').html("ERR : From Date greater than To Date");
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
		}

$.ajax({
		      type: "GET",
		      url: "dateexists.php",
		      success: function(data) {
			  var obj = $.parseJSON(data);      
					//var result = "<ul>"
				    $.each(obj, function() {
					var fromdatemysql =	  this['Effective_from'];
					var todatemysql    =   this['Effective_to'];
												
					//alert(todatemysql);
					if(fromdatemysql == fromdateval) {
					$('.myaligncol').html("ERR : 'Scheme' Already start in this Date");
					$('#errormsgcol').css('display','block');
					setTimeout(function() {
					$('#errormsgcol').hide();
					},5000);
					return false;
					}
					
				    if(todatemysql == todateval) {
						//alert("Hi");
					$('.myaligncol').html("ERR : 'Scheme' Already End in this Date");
					$('#errormsgcol').css('display','block');
					setTimeout(function() {
					$('#errormsgcol').hide();
					},5000);
					return false;
					}
					
					if(fromdateval == '') {
					$('.myaligncol').html("ERR : Select From Date");
					$('#errormsgcol').css('display','block');
					setTimeout(function() {
					$('#errormsgcol').hide();
					},5000);
					return false;
					}
					
					if(fromdatemysql > fromdateval) {
						//alert("Hi");
					$('.myaligncol').html("ERR : New Scheme Start Date not less than Scheme Exists");
					$('#errormsgcol').css('display','block');
					setTimeout(function() {
					$('#errormsgcol').hide();
					},5000);
					return false;
					}
					
					if(todatemysql > todateval) {
						//alert("Hi");
					$('.myaligncol').html("ERR :New Scheme End Date not less than  Scheme Exists");
					$('#errormsgcol').css('display','block');
					setTimeout(function() {
					$('#errormsgcol').hide();
					},5000);
					return false;
					}
					
				    });
			  }
      });	

		
		if(todateval == '') {
		$('.myaligncol').html("ERR : Select To Date");
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
		}
}
</script>	


<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headingsc">Scheme</div>
<div id="mytablescheme">
<form action="" method="post" id="validation" onsubmit="return schemevalidate()">
<table>
    <tr height="30px">
    <td class="pclr align">Scheme*</td>
    <td colspan="4"><input type="text"  name="Scheme_Description" id="Scheme_Description" size="60" autocomplete='off' value="<?php echo $Scheme_Description; ?>"/></td>
     </tr>
   
    <tr  height="30px;">
    <td class="align">Scheme Code</td>
    	<?php
		 if(!isset($_GET[id]) && $_GET[id] == '') {
			$schid					=	"SELECT Scheme_code FROM  scheme_master  ORDER BY id DESC";
			$schold					=	mysql_query($schid) or die(mysql_error());
			$schcnt					=	mysql_num_rows($schold);
			//$schcnt					=	0; // comment if live
			if($schcnt > 0) {
				$row_sch					  =	 mysql_fetch_array($schold);
				$schnumber	  =	$row_sch['Scheme_code'];

				$getschno			=	abs(str_replace("SCH",'',strstr($schnumber,"SCH")));
				$getschno++;
				if($getschno < 10) {
					$createdcode	=	"00".$getschno;
				} else if($getschno < 100) {
					$createdcode	=	"0".$getschno;
				} else {
					$createdcode	=	$getschno;
				}

				$Scheme_code				=	"SCH".$createdcode;
			} else {
				$Scheme_code				=	"SCH001";
			}
		}
	?>

    <td><input type="text"  name="Scheme_code" size="10" value="<?php echo $Scheme_code; ?>" autocomplete='off'/></td>
    <td class="align">Effective From*</td>
    <td>
    <input type="text" name="Effective_from" id="fromdate" onChange="changeDateFormat(this.value,'fromdate')" class="datepicker fromdate" value="<?php if($_REQUEST['id']!=''){ echo date("Y-m-d",strtotime($Effective_from));}?>" maxlength="10" autocomplete="off" size="10">
   </td>
      </tr>
    
 <tr  height="30px;">
 <td class="align"></td>
 <td></td>
 <td class="align">Effective To*</td>
    <td>
    <input type="text" name="Effective_to" id="todate" onChange="changeDateFormat(this.value,'todate')" class="datepicker todate" value="<?php if($_REQUEST['id']!=''){ echo date("Y-m-d",strtotime($Effective_to));}?>" maxlength="10" autocomplete="off" size="10">
</td>
     </tr>
    
     
    <tr height="50px;" align="center">
        <td colspan="10">
      <input type="submit" name="submit" id="submit" class="buttons" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="reset" name="reset"  class="buttons" value="Clear" id="clear" onclick="return sch();" />&nbsp;&nbsp;&nbsp;&nbsp;
     <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/></td> 
           
    </tr>
</table>
</form>
</div>
<?php include("../include/error.php");?>
 <div id="errormsgcol" style="display:none;clear:both;">
<h3 align="center" class="myaligncol"></h3><button id="closebutton">Close</button></div>
  <div id="search">
        <form action="" method="get">
        <input type="text" name="Scheme_code" value="<?php $_GET['Scheme_code']; ?>" autocomplete='off' placeholder='Search By Scheme'/>
        <input type="submit" name="submit" class="buttonsg" value="Go"/>
        </form>       
        </div>
<div class="mcf"></div>        
<div id="container">
	     <?php
		if($_GET['delID']!=''){
		if($_POST['submit']=='ConfirmDelete'){
		$id = $_GET['delID'];
		$query = "DELETE FROM `scheme_master` WHERE id = $id";
        //Run the query
        $result = mysql_query($query) or die(mysql_error());
        header("location:scheme.php?no=3&page=$page");
		}
		 }
		?> 
		<?php
		if($_GET['submit']!=='')
		{
		$var = @$_GET['Scheme_code'] ;
        $trimmed = trim($var);	
	    $qry="SELECT * FROM `scheme_master` where Scheme_code like '%".$trimmed."%' order by Scheme_code asc";
		}
		else
		{ 
		$qry="SELECT * FROM `scheme_master` order by Scheme_code asc";
		}
		$results=mysql_query($qry);
		$pager = new PS_Pagination($bd,$qry,4,4);
		$results = $pager->paginate();
		$num_rows= mysql_num_rows($results);			
		?>
        <div class="con">
        <table id="sort" class="tablesorter" width="100%">
		<thead>
		<tr>
		<th class="rounded">Scheme Code<img src="../images/sort.png" width="13" height="13" /></th>
		<th>Scheme Description</th>
        <th>Effective From</th>
        <th>Effective To</th>
      	<th align="right">Edit/Del</th>
		</tr>
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
		<td><?php echo $fetch['Scheme_code'];?></td>
		<td><?php echo $fetch['Scheme_Description'];?></td>
        <td><?php echo $fetch['Effective_from'];?></td>
        <td><?php echo $fetch['Effective_to'];?></td>
       	<td align="right">
        <a href="scheme.php?id=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']);?>"><img src="../images/user_edit.png" alt="" title="" width="11" height="11"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="scheme.php?id=<?php echo $fetch['id'];?>&delID=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']);?>"><img src="../images/trash.png" alt="" title="" width="11" height="11" /></a>
        </td>
        </tr>
		<?php $c++; $cc++; }		 
		}else{  echo "<tr><td align='center' colspan='13'><b>No records found</b></td><td style='display:none' align='center' colspan='13'><b>No records found</b></td><td style='display:none' align='center' colspan='13'><b>No records found</b></td><td style='display:none' align='center' colspan='13'><b>No records found</b></td><td style='display:none' align='center' colspan='13'><b>No records found</b></td></tr>";}  ?>
		</tbody>
		</table>
        </div>
         <div class="paginationfile" align="center">
         <table>
		<tr>
		<th class="pagination" scope="col">          
		<?php 
		if(!empty($num_rows)){
		//Display the link to first page: First
		echo $pager->renderFirst()."&nbsp; ";
		//Display the link to previous page: <<
		echo $pager->renderPrev();
		//Display page links: 1 2 3
		echo $pager->renderNav();
		//Display the link to next page: >>
		echo $pager->renderNext()."&nbsp; ";
		//Display the link to last page: Last
		echo $pager->renderLast(); } else{ echo "&nbsp;"; } ?>      
		</th>
		</tr>
        </table>
        </div> 
    <div class="msg" align="center" <?php if($_GET['delID']!=''){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
    <form action="" method="post">
    <input type="submit" name="submit" id="submit" class="buttonsdel" value="ConfirmDelete" />&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='scheme.php'"/>
    </form>
    </div>  
   </div>
</div>
<?php include('../include/footer.php'); ?>