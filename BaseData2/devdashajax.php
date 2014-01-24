<?php
session_start();
ob_start();
require_once "../include/config.php";
require_once "../include/ps_pagination.php";
require_once "../include/ajax_pagination.php";
if(isset($_GET['logout'])){
	session_destroy();
	header("Location:../index.php");
}
extract($_GET);
$KDCodeVal		=	getKDCode($kd_id,'KD_Code','id');
$DSR_CodeVal	=	getdsrval($dsr_id,'DSR_Code','id');
if(isset($_GET[kd_id]) && $_GET[kd_id] !='') {
	$nextrecval		=	"WHERE (Date >= '$fromdate' AND Date <= '$todate') AND KD_Code = '$KDCodeVal' AND DSR_Code = '$DSR_CodeVal'";
} else {
	$nextrecval		=	"";
}
$where		=	"$nextrecval";

if(isset($_GET) && $_GET !='')
{
	$qry="SELECT * FROM `transaction_hdr` $where";
}
else
{ 
	echo "Invalid Query";
	exit;
}
$results=mysql_query($qry);
$num_rows= mysql_num_rows($results);			
$pager = new PS_Pagination($bd, $qry,15,15);
$results = $pager->paginate(); ?>
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
		<tbody>
		<?php
        $result=mysql_query($qry);
		$num_rows= mysql_num_rows($result);
		$p					=	0;
		if(!empty($num_rows)) {   // FIRST IF LOOP
			$c=0;$cc=1;
			while($row = mysql_fetch_array($result)) {  // FIRST WHILE LOOP
				if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }
					$Transaction_Number		=	$row[Transaction_Number];
					$sel_lincnt		=	"SELECT * FROM `transaction_line` WHERE (Transaction_Number = '$Transaction_Number' AND Transaction_type = '2' AND KD_Code = '$KDCodeVal' AND DSR_Code = '$DSR_CodeVal')";
					$results_lincnt	=	mysql_query($sel_lincnt);
					$rowcnt_lincnt	=	mysql_num_rows($results_lincnt);					
				if($rowcnt_lincnt > 0) { // SECOND IF LOOP 
					while($row_lincnt	=	mysql_fetch_array($results_lincnt)) {   // SECOND WHILE LOOP
						$p					=	1;
						?>     			
						<tr>
							<td><?php echo finddbval("('".$row_lincnt['Product_code']."')",'Product_description1','Product_code','product'); ?></td> 
							<td><?php echo $row_lincnt['UOM'];?></td>
							<td><?php echo $row_lincnt['Sold_quantity'];?></td>
							<td><?php echo $row_lincnt['Price'];?></td>
							<td><?php echo $row_lincnt['Value'];?></td>
						</tr>
					<?php } // SECOND WHILE LOOP
				} // SECOND IF LOOP ?>

				<?php $c++; $cc++; 
			} 	// FIRST WHILE LOOP
		} // FIRST IF LOOP
		else {	if($p != 0) { ?> 
				<tr>
					<td align='center' colspan='5'><b>No records found</b></td>
					<td style="display:none;" >Cust Name</td>
					<td style="display:none;" >Add Line1</td>
					<td style="display:none;" >Add Line1</td>
					<td style="display:none;" >Add Line2</td>
				</tr>
				<?php } 
			} if($p == 0) { ?>
				<tr>
					<td align='center' colspan='5'><b>No records found</b></td>
					<td style="display:none;" >Cust Name</td>
					<td style="display:none;" >Add Line1</td>
					<td style="display:none;" >Add Line1</td>
					<td style="display:none;" >Add Line2</td>
				</tr>
			 <?php } ?>		 
		</tbody>
 		</table>        
   </div>
 </div>
