<?php 
require_once('../include/header.php'); 
require_once('../include/config.php');
require_once("../include/ps_pagination.php");
if(isset($_GET['logout'])){
	session_destroy();
	header("Location:../index.php");
}
$qry="SELECT * FROM `device_data_view`";
$results=mysql_query($qry);
?>
<link type="text/css" rel="stylesheet" href="../css/popup.css" />
<style type="text/css">

#totaltable{
	width:100%;
	height:400px;
}

.mis {
	width:100%;
	margin-left:5px;
	margin-right:auto;
}
.lefttable {
	width:490px;
	clear:both;
	float:left;
    padding:10px 0px 0px 5px;
		
}
.center {
 width:50px;
 padding-left:30px;
 float:left; 
}
.righttable {
	float:right;
}
.tl1 {
	width:100%;
	height:150px;
	overflow:scroll;
	overflow-x:hidden;
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
/*.scrollmagic {
    height: 130px;
    overflow-x: hidden;
    overflow-y: scroll;
    width: 100%;
}*/
.confirmFirstDeviceFeed {
	margin:0 auto;
	display:none;
	background:#EEEEEE;
	color:#fff;
	width:400px;
	height:200px;
	position:fixed;
	left:500px;
	top:250px;
	border-bottom:2px solid #A09E9E;
	z-index:3;
	border-radius:2px 2px 2px 2px;
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
	padding:2px 5px 0 5px;
	font-weight:bold;
	font-size:13px;
	color:#000;
}
.conitems td {
	padding:2px 5px 0 5px;
	background:#fff;
	border-collapse:collapse;
	color: #000;
	font-size:13px;
}
.conitems tbody tr:hover td {
	background: #c1c1c1;
}
.headerdev_chgd {
	margin-left:auto;
	margin-right:auto;
	width:99%;
	height:80px;
	padding:10px 0px 10px 0px;
	border-radius:10px;
	background:#C1C1C1;
}

.wrap {
    width: 480px;
	padding-left:5px;
}

.wrap table {
    width: 480px;
    table-layout: fixed;
	
}

.wrap table tr td {
  	border-collapse:inherit;
    border: 1px solid #666;
    width: 100px;
	background:#FFF;
    word-wrap: break-word;
}

.wrap table{
	border-collapse:collapse;
}
.wrap  table.head tr td {
    background:#999;
    font-weight:bold;
	font-size:12px;
}

.inner_table {
    height: 100px;
    overflow-y: auto;
}


.wrap2 {
    width: 480px;
	padding-left:5px;
}

.wrap2 table {
    width: 480px;
    table-layout: fixed;
	}
	
.wrap2 table{
	border-collapse:collapse;
}

.wrap2 table tr td {
 
	border-collapse:inherit;
    border: 1px solid #666;
    width: 100px;
	background:#FFF;
    word-wrap: break-word;
}

.wrap2  table.head2 tr td {
    background:#999;
	font-weight:bold;
	font-size:12px;
}

.inner_table2 {
    height: 130px;
    overflow-y: auto;
}
.righttable_mod {
	width:478px;
	height:370px;
	padding:10px 10px 0px 0px;
	margin:0 auto;
	float:right;
}
</style>

<script type="text/javascript">
$(document).ready(function() {
	$('#wait_1').hide();
	$('.drop_1').change(function(){
	  $('#wait_1').show();
	  $('.result_1').hide();
      $.get("func.php", {
		func: "drop_1",
		drop_var: $('#drop_1').val()
      }, function(response){
        $('#result_1').fadeOut();
        setTimeout("finishAjax('result_1', '"+escape(response)+"')", 400);
      });
    	return false;
	});
});

function finishAjax(id, response) {
  $('#wait_1').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}
</script>


<div id="mainareadash">
<div><h2 align="center">Device Dashboard</h2></div>

<div id="cont">
<div class="headerdev_chgd">   
    <table width="100%">
      <tr>
        <td class="align">KD Name</td>
        <td><select  name="kd_id" id="kd_id" autocomplete="off" autofocus onChange="getalldsrtokd(this.value,'dsr_id','required','DSRSPANID');">
            <option value="">--- Select ---</option>
			<?php $sel_kd		=	"SELECT id,KD_Name,KD_Code from kd GROUP BY KD_Name";
			      $res_kd	    =	mysql_query($sel_kd) or die(mysql_error());	
		          while($row_kd	= mysql_fetch_array($res_kd)){ ?>
			<option value="<?php echo $row_kd[id]; ?>"><?php echo ucwords(strtolower($row_kd[KD_Name])); ?></option>
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
		
		<!-- <a href="javascript:void(0);" onclick="javascript:return getdevdash();">GO</a> -->

		<input type="button" value="GO" onclick="javascript:return getdevdash();" class="buttons_new">

        </td>
      </tr>
      <tr>
        <td class="align">FROM</td>
        <td><input type="text" name="fromdate" id="fromdate" onChange="changeDateFormat(this.value,'fromdate')" class="datepicker fromdate" value="<?php echo date('Y-m-d')?>" maxlength="10" autocomplete="off"></td>
        
		<!-- <td>SalesRepresentative Code</td>
		        <td><select name="Salesperson_id" id="Salesperson_id" value="" class="required">
		            <option value="">--- Select ---</option>
			<?php $sales_qry=mysql_query("select Salesperson_id,salesperson_name from sales_representative");?>
			<?php while($res_sales = mysql_fetch_array($sales_qry)){ ?>
			<option value="<?php echo $res_sales['Salesperson_id']; ?>" <?php if($res_sales['Salesperson_id']==$fetch['Salesperson_id']){?>selected <?php } ?> ><?php echo $res_sales['salesperson_name']; ?></option>
			<?php }?>
		</select></td> -->
      </tr>
      <tr>
        <td class="align">TO</td>
        <td><input type="text" name="todate" id="todate" onChange="changeDateFormat(this.value,'todate')" value="<?php echo date('Y-m-d')?>" maxlength="10" autocomplete="off" class="datepicker todate" /></td>
        <!-- <td>Device ID</td>
        <td ><select name="KDCode" id="KDCode" value="" class="required">
            <option value="">--- Select ---</option>
        			<?php $dev_qry=mysql_query("select device_id,device_desc from device_master");
        			while($res_dev = mysql_fetch_array($dev_qry)){ ?>
        			<option value="<?php echo $res_dev['device_id']; ?>" <?php if($res_dev['device_id']==$fetch['device_id']){?>selected <?php } ?> ><?php echo $res_dev['device_desc']; ?></option>
        			<?php }?>
        		</select> -->
      </tr>
    </table>
  </div>
</div>  <!--cont end-->
<div id="tablestr">
<div class="lefttable">
<div class="wrap">
    <table class="head">
        <tr>
          <h3 align="center">SALE</h3>
            <td align="center"><strong>SKU</strong></td>
            <td align="center"><strong>QTY</strong></td>
            <td align="center"><strong>AVG PRICE</strong></td>
            <td align="center"><strong>VALUE</strong></td>
        </tr>
    </table>
    <div class="inner_table">
        <table>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    </div>
</div>

<div class="mcf"></div>
<div class="wrap">
    <table class="head">
        <tr>
           <h3 align="center">CANCEL</h3>
            <td align="center"><strong>SKU</strong></td>
            <td align="center"><strong>QTY</strong></td>
            <td align="center"><strong>AVG PRICE</strong></td>
            <td align="center"><strong>VALUE</strong></td>
        </tr>
    </table>
    <div class="inner_table">
        <table>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    </div>
</div>


<div class="mcf"></div>
<div class="wrap">
    <table class="head">
        <tr>
           <h3 align="center">RETURN</h3>
            <td align="center"><strong>SKU</strong></td>
            <td align="center"><strong>QTY</strong></td>
            <td align="center"><strong>AVG PRICE</strong></td>
            <td align="center"><strong>VALUE</strong></td>
        </tr>
    </table>
    <div class="inner_table">
        <table>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    </div>
  </div>
</div>




<div class="righttable_mod">
<div class="wrap2">
    <table class="head2">
        <tr>
          <h3 align="center">COLLECTION</h3>
            <td align="center"><strong>CUSTOMER</strong></td>
            <td align="center"><strong>SALE</strong></td>
            <td align="center"><strong>COLLECTION</strong></td>
            <td align="center"><strong>BALANCE DUE</strong></td>
        </tr>
    </table>
    <div class="inner_table2">
        <table>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    </div>
</div>
<div class="mcf"></div>
<div class="wrap2">
    <table class="head2">
        <tr>
           <h3 align="center">VEHICLE STOCK</h3>
            <td align="center"><strong>SKU</strong></td>
            <td align="center"><strong>OPENING BALANCE</strong></td>
            <td align="center"><strong>SOLD</strong></td>
            <td align="center"><strong>CLOSING BALANCE</strong></td>
        </tr>
    </table>
    <div class="inner_table2">
        <table>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    </div>
</div>

</div>

</div>  <!--mainareadash-->
</div>

<div style="clear:both;"></div>
<div id="errormsgdev" style="display:none;"><h3 align="center" class="myaligndev"></h3><button id="closebutton">Close</button></div>
</div>
<div id="backgroundChatPopup" ></div>
<?php require_once('../include/footer.php'); ?>