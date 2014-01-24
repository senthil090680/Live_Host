<?php
session_start();
ob_start();
require_once ('../include/header.php');
require_once "../include/ps_pagination.php";
if(isset($_GET['logout'])){
	session_destroy();
	header("Location:../index.php");
}

error_reporting(0);
?>
<link type="text/css" rel="stylesheet" href="../css/popup.css" />
<style type="text/css">
#tablestr_dev {
	width:100%;
	margin-left:auto;
	margin-right:auto;
}

.con3_dev{
	width:100%;
	text-align:left;
	border-collapse:collapse;
	background:#a09e9e;
	margin-left:auto;
	margin-right:auto;
	border-radius:10px;
	overflow:scroll;
	overflow-y:hidden;
}
.con3_dev th {
	width:22%;
	padding:2px 5px 0 5px;
	font-weight:bold;
	font-size:13px;
	color:#000;
}
.con3_dev td  {
	padding:2px 3px 0 3px;
	background:#fff;
	border-collapse:collapse;
	color: #000;
	font-size:13px;
}
.con3_dev tbody tr:hover td {
	background: #c1c1c1;
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
	width:50px;
	height:25px;
}
.headerdevice {
	margin-left:auto;
	margin-right:auto;
	width:80%;
	height:150px;
	padding:30px 0px 10px 0px;
	border-radius:10px;
	background:#C1C1C1;
}
.statictabledev {
	width:100%;
	float:left;
	padding-top:10px;
}
.conitems {
	width:100%;
	text-align:left;
	border-collapse:collapse;
	background:#a09e9e;
	margin-left:auto;
	margin-right:auto;
	border-radius:10px;
}
.conitems th {
	width:22%;
	/*padding:2px 5px 0 5px;*/
	font-weight:bold;
	font-size:13px;
	color:#000;
}
.conitems td {
	/*padding:2px 5px 0 5px;*/
	background:#fff;
	border-collapse:collapse;
	color: #000;
	font-size:13px;
}
.conitems tbody tr:hover td {
	background: #c1c1c1;
}

.confirmFirstDeviceTrans {
	top:150px;
	left:180px;
	width:74%;
	height:500px;
	background:#EEEEEE;
	position:fixed;
	margin:0 auto;
	display:none;
	border-bottom:2px solid #A09E9E;
	z-index:100;
	border-radius:2px 2px 2px 2px;
	color:#fff;
}

.confirmFirstDeviceImage {
	margin:0 auto;
	display:none;
	background:#EEEEEE;
	color:#fff;
	width:400px;
	height:300px;
	position:fixed;
	left:750px;
	top:250px;
	border-bottom:2px solid #A09E9E;
	z-index:3;
	border-radius:2px 2px 2px 2px;
}
.confirmFirstDeviceSig {
	margin:0 auto;
	display:none;
	background:#EEEEEE;
	color:#fff;
	width:400px;
	height:300px;
	position:fixed;
	left:750px;
	top:250px;
	border-bottom:2px solid #A09E9E;
	z-index:3;
	border-radius:2px 2px 2px 2px;
}
.confirmFirstDeviceFeed {
	margin:0 auto;
	display:none;
	background:#EEEEEE;
	color:#fff;
	width:400px;
	height:75px;
	position:fixed;
	left:750px;
	top:250px;
	border-bottom:2px solid #A09E9E;
	z-index:3;
	border-radius:2px 2px 2px 2px;
}
.confirmBatchControl {
	margin:0 auto;
	display:none;
	background:#EEEEEE;
	color:#fff;
	width:400px;
	height:75px;
	position:fixed;
	left:150px;
	top:380px;
	border-bottom:2px solid #A09E9E;
	z-index:4;
	border-radius:2px 2px 2px 2px;
}
.myaligndev {
	padding-top:8px;
	margin:0 auto;
	color:#FF0000;
}

#errormsgdev{
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
</style>

