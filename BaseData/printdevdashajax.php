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
extract($_REQUEST);
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

<title>DEVICE DASHBOARD</title>
<script type="text/javascript" src="../js/jquery1.js"></script>
<script type="text/javascript" src="../js/jquery2.js"></script>
<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
<script type="text/javascript" src="../js/validator.js"></script>

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
    height: auto;
    /*overflow-x: hidden;
    overflow-y: scroll;*/
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

.con3 {
	width:100%;
	text-align:left;
	border-collapse:collapse;
	background:#a09e9e;
	margin-left:auto;
	margin-right:auto;
	border-radius:10px;
}
.con3 th {
	padding:2px 5px 0 5px;
	font-weight:bold;
	font-size:14px;
	color:#000;
}
.con3 td {
	padding:2px 5px 0 5px;
	background:#fff;
	border-collapse:collapse;
	padding-left:10px;
	color:#000;
	font-size:14px;
}
.con3 tbody tr:hover td {
	background: #c1c1c1;
}
</style>

<div id="cont">
<div id="tablestr">
<div class="mis">
 <div class="lefttable">
<div class="tl1 scrollmagic"> 
  <div class="con3">
       <h3 align="center">DEVICE DASHBOARD</h3>
	   <h3><div >&nbsp;&nbsp;&nbsp;&nbsp;FROM : <?php echo $fromdate; ?> &nbsp;&nbsp;&nbsp;&nbsp;TO : <?php echo $todate; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DSR : <?php echo getdbval($DSR_CodeVal,'DSRName','DSR_Code','dsr'); ?> &nbsp;&nbsp;&nbsp;&nbsp; </div></h3>
	   <h3 align="left">Sale</h3>
     	<table width="100%" border="1">
       	<thead>
        <tr>
			<th style="width:50%">SKU</th>
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
							<td align="left"><?php echo finddbval("('".$row_lincnt['Product_code']."')",'Product_description1','Product_code','product'); ?></td> 
							<td align="right"><?php echo number_format($row_lincnt['Sold_quantity']);?></td>
							<td align="right"><?php echo number_format($row_lincnt['Price'],2);?></td>
							<td align="right"><?php echo number_format($row_lincnt['Value'],2);?></td>
						</tr>
					<?php } // SECOND WHILE LOOP
				} // SECOND IF LOOP ?>

				<?php $c++; $cc++; 
			} 	// FIRST WHILE LOOP
		} // FIRST IF LOOP
		else {	if($p != 0) { ?> 
				<tr>
					<td align='center' colspan='4'><b>No records found</b></td>
					<td style="display:none;" >Cust Name</td>
					<td style="display:none;" >Add Line1</td>
					<td style="display:none;" >Add Line1</td>
					<td style="display:none;" >Add Line2</td>
				</tr>
				<?php } 
			} if($p == 0) { ?>
				<tr>
					<td align='center' colspan='4'><b>No records found</b></td>
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
       <h3 align="left">Cancel</h3>
		<table width="100%" border="1">
       	<thead>
		<tr>
			<th style="width:50%">SKU</th>
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
							<td align="left"><?php echo finddbval("('".$row_lincnt['Product_code']."')",'Product_description1','Product_code','product'); ?></td> 
							<td align="right"><?php echo $row_lincnt['Sold_quantity'];?></td>
							<td align="right"><?php echo $row_lincnt['Price'];?></td>
							<td align="right"><?php echo $row_lincnt['Value'];?></td>
						</tr>
					<?php } // SECOND WHILE LOOP
				} // SECOND IF LOOP ?>

				<?php $c++; $cc++; 
			} 	// FIRST WHILE LOOP
		} else{ if($q != 0) { ?>
			<tr>
				<td align='center' colspan='4'><b>No records found</b></td>
				<td style="display:none;" >Cust Name</td>
				<td style="display:none;" >Add Line1</td>
				<td style="display:none;" >Add Line1</td>
				<td style="display:none;" >Add Line2</td>
			</tr>
			<?php } 
		 } if($q == 0) { ?>
				<tr>
					<td align='center' colspan='4'><b>No records found</b></td>
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
       <h3 align="left">Returns</h3>
		<table width="100%" border="1">
       	<thead>
		<tr>
			<th style="width:50%">SKU</th>
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
							<td align="left"><?php echo finddbval("('".$row_lincnt['Product_code']."')",'Product_description1','Product_code','product'); ?></td> 
							<td align="right"><?php echo number_format($row_lincnt['Reurn_quantity']); ?></td>
							<td align="right"><?php echo number_format($row_lincnt['Price'],2); ?></td>
							<td align="right"><?php echo number_format($row_lincnt['Value'],2); ?></td>
						</tr>
					<?php } // SECOND WHILE LOOP
				} // SECOND IF LOOP 				
				$c++; $cc++; 
			} 	// FIRST WHILE LOOP
		} else {  if($r != 0) { ?>
			<tr>
				<td align='center' colspan='4'><b>No records found</b></td>
				<td style="display:none;" >Cust Name</td>
				<td style="display:none;" >Add Line1</td>
				<td style="display:none;" >Add Line1</td>
				<td style="display:none;" >Add Line2</td>
			</tr>
			<?php } 
		   } 
		 if($r == 0) { ?>
				<tr>
					<td align='center' colspan='4'><b>No records found</b></td>
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

<div class="righttable">
 <!-- <div class="t11 scrollmagic"> 
  <div class="con3">
       <h3 align="center">Metrics</h3>
 		<table width="100%" border="1">
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
 				<td align='center' colspan='4'><b>No records found</b></td>
 				<td style="display:none;" >Cust Name</td>
 				<td style="display:none;" >Add Line1</td>
 				<td style="display:none;" >Add Line1</td>
 				<td style="display:none;" >Add Line2</td>
 			</tr>
 		 <?php } ?>		 		 
 		</tbody>
 		</table>
   </div>
 </div> -->

