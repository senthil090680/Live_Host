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

ini_set("memory_limit","-1");
//echo ini_get("memory_limit");

//ini_set("display_errors",true);
//error_reporting(E_ALL & ~E_NOTICE);

extract($_REQUEST);
//debugerr($_REQUEST);
//exit;
$params		=	$kdcode;
$where		=	"";
$complete_query		=	'';
$target_query		=	'';
if(isset($_REQUEST[kdcode]) && $_REQUEST[kdcode] !='') {
	
	if($kdcode	==	'') {
		$complete_query		=	'WHERE (Loaded_quantity != "0" OR Stock_quantity != "0" OR Sold_quantity != "0" OR Return_quantity != "0")';
		$target_query		=	'';
	} elseif($kdcode	!=	'') {
		if(is_array($kdcode)) {			
			$kdcodestr			=	implode("','",$kdcode);
		} else {
			$kdcodestr			=	$kdcode;
		}
		$complete_query		=	" WHERE KD_Code IN ('".$kdcodestr."') AND (Loaded_quantity != '0' OR Stock_quantity != '0' OR Sold_quantity != '0' OR Return_quantity != '0')";
		$target_query		.=	" WHERE KD_Code IN ('".$kdcodestr."')";
	}

	$finalSearchInfo					=	'';
	
	$query_kdstock									=   "SELECT id,KD_Code,Product_code,DSR_Code,Device_Code,Vehicle_Code,Date,Cycle_Start_Flag,UOM,Loaded_quantity,Sold_quantity,Return_quantity,Stock_quantity FROM vehicle_stock $complete_query";
	//echo $query_kdstock;
	//exit;
	$res_kdstock											=   mysql_query($query_kdstock);
	while($row_kdstock										=   mysql_fetch_assoc($res_kdstock)) {		
		$kdstockInfo[]										=	$row_kdstock;
		$kdcode_trans[]										=	$row_kdstock["KD_Code"];
		$prodcode_trans[]									=	$row_kdstock["Product_code"];
		$dsrcode_trans[]									=	$row_kdstock["DSR_Code"];
		$devcode_trans[]									=	$row_kdstock["Device_Code"];
		$vehcode_trans[]									=	$row_kdstock["Vehicle_Code"];
	}
	 
	$kdcode_trans									=	array_unique($kdcode_trans);
	$kdcode_Total									=	implode("','",$kdcode_trans);

	$prodcode_trans									=	array_unique($prodcode_trans);
	$prodcode_Total									=	implode("','",$prodcode_trans);

	$dsrcode_trans									=	array_unique($dsrcode_trans);
	$dsrcode_Total									=	implode("','",$dsrcode_trans);

	$devcode_trans									=	array_unique($devcode_trans);
	$devcode_Total									=	implode("','",$devcode_trans);

	$vehcode_trans									=	array_unique($vehcode_trans);
	$vehcode_Total									=	implode("','",$vehcode_trans);

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

			if($val_kd["Loaded_quantity"] != '0' || $val_kd["Sold_quantity"] != '0' || $val_kd["Return_quantity"] != '0' || $val_kd["Stock_quantity"] != '0') {
				$finalkdInfo[$i]["KD_Name"]							=   $kdInfo[$val_kd["KD_Code"]]["KD_Name"];
				$finalkdInfo[$i]["KD_Code"]							=   $val_kd["KD_Code"];
				$finalkdInfo[$i]["Product_code"]					=   $val_kd["Product_code"];
				$finalkdInfo[$i]["UOM"]								=   $val_kd["UOM"];
				$finalkdInfo[$i]["DSR_Code"]						=   $val_kd["DSR_Code"];
				$finalkdInfo[$i]["Device_Code"]						=   $val_kd["Device_Code"];
				$finalkdInfo[$i]["Vehicle_Code"]					=   $val_kd["Vehicle_Code"];
				$finalkdInfo[$i]["Loaded_quantity"]					=   $val_kd["Loaded_quantity"];
				$finalkdInfo[$i]["Sold_quantity"]					=   $val_kd["Sold_quantity"];
				$finalkdInfo[$i]["Return_quantity"]					=   $val_kd["Return_quantity"];
				$finalkdInfo[$i]["Stock_quantity"]					=   $val_kd["Stock_quantity"];
			}
			$finalkdInfo[$i]["DateVal"]							=   $val_kd["Date"];
			$finalkdInfo[$i]["transid"]							=   $val_kd["id"];
			$i++;
		}
		$k++;
	}

	$finalSearchInfo          =   $finalkdInfo;
	//pre($finalSearchInfo);
	//exit;

	
	$query_dsr										=   "SELECT DSRName,DSR_Code FROM dsr WHERE DSR_Code IN ('".$dsrcode_Total."')";
	$res_dsr										=   mysql_query($query_dsr);
	while($row_dsr									=   mysql_fetch_assoc($res_dsr)) {
		$dsrInfo[$row_dsr["DSR_Code"]]				=	$row_dsr;
	}
	
	//pre($dsrInfo);
	//exit;

	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_dsr){
		//echo $dsrInfo[$val_dsr["DSRCode"]]["DSR_Code"] . "-". $val_dsr["DSRCode"]."<br>";
		if($dsrInfo[$val_dsr["DSR_Code"]]["DSR_Code"] == $val_dsr["DSR_Code"]) {                                    
			$finaldsrInfo[$i]["DSR_Name"]							=   $dsrInfo[$val_dsr["DSR_Code"]]["DSRName"];
			$finaldsrInfo[$i]["DSR_Code"]							=   $val_dsr["DSR_Code"];
			$finaldsrInfo[$i]["KD_Name"]							=   $val_dsr["KD_Name"];
			$finaldsrInfo[$i]["KD_Code"]							=   $val_dsr["KD_Code"];
			$finaldsrInfo[$i]["Product_code"]						=   $val_dsr["Product_code"];
			$finaldsrInfo[$i]["Device_Code"]						=   $val_dsr["Device_Code"];
			$finaldsrInfo[$i]["Vehicle_Code"]						=   $val_dsr["Vehicle_Code"];
			$finaldsrInfo[$i]["UOM"]								=   $val_dsr["UOM"];
			$finaldsrInfo[$i]["Loaded_quantity"]					=   $val_dsr["Loaded_quantity"];
			$finaldsrInfo[$i]["Sold_quantity"]						=   $val_dsr["Sold_quantity"];
			$finaldsrInfo[$i]["Return_quantity"]					=   $val_dsr["Return_quantity"];
			$finaldsrInfo[$i]["Stock_quantity"]						=   $val_dsr["Stock_quantity"];
			$finaldsrInfo[$i]["DateVal"]							=   $val_dsr["DateVal"];
			$finaldsrInfo[$i]["transid"]							=   $val_dsr["transid"];
			$i++;
		}
		$k++;
	}

	$finalSearchInfo          =   $finaldsrInfo;

	//$finalSearchInfo	=	array_multi_sort($finalSearchInfo, 'DateVal','Product_Name', $order=SORT_ASC);
	//pre($finalSearchInfo);
	//exit;

	
	$query_prod										=   "SELECT id,Product_description1,Product_code FROM product WHERE Product_code IN ('".$prodcode_Total."')";
	$res_prod										=   mysql_query($query_prod);
	while($row_prod									=   mysql_fetch_assoc($res_prod)) {
		$prodInfo[$row_prod["Product_code"]]		=	$row_prod;
	}
	
	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_prod){
		//$transInfo[$val_transno["Transaction_Number"]]["Transaction_Number"];
		if($prodInfo[$val_prod["Product_code"]]["Product_code"] == $val_prod["Product_code"]) {                                     
			$finalprodInfo[$i]["DSR_Name"]							=   $val_prod["DSR_Name"];
			$finalprodInfo[$i]["DSR_Code"]							=   $val_prod["DSR_Code"];
			$finalprodInfo[$i]["KD_Name"]							=   $val_prod["KD_Name"];
			$finalprodInfo[$i]["KD_Code"]							=   $val_prod["KD_Code"];
			$finalprodInfo[$i]["Product_code"]						=   $val_prod["Product_code"];
			$finalprodInfo[$i]["Product_Name"]						=   $prodInfo[$val_prod["Product_code"]]["Product_description1"];
			$finalprodInfo[$i]["Product_Id"]						=   $prodInfo[$val_prod["Product_code"]]["id"];
			$finalprodInfo[$i]["Device_Code"]						=   $val_prod["Device_Code"];
			$finalprodInfo[$i]["Vehicle_Code"]						=   $val_prod["Vehicle_Code"];
			$finalprodInfo[$i]["UOM"]								=   $val_prod["UOM"];
			$finalprodInfo[$i]["Loaded_quantity"]					=   $val_prod["Loaded_quantity"];
			$finalprodInfo[$i]["Sold_quantity"]						=   $val_prod["Sold_quantity"];
			$finalprodInfo[$i]["Return_quantity"]					=   $val_prod["Return_quantity"];
			$finalprodInfo[$i]["Stock_quantity"]					=   $val_prod["Stock_quantity"];
			$finalprodInfo[$i]["DateVal"]							=   $val_prod["DateVal"];
			$finalprodInfo[$i]["transid"]							=   $val_prod["transid"];
		} else {
			$finalprodInfo[$i]["DSR_Name"]							=   $val_prod["DSR_Name"];
			$finalprodInfo[$i]["DSR_Code"]							=   $val_prod["DSR_Code"];
			$finalprodInfo[$i]["KD_Name"]							=   $val_prod["KD_Name"];
			$finalprodInfo[$i]["KD_Code"]							=   $val_prod["KD_Code"];
			$finalprodInfo[$i]["Product_code"]						=   $val_prod["Product_code"];
			$finalprodInfo[$i]["Device_Code"]						=   $val_prod["Device_Code"];
			$finalprodInfo[$i]["Vehicle_Code"]						=   $val_prod["Vehicle_Code"];
			$finalprodInfo[$i]["UOM"]								=   $val_prod["UOM"];
			$finalprodInfo[$i]["Loaded_quantity"]					=   $val_prod["Loaded_quantity"];
			$finalprodInfo[$i]["Sold_quantity"]						=   $val_prod["Sold_quantity"];
			$finalprodInfo[$i]["Return_quantity"]					=   $val_prod["Return_quantity"];
			$finalprodInfo[$i]["Stock_quantity"]					=   $val_prod["Stock_quantity"];
			$finalprodInfo[$i]["DateVal"]							=   $val_prod["DateVal"];
			$finalprodInfo[$i]["transid"]							=   $val_prod["transid"];
		}
		$i++;
		$k++;
	}

	$finalSearchInfo          =   $finalprodInfo;

	//$finalSearchInfo	=	array_multi_sort($finalSearchInfo, 'DateVal','Product_Name', $order=SORT_ASC);
	//pre($finalSearchInfo);
	//exit;


	$query_prod										=   "SELECT Product_id,Product_description1,Product_code FROM customertype_product WHERE Product_code IN ('".$prodcode_Total."')";
	$res_prod										=   mysql_query($query_prod);
	while($row_prod									=   mysql_fetch_assoc($res_prod)) {
		$prodInfoAnot[$row_prod["Product_code"]]	=	$row_prod;
	}
	
	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_prod){
		//$transInfo[$val_transno["Transaction_Number"]]["Transaction_Number"];
		if($prodInfoAnot[$val_prod["Product_code"]]["Product_code"] == $val_prod["Product_code"]) {                                     
			$finalprodInfo[$i]["DSR_Name"]							=   $val_prod["DSR_Name"];
			$finalprodInfo[$i]["DSR_Code"]							=   $val_prod["DSR_Code"];
			$finalprodInfo[$i]["KD_Name"]							=   $val_prod["KD_Name"];
			$finalprodInfo[$i]["KD_Code"]							=   $val_prod["KD_Code"];
			$finalprodInfo[$i]["Product_code"]						=   $val_prod["Product_code"];
			$finalprodInfo[$i]["Product_Name"]						=   $prodInfoAnot[$val_prod["Product_code"]]["Product_description1"];
			$finalprodInfo[$i]["Product_Id"]						=   $prodInfoAnot[$val_prod["Product_code"]]["Product_id"];
			$finalprodInfo[$i]["Device_Code"]						=   $val_prod["Device_Code"];
			$finalprodInfo[$i]["Vehicle_Code"]						=   $val_prod["Vehicle_Code"];
			$finalprodInfo[$i]["UOM"]								=   $val_prod["UOM"];
			$finalprodInfo[$i]["Loaded_quantity"]					=   $val_prod["Loaded_quantity"];
			$finalprodInfo[$i]["Sold_quantity"]						=   $val_prod["Sold_quantity"];
			$finalprodInfo[$i]["Return_quantity"]					=   $val_prod["Return_quantity"];
			$finalprodInfo[$i]["Stock_quantity"]					=   $val_prod["Stock_quantity"];
			$finalprodInfo[$i]["DateVal"]							=   $val_prod["DateVal"];
			$finalprodInfo[$i]["transid"]							=   $val_prod["transid"];			
		} else {
			$finalprodInfo[$i]["DSR_Name"]							=   $val_prod["DSR_Name"];
			$finalprodInfo[$i]["DSR_Code"]							=   $val_prod["DSR_Code"];
			$finalprodInfo[$i]["KD_Name"]							=   $val_prod["KD_Name"];
			$finalprodInfo[$i]["KD_Code"]							=   $val_prod["KD_Code"];
			$finalprodInfo[$i]["Product_code"]						=   $val_prod["Product_code"];
			$finalprodInfo[$i]["Product_Name"]						=   $val_prod["Product_Name"];
			$finalprodInfo[$i]["Product_Id"]						=   $val_prod["Product_Id"];
			$finalprodInfo[$i]["Device_Code"]						=   $val_prod["Device_Code"];
			$finalprodInfo[$i]["Vehicle_Code"]						=   $val_prod["Vehicle_Code"];
			$finalprodInfo[$i]["UOM"]								=   $val_prod["UOM"];
			$finalprodInfo[$i]["Loaded_quantity"]					=   $val_prod["Loaded_quantity"];
			$finalprodInfo[$i]["Sold_quantity"]						=   $val_prod["Sold_quantity"];
			$finalprodInfo[$i]["Return_quantity"]					=   $val_prod["Return_quantity"];
			$finalprodInfo[$i]["Stock_quantity"]					=   $val_prod["Stock_quantity"];
			$finalprodInfo[$i]["DateVal"]							=   $val_prod["DateVal"];
			$finalprodInfo[$i]["transid"]							=   $val_prod["transid"];			
		}
		$i++;
		$k++;
	}

	$finalSearchInfo          =   $finalprodInfo;
	//pre($finalSearchInfo);
	//exit;


	$query_dev										=   "SELECT id,device_code,device_description FROM device_master WHERE device_code IN ('".$devcode_Total."')";
	//echo $query_dev;
	//exit;
	$res_dev										=   mysql_query($query_dev);
	while($row_dev									=   mysql_fetch_assoc($res_dev)) {
		$devInfo[$row_dev["device_code"]]			=	$row_dev;
	}
	
	//pre($devInfo);
	//exit;

	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_dev){
		//$devInfo[$val_dev["Transaction_Number"]]["Transaction_Number"];
		if($devInfo[$val_dev["Device_Code"]]["device_code"] == $val_dev["Device_Code"]) {                                     
			$finaldevInfo[$i]["DSR_Name"]							=   $val_dev["DSR_Name"];
			$finaldevInfo[$i]["DSR_Code"]							=   $val_dev["DSR_Code"];
			$finaldevInfo[$i]["KD_Name"]							=   $val_dev["KD_Name"];
			$finaldevInfo[$i]["KD_Code"]							=   $val_dev["KD_Code"];
			$finaldevInfo[$i]["Product_code"]						=   $val_dev["Product_code"];
			$finaldevInfo[$i]["Product_Name"]						=   $val_dev["Product_Name"];
			$finaldevInfo[$i]["Product_Id"]							=   $val_dev["Product_Id"];
			$finaldevInfo[$i]["Device_Name"]						=   $devInfo[$val_dev["Device_Code"]]["device_description"];
			$finaldevInfo[$i]["Device_Code"]						=   $val_dev["Device_Code"];
			$finaldevInfo[$i]["Vehicle_Code"]						=   $val_dev["Vehicle_Code"];
			$finaldevInfo[$i]["UOM"]								=   $val_dev["UOM"];
			$finaldevInfo[$i]["Loaded_quantity"]					=   $val_dev["Loaded_quantity"];
			$finaldevInfo[$i]["Sold_quantity"]						=   $val_dev["Sold_quantity"];
			$finaldevInfo[$i]["Return_quantity"]					=   $val_dev["Return_quantity"];
			$finaldevInfo[$i]["Stock_quantity"]						=   $val_dev["Stock_quantity"];
			$finaldevInfo[$i]["DateVal"]							=   $val_dev["DateVal"];
			$finaldevInfo[$i]["transid"]							=   $val_dev["transid"];
			$i++;
		}
		$k++;
	}

	$finalSearchInfo          =   $finaldevInfo;
	//pre($finalSearchInfo);
	//exit;



	$query_veh										=   "SELECT id,vehicle_code,vehicle_desc FROM vehicle_master WHERE vehicle_code IN ('".$vehcode_Total."')";
	//echo $query_veh;
	//exit;
	$res_veh										=   mysql_query($query_veh);
	while($row_veh									=   mysql_fetch_assoc($res_veh)) {
		$vehInfo[$row_veh["vehicle_code"]]			=	$row_veh;
	}
	
	//pre($devInfo);
	//exit;

	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_veh){
		//$devInfo[$val_dev["Transaction_Number"]]["Transaction_Number"];
		if($vehInfo[$val_veh["Vehicle_Code"]]["vehicle_code"] == $val_veh["Vehicle_Code"]) {                                     
			$finalvehInfo[$i]["DSR_Name"]							=   $val_veh["DSR_Name"];
			$finalvehInfo[$i]["DSR_Code"]							=   $val_veh["DSR_Code"];
			$finalvehInfo[$i]["KD_Name"]							=   $val_veh["KD_Name"];
			$finalvehInfo[$i]["KD_Code"]							=   $val_veh["KD_Code"];
			$finalvehInfo[$i]["Product_code"]						=   $val_veh["Product_code"];
			$finalvehInfo[$i]["Product_Name"]						=   $val_veh["Product_Name"];
			$finalvehInfo[$i]["Product_Id"]							=   $val_veh["Product_Id"];
			$finalvehInfo[$i]["Device_Name"]						=   $val_veh["Device_Name"];
			$finalvehInfo[$i]["Device_Code"]						=   $val_veh["Device_Code"];
			$finalvehInfo[$i]["Vehicle_Name"]						=   $vehInfo[$val_veh["Vehicle_Code"]]["vehicle_desc"];
			$finalvehInfo[$i]["Vehicle_Code"]						=   $val_veh["Vehicle_Code"];
			$finalvehInfo[$i]["UOM"]								=   $val_veh["UOM"];
			$finalvehInfo[$i]["Loaded_quantity"]					=   $val_veh["Loaded_quantity"];
			$finalvehInfo[$i]["Sold_quantity"]						=   $val_veh["Sold_quantity"];
			$finalvehInfo[$i]["Return_quantity"]					=   $val_veh["Return_quantity"];
			$finalvehInfo[$i]["Stock_quantity"]						=   $val_veh["Stock_quantity"];
			$finalvehInfo[$i]["DateVal"]							=   $val_veh["DateVal"];
			$finalvehInfo[$i]["transid"]							=   $val_veh["transid"];
			$i++;
		}
		$k++;
	}

	$finalSearchInfo          =   $finalvehInfo;
	//pre($finalSearchInfo);
	//exit;

	//$orderbycolumns     =   "Product_Name";
	$orderbycolumns     =   "DateVal";
	$orderbysorting     =   'DESC';

	if($orderbysorting == 'DESC') {
		$dir        =   'arsort';               
	} else {
		$dir        =   'asort';   
	}
	//$finalSearchInfo	=	subval_sort($finalSearchInfo,$orderbycolumns,$dir);

	//$finalSearchInfo	=	array_multi_sort($finalSearchInfo, 'DateVal','Product_Name', $order=SORT_DESC);
	$finalSearchInfo	=	array_multi_sort($finalSearchInfo, 'DateVal','Product_Name', $order=SORT_ASC);

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
		<th align="center" style="width:19%" nowrap="nowrap">Date</th>
		<th align="center" style="width:11%" nowrap="nowrap">DSR Name</th>
		<th align="center" style="width:10%">Device Name</th>
		<th align="center" style="width:10%" nowrap="nowrap">Vehicle Name</th>
		<th align="center" style="width:10%">UOM</th>
		<th align="center" style="width:10%">Loaded Quantity</th>
		<th align="center" style="width:10%">Sold Quantity</th>
		<th align="center" style="width:10%">Return Quantity</th>
		<th align="center" style="width:10%">Stock</th>
  </tr>
  </thead>
 <tbody>
         
  <?php	$k						=	0;
		$arrcnt					=	count($finalSearchInfo);
		$subtotalcheckfor		=	1;