<div class="t11 scrollmagic">  
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
		//$qry="SELECT * FROM `device_data_view` $where"; 
        $result=mysql_query($qry);
		$num_rows= mysql_num_rows($result);
		$q		=	0;
		if(!empty($num_rows)){
			$c=0;$cc=1;
			while($row = mysql_fetch_array($result)) {  // FIRST WHILE LOOP
				if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }
					$Transaction_Number		=	$row[Transaction_Number];
					$sel_lincnt		=	"SELECT * FROM `transaction_line` WHERE (Transaction_Number = '$Transaction_Number' AND Transaction_type = '3' AND KD_Code = '$KDCodeVal' AND DSR_Code = '$DSR_CodeVal')";
					$results_lincnt	=	mysql_query($sel_lincnt);
					$rowcnt_lincnt	=	mysql_num_rows($results_lincnt);					
				if($rowcnt_lincnt > 0) { // SECOND IF LOOP 
					$q		=	1;
					while($row_lincnt	=	mysql_fetch_array($results_lincnt)) {   // SECOND WHILE LOOP
						?>     			
						<tr>
							<td><?php echo finddbval("('".$row_lincnt['Product_code']."')",'Product_description1','Product_code','product'); ?></td> 
							<td><?php echo $row_lincnt['UOM'];?></td>
							<td><?php echo $row_lincnt['Sold_quantity'];?></td>
							<td><?php echo $row_lincnt['Price'];?></td>
							<td><?php echo $row_lincnt['Value'];?></td>
						</tr>
					<?php } // SECOND WHILE LOOP
				} // SECOND IF LOOP ?>

				<?php $c++; $cc++; 
			} 	// FIRST WHILE LOOP
		} else{ if($q != 0) { ?>
			<tr>
				<td align='center' colspan='5'><b>No records found</b></td>
				<td style="display:none;" >Cust Name</td>
				<td style="display:none;" >Add Line1</td>
				<td style="display:none;" >Add Line1</td>
				<td style="display:none;" >Add Line2</td>
			</tr>
			<?php } 
		 } if($q == 0) { ?>
				<tr>
					<td align='center' colspan='5'><b>No records found</b></td>
					<td style="display:none;" >Cust Name</td>
					<td style="display:none;" >Add Line1</td>
					<td style="display:none;" >Add Line1</td>
					<td style="display:none;" >Add Line2</td>
				</tr>
			 <?php } ?>		 		 
		</tbody>
		</table>
  </div>
  </div> 
<div class="t11 scrollmagic">  
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
		//$qry="SELECT * FROM `device_data_view` $where"; 
        $result=mysql_query($qry);
		$num_rows= mysql_num_rows($result);
		$r				=	0;
		if(!empty($num_rows)){
			$c=0;$cc=1;
			while($row = mysql_fetch_array($result)) {  // FIRST WHILE LOOP
				if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }
					$Transaction_Number		=	$row[Transaction_Number];
					//$sel_lincnt		=	"SELECT * FROM `transaction_line` WHERE (Transaction_Number = '$Transaction_Number' AND Transaction_type = '4' AND KD_Code = '$KDCodeVal' AND DSR_Code = '$DSR_CodeVal')";
					$sel_lincnt		=	"SELECT * FROM `transaction_return_line` WHERE (Transaction_Number = '$Transaction_Number' AND KD_Code = '$KDCodeVal' AND DSR_Code = '$DSR_CodeVal')";
					$results_lincnt	=	mysql_query($sel_lincnt);
					$rowcnt_lincnt	=	mysql_num_rows($results_lincnt);
					
				if($rowcnt_lincnt > 0) { // SECOND IF LOOP 
					while($row_lincnt	=	mysql_fetch_array($results_lincnt)) {   // SECOND WHILE LOOP
						$r = 1;
						?>     			
						<tr>
							<td><?php echo finddbval("('".$row_lincnt['Product_code']."')",'Product_description1','Product_code','product'); ?></td> 
							<td><?php echo $row_lincnt['UOM']; ?></td>
							<td><?php echo $row_lincnt['Reurn_quantity']; ?></td>
							<td><?php echo $row_lincnt['Price']; ?></td>
							<td><?php echo $row_lincnt['Value']; ?></td>
						</tr>
					<?php } // SECOND WHILE LOOP
				} // SECOND IF LOOP 				
				$c++; $cc++; 
			} 	// FIRST WHILE LOOP
		} else {  if($r != 0) { ?>
			<tr>
				<td align='center' colspan='5'><b>No records found</b></td>
				<td style="display:none;" >Cust Name</td>
				<td style="display:none;" >Add Line1</td>
				<td style="display:none;" >Add Line1</td>
				<td style="display:none;" >Add Line2</td>
			</tr>
			<?php } 
		   } 
		 if($r == 0) { ?>
				<tr>
					<td align='center' colspan='5'><b>No records found</b></td>
					<td style="display:none;" >Cust Name</td>
					<td style="display:none;" >Add Line1</td>
					<td style="display:none;" >Add Line1</td>
					<td style="display:none;" >Add Line2</td>
				</tr>
			 <?php } ?>		 
		</tbody>
		</table>
  </div>
  </div>     
   </div>
