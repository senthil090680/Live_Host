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
$query_DSR 							=	"select id,DSRName,DSR_Code from dsr";
$query 								=	mysql_query($query_DSR) or die(mysql_error());
$sql_device   						=	"select id,device_description,device_code from device_master";
$sql   								=	mysql_query($sql_device) or die(mysql_error());
$route_sql							=	"select id,location,route_desc,route from route_master";
$route								=	mysql_query($route_sql) or die(mysql_error());
$vehicle_sql						=	"select id,vehicle_desc,vehicle_code,vehicle_reg_no from vehicle_master";
$vehicle							=	mysql_query($vehicle_sql) or die(mysql_error());
$location_sql						=	"select id,location from location";
$location_res						=	mysql_query($location_sql) or die(mysql_error());
$id									=	isset($_REQUEST['id']);

if(isset($_GET['idvalnum']) && $_GET['idvalnum'] !='') {
	$routemonth	=	trim(date('m'),0);
	$routeyear	=	date('Y');
	$where							=	"WHERE id = '$idvalnum'";
	$qry_showplan					=	"SELECT * FROM `routemonthplan` $where";
	$res_showplan					=	mysql_query($qry_showplan) or die(mysql_error());
	$rowcnt_showplan				=	mysql_num_rows($res_showplan);
	if($rowcnt_showplan > 0) {
		$row_showplan				=	mysql_fetch_array($res_showplan);
		$dsrcode				=	$row_showplan[DSR_Code];
	}
} 





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
#errormsgmonplan {
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
.myalignmonplan {
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
</style>
<body <?php if($dsrcode != '') { ?> onload="getDSRRoutes('<?php echo $dsrcode; ?>')" <?php } ?> >
<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="heading_report">KD Sales Performance</div>
<div id="mytableform_report" align="center">
<form method="post" action="" id="routemasterplan">
<table width="100%" >
<tr>
<td>
<fieldset class="alignment_report">
  <legend><strong>KD Sales Performance</strong></legend>
  <table width="100%" >
 <tr>
	<td colspan="7">	 	  
	  <table>
	    <tr>
		<td align="left" style="width:5%" height="28" nowrap="nowrap">KD*</td>
		<td align="left" style="width:5%" >
		<!-- <select class="dsrname" name="dsrname" id="dsrname" onChange="getAllRoutes(this.value);"> -->
		<select class="dsrname" name="dsrname" id="dsrname" multiple onChange="getDSRRoutes(this.value);">
		  <option value="">---Select---</option>
		<?php while($info = mysql_fetch_assoc($query)){?>
		<option value="<?php echo  $info['DSR_Code']; ?>" <?php if($dsrcode == $info['DSR_Code']) { echo "selected"; } ?> > <?php echo  $info['DSRName'] ?></option>
		<?php }?> 
		</select>
		</td>
		
		<td align="left" style="width:5%" height="28" nowrap="nowrap">BRAND</td>
		<td align="left" style="width:5%" nowrap="nowrap">
		<select class="dsrname" name="dsrname" id="dsrname" multiple onChange="getDSRRoutes(this.value);">
		  <option value="">---Select---</option>
		<?php while($info = mysql_fetch_assoc($query)){?>
		<option value="<?php echo  $info['DSR_Code']; ?>" <?php if($dsrcode == $info['DSR_Code']) { echo "selected"; } ?> > <?php echo  $info['DSRName'] ?></option>
		<?php } ?> 
		</select>
		</td>

		<td align="left" style="width:5%" height="28" nowrap="nowrap" ><span id="copyfromspan">PRODUCT &nbsp;&nbsp;</span></td>
		<td align="left" style="width:20%" nowrap="nowrap" colspan="2"><span id="copyfromselectspan">
		<select class="dsrname" style="width:500px;" name="monthplan" id="monthplan" multiple onChange="getOldOrMasterRoutes(this.value);">
		  <option value="">---Select---</option>
		<option value="1" > Master Plan</option>
		<option value="<?php echo $firmonthnum; ?>" align="center"> <?php echo $firmonth; ?></option>
		<option value="<?php echo $secmonthnum; ?>" align="center"> <?php echo $secmonth; ?></option>
		<option value="<?php echo $thimonthnum; ?>" align="center"> <?php echo $thimonth; ?></option>
		</select> &nbsp;
		</span>
		</td>

		<?php //$curmonth		=	date('F',strtotime("-1 months")); ?>
		<!-- <td height="28" align="left" style="width:20%" colspan="2" nowrap="nowrap" >
			<div id="tobecopied" > &nbsp;Date / Week Start / Month </div>	
		</td> -->
	  </tr>

	  
	  
	  <tr>
		<td align="left" style="width:5%" height="28" nowrap="nowrap">REPORT BY*</td>
		<td align="left" style="width:5%" >
		<!-- <select class="dsrname" name="dsrname" id="dsrname" onChange="getAllRoutes(this.value);"> -->
		<select class="dsrname" name="dsrname" id="dsrname" onChange="getDSRRoutes(this.value);">
		  <option value="">---Select---</option>
		<?php while($info = mysql_fetch_assoc($query)){?>
		<option value="<?php echo  $info['DSR_Code']; ?>" <?php if($dsrcode == $info['DSR_Code']) { echo "selected"; } ?> > <?php echo  $info['DSRName'] ?></option>
		<?php }?> 
		</select>
		</td>
		
		<td align="left" style="width:5%" height="28" nowrap="nowrap">RSM</td>
		<td align="left" style="width:5%" nowrap="nowrap">
		<select class="dsrname" name="dsrname" id="dsrname" multiple onChange="getDSRRoutes(this.value);">
		  <option value="">---Select---</option>
		<?php while($info = mysql_fetch_assoc($query)){?>
		<option value="<?php echo  $info['DSR_Code']; ?>" <?php if($dsrcode == $info['DSR_Code']) { echo "selected"; } ?> > <?php echo  $info['DSRName'] ?></option>
		<?php }?> 
		</select>
		</td>

		<td align="left" style="width:5%" height="28" nowrap="nowrap" ><span id="copyfromspan">ASM &nbsp;&nbsp;</span></td>
		<td align="left" style="width:20%" nowrap="nowrap"><span id="copyfromselectspan">
		<select class="dsrname" name="monthplan" id="monthplan" multiple onChange="getOldOrMasterRoutes(this.value);">
		  <option value="">---Select---</option>
		<option value="1" > Master Plan</option>
		<option value="<?php echo $firmonthnum; ?>" align="center"> <?php echo $firmonth; ?></option>
		<option value="<?php echo $secmonthnum; ?>" align="center"> <?php echo $secmonth; ?></option>
		<option value="<?php echo $thimonthnum; ?>" align="center"> <?php echo $thimonth; ?></option>
		</select> &nbsp; FREQUENCY : <select class="dsrname" name="monthplan" id="monthplan" onChange="getOldOrMasterRoutes(this.value);">
		  <option value="">---Select---</option>
		<option value="1" > Master Plan</option>
		<option value="<?php echo $firmonthnum; ?>" align="center"> <?php echo $firmonth; ?></option>
		<option value="<?php echo $secmonthnum; ?>" align="center"> <?php echo $secmonth; ?></option>
		<option value="<?php echo $thimonthnum; ?>" align="center"> <?php echo $thimonth; ?></option>
		</select>
		</span>
		</td>

		<?php //$curmonth		=	date('F',strtotime("-1 months")); ?>
		<td height="28" align="left" style="width:20%" colspan="2" nowrap="nowrap" >
			<div id="tobecopied" >  From Date :   <input type="text" size="9" readonly class="datepicker" onClick="includeweekend();" name="includesatsun" id="includesatsun" value="" />	&nbsp; </div>
			<div id="alreadycopied" > To Date &nbsp;&nbsp;&nbsp; &nbsp;: <input type="text" size="9" readonly class="datepicker" onClick="repeatrouteweek();" name="repeatroute" id="repeatroute" value="" /> &nbsp; <input type="button" class="buttons" onClick="repeatrouteweek();" name="repeatroute" id="repeatroute" value="GO" /> </div>	
		</td>
	  </tr>
	 </table>
	 </td>
  </tr>
  
  <tr>
	<td colspan="7">
		<div class="condaily_routeplan">
		  <table border="1">
			<thead>
			  <tr>
				<th align="center" style="width:15%" height="28">Seq. No\Day</th>
				<th align="center" style="width:15%">Monday</th>

				<th align="center" style="width:15%">Tuesday</th>

				<th align="center" style="width:15%">Wednesday</th>

				<th align="center" style="width:15%">Thursday</th>

				<th align="center" style="width:15%">Friday</th>

				<th align="center" style="width:15%">Saturday</th>
				<th align="center" style="width:15%">Thursday</th>
				<th align="center" style="width:15%">Thursday</th>
				<th align="center" style="width:15%">Thursday</th>
			  </tr>
		  </thead>
		  <tbody>
			<?php for($k=1; $k<26; $k++) { ?>
			  <tr>
				<td align="center" style="width:15%" height="28"><?php echo $k; ?></td>
				<td align="center" style="width:15%"><span id="mon_<?php echo $k; ?>"> </span></td>
				<td align="center" style="width:15%"><span id="tue_<?php echo $k; ?>"> </span></td>
				<td align="center" style="width:15%"><span id="wed_<?php echo $k; ?>"> </span></td>
				<td align="center" style="width:15%"><span id="thu_<?php echo $k; ?>"> </span></td>
				<td align="center" style="width:15%"><span id="fri_<?php echo $k; ?>"> </span></td>
				<td align="center" style="width:15%"><span id="sat_<?php echo $k; ?>"> </span></td>
				<td align="center" style="width:15%"><span id="thu_<?php echo $k; ?>"> </span></td>
				<td align="center" style="width:15%"><span id="fri_<?php echo $k; ?>"> </span></td>
				<td align="center" style="width:15%"><span id="sat_<?php echo $k; ?>"> </span></td>
			  </tr>
			<?php } ?>
		 </tbody>
		</table>
		</div>
	</td>
</tr>

</table>
</fieldset>
</td>
</tr> 
</table>
	 <table width="50%" style="clear:both">
		 <tr align="center" height="10px;">
			 <td ><input type="button" name="submit" id="submit" class="buttons" value="Save" onClick="return routemonthpl();"/>&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="reset" name="reset" class="buttons" value="Clear" id="clear" />&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/>&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="button" name="View" value="View" class="buttons" onclick="window.location='routemonthplview.php'"/></td>
			 </td>
		 </tr>
	 </table>
</form>
<?php include("../include/error.php"); ?>
<div class="mcf"></div> 
	  <div id="errormsgmonplan" style="display:none;"><h3 align="center" class="myalignmonplan"></h3><button id="closebutton">Close</button></div>
    
     </div>
  </div>
</div>
<?php include('../include/footer.php');?>