<script type="text/javascript">
function getprint(){
	//alert('Hi');
	var kd_id			=	$('select[name="kd_id"]').val();
	var dsr_id			=	$('select[name="dsr_id"]').val();
	var fromdate		=	$('input[name="fromdate"]').val();
	var todate			=	$('input[name="todate"]').val();
	/*var Salesperson_id	=	$('input[name="Salesperson_id"]').val();
	var KDCode			=	$('select[name="KDCode"]').val();*/

	var fromdate, todate, dt1, dt2, mon1, mon2, yr1, yr2, date1, date2;
	var chkFrom = fromdate;
	var chkTo = todate;
	dt1 = parseInt(fromdate.substring(8, 10), 10);
	mon1 = (parseInt(fromdate.substring(5, 7), 10)) - 1;
	yr1 = parseInt(fromdate.substring(0, 4), 10);

	dt2 = parseInt(todate.substring(8, 10), 10);
	mon2 = (parseInt(todate.substring(5, 7), 10)) - 1;
	yr2 = parseInt(todate.substring(0, 4), 10);
	date1 = new Date(yr1, mon1, dt1);
	date2 = new Date(yr2, mon2, dt2);

	//alert(KDCode);

	if(kd_id == ''){
		$('.myaligndev').html('ERR : Select KD');
		$('#errormsgdev').css('display','block');
		setTimeout(function() {
			$('#errormsgdev').hide();
		},5000);
		return false;
	} else if(dsr_id == ''){
		$('.myaligndev').html('ERR : Select SR Name');
		$('#errormsgdev').css('display','block');
		setTimeout(function() {
			$('#errormsgdev').hide();
		},5000);
		return false;
	}
	
	if(dsr_id != ''){
		var dsr_split		=	dsr_id.split('~');
		var dsr_act_id		=	dsr_split[0];
		var dsr_sales_id	=	dsr_split[1];
		$('#errormsgdev').css('display','none');
		//$('input[name="Salesperson_id"]').val(dsr_sales_id);
	}
	
	if(fromdate == ''){
		$('.myaligndev').html('ERR : Select From Date');
		$('#errormsgdev').css('display','block');
		setTimeout(function() {
			$('#errormsgdev').hide();
		},5000);
		return false;
	} else if(todate == ''){
		$('.myaligndev').html('ERR : Select To Date');
		$('#errormsgdev').css('display','block');
		setTimeout(function() {
			$('#errormsgdev').hide();
		},5000);
		return false;
	}
	
	//alert(date2);
	//alert(date1);

	if (date2 <= date1) {
		//alert("To date Should be greater than From date");
		/*$('#fromerr').html('');
		$('#toerr').html('To date Should be greater than From date');
		$('#toerr').css('color','#FF0000');
		document.getElementById(varTo).value = '';
		document.getElementById(varTo).focus();
		return false;*/
		$('.myaligndev').html('ERR : To date Should be greater than From date!');
		$('#errormsgdev').css('display','block');
		setTimeout(function() {
			$('#errormsgdev').hide();
		},5000);
		return false;
	}
	var currentdate = new Date();

	//alert(date2);
	//alert(currentdate);

	if(date2 <= currentdate)
	{
		//alert('Date greater than Today');
	} else {
		//alert('To Date greater than Today');
		/*$('#fromerr').html('');
		$('#toerr').html('To Date greater than Today');
		$('#toerr').css('color','#FF0000');
		return false;*/
		$('.myaligndev').html('ERR : To Date greater than Today!');
		$('#errormsgdev').css('display','block');
		setTimeout(function() {
			$('#errormsgdev').hide();
		},5000);
		return false;
	}

	/*if(KDCode == ''){
		$('.myaligndev').html('ERR : Select Device');
		$('#errormsgdev').css('display','block');
		setTimeout(function() {
			$('#errormsgdev').hide();
		},5000);
		return false;
	}*/

	$.ajax({
		url : "printdevtransajax.php",
		type: "post",
		dataType: "text",
		//data : { "kd_id" : kd_id,"dsr_id": dsr_act_id,"fromdate" : fromdate,"todate": todate,"Salesperson_id" : dsr_sales_id,"KDCode": KDCode },
		data : { "kd_id" : kd_id,"dsr_id": dsr_act_id,"fromdate" : fromdate,"todate": todate },
		success : function (dataval) {
			var trimval		=	$.trim(dataval);
			var win = window.open();
            win.document.write(dataval);
			//alert(trimval);
	//		$("#dailystockvalidation").attr("target","_blank");
//			$("#dailystockvalidation").attr("action","printdevtransajax.php");
//			$("#dailystockvalidation").submit();
//			$('#backgroundChatPopup').html(trimval);
		}
	});
}
</script>

