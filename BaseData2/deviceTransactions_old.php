<?php
session_start();
ob_start();
include('../include/header.php');
include "../include/ps_pagination.php";
if(isset($_GET['logout'])){
session_destroy();
header("Location:../index.php");
}
?>
<!------------------------------- Form -------------------------------------------------->
<div id="mainarea">
<div class="mcf"></div>
<div><h2 align="center">Device Transactions</h2></div>
<div id="containerBD">
      <table width="100%"  border="1">
  <tr>
    <td>KD Code</td>
	<td>
	<select  name="kd_id" id="kd_id"   autocomplete="off"  autofocus>
	<option value="">--- Select ---</option>
		<option value=""></option>

	</select>
	</td>
    <td>DSR Code</td>
	<td>
	<select  name="dsr_id" id="dsr_id"  autocomplete="off"  >
	<option value="">--- Select ---</option>
	</select>
	</td>
  </tr>
  <tr>
    <td>FROM</td>
	<td><input type="text" name="fromdate" class="datepicker" value="" maxlength="10" autocomplete="off"></td>
    <td>SalesRepresentative Code</td>
	<td><input type="text" name="Salesperson_id" value="" maxlength="10" autocomplete="off" ></td>

  </tr>
  <tr>
    <td>TO</td>
	<td><input type="text" name="todate" value="" maxlength="10" autocomplete="off" class="datepicker"></td>
    <td>Device ID</td>
	<td ><input type="text" name="KDCode" value="" maxlength="10" autocomplete="off"></td>
  </tr>
</table>

<div style="width:100%">
<div style="float:left;width:41%" class="con3">
<!-- 1st table -->
<table width="100%">
<tr><td>
<!-- 2nd table -->
		<table width="100%">
  		<thead>
		<tr>
		<th align="left">Date</th>
   		<th>Time</th>
   		<th>Customer</th>
		<th>Transaction Type</th>
		<th>Transaction No</th>
		</tr>
		</thead>
		<tbody>
		<?php
		if($_GET['device_id']!='')
		{
	    $qry="SELECT *  FROM `devicetransactions` where  device_id LIKE '%".$_GET['device_id']."%'  order by id asc";
		}
		else
		{ 
		$qry="SELECT *  FROM `devicetransactions` order by id asc";
		}
		$results=mysql_query($qry);
		$num_rows= mysql_num_rows($results);			
		$pager = new PS_Pagination($bd, $qry,15,15);
		$results = $pager->paginate();
		if(!empty($num_rows)){
		$c=0;$cc=1;
		while($fetch = mysql_fetch_array($results)) {
		if($c % 2 == 0){ $cls =""; } else{ $cls ="class='odd'"; }
		?>		
		<tr>
		<td><?php echo $fetch['date'];?></td>
		<td><?php echo $fetch['time'];?></td>
		<td><?php echo $fetch['customer'];?></td>
		<td><?php echo $fetch['transactiontype'];?></td>
		<td><?php echo $fetch['transactionno'];?></td>
        </tr>
		<?php $c++; $cc++; }		 
		}else{  echo "<tr><td align='center' colspan='13'><b>No records found</b></td></tr>";}  ?>
		</tbody>
		</table>
<!-- 2nd table -->
</td>
<td>
<div style="float:right;" class="con3">
<!-- 3rd table -->
<table width="100%">
  		<thead>
		<tr>
		<th align="left">Reference No</th>
		<th align="left">Product Item</th>
   		<th>POSM</th>
   		<th>Currency</th>
		<th>Sale Value</th>
		<th>Collection Value</th>
		<th>Balance Due</th>
		<th>Customer Image</th>
		<th>Customer Signature</th>
		<th>Feedback</th>
		</tr>
		</thead>
		<tbody>
		<?php
		if($_GET['device_id']!='')
		{
	    $qry="SELECT *  FROM `devicetransactions` where  device_id LIKE '%".$_GET['device_id']."%'  order by id asc";
		}
		else
		{ 
		$qry="SELECT *  FROM `devicetransactions` order by id asc";
		}
		$results=mysql_query($qry);
		$num_rows= mysql_num_rows($results);			
		$pager = new PS_Pagination($bd, $qry,15,15);
		$results = $pager->paginate();
		if(!empty($num_rows)){
		$c=0;$cc=1;
		while($fetch = mysql_fetch_array($results)) {
		if($c % 2 == 0){ $cls =""; } else{ $cls ="class='odd'"; }
		?>		
		<tr>
		<td><?php echo $fetch['date'];?></td>
		<td><?php echo $fetch['date'];?></td>
		<td><?php echo $fetch['time'];?></td>
		<td><?php echo $fetch['customer'];?></td>
		<td><?php echo $fetch['transactiontype'];?></td>
		<td><?php echo $fetch['transactionno'];?></td>
		<td><?php echo $fetch['transactiontype'];?></td>
		<td><?php echo $fetch['transactionno'];?></td>
		<td><?php echo $fetch['transactiontype'];?></td>
		<td><?php echo $fetch['transactionno'];?></td>
        </tr>
		<?php $c++; $cc++; }		 
		}else{  echo "<tr><td align='center' colspan='13'><b>No records found</b></td></tr>";}  ?>
		</tbody>
		</table>
<!-- 3rd table -->
</div>
</td>
</tr>
</table>

		</div>
		<!--Pagination  -->
 
		<?php 
		if($num_rows > 10){?>     
        <div class="paginationfile" align="center">
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
		</div>   
		<?php } else{ echo "&nbsp;"; }?>

</div>

</div>
<?php include('../include/footer.php'); ?>