<?php
ob_start();
include('../include/header.php');
include "../include/ps_pagination.php";
require_once "../include/ajax_pagination.php";

//ini_set("display_errors",false);
//echo ini_get("display_errors");
if(isset($_GET['logout'])){
	session_destroy();
	header("Location:../index.php");
}
extract($_REQUEST);
$msg								=	'';
$query_KD 							=	"select id,KD_Name,KD_Code from kd";
$res_KD 							=	mysql_query($query_KD) or die(mysql_error());
$id									=	isset($_REQUEST['id']);
?>
<!------------------------------- Form -------------------------------------------------->
<style type="text/css">
.heading_report{
	background:#a09e9e;
	width:100%;
	margin-left:auto;
	margin-right:auto;
	height:25px;
	padding-top:5px;
	border-radius:6px;
	font-weight:bold;
	font-size:14px;
	clear:both;
}
#mytableform_report{
	background:#fff;
	width:99%;
	margin-left:auto;
	margin-right:auto;
	height:480px;
}
.alignment_report{
width:96%;
padding-left:20px;
margin-left:10px;
font-size:16px;
}
.condaily_routeplan th {
	padding:2px 5px 0 5px;
	font-weight:bold;
	font-size:14px;
	color:#000;
}
.condaily_routeplan td {
	padding:2px 5px 0 5px;
	background:#fff;
	border-collapse:collapse;
	padding-left:10px;
	color:#000;
	font-size:14px;
}
.condaily_routeplan tbody tr:hover td {
	background: #c1c1c1;
}
.condaily_routeplan{
	width:100%;
	text-align:left;
	height:350px;
	border-collapse:collapse;
	background:#a09e9e;
	margin-left:auto;
	margin-right:auto;
	border-radius:10px;
	overflow:scroll;
	overflow-x:hidden;
}
#errormsgkdvehstockled {
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
.myalignkdvehstockled {
	padding-top:8px;
	margin:0 auto;
	color:#FF0000;
}

.buttons_new{
	-webkit-box-shadow:rgba(0,0,0,0.2) 0 1px 0 0;
	-moz-box-shadow:rgba(0,0,0,0.2) 0 1px 0 0;
	box-shadow:rgba(0,0,0,0.2) 0 1px 0 0;
	border-bottom-color:#333;
	border:1px solid #686868;
	background-color:#31859C;
	border-radius:5px;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	color:#000;
	font-family:Calibri;
	font-size:12px;
	padding:3px;
	cursor:pointer;
	width:160px;
	height:15px;
}
.buttons_gray {
	-webkit-box-shadow:rgba(0,0,0,0.2) 0 1px 0 0;
	-moz-box-shadow:rgba(0,0,0,0.2) 0 1px 0 0;
	box-shadow:rgba(0,0,0,0.2) 0 1px 0 0;
	border-bottom-color:#333;
	border:1px solid #686868;
	background-color:#A09E9E;
	border-radius:5px;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	color:#000;
	font-family:Calibri;
	font-size:12px;
	padding:3px;
	cursor:pointer;
	width:240px;
	height:15px;
}

.align2 {
	padding-left:10px;
}

#span1 {
	width: 30px; 
	float:left;
  }
#span2 { 
    width: 30px; 
	float:right;
	}
	
#colors{
	background-color:#CCC;
}
  
</style>
<body <?php if($dsrcode != '') { ?> onLoad="getDSRRoutes('<?php echo $dsrcode; ?>')" <?php } ?> >
<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="heading_report">KD VEHICLE STOCK LEDGER</div>
<div id="mytableform_report" align="center">
<div class="mcf"></div>
<!-- <form method="post" action="" id="routemasterplan"> -->
<table width="100%">
 <tr>
     	<td align="center" nowrap="nowrap" >
		<span id="kdspan">
			<select class="dsrname" name="kdcode" id="kdcode" onChange="getKDvehiclestockledger();"> <!-- multiple -->
				<option value="">---KD---</option>
				<?php while($info = mysql_fetch_assoc($res_KD)){?>
				<option value="<?php echo  $info['KD_Code']; ?>" <?php if($kdcode == $info['KD_Code']) { echo "selected"; } ?> > <?php echo  upperstate($info['KD_Name']); ?></option>
				<?php }?> 
			</select>
		</span>&nbsp;&nbsp;&nbsp;&nbsp;
		<div id='loadingmessagediv' style='display:none'>
			  <img src='../images/loading.gif'/><br/><br/><br/>
			</div>
		</td>		
   	 </tr>
</table>
     
<div class="mcf">
	<div class="condaily_routeplan">
	   <span id="ajaxresultpage">
		  <table border="1" width="100%">
			<thead>
			 <tr>
				<th align="center" style="width:40%">Product</th>
				<th align="center" style="width:10%">Date</th>
				<th align="center" style="width:11%" nowrap="nowrap">DSR Name</th>
				<th align="center" style="width:10%">Device Name</th>
				<th align="center" style="width:10%" nowrap="nowrap">Vehicle Name</th>
				<th align="center" style="width:10%">UOM</th>
				<th align="center" style="width:10%">Loaded Quantity</th>
				<th align="center" style="width:10%">Sold Quantity</th>
				<th align="center" style="width:10%">Return Quantity</th>
				<th align="center" style="width:10%">Stock</th>
		  </tr>
		  </thead>
	     <tbody>
         <tr>
			 <td colspan="10" align="center"><strong>NO RECORDS FOUND</strong></td>
			 <!-- <td style="width:40%">&nbsp;</td>
			 <td>&nbsp;</td>	
			 <td>&nbsp;</td>
			 <td>&nbsp;</td>	
			 <td>&nbsp;</td>
			 <td>&nbsp;</td>	
			 <td>&nbsp;</td> -->
		 </tr>
         </tbody>
		</table>	
		</span>
		</div>
</div>
<div class="mcf"></div>
	 <table width="50%" style="clear:both">
		 <tr align="center" height="10px;">
			 <!-- <td ><input type="button" name="submit" id="submit" class="buttons" value="Save" onClick="return routemonthpl();"/>&nbsp;&nbsp;&nbsp;&nbsp;
			 				 <input type="reset" name="reset" class="buttons" value="Clear" id="clear" />&nbsp;&nbsp;&nbsp;&nbsp;
			 				 <input type="button" name="cancel" value="Cancel" class="buttons" onClick="window.location='../include/empty.php'"/>&nbsp;&nbsp;&nbsp;&nbsp;
			 				 <input type="button" name="View" value="View" class="buttons" onClick="window.location='routemonthplview.php'"/></td>
			 </td> -->
		 </tr>
	 </table>
<!-- </form> -->
<?php include("../include/error.php"); ?>
<div class="mcf"></div> 
	  <div id="errormsgkdvehstockled" style="display:none;"><h3 align="center" class="myalignkdvehstockled"></h3><button id="closebutton">Close</button></div>
    
     </div>
  </div>
</div>
<?php include('../include/footer.php');	?>