<!-- Left End  -->
<?php $sel_lincnt		=	"SELECT * FROM `feedback` WHERE (Date >= '$fromdate' AND Date <= '$todate' AND KD_Code = '$KDCodeVal' AND DSR_Code = '$DSR_CodeVal')";
$results_lincnt	=	mysql_query($sel_lincnt);
$rowcnt_lincnt	=	mysql_num_rows($results_lincnt); ?>
<?php if($rowcnt_lincnt > 0) { ?><div class="center"><a onclick="deviceDashPopup('<?php echo $fromdate; ?>','<?php echo $todate; ?>','<?php echo $KDCodeVal; ?>','<?php echo $DSR_CodeVal; ?>')" rel="facebox" class="link" ><input type="button" name="feedback" value="Feedback" class="buttonsdel"/></a>
</div>
<?php } ?> 
      <div class="righttable">
 <div class="t11 scrollmagic"> 
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
		$sel_lincnt		=	"SELECT * FROM `dsr_metrics` WHERE (Date >= '$fromdate' AND Date <= '$todate' AND KD_Code = '$KDCodeVal' AND DSR_Code = '$DSR_CodeVal')";
		$results_lincnt	=	mysql_query($sel_lincnt);
		$rowcnt_lincnt	=	mysql_num_rows($results_lincnt);				
		if($rowcnt_lincnt > 0) { // SECOND IF LOOP 
			while($row_lincnt	=	mysql_fetch_array($results_lincnt)) {   // SECOND WHILE LOOP  ?>     			
				<tr>
					<td><?php echo $row_lincnt['visit_Count'];?></td> 
					<td><?php echo $row_lincnt['Invoice_Count'];?></td>
					<td><?php echo $row_lincnt['Invoice_Line_Count'];?></td>
					<td><?php echo $row_lincnt['Drop_Size_Value'];?></td>
					<td><?php echo $row_lincnt['Basket_Size_Value'];?></td>
				</tr>
			<?php } // SECOND WHILE LOOP
		} // SECOND IF LOOP
		else { ?>
			<tr>
				<td align='center' colspan='5'><b>No records found</b></td>
				<td style="display:none;" >Cust Name</td>
				<td style="display:none;" >Add Line1</td>
				<td style="display:none;" >Add Line1</td>
				<td style="display:none;" >Add Line2</td>
			</tr>
		 <?php } ?>		 		 
		</tbody>
		</table>
   </div>
 </div>

<div class="t11 scrollmagic">
   <div class="con3">
       <h3 align="center">Stock</h3>
		<table width="100%">
       	<thead>
		<tr>
			<th>SKU</th>
			<th>UOM</th>
			<th>Loaded Quantity</th>
			<th>Sold Quantity</th>
			<th>Return Quantity</th>
			<th>Stock Quantity</th>
     	</tr>
		</tr>
		</thead>
		<?php
		$sel_lincnt		=	"SELECT * FROM `vehicle_stock` WHERE (Date >= '$fromdate' AND Date <= '$todate' AND KD_Code = '$KDCodeVal' AND DSR_Code = '$DSR_CodeVal')";
		$results_lincnt	=	mysql_query($sel_lincnt);
		$rowcnt_lincnt	=	mysql_num_rows($results_lincnt);				
		if($rowcnt_lincnt > 0) { // SECOND IF LOOP 
			while($row_lincnt	=	mysql_fetch_array($results_lincnt)) {   // SECOND WHILE LOOP  ?>     			
				<tr>
					<td><?php echo finddbval("('".$row_lincnt['Product_Code']."')",'Product_description1','Product_code','product');?></td> 
					<td><?php echo $row_lincnt['UOM'];?></td>
					<td><?php echo $row_lincnt['Loaded_quantity'];?></td>
					<td><?php echo $row_lincnt['Sold_quantity'];?></td>
					<td><?php echo $row_lincnt['Return_quantity'];?></td>
					<td><?php echo $row_lincnt['Stock_quantity'];?></td>
				</tr>
			<?php } // SECOND WHILE LOOP
		} // SECOND IF LOOP
		else { ?>
			<tr>
				<td align='center' colspan='6'><b>No records found</b></td>
				<td style="display:none;" >Cust Name</td>
				<td style="display:none;" >Add Line1</td>
				<td style="display:none;" >Add Line1</td>
				<td style="display:none;" >Add Line2</td>
				<td style="display:none;" >Add Line2</td>
			</tr>
		 <?php } ?>	
		</tbody>
		</table>
  </div>
    </div> 

