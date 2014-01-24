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
//$KDCodeVal  =$_GET[KD_Code];
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

?>
<div id="totaltable">
<div class="lefttable">
<div class="wrap">
       <h3 align="center">Sale</h3>
     	<table class="head">
       	<thead>
        <tr>
			<td align="center" width="150px"><strong>SKU</strong></td>
            <td align="center"><strong>QTY</strong></td>
            <td align="center"><strong>AVG PRICE</strong></td>
            <td align="center"><strong>VALUE</strong></td>
		</tr>
        </thead>
	</table>
     <div class="inner_table">
        <table> 
      
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
						$p				=	1;
						?>    
                   			
						<tr>
							<td align="left" width="150px" style="font-weight:bold"><?php echo finddbval("('".$row_lincnt['Product_code']."')",'Product_description1','Product_code','product'); ?></td> 
							<td align="right" style="font-weight:bold"><?php echo number_format($row_lincnt['Sold_quantity']);?></td>
							<td align="right" style="font-weight:bold"><?php echo number_format(trim($row_lincnt['Price']),2);?></td>
							<td align="right" style="font-weight:bold"><?php echo number_format($row_lincnt['Value'],2);?></td>
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
           
		</table>        
   </div>
 </div>
 
 
 
 
 

<div class="wrap">
<table class="head">
<thead>
      <tr>
           <h3 align="center">CANCEL</h3>
            <td align="center" width="150px"><strong>SKU</strong></td>
            <td align="center"><strong>QTY</strong></td>
            <td align="center"><strong>AVG PRICE</strong></td>
            <td align="center"><strong>VALUE</strong></td>
        </tr>
        </thead>
        </table>
      <div class="inner_table">
        <table>	
        <tbody>
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
							<td align="left" width="150px" style="font-weight:bold"><?php echo finddbval("('".$row_lincnt['Product_code']."')",'Product_description1','Product_code','product'); ?></td> 
							<td align="right" style="font-weight:bold"><?php echo number_format($row_lincnt['Sold_quantity']);?></td>
							<td align="right" style="font-weight:bold"><?php echo number_format($row_lincnt['Price'],2);?></td>
							<td align="right" style="font-weight:bold"><?php echo number_format($row_lincnt['Value'],2);?></td>
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
  
  
  

