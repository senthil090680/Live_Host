<?php
session_start();
ob_start();
require_once "../include/config.php";
require_once "../include/ajax_pagination.php";
//require_once "../include/ps_pagination.php";
if(isset($_GET['logout'])){
	session_destroy();
	header("Location:../index.php");
}
extract($_REQUEST);
//debugerr($_REQUEST);
//exit;
$params		=	$kdcode;
$where		=	"";
$complete_query		=	'';
$target_query		=	'';
if(isset($_REQUEST[kdcode]) && $_REQUEST[kdcode] !='') {
	
	if($kdcode	==	'') {
		$complete_query		=	'';
		$target_query		=	'';
	} elseif($kdcode	!=	'') {
		if(is_array($kdcode)) {			
			$kdcodestr			=	implode("','",$kdcode);
		} else {
			$kdcodestr			=	$kdcode;
		}
		$complete_query		=	" WHERE KD_Code IN ('".$kdcodestr."')";
		$target_query		.=	" WHERE KD_Code IN ('".$kdcodestr."')";
	}

	$finalSearchInfo					=	'';
	
	$query_kdstock									=   "SELECT id,KD_Code,Product_code,Product_description,UOM1,TransactionType,TransactionNo,TransactionQty,BalanceQty,DATE,StockDateTime,UpdatedDateTime,AddedFirstTime FROM opening_stock_update $complete_query";
	//echo $query_kdstock;
	//exit;
	$res_kdstock											=   mysql_query($query_kdstock);
	while($row_kdstock										=   mysql_fetch_assoc($res_kdstock)) {		
		$kdstockInfo[]										=	$row_kdstock;
		$kdcode_trans[]										=	$row_kdstock["KD_Code"];

		$transType											=	$row_kdstock["TransactionType"];
		$prodcode_trans[]											=	$row_kdstock["Product_code"];
		if($transType	==	'Receipts') {
			$transno_trans[$row_kdstock["TransactionNo"]]	=	$row_kdstock["TransactionNo"];
		}
	}
	 
	$kdcode_trans									=	array_unique($kdcode_trans);
	$kdcode_Total									=	implode("','",$kdcode_trans);

	$prodcode_trans									=	array_unique($prodcode_trans);
	$prodcode_Total									=	implode("','",$prodcode_trans);

	$transno_trans									=	array_unique($transno_trans);
	$transno_Total									=	implode("','",$transno_trans);

	//pre($kdstockInfo);
	//exit;

	$finalSearchInfo								=	$kdstockInfo;
	//pre($finalSearchInfo);
	//exit;

	$query_kd										=   "SELECT KD_Name,KD_Code FROM kd WHERE KD_Code IN ('".$kdcode_Total."')";
	$res_kd											=   mysql_query($query_kd);
	while($row_kd									=   mysql_fetch_assoc($res_kd)) {
		$kdInfo[$row_kd["KD_Code"]]					=	$row_kd;
	}

	//pre($kdInfo);
	//exit;
	 
	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_kd){
		//$transInfo[$val_transno["Transaction_Number"]]["Transaction_Number"];
		if($kdInfo[$val_kd["KD_Code"]]["KD_Code"] == $val_kd[KD_Code]) {                                     
			$finalkdInfo[$i]["KD_Name"]							=   $kdInfo[$val_kd["KD_Code"]]["KD_Name"];
			$finalkdInfo[$i]["KD_Code"]							=   $val_kd["KD_Code"];
			$finalkdInfo[$i]["Product_code"]					=   $val_kd["Product_code"];
			$finalkdInfo[$i]["Product_description"]				=   $val_kd["Product_description"];
			$finalkdInfo[$i]["UOM1"]							=   $val_kd["UOM1"];
			$finalkdInfo[$i]["TransactionType"]					=   $val_kd["TransactionType"];
			$finalkdInfo[$i]["TransactionNo"]					=   $val_kd["TransactionNo"];
			$finalkdInfo[$i]["TransactionQty"]					=   $val_kd["TransactionQty"];
			$finalkdInfo[$i]["BalanceQty"]						=   $val_kd["BalanceQty"];
			$finalkdInfo[$i]["DateVal"]							=   $val_kd["DATE"];
			$finalkdInfo[$i]["transid"]							=   $val_kd["id"];
			$i++;
		}
		$k++;
	}

	$finalSearchInfo          =   $finalkdInfo;
	//pre($finalSearchInfo);
	//exit;

	$query_prodcodemax										=   "SELECT MAX(id) AS pids,Product_code FROM `opening_stock_update` WHERE Product_code IN ('".$prodcode_Total."') GROUP BY Product_code";
	//echo $query_prodcodemax;
	//exit;
	$res_prodcodemax										=   mysql_query($query_prodcodemax);
	while($row_prodcodemax									=   mysql_fetch_assoc($res_prodcodemax)) {		
		$prodcodemaxInfo[$row_prodcodemax[pids]]			=	$row_prodcodemax;
	}
	 
	//pre($prodcodemaxInfo);
	//exit;
	
	$i=0;
	foreach($finalSearchInfo as $val_maxid){		
		if($prodcodemaxInfo[$val_maxid["transid"]]["pids"] == $val_maxid[transid]) {   
			//echo $prodcodemaxInfo[$val_maxid["transid"]]["pids"]. "--".$val_maxid[transid]."<br>";
			$finalSearchInfo[$i]["TransactionType"]					=   "Closing Stock";
		}
		$i++;
	}

	//pre($finalSearchInfo);
	//exit;


	$query_tno											=	"SELECT supplier_category,supplier_name,Transaction_number FROM stock_receipts WHERE Transaction_number IN ('".$transno_Total."')";
	//echo $query_tno;
	//exit;
	$res_tno											=   mysql_query($query_tno) or die(mysql_error());
	while($row_tno										=   mysql_fetch_assoc($res_tno)) {
		$transnoInfo[$row_tno["Transaction_number"]]	=	$row_tno;
	}

	//pre($transnoInfo);
	//exit;
	 
	$i=0;
	foreach($finalSearchInfo as $val_tno){
		//echo $transnoInfo[$val_tno["TransactionNo"]]["Transaction_number"] . "--" .$val_tno[TransactionNo]."<br>";
		if($transnoInfo[$val_tno["Transaction_number"]]["Transaction_number"] == $val_tno[Transaction_number]) {                                     
			$finalSearchInfo[$i]["supplier_category"]					=   $transnoInfo[$val_tno["TransactionNo"]]["supplier_category"];
			$finalSearchInfo[$i]["supplier_name"]						=   $transnoInfo[$val_tno["TransactionNo"]]["supplier_name"];			
		}
		$i++;
	}

	//pre($finalSearchInfo);
	//exit;


	$orderbycolumns     =   "Product_description";
	$orderbysorting     =   'ASC';

	if($orderbysorting == 'DESC') {
		$dir        =   'arsort';               
	} else {
		$dir        =   'asort';   
	}
	$finalSearchInfo	=	subval_sort($finalSearchInfo,$orderbycolumns,$dir);
	//pre($finalSearchInfo);
	//exit;

} else {
	$nextrecval			=	"";
}
$num_rows		=	count($finalSearchInfo);
?>
<title>KD STOCK LEDGER</title>
<script type="text/javascript" src="../js/jquery1.js"></script>
<script type="text/javascript" src="../js/jquery2.js"></script>
<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
<script type="text/javascript" src="../js/validator.js"></script>

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
	height:auto;
	border-collapse:collapse;
	background:#a09e9e;
	margin-left:auto;
	margin-right:auto;
	border-radius:10px;
	overflow:auto;
	overflow-x:hidden;
}
#errormsgkdstockled {
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
.myalignkdstockled {
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

.align2 {
	padding-left:10px;
}

#span1 {
	width: 30px; 
	float:left;
  }
