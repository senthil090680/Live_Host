<?php
ob_start();
require_once('../include/header.php');
require_once "../include/ps_pagination.php";
require_once "../include/ajax_pagination.php";

//ini_set("display_errors",false);
//echo ini_get("display_errors");
if(isset($_GET['logout'])){
	session_destroy();
	header("Location:../index.php");
}
extract($_REQUEST);
$msg								=	'';
$query_DSR 							=	"select id,DSRName,DSR_Code from dsr";
$res_DSR 							=	mysql_query($query_DSR) or die(mysql_error());

$query_KD 							=	"select id,KD_Name,KD_Code from kd";
$res_KD 							=	mysql_query($query_KD) or die(mysql_error());

$query_Prod 						=	"select id,Product_description1,Product_code from product";
$res_Prod 							=	mysql_query($query_Prod) or die(mysql_error());

$query_brand 						=	"select id,brand from brand";
$res_brand 							=	mysql_query($query_brand) or die(mysql_error());

$query_RSM 							=	"select id,DSRName,DSR_Code from rsm_sp";
$res_RSM 							=	mysql_query($query_RSM) or die(mysql_error());

$query_ASM 							=	"select id,DSRName,DSR_Code from asm_sp";
$res_ASM 							=	mysql_query($query_ASM) or die(mysql_error());

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
	height:210px;
	border-collapse:collapse;
	background:#a09e9e;
	margin-left:auto;
	margin-right:auto;
	border-radius:10px;
	overflow:scroll;
	overflow-x:hidden;
}
#errormsgsalper {
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
.myalignsalper {
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
<div align="center" class="heading_report">KD Sales Performance</div>
<div id="mytableform_report" align="center">
<div class="mcf"></div>
<form method="post" action="" id="routemasterplan">
<table width="100%" style="background-color:#CCC">
 <tr>
     	<td align="left" style="width:4%" class="align2" nowrap="nowrap">
			<span id="kdspan">
				<select class="dsrname" name="kdcode" id="kdcode" multiple onChange="getKDspecific();">
					<option value="">---KD---</option>
					<?php while($info = mysql_fetch_assoc($res_KD)){?>
					<option value="<?php echo  $info['KD_Code']; ?>" <?php if($kdcode == $info['KD_Code']) { echo "selected"; } ?> > <?php echo  upperstate($info['KD_Name']); ?></option>
					<?php }?> 
				</select>
			</span>
		</td>
		
		<td align="left" style="width:4%" class="align2">
			<span id="brandspan">
				<select class="dsrname" name="brandcode" id="brandcode" multiple onChange="getbrandspecific(this.value);">
					<option value="">---Brand---</option>
					<?php while($info = mysql_fetch_assoc($res_brand)){?>
					<option value="<?php echo  $info['id']; ?>" <?php if($brandcode == $info['id']) { echo "selected"; } ?> > <?php echo  upperstate($info['brand']); ?></option>
					<?php } ?> 
				</select>
			</span>
		</td>

	    <td align="left" style="width:10%" nowrap="nowrap">
			<span id="productspan">
				<select class="dsrname" style="width:570px;" name="prodcode" id="prodcode" multiple onChange="getprodspecific(this.value);">
					<option value="">----------------------------------------------Product-----------------------------------------</option>
					<?php while($info = mysql_fetch_assoc($res_Prod)){?>
					<option value="<?php echo  $info['Product_code']; ?>" <?php if($prodcode == $info['Product_code']) { echo "selected"; } ?> > <?php echo  upperstate($info['Product_description1']); ?></option>
					<?php } ?> 		
				</select>
			</span>
		</td>
        
        <td align="left" style="width:4%" nowrap="nowrap" class="align2">
			<span id="rsmspan">
				<select class="dsrname" name="rsmcode" id="rsmcode" multiple onChange="getrsmspecific(this.value);">
					<option value="">---RSM---</option>
					<?php while($info_rsm = mysql_fetch_assoc($res_RSM)) { ?>
					<option value="<?php echo  $info_rsm['id']; ?>" <?php if($rsmcode == $info_rsm['id']) { echo "selected"; } ?> > <?php echo  upperstate($info_rsm['DSRName']); ?></option>
					<?php } ?> 
				</select>
			</span>
		</td>

    	
        <td align="left" nowrap="nowrap" style="width:4%" class="align2">
			<span id="asmspan">
				<select class="dsrname" name="asmcode" id="asmcode" multiple onChange="getasmspecific(this.value);">
					<option value="">---ASM---</option>
					<?php while($info_asm = mysql_fetch_assoc($res_ASM)) { ?>
					<option value="<?php echo  $info_asm['DSR_Code']; ?>" <?php if($asmcode == $info_asm['DSR_Code']) { echo "selected"; } ?> > <?php echo  upperstate($info_asm['DSRName']); ?></option>
					<?php } ?> 
				</select>
			</span>
        </td>         
	  </tr>
</table>
	  
<table style="background-color:#CCC">	  
	   <tr>
        <td align="left" style="width:4%" class="align2">
			<select name="reportby" id="reportby">
				<option value="">---REPORT BY---</option>
				<option value="KD" > KD</option>
				<option value="RSM" > RSM</option>
				<option value="ASM" > ASM</option>
				<option value="Brand/Product" > Brand/Product</option>
			</select>
        </td>
        
        <td class="align">
			<select class="dsrname" name="freqval" id="freqval" onChange="frequencychange(this.value);" >
				<option value="">---Frequency---</option>
				<option value="Daily"> Daily</option>
				<option value="Weekly"> Weekly</option>
				<option value="Monthly"> Monthly</option>
				<option value="Custom"> Custom</option>
			</select>
        </td>
        
       <td class="align2">
			<div id="dailylabel" style="display:none;"> Date: &nbsp;</div>
			<div id="weeklabel" style="display:none;"> Week Start: &nbsp;</div>
			<div id="monthlabel" style="display:none;"> Month: &nbsp;</div>
	   </td>
        <td>
			<div id="dailydate" style="display:none;"><input type="text" name="dailydates" id="dailydates" onChange="changeDateFormat(this.value,'dailydates')" class="datepicker" size="15"></div>
			<div id="weeklydate" style="display:none;"><input type="text" name="weeklydates" id="weeklydates" onChange="changeDateFormat(this.value,'weeklydates')" class="datepicker" size="15"></div>
			<div id="monthlydate" style="display:none;">
				<select name="propmonth" id="propmonth">
					<option value="">--Select--</option>
					<option value="1">January</option>
					<option value="2">February</option>
					<option value="3">March</option>
					<option value="4">April</option>
					<option value="5">May</option>
					<option value="6">June</option>
					<option value="7">July</option>
					<option value="8">August</option>
					<option value="9">September</option>
					<option value="10">October</option>
					<option value="11">November</option>
					<option value="12">December</option>
				</select> &nbsp;&nbsp; 
				<select name="propyear" id="propyear" >
					<option value="">--Select--</option>
					<?php $curyear = date("Y");
					for($i=2010; $i<=$curyear;$i++) { ?>
						<option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
					<?php } ?>
				</select>
			</div>
		</td>	
		<td height="28" align="left" style="width:20%" colspan="2" nowrap="nowrap" class="align">
			<div id="fromdate" style="display:none;">  From Date :   <input type="text" size="9" readonly class="datepicker" onClick="includeweekend();" name="fromdates" id="fromdates" value="" onChange="changeDateFormat(this.value,'fromdates')" />	&nbsp; </div>
        </td>
        
        <td class="align2" nowrap="nowrap">  
		    <div id="todate" style="display:none;"> To Date &nbsp;&nbsp;&nbsp; &nbsp;: <input type="text" size="9" readonly class="datepicker" onClick="repeatrouteweek();" name="todates" id="todates" onChange="changeDateFormat(this.value,'todates')" value="" />  &nbsp; </div>
		</td>
		
		<td class="align2" nowrap="nowrap">  
		    <input type="button" class="buttons" onClick="kdsalesperform();" value="GO" />
		</td>
	  </tr>
	 </table>     
<div class="mcf">
	<div class="condaily_routeplan">
		  <table border="1" width="100%">
			<thead>
			  <tr>
				<th align="center" style="width:10%">KD Name</th>
				<th align="center" style="width:10%">SR Name</th>
				<th align="center" style="width:10%">ASM Name</th>
				<th align="center" style="width:10%">RSM Name</th>
				<th align="center" style="width:10%">Brand</th>
				<th align="center" style="width:10%">Product</th>
				<th align="center" style="width:10%">Target
                <table  width="100%"><tr><td>Units</td><td>Naira</td></tr></table>
                </th>
				<th align="center" style="width:10%">Sales
                 <table width="100%"><tr><td>Units</td><td>Naira</td></tr></table>
                </th>
				<th align="center" style="width:10%">Difference
                 <table  width="100%"><tr><td>Units</td><td>Naira</td></tr></table>
                </th>          
		  </tr>
		  </thead>
	     <tbody>
         <tr>
		 <td>&nbsp;</td>
         <td>&nbsp;</td>	
         <td>&nbsp;</td>
         <td>&nbsp;</td>	
         <td>&nbsp;</td>
         <td>&nbsp;</td>	
         <td>&nbsp;
         <table width="100%"><tr><td>1</td><td>2</td></tr></table>
         </td>	
         <td>&nbsp;
         <table width="100%"><tr><td>2</td><td>3</td></tr></table>
         </td>	
         <td>&nbsp;
         <table  width="100%"><tr><td>2</td><td>2</td></tr></table>
         </td>	
    	 </tbody>
		</table>	
		</div>
</div>
<div class="mcf"></div>
	 <table width="50%" style="clear:both">
		 <tr align="center" height="10px;">
			 <td ><input type="button" name="submit" id="submit" class="buttons" value="Save" onClick="return routemonthpl();"/>&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="reset" name="reset" class="buttons" value="Clear" id="clear" />&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="button" name="cancel" value="Cancel" class="buttons" onClick="window.location='../include/empty.php'"/>&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="button" name="View" value="View" class="buttons" onClick="window.location='routemonthplview.php'"/></td>
			 </td>
		 </tr>
	 </table>
</form>
<?php require_once("../include/error.php"); ?>
<div class="mcf"></div> 
	  <div id="errormsgsalper" style="display:none;"><h3 align="center" class="myalignsalper"></h3><button id="closebutton">Close</button></div>
    
     </div>
  </div>
</div>
<?php require_once('../include/footer.php');?>