<div class="wrap">
     <table class="head">
    <thead>
        <tr>
           <h3 align="center">RETURN</h3>
            <td align="center" width="150px"><strong>SKU</strong></td>
            <td align="center"><strong>QTY</strong></td>
            <td align="center"><strong>AVG PRICE</strong></td>
            <td align="center"><strong>VALUE</strong></td>
        </tr>
        </thead>
    </table>
      <div class="inner_table">
        <table>
        <tbody>
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
                    <td align="left" width="150px" style="font-weight:bold"><?php echo finddbval("('".$row_lincnt['Product_code']."')",'Product_description1','Product_code','product'); ?></td> 
                    <td align="right" style="font-weight:bold"><?php echo number_format($row_lincnt['Reurn_quantity']); ?></td>
                    <td align="right" style="font-weight:bold"><?php echo number_format($row_lincnt['Price'],2); ?></td>
                    <td align="right" style="font-weight:bold"><?php echo number_format($row_lincnt['Value'],2); ?></td>
                    </tr>
					<?php } // SECOND WHILE LOOP
				} // SECOND IF LOOP 				
				$c++; $cc++; 
			} 	// FIRST WHILE LOOP
		} else {if($r != 0) { ?>
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




<div class="righttable_mod">
<div class="wrap2">
     <table class="head2">
     <thead>
        <tr>
          <h3 align="center">COLLECTION</h3>
            <td align="center"><strong>CUST. CNT</strong></td>
            <td align="center"><strong>SALE</strong></td>
            <td align="center"><strong>COLLECTION</strong></td>
            <td align="center"><strong>BALANCE DUE</strong></td>
        </tr>
        </thead>
    </table>
      <div class="inner_table2">
        <table>
        <tbody>
		<?php
		$sel_lincnt		=	"SELECT * FROM `sale_and_collection` WHERE (Date >= '$fromdate' AND Date <= '$todate' AND KD_Code = '$KDCodeVal' AND DSR_Code = '$DSR_CodeVal')";
		$results_lincnt	=	mysql_query($sel_lincnt);
		$rowcnt_lincnt	=	mysql_num_rows($results_lincnt);				
		if($rowcnt_lincnt > 0) { // SECOND IF LOOP 
			while($row_lincnt	=	mysql_fetch_array($results_lincnt)) {   // SECOND WHILE LOOP
					$datefordsr		=	explode(" ",$row_lincnt['Date']);
			?>     			
				
					<?php $sel_customer		=	"SELECT count(*) AS CUSLIST FROM `transaction_hdr` WHERE (Date = '$datefordsr[0]' AND KD_Code = '$KDCodeVal' AND DSR_Code = '$DSR_CodeVal')";
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
                    <tr>
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
	 
     
     
 <div class="wrap2">
    <table class="head2">
       <thead>
        <tr>
           <h3 align="center">VEHICLE STOCK</h3>
            <td align="center" width="250px"><strong>SKU</strong></td>
            <td align="center" width="50px"><strong>OPENING BALANCE</strong></td>
            <td align="center" width="50px"><strong>SOLD</strong></td>
            <td align="center" width="50px"><strong>CLOSING BALANCE</strong></td>
        </tr>
        </thead>
    </table>

      <div class="inner_table2">
      <table>
      <tbody>		
		<?php
		$sel_lincnt		=	"SELECT * FROM `vehicle_stock` WHERE (Date >= '$fromdate' AND Date <= '$todate' AND KD_Code = '$KDCodeVal' AND Sold_quantity >0 AND DSR_Code = '$DSR_CodeVal') AND (Loaded_quantity != '' OR Sold_quantity != '' OR Return_quantity != '' OR Stock_quantity != '')";
		$results_lincnt	=	mysql_query($sel_lincnt);
		$rowcnt_lincnt	=	mysql_num_rows($results_lincnt);
		$Closing_Stock				=	'';
		$Cal_Closing_Stock			=	0;
		$opn_Stock					=	0;
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
				<td  align="left" width="150px" style="font-weight:bold"><?php echo finddbval("('".$row_lincnt['Product_Code']."')",'Product_description1','Product_code','product');?></td> 
				<td  align="right" style="font-weight:bold"><?php echo number_format($opn_Stock);?></td>
				<td  align="right" style="font-weight:bold"><?php echo number_format($row_lincnt['Sold_quantity']);?></td>
				<td  align="right" style="font-weight:bold"><?php echo number_format($row_lincnt['Stock_quantity']);?></td>				
			</tr>
			<?php 
			$cycstartdate					=	'';
			$previousdate					=	'';
			$opn_Stock						=	0;
			} // SECOND WHILE LOOP
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
   <div style="clear:both">    
 <!-- Right End  -->     
  </div>

</div>
  
  <?php if(!empty($num_rows)) { ?>
	 
	 <div style="padding-left:450px;padding-top:390px;">
	 <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1&nbsp;&nbsp;&nbsp; <a href="javascript:void(0);" onClick="getdashmetrics('<?php echo $KDCodeVal; ?>','<?php echo $DSR_CodeVal; ?>','<?php echo $fromdate; ?>','<?php echo $todate; ?>')">2</a><br/><br/></div>
	 <span ><input type="button" name="kdproduct" value="Print" class="buttons" onclick="print_pages('printdevdashajax');" ></span>&nbsp;&nbsp;&nbsp;<span ><input type="button" value="Close" class="buttons" onclick="window.location='../include/empty.php'"></span></div>
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