if($arrcnt > 0) {
 foreach($finalSearchInfo AS $SearchKey=>$SearchVal) { 
	?>
		 <tr>			
			<td style="width:40%"><?php echo $SearchVal[Product_Name]; ?></td>
			 <td><?php echo upperstate($SearchVal[DateVal]); ?></td>
			 <td><?php echo upperstate($SearchVal[DSR_Name]); ?></td>
			 <td><?php echo strtoupper($SearchVal[Device_Name]); ?></td>
			 <!-- <td><?php echo upperstate($SearchVal[Device_Name]); ?></td> -->
			 <td><?php echo upperstate($SearchVal[Vehicle_Name]); ?></td>
			 <td><?php echo upperstate($SearchVal[UOM]); ?></td>
			 <td><?php echo upperstate($SearchVal[Loaded_quantity]); ?></td>
			 <td><?php echo upperstate($SearchVal[Sold_quantity]); ?></td>
			 <td><?php echo upperstate($SearchVal[Return_quantity]); ?></td>
			 <td><?php echo upperstate($SearchVal[Stock_quantity]); ?></td>
		 </tr>
<?php } ?>
   </tbody>	
  </table>
  <span id="printopen" style="padding-left:470px;padding-top:10px;<?php if($num_rows > 0 ) { echo "display:block;"; } else { echo "display:none;"; } ?>" ><input type="button" name="kdproduct" value="Print" class="buttons" onclick="print_pages('printkdvehstockled');"></span>
<form id="printkdvehstockled" target="_blank" action="printkdvehstockled.php" method="post">
	<input type="hidden" name="kdcode" id="kdcode" value="<?php echo $kdcode; ?>" />
</form>  
  <?php 
} else { ?>
 <tr>
	<td colspan="10" align="center"><strong>NO RECORDS FOUND</strong></td>
 </tr>
<?php } exit(0); ?>