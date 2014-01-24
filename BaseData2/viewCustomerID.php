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
<div><h2 align="center">Customer Master</h2></div>
<div id="containerBD">
        <div class="clearfix"></div>
        <div class="con3">
		<table id="sort" class="tablesorter" align="center">
		<thead>
		<tr>
		<th class="rounded">State<img src="../images/sort.png" width="13" height="13" /></th>
		<th class="rounded">Province</th>
		<th>Location</th>
		<th>GPS</th>
		<th>Category</th>
		<th>Customer Type</th>
		<th>Route</th>
		<th>Sequence Number</th>
        <th>Barcode</th>
		<th>Max Discount</th>
</tr>
		</thead>
		<tbody>
		<?php
		$sel="select * from  customer where customer_code='".$_REQUEST['customer_code']."'"; 
		$results_single=mysql_query($sel);
		$num_rows= mysql_num_rows($results_single);			
		if(!empty($num_rows)){
		$c=0;$cc=1;
		while($fetch = mysql_fetch_array($results_single)) {
		if($c % 2 == 0){ $cls =""; } else{ $cls ="class='odd'"; }
		?>		
		<tr>
		<td><?php echo $fetch['State'];?></td>
		<td><?php echo $fetch['province'];?></td>
		<td><?php echo $fetch['location'];?></td>
		<td><?php echo $fetch['GPS'];?></td>
		<td><?php echo $fetch['category1'];?></td>
		<td><?php echo $fetch['customer_type'];?></td>
		<td><?php echo $fetch['route1'].$fetch['route2'];?></td>
		<td><?php echo $fetch['sequence_number'];?></td>
        <td><?php echo $fetch['Barcode'];?></td>
		<td><?php echo $fetch['Max_Discount'];?></td>
      </tr>
		<?php $c++; $cc++; }		 
		}else{  echo "<tr><td align='center' colspan='13'><b>No records found</b></td></tr>";}  ?>
		</tbody>
		</table>
		</div>
		<div align="center" style="padding:10px 0 0 0"><a href="customerMaster.php"><input type="button" name="Cancel" value="Cancel" class="buttons"></a></div>

	</div>   
        
<!--Messages-->
</div>
<?php include('../include/footer.php'); ?>