#span2 { 
    width: 30px; 
	float:right;
	}
	
#colors{
	background-color:#CCC;
}
  
</style>

<table border="1" width="100%" style="border-collapse:collapse">
	<thead>
	  <tr>
			<th align="center" colspan="10">KD STOCK LEDGER</th>
	  </tr>
	  <tr>
			<th align="left" colspan="19"><?php echo "KD : &nbsp;&nbsp;";

			echo upperstate(getdbval($kdcode,'KD_Name','KD_Code','kd'));

			//exit;
			/*if(is_array_empty($srcode)){
				echo getdbval($srcode,'DSRName','DSR_Code','dsr');
			} else{
				echo "ALL";
			}*/
			?></th>		
		</tr>
	  <tr>
		<th align="center" style="width:40%">Product</th>
		<th align="center" style="width:10%">Date</th>
		<th align="center" style="width:11%" nowrap="nowrap">Transaction</th>
		<th align="center" style="width:10%">Tran Number</th>
		<th align="center" style="width:10%" nowrap="nowrap">Party</th>
		<th align="center" style="width:10%">Quantity</th>
		<th align="center" style="width:10%">Balance</th>
  </tr>
  </thead>
 <tbody>
         
  <?php	$k						=	0;
		$arrcnt					=	count($finalSearchInfo);
		$subtotalcheckfor		=	1;

if($arrcnt > 0) {
 foreach($finalSearchInfo AS $SearchKey=>$SearchVal) { 
	 $TransactionType	=	$SearchVal[TransactionType];
	?>
		 <tr>			 
			<td style="width:40%"><?php echo $SearchVal[Product_description]; ?></td>
			 <td><?php echo $SearchVal[DateVal]; ?></td>	
			 <td><?php 
			if($TransactionType		==	'OpeningStock') {
				$TransactionTypeVal	=	"Opening Stock";
			} else {
				$TransactionTypeVal	=	$TransactionType;
			}	
			echo $TransactionTypeVal; ?></td>
			 <td><?php echo $SearchVal[TransactionNo]; ?></td>	
			 <td><?php
			 if($TransactionType		==	'Receipts') {
				$PartyVal		=	$SearchVal[supplier_name];
				if($PartyVal == 'Fareast') {
					$PartyVal	=	'FMCL';
				}
			} else {
				$PartyVal		=	"Nil";
			}				 
			echo $PartyVal; ?></td>
			 <td><?php echo $SearchVal[TransactionQty]; ?></td>	
			 <td><?php echo $SearchVal[BalanceQty]; ?></td>
		 </tr>
<?php } ?>
   </tbody>	
  </table>
  <span id="printopen" style="padding-left:580px;padding-top:10px;<?php if($num_rows > 0 ) { echo "display:block;"; } else { echo "display:none;"; } ?>" ><input type="button" name="kdproduct" value="Print" class="buttons" onclick="hideprintbutton();"></span>
<?php } else { ?>
 <tr>
	<td colspan="7" align="center"><strong>NO RECORDS FOUND</strong></td>
 </tr>
<?php } exit(0); ?>