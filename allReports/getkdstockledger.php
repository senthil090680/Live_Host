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
<table border="1" width="100%">
	<thead>
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
  <span id="printopen" style="padding-left:470px;padding-top:10px;<?php if($num_rows > 0 ) { echo "display:block;"; } else { echo "display:none;"; } ?>" ><input type="button" name="kdproduct" value="Print" class="buttons" onclick="print_pages('printkdstockled');"></span>
<form id="printkdstockled" target="_blank" action="printkdstockled.php" method="post">
	<input type="hidden" name="kdcode" id="kdcode" value="<?php echo $kdcode; ?>" />
</form>  
  <?php 
} else { ?>
 <tr>
	<td colspan="7" align="center"><strong>NO RECORDS FOUND</strong></td>
 </tr>
<?php } exit(0); ?>