<div class="t11 scrollmagic">  
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
		$sel_lincnt		=	"SELECT * FROM `sale_and_collection` WHERE (Date >= '$fromdate' AND Date <= '$todate' AND KD_Code = '$KDCodeVal' AND DSR_Code = '$DSR_CodeVal')";
		$results_lincnt	=	mysql_query($sel_lincnt);
		$rowcnt_lincnt	=	mysql_num_rows($results_lincnt);				
		if($rowcnt_lincnt > 0) { // SECOND IF LOOP 
			while($row_lincnt	=	mysql_fetch_array($results_lincnt)) {   // SECOND WHILE LOOP
					$datefordsr		=	$row_lincnt['Date'];
			?>     			
				<tr>
					<?php $sel_customer		=	"SELECT count(*) AS CUSLIST FROM `transaction_hdr` WHERE (Date = '$datefordsr' AND KD_Code = '$KDCodeVal' AND DSR_Code = '$DSR_CodeVal')";
					$results_customer	=	mysql_query($sel_customer);
					$rowcnt_customer	=	mysql_num_rows($results_customer);				
					if($rowcnt_customer > 0) {
						$row_customer	=	mysql_fetch_array($results_customer);
						$CUSCNT			=	$row_customer['CUSLIST'];
					}

					$sel_visinvoice		=	"SELECT * FROM `dsr_metrics` WHERE (Date = '$datefordsr' AND KD_Code = '$KDCodeVal' AND DSR_Code = '$DSR_CodeVal')";
					$results_visinvoice	=	mysql_query($sel_visinvoice);
					$rowcnt_visinvoice	=	mysql_num_rows($results_visinvoice);				
					if($rowcnt_visinvoice > 0) {
						$row_visinvoice	=	mysql_fetch_array($results_visinvoice);
						$visit_Count		=	$row_visinvoice['visit_Count'];
						$Invoice_Count		=	$row_visinvoice['Invoice_Count'];
					} ?>

					<td><?php echo $CUSCNT;?></td> 
					<td><?php echo $visit_Count;?></td>
					<td><?php echo $Invoice_Count;?></td>
					<td><?php echo $row_lincnt['total_sale_value'];?></td>
					<td><?php echo $row_lincnt['total_collection_value'];?></td>
				</tr>
			<?php 
			$CUSCNT					=	0;
			$visit_Count			=	0;
			$Invoice_Count			=	0;
				} // SECOND WHILE LOOP
		} // SECOND IF LOOP
		else { ?>
			<tr>
				<td align='center' colspan='5'><b>No records found</b></td>
				<td style="display:none;" >Cust Name</td>
				<td style="display:none;" >Add Line1</td>
				<td style="display:none;" >Add Line1</td>
				<td style="display:none;" >Add Line2</td>
			</tr>
		 <?php } ?>	 
		</tbody>
		</table>
	  
  </div>
	  </div>	 
	 
 <!-- Right End  -->     
  </div>
  <?php if(!empty($num_rows)) { ?>
	 <div style="padding-left:450px;padding-top:440px;"><span ><input type="button" name="kdproduct" value="Print" class="buttons" onclick="print_pages('printdevdashajax');" ></span>&nbsp;&nbsp;&nbsp;<span ><input type="button" value="Close" class="buttons" onclick="window.location='../include/empty.php'"></span></div>
	<form id="printdevdashajax" target="_blank" action="printdevdashajax.php" method="post">
		<input type="hidden" name="fromdate" id="fromdate" value="<?php echo $fromdate; ?>" />
		<input type="hidden" name="todate" id="todate" value="<?php echo $todate; ?>" />
		<input type="hidden" name="kd_id" id="kd_id" value="<?php echo $kd_id; ?>" />
		<input type="hidden" name="dsr_id" id="dsr_id" value="<?php echo $dsr_id; ?>" />
		<input type="hidden" name="sortorder" id="sortorder" value="<?php echo $sortorder; ?>" />
		<input type="hidden" name="ordercol" id="ordercol" value="<?php echo $ordercol; ?>" />
		<input type="hidden" name="page" id="page" value="<?php echo $_REQUEST[page]; ?>" />
	</form>
	<?php } ?>
</div>
<?php exit(0); ?>