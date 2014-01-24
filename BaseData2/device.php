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
.scrollmagic {
    height: 130px;
    overflow-x: hidden;
    overflow-y: scroll;
    width: 100%;
}
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
</style>
<div id="mainareadash">
<div><h2 align="center">Device Dashboard</h2></div>
<div id="cont">
<div class="headerdev_chgd">   
    <table width="100%">
      <tr>
        <td class="align">KD Code</td>
        <td><select  name="kd_id" id="kd_id" autocomplete="off" autofocus>
            <option value="">--- Select ---</option>
			<?php $sel_kd		=	"SELECT id,KD_Name from kd GROUP BY KD_Name";
			$res_kd			=	mysql_query($sel_kd) or die(mysql_error());	
			while($row_kd	= mysql_fetch_array($res_kd)){ ?>
			<option value="<?php echo $row_kd[id]; ?>" <?php if($kd_id == $row_kd[id]) { echo "selected"; } ?> ><?php echo ucwords(strtolower($row_kd[KD_Name])); ?></option>
			<?php } ?><option value="">ALL</option>
          </select>
        </td>
        <td>DSR Code</td>
        <td><select name="dsr_id" id="dsr_id" class="required">
            <option value="">--- Select ---</option>
			<?php $DSR_Main_Qry	=	"select id,DSR_Code,DSRName FROM dsr";
			$DSR_qry		=	mysql_query($DSR_Main_Qry);
			while($res_DSR = mysql_fetch_array($DSR_qry)){ ?>
			<option value="<?php echo $res_DSR['id']?>" <?php if($res_DSR['DSR_Code']==$fetch['id']){?>selected <?php } ?>><?php echo $res_DSR['DSRName'];?></option>
			<?php } ?>
		</select>&nbsp;&nbsp;
		
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
<div id="tablestr">
<div class="mis">
 <div class="lefttable">
<div class="tl1 scrollmagic"> 
  <div class="con3">
       <h3 align="center">Sale</h3>
     	<table width="100%">
       	<thead>
        <tr>
	    <th>SKU</th>
        <th>UOM</th>
        <th>QTY</th>
        <th>Average Price</th>
        <th>Value</th>
		</tr>
		</tr>
		</thead>
		<?php
		$qry="SELECT * FROM `device_data_view` order by SKU_sale asc"; 
        $result=mysql_query($qry);
		$c=0;$cc=1;
		while($row = mysql_fetch_array($result)) {
		if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }
		?>
      
		<tbody>
		<tr>
   		<td><?php echo $row['SKU_sale'];?></td> 
       	<td><?php echo $row['UOM_Sale'];?></td>
       	<td><?php echo $row['sale_qty'];?></td>
        <td><?php echo $row['sale_price'];?></td>
        <td><?php echo $row['sale_value'];?></td>
  		</tr>
		<?php $c++; $cc++; }	 
		?>
		</tbody>
 		</table>
        
   </div>
 </div>
<div class="tl2 scrollmagic">  
   <div class="con3">
       <h3 align="center">Cancel</h3>
		<table width="100%">
       	<thead>
		<tr>
	    <th>SKU</th>
        <th>UOM</th>
        <th>QTY</th>
        <th>Average Price</th>
        <th>Value</th>
		</tr>
		</tr>
		</thead>
		<?php
		$qry="SELECT * FROM `device_data_view`"; 
        $result=mysql_query($qry);
		$c=0;$cc=1;
		while($row = mysql_fetch_array($result)) {
		if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }
		?>
		<tbody>
		<tr>
		<td><?php echo $row['SKU_sale'];?></td> 
       	<td><?php echo $row['UOM_Sale'];?></td>
       	<td><?php echo $row['sale_qty'];?></td>
        <td><?php echo $row['sale_price'];?></td>
        <td><?php echo $row['sale_value'];?></td>
  		</tr>
		<?php $c++; $cc++; }		 
		?>
		</tbody>
		</table>
  </div>
  </div> 
