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
//pre($_REQUEST);
if(isset($_REQUEST[KD_Code]) && $_REQUEST[KD_Code] !='') {
	$nextrecval		=	"WHERE (Date >= '$fromdate' AND Date <= '$todate') AND KD_Code = '$KD_Code' AND DSR_Code = '$DSR_Code'";
} else {
	$nextrecval		=	"";
}
$where		=	"$nextrecval";

if(isset($_REQUEST) && $_REQUEST !='')
{
	$qry="SELECT SUM(visit_Count) AS VISCNT,SUM(Invoice_Count) AS INCNT,SUM(effective_Count) AS EFFCNT,SUM(productive_Count) AS PROCNT,SUM(Invoice_Line_Count) AS INLINCNT,SUM(Total_Sale_Value) AS TOTSAL,SUM(Drop_Size_Value) AS DRSZ,SUM(Basket_Size_Value) AS BASZ FROM `dsr_metrics` $where";
}
else
{ 
	echo "Invalid Query";
	exit;
}
$qry_fir		=	$qry;
$qry_sec		=	$qry;
$qry_third		=	$qry;

$res_fir		=	mysql_query($qry_fir);
$res_sec		=	mysql_query($qry_sec);
$res_third		=	mysql_query($qry_third);

$num_fir		=	mysql_num_rows($res_fir);
$num_sec		=	mysql_num_rows($res_sec);
$num_third		=	mysql_num_rows($res_third);