<div class="t11 scrollmagic">
   <div class="con3">
       <h3 align="left">Stock</h3>
		<table width="100%" border="1">
       	<thead>
		<tr>
			<th style="width:50%">SKU</th>
			<th>Opening Balance</th>
			<th>Sold Quantity</th>
			<th>Closing Balance</th>
     	</tr>
		</tr>
		</thead>
		<?php
		$sel_lincnt		=	"SELECT * FROM `vehicle_stock` WHERE (Date >= '$fromdate' AND Date <= '$todate' AND KD_Code = '$KDCodeVal' AND DSR_Code = '$DSR_CodeVal') AND (Loaded_quantity != '' OR Sold_quantity != '' OR Return_quantity != '' OR Stock_quantity != '')";
		$results_lincnt	=	mysql_query($sel_lincnt);
		$rowcnt_lincnt	=	mysql_num_rows($results_lincnt);				
		if($rowcnt_lincnt > 0) { // SECOND IF LOOP 
			while($row_lincnt	=	mysql_fetch_array($results_lincnt)) {   // SECOND WHILE LOOP  
				$KD_Code				=	$row_lincnt['KD_Code'];
				$vehicle_code			=	$row_lincnt['Vehicle_Code'];
				$Device_Code			=	$row_lincnt['Device_Code'];
				$Date					=	$row_lincnt['Date'];
				$DSR_Code				=	$row_lincnt['DSR_Code'];
				$Product_code			=	$row_lincnt['Product_Code'];
				$Loaded_quantity		=	$row_lincnt['Loaded_quantity'];
				$Sold_quantity			=	$row_lincnt['Sold_quantity'];
				$Return_quantity		=	$row_lincnt['Return_quantity'];
				$Stock_quantity			=	$row_lincnt['Stock_quantity'];
				$Cycle_Start_Flag		=	$row_lincnt['Cycle_Start_Flag'];
				$UOM					=	$row_lincnt['UOM'];

				if($Cycle_Start_Flag == 0) {
					$DSR_Code_val					=	getdsrval($DSR_Code,'id','DSR_Code');
					$query_cycstartdate				=	"SELECT cycle_start_date from cycle_flag WHERE (cycle_start_flag = '1' AND cycle_end_flag = '0') AND dsr_id = '$DSR_Code_val'";
					$res_cycstartdate				=	mysql_query($query_cycstartdate) or die(mysql_error());	
					$row_cycstartdate				=	mysql_fetch_array($res_cycstartdate);
					$cycstartdatearr				=	explode(" ",$row_cycstartdate[cycle_start_date]);
					$cycstartdate					=	$cycstartdatearr[0];

					$previousdate					=	date("Y-m-d", strtotime($DateVal . "- 1 day"));
					//$previousdate					=	date("Y-m-d", strtotime($DateVal . "yesterday"));

					//$previousdate					=	date('Y-m-d', strtotime($DateVal . " - 1 day"));

					$sel_openingstk					=	"SELECT * FROM vehicle_stock WHERE (Date BETWEEN '$cycstartdate' AND '$previousdate') AND DSR_Code = '$DSR_Code' AND Product_Code = '$Product_code' ORDER BY id ASC";
					$res_openingstk					=	mysql_query($sel_openingstk) or die(mysql_error());
					$rowcnt_openingstk				=	mysql_num_rows($res_openingstk);
					if($rowcnt_openingstk > 0){
						while($row_openingstk		=	mysql_fetch_array($res_openingstk)){
							$Loaded_qty				=	$row_openingstk['Loaded_quantity'];
							$Sold_qty				=	$row_openingstk['Sold_quantity'];
							$Return_qty				=	$row_openingstk['Return_quantity'];
							$Stock_qty				=	$row_openingstk['Stock_quantity'];

							if($opn_Stock == '') {
								$opn_Stock	=	0;
							}
							$Cal_Closing_Stock		=	intval($opn_Stock + $Loaded_qty) - intval($Sold_qty) +  intval($Return_qty);
							$opn_Stock				=	$Cal_Closing_Stock;
							//echo $Cal_Closing_Stock."<br/>";
							//echo $opn_Stock."<br/>";	
							$Cal_Closing_Stock		=	0;
						}
					}
				}
			?>     			
				<tr>
					<td align="left"><?php echo finddbval("('".$row_lincnt['Product_Code']."')",'Product_description1','Product_code','product');?></td> 
					<td  align="right" style="font-weight:bold"><?php echo number_format($opn_Stock);?></td>
					<td  align="right" style="font-weight:bold"><?php echo number_format($row_lincnt['Sold_quantity']);?></td>
					<td  align="right" style="font-weight:bold"><?php echo number_format($row_lincnt['Stock_quantity']);?></td>				
				</tr>
			<?php } // SECOND WHILE LOOP
		} // SECOND IF LOOP
		else { ?>
			<tr>
				<td align='center' colspan='4'><b>No records found</b></td>
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
       <h3 align="left">Collections</h3>
		<table width="100%" border="1">
       	<thead>
		<tr>
			<th>Customer</th>
			<!-- <th>Visits</th>
			<th>Invoice</th> -->
			<th>Sale</th>
			<th>Collections</th>
			<th>Balance Due</td>
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

					/*$sel_visinvoice		=	"SELECT * FROM `dsr_metrics` WHERE (Date = '$datefordsr' AND KD_Code = '$KDCodeVal' AND DSR_Code = '$DSR_CodeVal')";
					$results_visinvoice	=	mysql_query($sel_visinvoice);
					$rowcnt_visinvoice	=	mysql_num_rows($results_visinvoice);				
					if($rowcnt_visinvoice > 0) {
						$row_visinvoice	=	mysql_fetch_array($results_visinvoice);
						$visit_Count		=	$row_visinvoice['visit_Count'];
						$Invoice_Count		=	$row_visinvoice['Invoice_Count'];
					} */
					
					
					$BALDUE					=	$row_lincnt['total_sale_value'] - $row_lincnt['total_collection_value'];
					?>

					<td align="right" style="font-weight:bold"><?php echo $CUSCNT; ?></td> 
					<!--<td  align="center" style="font-weight:bold"><?php echo $visit_Count;?></td>
					<td  align="center" style="font-weight:bold"><?php echo $Invoice_Count;?></td>-->
					<td align="right" style="font-weight:bold"><?php echo number_format($row_lincnt['total_sale_value'],2);?></td>
					<td align="right" style="font-weight:bold"><?php echo number_format($row_lincnt['total_collection_value'],2);?></td>
					<td align="right" style="font-weight:bold"><?php echo number_format($BALDUE,2);?></td>

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
	  
	  <div class="t11 scrollmagic">  
   <div class="con3">
       <h3 align="left">FEEDBACK</h3>
		<table width="100%" border="1">
       	<thead>
		<tr>
			<th align="center">Feedback Category</th>
			<th align="center">Date</th>
			<th align="center">Feedback</th>
		</tr>
		</thead>
		<?php $sel_lincnt		=	"SELECT * FROM `feedback` WHERE (Date >= '$fromdate' AND Date <= '$todate' AND KD_Code = '$KDCodeVal' AND DSR_Code = '$DSR_CodeVal')";
		$results_lincnt	=	mysql_query($sel_lincnt);
		$rowcnt_lincnt	=	mysql_num_rows($results_lincnt); ?>		
		<tbody>
	<?php
	if(!empty($rowcnt_lincnt)){
	$c=0;$cc=1;$totalval=0;
	while($fetch = mysql_fetch_array($results_lincnt)) {
	if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }
	$devtransactionid			=		$fetch['id'];
	$DateVal					=		$fetch['Date'];
	$Feedback_type				=		$fetch['Feedback_type'];
	$Feedback					=		$fetch['Feedback'];
	?>
	<tr>
		<td align="left"><?php $sel_feedtype	=	"SELECT * FROM `feedback_type` WHERE id = '$Feedback_type'";
$results_feedtype	=	mysql_query($sel_feedtype);
$rowcnt_feedtype	=	mysql_num_rows($results_feedtype);
	if($rowcnt_feedtype > 0) { 
		$row_feedtype	=	mysql_fetch_array($results_feedtype);
		echo $row_feedtype[feedback_type]; 
	} ?></td>
		<td align="center"><?php echo $DateVal;?></td>
		<td align="left"><?php echo $Feedback;?></td>
	</tr>
	<?php $c++; $cc++; }		 
	}else{ ?>	
		<tr>
			<td align='center' colspan='3'><b>No records found</b></td>
			<td style="display:none;" >Cust Name</td>
			<td style="display:none;" >Add Line1</td>
		</tr>
	<?php } ?>
	</tbody>
		</table>
	  
  </div>
	  </div>	
	 
 <!-- Right End  -->     
  </div>
	 <span id="printopen" style="padding-left:580px;padding-top:10px;<?php if($num_rows > 0 ) { echo "display:block;"; } else { echo "display:none;"; } ?>" ><input type="button" name="kdproduct" value="Print" class="buttons" onclick="hideprintbutton();"></span>
</div>
</div>
</div>
<?php exit(0); ?>