<div class="tl2">  
   <div class="con3">
       <h3 align="center">Returns</h3>
		<table width="100%">
       	<thead>
		<tr>
	    <th>SKU</th>
        <th>UOM</th>
        <th>QTY</th>
        <th>Average Price</th>
        <th>Value</th>
		</tr>
		</tr>
		</thead>
		<?php
		$qry="SELECT * FROM `device_data_view` "; 
        $result=mysql_query($qry);
		$c=0;$cc=1;
		while($row = mysql_fetch_array($result)) {
		if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }
		?>
		<tbody>
		<tr>
		<td><?php echo $row['SKU_sale'];?></td> 
       	<td><?php echo $row['UOM_Sale'];?></td>
       	<td><?php echo $row['sale_qty'];?></td>
        <td><?php echo $row['sale_price'];?></td>
        <td><?php echo $row['sale_value'];?></td>
  		</tr>
		<?php $c++; $cc++; }		 
		?>
		</tbody>
		</table>
  </div>
  </div>     
   </div>
<!-- Left End  -->
<!-- <div class="center"><a href="deviceDashboardPopup.php" rel="facebox" class="link" ><input type="button" name="feedback" value="Feedback" class="buttonsdel"/></a>
</div>
 -->



      <div class="righttable">
 <div class="tabl scrollmagic"> 
  <div class="con3">
       <h3 align="center">Metrics</h3>
		<table width="100%">
       	<thead>
		<tr>
	    <th>Visits</th>
        <th>Invoices</th>
        <th>Products</th>
        <th>Drop Size</th>
        <th>Basket Size</th>
		</tr>
		</tr>
		</thead>
		<?php
		$qry="SELECT * FROM `device_data_view` "; 
        $result=mysql_query($qry);
		$c=0;$cc=1;
		while($row = mysql_fetch_array($result)) {
		if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }
		?>
		<tbody>
		<tr>
		<td><?php echo $row['visits'];?></td> 
       	<td><?php echo $row['invoices'];?></td>
       	<td><?php echo $row['SKU_products'];?></td>
        <td><?php echo $row['sale_price'];?></td>
        <td><?php echo $row['sale_value'];?></td>
  		</tr>
		<?php $c++; $cc++; }		 
		?>
		</tbody>
		</table>
   </div>
 </div>

<div class="tl2 scrollmagic">
   <div class="con3">
       <h3 align="center">Stock</h3>
		<table width="100%">
       	<thead>
		<tr>
	    <th>SKU</th>
        <th>UOM</th>
        <th>QTY</th>
        <th>Average Price</th>
        <th>Value</th>
     	</tr>
		</tr>
		</thead>
		<?php
		$qry="SELECT * FROM `device_data_view`"; 
        $result=mysql_query($qry);
		$c=0;$cc=1;
		while($row = mysql_fetch_array($result)) {
		if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }
		?>
		<tbody>
		<tr>
		<td><?php echo $row['SKU_stock'];?></td> 
       	<td><?php echo $row['UOM_Stock'];?></td>
       	<td><?php echo $row['stock_qty'];?></td>
        <td><?php echo $row['stock_price'];?></td>
        <td><?php echo $row['stock_value'];?></td>
  		</tr>
		<?php $c++; $cc++; }		 
		?>
		</tbody>
		</table>
  </div>
    </div> 

<div class="tl2 scrollmagic">  
   <div class="con3">
       <h3 align="center">Collections</h3>
		<table width="100%">
       	<thead>
		<tr>
	    <th>Customer</th>
        <th>Visits</th>
        <th>Invoice</th>
        <th>Sale</th>
        <th>Collections</th>
		</tr>
		</tr>
		</thead>
		<?php
		$qry="SELECT * FROM `device_data_view`"; 
        $result=mysql_query($qry);
		$c=0;$cc=1;
		while($row = mysql_fetch_array($result)) {
		if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }
		?>
		<tbody>
		<tr>
		<td><?php echo $row['customer_code'];?></td> 
       	<td><?php echo $row['visits'];?></td>
       	<td><?php echo $row['invoices'];?></td>
        <td><?php echo $row['stock_price'];?></td>
        <td><?php echo $row['collections'];?></td>
  		</tr>
		<?php $c++; $cc++; }		 
		?>
		</tbody>
		</table>
  </div>
      </div>
 <!-- Right End  -->     

  </div>
</div>
</div>
</div>
<div class="mcf"></div>
<div style="clear:both;"></div>
<div id="errormsgdev" style="display:none;"><h3 align="center" class="myaligndev"></h3><button id="closebutton">Close</button></div>
</div>
<div id="backgroundChatPopup" ></div>
<?php require_once('../include/footer.php'); ?>