?>

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
       <h3 align="center">DEVICE DASHBOARD - METRICS</h3>
	   <h3><div >&nbsp;&nbsp;&nbsp;&nbsp;FROM : <?php echo $fromdate; ?> &nbsp;&nbsp;&nbsp;&nbsp;TO : <?php echo $todate; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DSR : <?php echo getdbval($DSR_Code,'DSRName','DSR_Code','dsr'); ?> &nbsp;&nbsp;&nbsp;&nbsp; </div></h3>
	   
     	<table width="100%" border="1">
       	<thead>
        <tr>
			<td align="center" width="150px"><strong>Productivity Visits</strong></td>
            <td align="center"><strong>Actual Visits</strong></td>
            <td align="center"><strong>Sale Visits</strong></td>
            <td align="center"><strong>Productivity %</strong>
            <table><tr><td align="center">Target</td><td align="center">Actual</td></tr></table>
            </td>
            <td align="center"><strong>Unique Sales</strong></td>
            <td align="center"><strong>Coverage %</strong>
              <table><tr><td align="center">Target</td><td align="center">Actual</td></tr></table>
            </td>
		</tr>
		</tr>
		</thead>
		<tbody>
		<?php
		if(!empty($num_fir)) {   // FIRST IF LOOP
			$c=0;$cc=1;
			while($row_fir = mysql_fetch_array($res_fir)) {  // FIRST WHILE LOOP
				if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }

					//$productive_Count		=	$row_fir[PROCNT];
					//$visit_Count			=	$row_fir[VISCNT];
					//$effective_Count		=	$row_fir[EFFCNT];
					
					$monthyearval			=	explode("-",$fromdate);

					$productive_Count		=	tofindmetviscntformonth($monthyearval[0],$monthyearval[1],$DSR_Code,'productive_count');
					$visit_Count			=	$row_fir[VISCNT];
					$effective_Count		=	tofindmetviscntformonth($monthyearval[0],$monthyearval[1],$DSR_Code,'effective_count');
					
					//echo $fromdate;
					//exit;
					$get_monthyeararr		=	explode("-",$fromdate);
					$monthstr				=	ltrim($get_monthyeararr[1],0);
					$yearstr				=	$get_monthyeararr[0];
					$target_query			=	" WHERE monthval IN ('".$monthstr."') AND yearval IN ('".$yearstr."') AND SR_Code = '$DSR_Code'";

					$sel_tgt_check			=	"SELECT effective_percent,productive_percent FROM coverage_target_setting $target_query";
					//echo $sel_tgt_check;
					//exit;
					$res_tgt_check					=	mysql_query($sel_tgt_check) or die(mysql_error());
					$rowcnt_tgt_check				=	mysql_num_rows($res_tgt_check);
					if($rowcnt_tgt_check > 0){
						$row_tgt_check			=	mysql_fetch_array($res_tgt_check);
						$prod_visit				=	$row_tgt_check['productive_percent'];
						$eff_visit				=	$row_tgt_check['effective_percent'];
					}
					$prod_tgt_act_percent		=	($productive_Count/$prod_visit)*(100);
					$eff_tgt_act_percent		=	($effective_Count/$eff_visit)*(100);
					?>    
					<tr>
						<td align="right" width="150px" style="font-weight:bold"><?php echo $prod_visit; ?></td> 
						<td align="right" style="font-weight:bold"><?php echo $visit_Count;?></td>
						<td align="right" style="font-weight:bold"><?php echo $productive_Count;?></td>
						<td align="right" style="font-weight:bold">
							<table width="100%" >
								<tr>
										<td align='right' style='width:30px;'><?php if($prod_visit != '') { echo number_format($prod_visit); } else { echo '0'; } ?></td>
										<td align='left' style='width:30px;'><?php if($prod_tgt_act_percent != '') { echo number_format($prod_tgt_act_percent); } else { echo '0'; } ?></td>
									</tr>
							</table>
						</td>
						<td align="right" style="font-weight:bold"><?php echo $effective_Count;?></td>
						<td align="right" style="font-weight:bold">
							<table width="100%" >
								<tr>
										<td align='right' style='width:30px;'><?php if($eff_visit != '') { echo number_format($eff_visit); } else { echo '0'; } ?></td>
										<td align='left' style='width:30px;'><?php if($eff_tgt_act_percent != '') { echo number_format($eff_tgt_act_percent); } else { echo '0'; } ?></td>
									</tr>
							</table>
						</td>
					</tr>

				<?php $c++; $cc++; 
			} 	// FIRST WHILE LOOP
		} // FIRST IF LOOP
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
		<table width="100%" border="1">
       	<thead>
		<tr>
			<td align="center" width="150px"><strong>Invoice</strong></td>
            <td align="center"><strong>Lines</strong></td>
            <td align="center"><strong>Sale value</strong></td>
            <td align="center"><strong>Dropsize</strong></td>
            <td align="center"><strong>Basket Size</strong></td>
		</tr>
		</tr>
		</thead>
		<?php
		if(!empty($num_sec)){
			$c=0;$cc=1;
			while($row_sec = mysql_fetch_array($res_sec)) {  // FIRST WHILE LOOP
				if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }

					$Invoice_Count			=	$row_sec[INCNT];
					$Invoice_Line_Count		=	$row_sec[INLINCNT];
					$Total_Sale_Value		=	$row_sec[TOTSAL];


					$Drop_Size_Value		=	round($Total_Sale_Value/$Invoice_Count);
					$Basket_Size_Value		=	round($Total_Sale_Value/$Invoice_Line_Count);
						?>     
            			<tr>
							<td align="right" style="font-weight:bold"><?php echo number_format($Invoice_Count); ?></td>
							<td align="right" style="font-weight:bold"><?php echo number_format($Invoice_Line_Count); ?></td>
							<td align="right" style="font-weight:bold"><?php echo number_format($Total_Sale_Value,2); ?></td>
							<td align="right" style="font-weight:bold"><?php echo number_format($Drop_Size_Value); ?></td>
							<td align="right" style="font-weight:bold"><?php echo number_format($Basket_Size_Value); ?></td>
						</tr>
				<?php $c++; $cc++; 
			} 	// FIRST WHILE LOOP
		} else{ ?>
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
		<table width="100%" border="1">
       	<thead>
		<tr>
			<td align="center" width="150px"><strong>Effective Incentive</strong></td>
            <td align="center"><strong>Brand Incentive</strong></td>
            <td align="center"><strong>Productive Incentive</strong></td>
		</tr>
		</tr>
		</thead>
		<?php
		if(!empty($num_third)){
			$c=0;$cc=1;
			while($row_third = mysql_fetch_array($res_third)) {  // FIRST WHILE LOOP
				if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }
					
					
					$productive_Count		=	$row_third[PROCNT];
					$effective_Count		=	$row_third[EFFCNT];
					
					$get_monthyeararr		=	explode("-",$fromdate);
					$monthstr				=	ltrim($get_monthyeararr[1],0);
					$monthstr_notrim		=	$get_monthyeararr[1];
					$yearstr				=	$get_monthyeararr[0];

					$target_query			=	" WHERE monthval IN ('".$monthstr."') AND yearval IN ('".$yearstr."') AND SR_Code = '$DSR_Code'";

					$target_query_brand		=	" WHERE monthval IN ('".$monthstr."') AND yearval IN ('".$yearstr."') AND DSR_Code = '$DSR_Code'";

					$sel_inctgt_check			=	"SELECT prod_visit,eff_visit,prod_status,eff_status,tgtTypeProd,tgtTypeEff,effective_percent,productive_percent FROM coverage_target_setting $target_query";
					//echo $sel_inctgt_check;
					//exit;
					$res_inctgt_check					=	mysql_query($sel_inctgt_check) or die(mysql_error());
					$rowcnt_inctgt_check				=	mysql_num_rows($res_inctgt_check);
					if($rowcnt_inctgt_check > 0){
						$row_inctgt_check				=	mysql_fetch_array($res_inctgt_check);
						$prod_visit						=	$row_inctgt_check['prod_visit'];
						$eff_visit						=	$row_inctgt_check['eff_visit'];
						$prod_status					=	$row_inctgt_check['prod_status'];
						$eff_status						=	$row_inctgt_check['eff_status'];
						$tgtTypeProd					=	$row_inctgt_check['tgtTypeProd'];
						$tgtTypeEff						=	$row_inctgt_check['tgtTypeEff'];
						$effective_percent				=	$row_inctgt_check['effective_percent'];
						$productive_percent				=	$row_inctgt_check['productive_percent'];
					}
					
					if($tgtTypeProd == '0') {
						if($productive_Count >= $productive_percent) {
							$prod_tgt_inc		=	number_format(($productive_Count/$productive_percent)*($prod_visit),2);
						} else {
							$prod_tgt_inc		=	"0.00";
						}
					} else if($tgtTypeProd == '1') {
						$prod_tgt_inc		=	number_format(($productive_Count*$prod_visit),2);
					}

					if($tgtTypeEff == '0') {
						if($effective_Count >= $effective_percent) {
							$eff_tgt_inc		=	number_format(($effective_Count/$effective_percent)*($eff_visit),2);
						} else {
							$eff_tgt_inc		=	"0.00";
						}
					} else if($tgtTypeEff == '1') {
						$eff_tgt_inc		=	number_format(($effective_Count*$eff_visit),2);
					}
					
					$sel_tgt_brand			=	"SELECT target_units,target_naira,Brand_id FROM srbrand_incentive $target_query_brand";
					//echo $sel_tgt_brand;
					//exit;
					$res_tgt_brand					=	mysql_query($sel_tgt_brand) or die(mysql_error());
					$rowcnt_tgt_brand				=	mysql_num_rows($res_tgt_brand);
					if($rowcnt_tgt_brand > 0){
						while($row_tgt_brand		=	mysql_fetch_array($res_tgt_brand)) {
							$brandid_trans[]			=	$row_tgt_brand["Brand_id"];
							$tgt_brand[]				=	$row_tgt_brand;
						}
					}

					//pre($tgt_brand);

					$tot_tgt_brand_units				=	multi_array_sum($tgt_brand,'target_units');
					$tot_tgt_brand_naira				=	multi_array_sum($tgt_brand,'target_naira');

					$brandid_trans						=	array_unique($brandid_trans);
					$brandid_total						=	implode("','",$brandid_trans);

					$qry_prodcode						=	"SELECT Product_code FROM `product` WHERE brand IN ('".$brandid_total."') ";
					$res_prodcode						=	mysql_query($qry_prodcode) or die(mysql_error());
					$rowcnt_prodcode					=	mysql_num_rows($res_prodcode);
					if($rowcnt_prodcode > 0){
						while($row_prodcode				=	mysql_fetch_array($res_prodcode)) {
							$prodcode_trans[]			=	$row_prodcode["Product_code"];
						}
					}
				
					$prodcode_trans						=	array_unique($prodcode_trans);
					$prodcode_total						=	implode("','",$prodcode_trans);
		
					$prod_tgt_act_percent				=	($productive_Count/$prod_visit)*(100);
					$eff_tgt_act_percent				=	($effective_Count/$eff_visit)*(100);

					$query_transhdr													=   "SELECT id,Transaction_Number,Date,Time,transaction_Reference_Number FROM transaction_hdr WHERE Date LIKE '$yearstr-$monthstr_notrim-%' AND DSR_Code = '$DSR_Code'";
					//echo $query_transhdr;
					//exit;
					$res_transhdr													=   mysql_query($query_transhdr);
					$transno_transhdr												=	array();
					while($row_transhdr												=   mysql_fetch_assoc($res_transhdr)) {		
						$Transaction_Number											=	$row_transhdr[Transaction_Number];
						$query_returnline											=   "SELECT id,Transaction_Number FROM transaction_return_line WHERE Transaction_Number = '$Transaction_Number'";
						$res_returnline												=   mysql_query($query_returnline);
						$rowcnt_returnline											=   mysql_num_rows($res_returnline);

						if($rowcnt_returnline == 0) {
							$Transaction_Number_sales							=   $row_transhdr[Transaction_Number];
							if($row_transhdr[transaction_Reference_Number] !='' && $row_transhdr[transaction_Reference_Number] != '0') {
								$transaction_Reference_Number_cancel[]			=   $row_transhdr[transaction_Reference_Number];
								$transno_cancel_number[]						=   $row_transhdr[Transaction_Number];
							}
							$transhdr_result[]									=   $row_transhdr;
							$transhdrInfo[$row_transhdr[Transaction_Number]]	=   $row_transhdr;
							$transno_transhdr[]									=   $row_transhdr[Transaction_Number];
						}
					}
					 
					//pre($transno_transhdr);	
					//pre($transaction_Reference_Number_cancel);
					//pre($transno_cancel_number);

					foreach($transaction_Reference_Number_cancel AS $REFVALE){
						//echo $REFVALE		=	trim($REFVALE);
						//pre($transno_transhdr);
						//echo $arraysearchval		=	array_search($REFVALE,$transno_transhdr);
						//echo $REFVALE."++".pre($transno_transhdr)."<br>";
						if(array_search($REFVALE,$transno_transhdr) !== false) {
							//echo $REFVAL;
							$arraysearchval		=	array_search($REFVALE,$transno_transhdr);
							//echo $arraysearchval;
							unset($transno_transhdr[$arraysearchval]);
						} else {
							//echo $arraysearchval		=	array_search($REFVAL,$transno_transhdr);
							//echo "notin";
						}
					}

					//pre($transno_transhdr);
					//exit;
					//pre($transno_cancel_number);
					foreach($transno_cancel_number AS $REFVALUE){
						if(array_search($REFVALUE,$transno_transhdr) !== false) {
							$arraysearchval		=	array_search($REFVALUE,$transno_transhdr);
							unset($transno_transhdr[$arraysearchval]);
						}
					}

					//pre($transno_transhdr);

					//exit;
					$transno_transhdr		=	array_unique($transno_transhdr);
					$transno_Total			=	implode("','",$transno_transhdr);

					$qry_brand_tgt				=	"SELECT SUM(Sold_quantity) AS SOLQTY FROM `transaction_line` AS tl LEFT JOIN product pd ON tl.Product_code = pd.Product_code LEFT JOIN brand br on pd.brand = br.id WHERE tl.Transaction_Number IN ('".$transno_Total."') AND pd.Product_code IN ('".$prodcode_total."') AND tl.DSR_Code = '$DSR_Code' AND tl.Product_code != '' ";

					$res_brand_tgt					=	mysql_query($qry_brand_tgt) or die(mysql_error());
					$rowcnt_brand_tgt				=	mysql_num_rows($res_brand_tgt);
					if($rowcnt_brand_tgt > 0){
						while($row_brand_tgt		=	mysql_fetch_array($res_brand_tgt)) {
							$BRAND_SOLQTY			=	$row_brand_tgt["SOLQTY"];
						}
					}
					//echo $BRAND_SOLQTY;
					$brand_tgt_inc					=	number_format(($BRAND_SOLQTY) * ($tot_tgt_brand_naira),2);
					?>     			
                    <tr>
						<td align="right" style="font-weight:bold"><?php echo $eff_tgt_inc; ?></td>
						<td align="right" style="font-weight:bold"><?php echo $brand_tgt_inc; ?></td>
						<td align="right" style="font-weight:bold"><?php echo $prod_tgt_inc; ?></td>
                    </tr>
				<?php
				$c++; $cc++; 
			 }  // FIRST WHILE LOOP
		} else { ?>
				<tr>
					<td align='center' colspan='3'><b>No records found</b></td>
					<td style="display:none;" >Cust Name</td>
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
	 <span id="printopen" style="padding-left:580px;padding-top:10px;<?php if($num_fir > 0 || $num_sec > 0 || $num_third > 0) { echo "display:block;"; } else { echo "display:none;"; } ?>" ><input type="button" name="kdproduct" value="Print" class="buttons" onclick="hideprintbutton();"></span>
</div>
</div>
</div>
<?php exit(0); ?>