<div id="mainarea">
<div class="clearfix"></div>
<div><h2 align="center">Device Transactions View & Print</h2></div>
<div class="clearfix"></div>
  <div class="headerdevice">
  <form method="post" action=""  id="dailystockvalidation">
  <table width="100%">
  <tr height="30px">
    <td class="align">KD Name</td>
	<td>
	<select  name="kd_id" id="kd_id" autocomplete="off" autofocus onChange="getalldsrtokd(this.value,'dsr_id','required','DSRSPANID');">
	<option value="">--- Select ---</option>
	<?php $sel_kd		=	"SELECT id,KD_Name,KD_Code from kd GROUP BY KD_Name";
	$res_kd			=	mysql_query($sel_kd) or die(mysql_error());	
	while($row_kd	= mysql_fetch_array($res_kd)){
	$kdcode= $row_kd[KD_Code];
	?>
	<option value="<?php echo $row_kd[id]; ?>" <?php if($kd_id == $row_kd[id]) { echo "selected"; } ?> ><?php echo ucwords(strtolower($row_kd[KD_Name])); ?></option>
	<?php } ?>
	</select>
	</td>
     <td>DSR Name</td>
	 <td><span id="DSRSPANID">
		<select name="dsr_id" id="dsr_id" class="required">
            <option value="">--- Select ---</option>
		</select>
		
		<!--<select name="dsr_id" id="dsr_id" class="required">
            <option value="">--- Select ---</option>
        			<?php $DSR_Main_Qry	=	"select id,DSR_Code,DSRName FROM dsr";
        			$DSR_qry		=	mysql_query($DSR_Main_Qry);
        			while($res_DSR = mysql_fetch_array($DSR_qry)){ ?>
        			<option value="<?php echo $res_DSR['id']?>" <?php if($res_DSR['DSR_Code']==$fetch['id']){?>selected <?php } ?>><?php echo $res_DSR['DSRName'];?></option>
        			<?php } ?>
        		</select> -->
			</span>	
            &nbsp;&nbsp;
	
	<input type="button" value="GO" onclick="javascript:return getprint();" class="buttons_new">
	
	<!--<a href="javascript:void(0);" onclick="javascript:return getdevtrans();"><img src="../images/go2.png" /></a>-->
	
	</td>
  </tr>
  <tr height="30px">
    <td class="align">FROM</td>
	<td><input type="text" name="fromdate" id="fromdate" class="datepicker" onChange="changeDateFormat(this.value,'fromdate')" value="<?php echo date('Y-m-d'); ?>" maxlength="10" autocomplete="off"></td>
  </tr>
  <tr height="30px">
    <td class="align">TO</td>
	<td><input type="text" name="todate" id="todate" onChange="changeDateFormat(this.value,'todate')" value="<?php echo date('Y-m-d'); ?>" maxlength="10" autocomplete="off" class="datepicker"></td>

  </tr>
</table>
</form>
</div>

<!--  Header End  -->

<div id="errormsgdev" style="display:none;"><h3 align="center" class="myaligndev"></h3><button id="closebutton">Close</button></div>
<div class="clearfix"></div>

 <div class="clearfix"></div>
 </div>
</div>
<div id="backgroundChatPopup" ></div>
<?php require_once('../include/footer.php'); ?>