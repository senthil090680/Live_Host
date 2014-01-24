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
$reportby		=	'DateVal';
if(isset($_REQUEST[fromdatevalue]) && $_REQUEST[fromdatevalue] !='') {
		
	$datecol	=	"(Date >= '".$fromdatevalue."' AND Date <= '".$todatevalue."')";
	
	$get_monthsarr				=	array_unique(get_months($fromdatevalue,$todatevalue));
	$get_yearsarr				=	array_unique(get_years($fromdatevalue,$todatevalue));
	sort($get_monthsarr);
	sort($get_yearsarr);
	$monthstr					=	implode("','",$get_monthsarr);
	$yearstr					=	implode("','",$get_yearsarr);
	if($target_query	==	'') {
		$target_query		.=	" WHERE monthval IN ('".$monthstr."') AND yearval IN ('".$yearstr."')";
	} else if($target_query	!=	'') {
		$target_query		.=	" AND monthval IN ('".$monthstr."') AND yearval IN ('".$yearstr."')";
	}

	if($kdcode	==	'' || $kdcode	==	'null') {
		$complete_query		=	'';
		//$target_query		=	"";
	} elseif($kdcode	!=	'') {
		//$kdcodestr			=	implode("','",$kdcode);
		$kdcodestr				=	$kdcode;
		$complete_query		=	" WHERE KD_Code IN ('".$kdcodestr."')";
		if($target_query	==	'') {
			$target_query		.=	" WHERE KD_Code IN ('".$kdcodestr."')";
		} else if($target_query	!=	'') {
			$target_query		.=	" AND KD_Code IN ('".$kdcodestr."')";
		}
	}

	//echo $target_query;

	if($prodcode	==	'' || $prodcode == 'null') {
		$prodcodecol		=	'';
		//$target_query		=	"";
	} elseif($prodcode	!=	'') {
		//$prodcodestr		=	implode("','",$prodcode);
		$prodcodestr		=	$prodcode;

		$prodcodestrprint		=	explode("','",$prodcode);
		foreach($prodcodestrprint AS $productidval) {
			$productidvalue[]		=	getProduct($productidval,'id','Product_code');
		}
		$productidstr		=	implode("','",$productidvalue);
		$prodcodecol		=	"AND Product_code IN ('".$prodcodestr."')";
		if($target_query	==	'') {
			$target_query		.=	" WHERE Product_id IN ('".$productidstr."')";
		} else if($target_query	!=	'') {
			$target_query		.=	" AND Product_id IN ('".$productidstr."')";
		}
	}
	if($brandcode	==	'' || $brandcode == 'null') {
		$brandcodecol		=	'';
	} elseif($brandcode	!=	'') {
		//$brandcodestr		=	implode("','",$brandcode);
		$brandcodestr		=	$brandcode;
		$brandcodecol		=	$whereand . " Product_code IN ('".$brandcodestr."')";
	}
	if($asmcode	==	'' || $asmcode == 'null') {
		$asmcodecol		=	'';
		$wherefordsr	=	'';
	} elseif($asmcode	!=	'') {
		//$asmcodestr	=	implode("','",$asmcode);
		$asmcodestr		=	$asmcode;
		$asmcodecol		=	"ASM IN ('".$asmcodestr."')";
		$asmcodecolval	=	"DSR_Code IN ('".$asmcodestr."')";
		$wherefordsr	=	'WHERE';
	}

	$DSR_Codestr		=	findSR($wherefordsr,$asmcodecolval);

	if($rsmcode	==	'' || $rsmcode == 'null') {
		$rsmcodecol		=	'';
	} elseif($rsmcode	!=	'') {
		//$rsmcodestr	=	implode("','",$rsmcode);
		$rsmcodestr		=	$rsmcode;
		$rsmcodecol		=	"RSM IN ('".$rsmcodestr."')";
	}
	
	$finalSearchInfo					=	'';
	
	if($complete_query	==	'') {
		if($DSR_Codestr	==	'') {
			$complete_query		.=	"";
		} else {
			$complete_query		.=	" WHERE DSR_Code IN ('".$DSR_Codestr."')";
		}
	} else if($complete_query	!=	'') {
		if($DSR_Codestr	==	'') {
			$complete_query		.=	"";
		} else {
			$complete_query		.=	" AND DSR_Code IN ('".$DSR_Codestr."')";
		}
	}

	if($target_query	==	'') {
		if($DSR_Codestr	==	'') {
			$target_query		.=	"";
		} else {
			$target_query		.=	" WHERE DSR_Code IN ('".$DSR_Codestr."')";
		}
	} else if($target_query	!=	'') {
		if($DSR_Codestr	==	'') {
			$target_query		.=	"";
		} else {
			$target_query		.=	" AND DSR_Code IN ('".$DSR_Codestr."')";
		}
	}

	if($complete_query	==	'') {
		$complete_query		.=	" WHERE $datecol AND Transaction_type IN ('2','3','4') ORDER BY Transaction_Number";
		//$complete_query		.=	" WHERE $datecol";
	} else if($complete_query	!=	'') {
		$complete_query			.=	" AND $datecol AND Transaction_type IN ('2','3','4') ORDER BY Transaction_Number";
		//$complete_query		.=	" AND $datecol";
	}

	$query_transhdr													=   "SELECT id,Transaction_Number,Date,Time,transaction_Reference_Number FROM transaction_hdr $complete_query";
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
				$transaction_Reference_Number_cancel[]				=   $row_transhdr[transaction_Reference_Number];
				$transno_cancel_number[]							=   $row_transhdr[Transaction_Number];
			}
			$transhdr_result[]									=   $row_transhdr;
			$transhdrInfo[$row_transhdr[Transaction_Number]]	=   $row_transhdr;
			$transno_transhdr[]									=   $row_transhdr[Transaction_Number];
		}
	}
	 
	//pre($transno_transhdr);
	//pre($transaction_Reference_Number_cancel);
	//pre($transno_cancel_number);
	
	foreach($transaction_Reference_Number_cancel AS $REFVAL){
		if(array_search($REFVAL,$transno_transhdr) !== false) {
			$arraysearchval		=	array_search($REFVAL,$transno_transhdr);
			unset($transno_transhdr[$arraysearchval]);
		}
	}

	//pre($transno_transhdr);
	foreach($transno_cancel_number AS $REFVAL){
		if(array_search($REFVAL,$transno_transhdr) !== false) {
			$arraysearchval		=	array_search($REFVAL,$transno_transhdr);
			//unset($transno_transhdr[$arraysearchval]);
			//array_splice($transno_transhdr, $arraysearchval, 1);
			unset($transno_transhdr[$arraysearchval]);
		}
	}

	//pre($transno_transhdr);
	
	//exit;
	$transno_transhdr		=	array_unique($transno_transhdr);
	$transno_Total			=	implode("','",$transno_transhdr);

	//pre($transhdrInfo);                                                        
	$i=0;
	$k=0;

	$finalSearchInfo					=	$transhdr_result;
	//pre($finalSearchInfo);
	//exit;
				
	$query_trans									=   "SELECT id,KD_Code,DSR_Code,Product_code,Transaction_Number,Sold_Quantity AS SUM_SQ,Value AS VALUE_NAIRA,Scheme_Code,Product_Scheme_Flag FROM transaction_line WHERE Transaction_Number IN ('".$transno_Total."') $prodcodecol ORDER BY id";
	//echo $query_trans;
	//exit;
	$res_trans										=   mysql_query($query_trans);

	while($row_trans								=   mysql_fetch_assoc($res_trans)) {
		//$transInfo[$row_trans["Transaction_Number"]]=	$row_trans;
		$transInfo[$row_trans["Transaction_Number"]."-".$row_trans["id"]]	=	$row_trans;
		$transno_trans[]							=	$row_trans["Transaction_Number"];
		$kdcode_trans[]								=	$row_trans["KD_Code"];
		$dsrcode_trans[]							=	$row_trans["DSR_Code"];
		$prodcode_trans[]							=	$row_trans["Product_code"];
	}
	
	//pre($transInfo);
	//exit;

	//echo count($transInfo)."jungle";
	$transno_trans		=	array_unique($transno_trans);
	$transno_Total		=	implode("','",$transno_trans);

	$kdcode_trans		=	array_unique($kdcode_trans);
	$kdcode_Total		=	implode("','",$kdcode_trans);

	$dsrcode_trans		=	array_unique($dsrcode_trans);
	$dsrcode_Total		=	implode("','",$dsrcode_trans);

	$prodcode_trans		=	array_unique($prodcode_trans);
	$prodcode_Total		=	implode("','",$prodcode_trans);

	//pre($transInfo);
	//exit;

	$i=0;
	$k=0;
	//pre($finalSearchInfo);
	//exit;
	/*foreach($finalSearchInfo as $val_transno){
		//echo $transInfo[$val_transno["Transaction_Number"]]["Transaction_Number"] . "-". $val_transno["Transaction_Number"]."<br>";
		if($transInfo[$val_transno["Transaction_Number"]]["Transaction_Number"] == $val_transno["Transaction_Number"]) {                                     
			$finaltranslineInfo[$i]["DSRCode"]						=   $transInfo[$val_transno["Transaction_Number"]]["DSR_Code"];
			$finaltranslineInfo[$i]["Product_code"]					=   $transInfo[$val_transno["Transaction_Number"]]["Product_code"];
			$finaltranslineInfo[$i]["KD_Code"]						=   $transInfo[$val_transno["Transaction_Number"]]["KD_Code"];
			$finaltranslineInfo[$i]["KD_Code"]						=   $transInfo[$val_transno["Transaction_Number"]]["KD_Code"];
			$finaltranslineInfo[$i]["SUM_SQ"]						=   $transInfo[$val_transno["Transaction_Number"]]["SUM_SQ"];
			$finaltranslineInfo[$i]["VALUE_NAIRA"]					=   $transInfo[$val_transno["Transaction_Number"]]["VALUE_NAIRA"];
			$finaltranslineInfo[$i]["trans_id"]						=   $val_transno["id"];
			$finaltranslineInfo[$i]["DateVal"]						=   $val_transno["Date"];
			$i++;
		}
		$k++;
	}*/

	foreach($transInfo as $val_transnokey=>$val_transno) {

		//echo $val_transnokey."<br>";

		$explode_transno		=	explode("-",$val_transnokey);

		$searchValue			=	myfunction_tosearch_arrayvalue($finalSearchInfo, $explode_transno[0],'Transaction_Number','Transaction_Number');

		//echo $searchValue."<br>";

		//echo $explode_transno[0]."<br>";

	//foreach($finalSearchInfo as $val_transno){
		
		//echo $transInfo[$val_transno["Transaction_Number"]]["Transaction_Number"] . "-". $val_transno["Transaction_Number"]."<br>";
		if($searchValue) {
			$finaltranslineInfo[$i]["DSRCode"]						=   $val_transno["DSR_Code"];
			$finaltranslineInfo[$i]["Scheme_Code"]					=   $val_transno["Scheme_Code"];
			$finaltranslineInfo[$i]["TRANS_NO"]						=   $val_transno["Transaction_Number"];
			$finaltranslineInfo[$i]["Product_code"]					=   $val_transno["Product_code"];
			$finaltranslineInfo[$i]["KD_Code"]						=   $val_transno["KD_Code"];
			$finaltranslineInfo[$i]["SUM_SQ"]						=   $val_transno["SUM_SQ"];
			$finaltranslineInfo[$i]["VALUE_NAIRA"]					=   $val_transno["VALUE_NAIRA"];
			$finaltranslineInfo[$i]["Product_Scheme_Flag"]			=   $val_transno["Product_Scheme_Flag"];
			$finaltranslineInfo[$i]["trans_id"]						=   myfunction_tosearch_arrayvalue($finalSearchInfo, $explode_transno[0],'Transaction_Number','id');
			$finaltranslineInfo[$i]["DateVal"]						=   myfunction_tosearch_arrayvalue($finalSearchInfo, $explode_transno[0],'Transaction_Number','Date');
			$i++;
		}
		$k++;
	}

	$finalSearchInfo          =   $finaltranslineInfo;
	//pre($finalSearchInfo);
	//exit;

	
	$i=0;
	foreach($finalSearchInfo as $val_kd){
		if($val_kd["Scheme_Code"] !='' && $val_kd["Product_code"] !='' && $val_kd["Product_code"] !='0' && $val_kd["Product_Scheme_Flag"] == 0) {
			$actual_schemeline[$val_kd["Scheme_Code"].$val_kd["TRANS_NO"].$i]		=	$val_kd[VALUE_NAIRA];
		} if($val_kd["Scheme_Code"] !='' && $val_kd["Product_code"] !='' && $val_kd["Product_code"] !='0' && $val_kd["Product_Scheme_Flag"] == 1) {
			$finalSearchInfo[$i]["VALUE_NAIRA"]		=	$val_kd[VALUE_NAIRA];
		} else if ($val_kd["Scheme_Code"] == '' && $val_kd["Product_code"] !='' && $val_kd["Product_code"] != '0') {
			$finalSearchInfo[$i]["VALUE_NAIRA"]		=	$val_kd[VALUE_NAIRA];
		}

		if($val_kd["Scheme_Code"] !='' && $val_kd["Product_code"] == '0') {
			for($y=0;$y<1000;$y++){
				if($actual_schemeline[$val_kd["Scheme_Code"].$val_kd["TRANS_NO"].$y] != ''){
					$finalSearchInfo[$y]["VALUE_NAIRA"]		=	($actual_schemeline[$val_kd["Scheme_Code"].$val_kd["TRANS_NO"].$y])+($val_kd[VALUE_NAIRA]);
					$actual_schemeline[$val_kd["Scheme_Code"].$val_kd["TRANS_NO"].$y]		=	'';
				}
			//finalSearchInfo$searchvalueinfo[$val_kd["Scheme_Code"].$val_kd["TRANS_NO"]]
			}
			unset($finalSearchInfo[$i]["DSRCode"]);
			unset($finalSearchInfo[$i]["Scheme_Code"]);
			unset($finalSearchInfo[$i]["TRANS_NO"]);
			unset($finalSearchInfo[$i]["Product_code"]);
			unset($finalSearchInfo[$i]["KD_Code"]);
			unset($finalSearchInfo[$i]["SUM_SQ"]);
			unset($finalSearchInfo[$i]["VALUE_NAIRA"]);
			unset($finalSearchInfo[$i]["Product_Scheme_Flag"]);
			unset($finalSearchInfo[$i]["trans_id"]);
			unset($finalSearchInfo[$i]["DateVal"]);
		}

		$i++;
	}

	//pre($finalSearchInfo);
	//exit;

	$i=0;
	foreach($finalSearchInfo as $val_check) {
		if(!empty($val_check)) {
			$finalchecklineInfo[$i]["DSRCode"]						=   $val_check["DSRCode"];
			$finalchecklineInfo[$i]["Scheme_Code"]					=   $val_check["Scheme_Code"];
			$finalchecklineInfo[$i]["TRANS_NO"]						=   $val_check["Transaction_Number"];
			$finalchecklineInfo[$i]["Product_code"]					=   $val_check["Product_code"];
			$finalchecklineInfo[$i]["KD_Code"]						=   $val_check["KD_Code"];
			$finalchecklineInfo[$i]["SUM_SQ"]						=   $val_check["SUM_SQ"];
			$finalchecklineInfo[$i]["VALUE_NAIRA"]					=   $val_check["VALUE_NAIRA"];
			$finalchecklineInfo[$i]["trans_id"]						=   $val_check['trans_id'];
			$finalchecklineInfo[$i]["DateVal"]						=   $val_check['DateVal'];
			$i++;
		}		
	}

	$finalSearchInfo          =   $finalchecklineInfo;
	//pre($finalSearchInfo);
	//exit;



	$query_kd										=   "SELECT KD_Name,KD_Code FROM kd WHERE KD_Code IN ('".$kdcode_Total."')";
	$res_kd											=   mysql_query($query_kd);
	while($row_kd									=   mysql_fetch_assoc($res_kd)) {
		$kdInfo[$row_kd["KD_Code"]]					=	$row_kd;
	}
	 
	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_kd){
		//$transInfo[$val_transno["Transaction_Number"]]["Transaction_Number"];
		if($kdInfo[$val_kd["KD_Code"]]["KD_Code"] == $val_kd[KD_Code]) {                                     
			$finalkdInfo[$i]["KD_Name"]								=   $kdInfo[$val_kd["KD_Code"]]["KD_Name"];
			$finalkdInfo[$i]["DSRCode"]								=   $val_kd["DSRCode"];
			$finalkdInfo[$i]["Product_code"]						=   $val_kd["Product_code"];
			$finalkdInfo[$i]["SUM_SQ"]								=   $val_kd["SUM_SQ"];
			$finalkdInfo[$i]["VALUE_NAIRA"]							=   $val_kd["VALUE_NAIRA"];
			$finalkdInfo[$i]["trans_id"]							=   $val_kd["trans_id"];
			$finalkdInfo[$i]["KD_Code"]								=   $val_kd["KD_Code"];
			$finalkdInfo[$i]["DateVal"]								=   $val_kd["DateVal"];
			$i++;
		}
		$k++;
	}

	$finalSearchInfo          =   $finalkdInfo;
	//pre($finalSearchInfo);
	//exit;


	$query_dsr										=   "SELECT ASM,DSRName,DSR_Code FROM dsr WHERE DSR_Code IN ('".$dsrcode_Total."')";
	$res_dsr										=   mysql_query($query_dsr);
	while($row_dsr									=   mysql_fetch_assoc($res_dsr)) {
		$dsrInfo[$row_dsr["DSR_Code"]]				=	$row_dsr;
		$asmcode_dsr[]								=	$row_dsr["ASM"];
	}
	
	//pre($dsrInfo);
	//exit;
	//$asmcode_dsr			=	array_unique($asmcode_dsr);
	$asmcode_Total			=	implode("','",$asmcode_dsr);

	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_dsr){
		//echo $dsrInfo[$val_dsr["DSRCode"]]["DSR_Code"] . "-". $val_dsr["DSRCode"]."<br>";
		if($dsrInfo[$val_dsr["DSRCode"]]["DSR_Code"] == $val_dsr["DSRCode"]) {                                    
			$finaldsrInfo[$i]["DSR_Name"]							=   $dsrInfo[$val_dsr["DSRCode"]]["DSRName"];
			$finaldsrInfo[$i]["ASM_Id"]								=   $dsrInfo[$val_dsr["DSRCode"]]["ASM"];
			$finaldsrInfo[$i]["KD_Name"]							=   $val_dsr["KD_Name"];
			$finaldsrInfo[$i]["DSRCode"]							=   $val_dsr["DSRCode"];
			$finaldsrInfo[$i]["Product_code"]						=   $val_dsr["Product_code"];
			$finaldsrInfo[$i]["SUM_SQ"]								=   $val_dsr["SUM_SQ"];
			$finaldsrInfo[$i]["VALUE_NAIRA"]						=   $val_dsr["VALUE_NAIRA"];
			$finaldsrInfo[$i]["trans_id"]							=   $val_dsr["trans_id"];
			$finaldsrInfo[$i]["KD_Code"]							=   $val_dsr["KD_Code"];
			$finaldsrInfo[$i]["DateVal"]							=   $val_dsr["DateVal"];
			$i++;
		}
		$k++;
	}

	$finalSearchInfo          =   $finaldsrInfo;
	//pre($finalSearchInfo);
	//exit;

	$query_prod										=   "SELECT brand,id,Product_description1,Product_code FROM product WHERE Product_code IN ('".$prodcode_Total."')";
	$res_prod										=   mysql_query($query_prod);
	while($row_prod									=   mysql_fetch_assoc($res_prod)) {
		$prodInfo[$row_prod["Product_code"]]		=	$row_prod;
		$brandid_brand[]							=	$row_prod["brand"];
	}
	
	$brandid_Total			=	implode("','",$brandid_brand);

	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_prod){
		//$transInfo[$val_transno["Transaction_Number"]]["Transaction_Number"];
		if($prodInfo[$val_prod["Product_code"]]["Product_code"] == $val_prod["Product_code"]) {                                     
			$finalprodInfo[$i]["DSRCode"]							=   $val_prod["DSRCode"];
			$finalprodInfo[$i]["DSR_Name"]							=   $val_prod["DSR_Name"];
			$finalprodInfo[$i]["KD_Name"]							=   $val_prod["KD_Name"];
			$finalprodInfo[$i]["ASM_Id"]							=   $val_prod["ASM_Id"];
			$finalprodInfo[$i]["Product_code"]						=   $val_prod["Product_code"];
			$finalprodInfo[$i]["Product_Name"]						=   $prodInfo[$val_prod["Product_code"]]["Product_description1"];
			$finalprodInfo[$i]["Brand_Id"]							=   $prodInfo[$val_prod["Product_code"]]["brand"];
			$finalprodInfo[$i]["Product_Id"]						=   $prodInfo[$val_prod["Product_code"]]["id"];
			$finalprodInfo[$i]["SUM_SQ"]							=   $val_prod["SUM_SQ"];
			$finalprodInfo[$i]["VALUE_NAIRA"]						=   $val_prod["VALUE_NAIRA"];
			$finalprodInfo[$i]["trans_id"]							=   $val_prod["trans_id"];
			$finalprodInfo[$i]["KD_Code"]							=   $val_prod["KD_Code"];
			$finalprodInfo[$i]["DateVal"]							=   $val_prod["DateVal"];			
		} else {
			$finalprodInfo[$i]["DSRCode"]							=   $val_prod["DSRCode"];
			$finalprodInfo[$i]["DSR_Name"]							=   $val_prod["DSR_Name"];
			$finalprodInfo[$i]["KD_Name"]							=   $val_prod["KD_Name"];
			$finalprodInfo[$i]["ASM_Id"]							=   $val_prod["ASM_Id"];
			$finalprodInfo[$i]["Product_code"]						=   $val_prod["Product_code"];
			$finalprodInfo[$i]["SUM_SQ"]							=   $val_prod["SUM_SQ"];
			$finalprodInfo[$i]["VALUE_NAIRA"]						=   $val_prod["VALUE_NAIRA"];
			$finalprodInfo[$i]["trans_id"]							=   $val_prod["trans_id"];
			$finalprodInfo[$i]["KD_Code"]							=   $val_prod["KD_Code"];
			$finalprodInfo[$i]["DateVal"]							=   $val_prod["DateVal"];
		}
		$i++;
		$k++;
	}

	$finalSearchInfo          =   $finalprodInfo;
	//pre($finalSearchInfo);
	//exit;


	$query_prod										=   "SELECT brand,Product_id,Product_description1,Product_code FROM customertype_product WHERE Product_code IN ('".$prodcode_Total."')";
	$res_prod										=   mysql_query($query_prod) or die(mysql_error());
	while($row_prod									=   mysql_fetch_assoc($res_prod)) {
		$prodInfoAnot[$row_prod["Product_code"]]		=	$row_prod;
		$brandid_brand[]							=	$row_prod["brand"];
	}
	
	$brandid_Total			=	implode("','",$brandid_brand);

	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_prod){
		//$transInfo[$val_transno["Transaction_Number"]]["Transaction_Number"];
		if($prodInfoAnot[$val_prod["Product_code"]]["Product_code"] == $val_prod["Product_code"]) {
			$finalprodInfo[$i]["DSRCode"]							=   $val_prod["DSRCode"];
			$finalprodInfo[$i]["DSR_Name"]							=   $val_prod["DSR_Name"];
			$finalprodInfo[$i]["KD_Name"]							=   $val_prod["KD_Name"];
			$finalprodInfo[$i]["ASM_Id"]							=   $val_prod["ASM_Id"];
			$finalprodInfo[$i]["Product_code"]						=   $val_prod["Product_code"];
			$finalprodInfo[$i]["Product_Name"]						=   $prodInfoAnot[$val_prod["Product_code"]]["Product_description1"];
			$finalprodInfo[$i]["Brand_Id"]							=   $prodInfoAnot[$val_prod["Product_code"]]["brand"];
			$finalprodInfo[$i]["Product_Id"]						=   $prodInfoAnot[$val_prod["Product_code"]]["Product_id"];
			$finalprodInfo[$i]["SUM_SQ"]							=   $val_prod["SUM_SQ"];
			$finalprodInfo[$i]["VALUE_NAIRA"]						=   $val_prod["VALUE_NAIRA"];
			$finalprodInfo[$i]["trans_id"]							=   $val_prod["trans_id"];
			$finalprodInfo[$i]["KD_Code"]							=   $val_prod["KD_Code"];
			$finalprodInfo[$i]["DateVal"]							=   $val_prod["DateVal"];			
		} else {
			$finalprodInfo[$i]["DSRCode"]							=   $val_prod["DSRCode"];
			$finalprodInfo[$i]["DSR_Name"]							=   $val_prod["DSR_Name"];
			$finalprodInfo[$i]["KD_Name"]							=   $val_prod["KD_Name"];
			$finalprodInfo[$i]["ASM_Id"]							=   $val_prod["ASM_Id"];
			$finalprodInfo[$i]["Product_code"]						=   $val_prod["Product_code"];
			$finalprodInfo[$i]["Product_Name"]						=   $val_prod["Product_Name"];
			$finalprodInfo[$i]["Brand_Id"]							=   $val_prod["Brand_Id"];
			$finalprodInfo[$i]["Product_Id"]						=   $val_prod["Product_Id"];
			$finalprodInfo[$i]["SUM_SQ"]							=   $val_prod["SUM_SQ"];
			$finalprodInfo[$i]["VALUE_NAIRA"]						=   $val_prod["VALUE_NAIRA"];
			$finalprodInfo[$i]["trans_id"]							=   $val_prod["trans_id"];
			$finalprodInfo[$i]["KD_Code"]							=   $val_prod["KD_Code"];
			$finalprodInfo[$i]["DateVal"]							=   $val_prod["DateVal"];			
		}
		$i++;
		$k++;
	}

	$finalSearchInfo          =   $finalprodInfo;
	//pre($finalSearchInfo);
	//exit;

	$query_asm									=   "SELECT id,DSRName,RSM FROM asm_sp WHERE id IN ('".$asmcode_Total."')";
	$res_asm										=   mysql_query($query_asm);
	while($row_asm									=   mysql_fetch_assoc($res_asm)) {
		$asmInfo[$row_asm["id"]]					=	$row_asm;
		$rsmcode_rsm[]								=	$row_asm["RSM"];
	}
	
	$rsmcode_Total			=	implode("','",$rsmcode_rsm);

	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_asm){
		//$transInfo[$val_transno["Transaction_Number"]]["Transaction_Number"];
		if($asmInfo[$val_asm["ASM_Id"]]["id"] == $val_asm["ASM_Id"]) {                                     
			$finalasmInfo[$i]["ASM_Name"]							=   $asmInfo[$val_asm["ASM_Id"]]["DSRName"];
			$finalasmInfo[$i]["RSM_Id"]								=   $asmInfo[$val_asm["ASM_Id"]]["RSM"];
			$finalasmInfo[$i]["Product_Name"]						=   $val_asm["Product_Name"];
			$finalasmInfo[$i]["DSR_Name"]							=   $val_asm["DSR_Name"];
			$finalasmInfo[$i]["ASM_Id"]								=   $val_asm["ASM_Id"];
			$finalasmInfo[$i]["KD_Name"]							=   $val_asm["KD_Name"];
			$finalasmInfo[$i]["DSRCode"]							=   $val_asm["DSRCode"];
			$finalasmInfo[$i]["Product_code"]						=   $val_asm["Product_code"];
			$finalasmInfo[$i]["Product_Id"]							=   $val_asm["Product_Id"];
			$finalasmInfo[$i]["Brand_Id"]							=   $val_asm["Brand_Id"];
			$finalasmInfo[$i]["SUM_SQ"]								=   $val_asm["SUM_SQ"];
			$finalasmInfo[$i]["VALUE_NAIRA"]						=   $val_asm["VALUE_NAIRA"];
			$finalasmInfo[$i]["trans_id"]							=   $val_asm["trans_id"];
			$finalasmInfo[$i]["KD_Code"]							=   $val_asm["KD_Code"];
			$finalasmInfo[$i]["DateVal"]							=   $val_asm["DateVal"];
			$i++;
		}
		$k++;
	}

	$finalSearchInfo          =   $finalasmInfo;
	//pre($finalSearchInfo);
	//exit;

	$query_rsm										=   "SELECT id,DSRName,DSR_Code FROM rsm_sp WHERE id IN ('".$rsmcode_Total."')";
	$res_rsm										=   mysql_query($query_rsm);
	while($row_rsm									=   mysql_fetch_assoc($res_rsm)) {
		$rsmInfo[$row_rsm["id"]]					=	$row_rsm;
	}

	//pre($rsmInfo);
	//exit;
	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_rsm){
		//echo $rsmInfo[$val_rsm["RSM_Code"]]["id"] . "-". $val_rsm["RSM_Code"]."<br>";
		if($rsmInfo[$val_rsm["RSM_Id"]]["id"] == $val_rsm["RSM_Id"]) {                                     
			$finalrsmInfo[$i]["ASM_Name"]							=   $val_rsm["ASM_Name"];
			$finalrsmInfo[$i]["ASM_Id"]								=   $val_rsm["ASM_Id"];
			$finalrsmInfo[$i]["RSM_Name"]							=   $rsmInfo[$val_rsm["RSM_Id"]]["DSRName"];
			$finalrsmInfo[$i]["RSM_Id"]								=   $val_rsm["RSM_Id"];
			$finalrsmInfo[$i]["Product_Name"]						=   $val_rsm["Product_Name"];
			$finalrsmInfo[$i]["Product_code"]						=   $val_rsm["Product_code"];
			$finalrsmInfo[$i]["Product_Id"]							=   $val_rsm["Product_Id"];
			$finalrsmInfo[$i]["DSR_Name"]							=   $val_rsm["DSR_Name"];
			$finalrsmInfo[$i]["DSRCode"]							=   $val_rsm["DSRCode"];
			$finalrsmInfo[$i]["KD_Name"]							=   $val_rsm["KD_Name"];
			$finalrsmInfo[$i]["KD_Code"]							=   $val_rsm["KD_Code"];
			$finalrsmInfo[$i]["Brand_Id"]							=   $val_rsm["Brand_Id"];
			$finalrsmInfo[$i]["SUM_SQ"]								=   $val_rsm["SUM_SQ"];
			$finalrsmInfo[$i]["VALUE_NAIRA"]						=   $val_rsm["VALUE_NAIRA"];
			$finalrsmInfo[$i]["trans_id"]							=   $val_rsm["trans_id"];
			$finalrsmInfo[$i]["DateVal"]							=   $val_rsm["DateVal"];
			$i++;
		}
		$k++;
	}

	$finalSearchInfo          =   $finalrsmInfo;
	//pre($finalSearchInfo);
	//exit;

	$query_brand									=   "SELECT id,brand FROM brand WHERE id IN ('".$brandid_Total."')";
	$res_brand										=   mysql_query($query_brand);
	while($row_brand									=   mysql_fetch_assoc($res_brand)) {
		$brandInfo[$row_brand["id"]]				=	$row_brand;
	}

	//pre($rsmInfo);
	//exit;
	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_brand){
		//echo $rsmInfo[$val_rsm["RSM_Code"]]["id"] . "-". $val_rsm["RSM_Code"]."<br>";
		if($brandInfo[$val_brand["Brand_Id"]]["id"] == $val_brand["Brand_Id"]) {                                     
			$finalbrandInfo[$i]["ASM_Name"]							=   $val_brand["ASM_Name"];
			$finalbrandInfo[$i]["ASM_Id"]							=   $val_brand["ASM_Id"];
			$finalbrandInfo[$i]["RSM_Name"]							=   $val_brand["RSM_Name"];
			$finalbrandInfo[$i]["RSM_Id"]							=   $val_brand["RSM_Id"];
			$finalbrandInfo[$i]["Product_Name"]						=   $val_brand["Product_Name"];
			$finalbrandInfo[$i]["Product_code"]						=   $val_brand["Product_code"];
			$finalbrandInfo[$i]["Product_Id"]						=   $val_brand["Product_Id"];
			$finalbrandInfo[$i]["DSR_Name"]							=   $val_brand["DSR_Name"];
			$finalbrandInfo[$i]["DSRCode"]							=   $val_brand["DSRCode"];
			$finalbrandInfo[$i]["KD_Name"]							=   $val_brand["KD_Name"];
			$finalbrandInfo[$i]["KD_Code"]							=   $val_brand["KD_Code"];
			$finalbrandInfo[$i]["Brand_Name"]						=   $brandInfo[$val_brand["Brand_Id"]]["brand"];
			$finalbrandInfo[$i]["Brand_Id"]							=   $val_brand["Brand_Id"];
			$finalbrandInfo[$i]["SUM_SQ"]							=   $val_brand["SUM_SQ"];
			$finalbrandInfo[$i]["VALUE_NAIRA"]						=   $val_brand["VALUE_NAIRA"];
			$finalbrandInfo[$i]["trans_id"]							=   $val_brand["trans_id"];
			$finalbrandInfo[$i]["DateVal"]							=   $val_brand["DateVal"];
			$i++;
		}
		$k++;
	}

	$finalSearchInfo          =   $finalbrandInfo;
	//pre($finalSearchInfo);
	//exit;	
	
	$orderbycolumns     =   'Product_code';
	$orderbysorting     =   'ASC';

	if($orderbysorting == 'DESC') {
		$dir        =   'arsort';               
	} else {
		$dir        =   'asort';   
	}
	$finalSearchInfo	=	subval_sort($finalSearchInfo,$orderbycolumns,$dir);
	
	$i=0;

	//pre($finalSearchInfo);
	foreach($finalSearchInfo AS $key=>$value) {
		$DSRCode											=	$value[DSRCode];
		$Product_code										=	$value[Product_code];
		$KD_Code											=	$value[KD_Code];
		$DateVal											=	$value[DateVal];
		$check[$DateVal.$DSRCode.$Product_code.$KD_Code]				=	$DateVal.$DSRCode.$Product_code.$KD_Code;

		//echo $check[$DateVal.$DSRCode.$Product_code.$KD_Code] ." == ". $checkagain[$DateVal.$DSRCode.$Product_code.$KD_Code]."<br>";

		if(($check[$DateVal.$DSRCode.$Product_code.$KD_Code] == $checkagain[$DateVal.$DSRCode.$Product_code.$KD_Code]) && ($check[$DateVal.$DSRCode.$Product_code.$KD_Code] != '' &&  $checkagain[$DateVal.$DSRCode.$Product_code.$KD_Code] != '')) {			
			$Sold_Qty[$DateVal.$DSRCode.$Product_code.$KD_Code]		+=	$value[SUM_SQ];
			$VALUE_NAIRA[$DateVal.$DSRCode.$Product_code.$KD_Code]	+=	$value[VALUE_NAIRA];

		//echo $Sold_Qty[$DateVal.$DSRCode.$Product_code.$KD_Code]."==in". $DateVal.$DSRCode.$Product_code.$KD_Code. "<br>";
			//echo $VALUE_NAIRA[$DateVal.$DSRCode.$Product_code.$KD_Code]."==". $DateVal.$DSRCode.$Product_code.$KD_Code. "<br>";

			//echo $gettingi[$DateVal.$DSRCode.$Product_code.$KD_Code]-1;
			//echo $Sold_Qty[$DateVal.$DSRCode.$Product_code.$KD_Code];
			$finalsumInfo[$gettingi[$DateVal.$DSRCode.$Product_code.$KD_Code]]["SUM_SQ"]				=   $Sold_Qty[$DateVal.$DSRCode.$Product_code.$KD_Code];
			$finalsumInfo[$gettingi[$DateVal.$DSRCode.$Product_code.$KD_Code]]["VALUE_NAIRA"]			=   $VALUE_NAIRA[$DateVal.$DSRCode.$Product_code.$KD_Code];
		} else {
			$finalsumInfo[$i]["ASM_Name"]					=   $value["ASM_Name"];
			$finalsumInfo[$i]["ASM_Id"]						=   $value["ASM_Id"];
			$finalsumInfo[$i]["RSM_Name"]					=   $value["RSM_Name"];
			$finalsumInfo[$i]["RSM_Id"]						=   $value["RSM_Id"];
			$finalsumInfo[$i]["Product_Name"]				=   $value["Product_Name"];
			$finalsumInfo[$i]["Product_code"]				=   $value["Product_code"];
			$finalsumInfo[$i]["Product_Id"]					=   $value["Product_Id"];
			$finalsumInfo[$i]["DSR_Name"]					=   $value["DSR_Name"];
			$finalsumInfo[$i]["DSRCode"]					=   $value["DSRCode"];
			$finalsumInfo[$i]["KD_Name"]					=   $value["KD_Name"];
			$finalsumInfo[$i]["KD_Code"]					=   $value["KD_Code"];
			$finalsumInfo[$i]["Brand_Name"]					=   $value["Brand_Name"];
			$finalsumInfo[$i]["Brand_Id"]					=   $value["Brand_Id"];
			$finalsumInfo[$i]["SUM_SQ"]						=   $value["SUM_SQ"];
			$finalsumInfo[$i]["VALUE_NAIRA"]				=   $value["VALUE_NAIRA"];
			$finalsumInfo[$i]["trans_id"]					=   $value["trans_id"];
			$finalsumInfo[$i]["DateVal"]					=   $value["DateVal"];
			$Sold_Qty[$DateVal.$DSRCode.$Product_code.$KD_Code]			+=	$value[SUM_SQ];
			$VALUE_NAIRA[$DateVal.$DSRCode.$Product_code.$KD_Code]		+=	$value[VALUE_NAIRA];
			$gettingi[$DateVal.$DSRCode.$Product_code.$KD_Code]			=	$i;
			$i++;
			$checkagain[$DateVal.$DSRCode.$Product_code.$KD_Code]		=	$check[$DateVal.$DSRCode.$Product_code.$KD_Code];
		}
		
	}

	//pre($Sold_Qty);
	//pre($VALUE_NAIRA);
	//pre($gettingi);
	//pre($finalsumInfo);
	$finalSearchInfo			=	$finalsumInfo;
	//pre($finalSearchInfo);
	//exit;

	$orderbycolumns     =   'Product_Id';
	$orderbysorting     =   'ASC';

	if($orderbysorting == 'DESC') {
		$dir        =   'arsort';               
	} else {
		$dir        =   'asort';   
	}
	$finalSearchInfo	=	subval_sort($finalSearchInfo,$orderbycolumns,$dir);
	//pre($finalSearchInfo);
	//exit;

	//echo $target_query;
	//exit;
	$query_target									=   "SELECT KD_Code,DSR_Code,Product_id,target_units,target_naira,monthval,yearval FROM sr_incentive $target_query ORDER BY Product_id,KD_Code,DSR_Code";
	//echo $query_target;
	//exit;
	$res_target										=   mysql_query($query_target);
	while($row_target								=   mysql_fetch_assoc($res_target)) {
		$SR_Code									=	$row_target[DSR_Code];
		$Product_id									=	$row_target[Product_id];
		$KD_Code									=	$row_target[KD_Code];
		$monthval												=	$row_target[monthval];
		$yearval												=	$row_target[yearval];
		$targetNaira[$SR_Code.$Product_id.$KD_Code]["target_naira"][$monthval.$yearval]		=	$row_target["target_naira"];
		$targetUnits[$SR_Code.$Product_id.$KD_Code]["target_units"][$monthval.$yearval]		=	$row_target["target_units"];
		$targetInfo[$SR_Code.$Product_id.$KD_Code]						=	$SR_Code.$Product_id.$KD_Code;
	}

	//pre($targetInfo);
	//pre($finalSearchInfo);
	//exit;
	$i=0;
	foreach($finalSearchInfo as $val_target)	{
		$SRCODEVAL			=	$val_target["DSRCode"];
		$PRODUCT_ID			=	$val_target["Product_Id"];
		$KD_CODE			=	$val_target["KD_Code"];

		$INDEX_VAL			=	$SRCODEVAL.$PRODUCT_ID.$KD_CODE;
		//echo	$targetInfo[$INDEX_VAL]	. "==".	$INDEX_VAL."<br>"; 
		if($targetInfo[$INDEX_VAL]	==	$INDEX_VAL) {
			$monthyeararrval			=	explode('-',$finalSearchInfo[$i]["DateVal"]);
			$monthvalue					=	ltrim($monthyeararrval[1],0);

			$sales_units									=	$finalSearchInfo[$i]["SUM_SQ"];
			$sales_naira									=	$finalSearchInfo[$i]["VALUE_NAIRA"];
			$finalSearchInfo[$i]["target_units"]			=   $targetUnits[$INDEX_VAL]["target_units"][$monthvalue.$monthyeararrval[0]];
			$finalSearchInfo[$i]["target_naira"]			=   $targetNaira[$INDEX_VAL]["target_naira"][$monthvalue.$monthyeararrval[0]];
			$finalSearchInfo[$i]["diff_units"]				=   $targetUnits[$INDEX_VAL]["target_units"][$monthvalue.$monthyeararrval[0]] - $sales_units;
			$finalSearchInfo[$i]["diff_naira"]				=   $targetNaira[$INDEX_VAL]["target_naira"][$monthvalue.$monthyeararrval[0]] - $sales_naira;
		}
		$i++;
	}
	//pre($finalSearchInfo);
	//exit;

	$orderbycolumns     =   $reportby;
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
<title>KD SALES LIST</title>
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
	overflow:scroll;
	overflow-x:hidden;
}
#errormsgsalper {
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
.myalignsalper {
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
		<th align="center" colspan="10">KD SALES LIST REPORT</th>
   </tr>
   <tr>
			<!--<th align="left" colspan="19"><?php 
			

			echo "From Date : &nbsp;&nbsp;&nbsp;".$fromdatevalue."&nbsp;&nbsp;&nbsp;&nbsp;To Date : &nbsp;&nbsp;&nbsp;".$todatevalue."&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;KD : &nbsp;&nbsp;";
						
			if($kdcode == '' || $kdcode == 'null') {
				echo "ALL";
			} else {
				$explode_kdcode		=	explode(",", str_replace("'","",$kdcode));
				$tom	=	0;
				foreach($explode_kdcode AS $kdval) {
					if($tom	==	0) {
						echo upperstate(getdbval($kdval,'KD_Name','KD_Code','kd'));
					} else {
						echo ",&nbsp;".upperstate(getdbval($kdval,'KD_Name','KD_Code','kd'));
					}
					$tom++;
				}
			}
			
			echo "&nbsp;&nbsp;&nbsp;PRODUCT : &nbsp;&nbsp;";

			if($prodcode == '' || $prodcode == 'null') {
				echo "ALL";
			} else {
				$explode_prodcode		=	explode(",", str_replace("'","",$prodcode));
				$tom	=	0;
				foreach($explode_prodcode AS $prodval) {
					if($tom	==	0) {
						echo upperstate(getdbval($prodval,'Product_description1','Product_code','product'));
					} else {
						echo ",&nbsp;".upperstate(getdbval($prodval,'Product_description1','Product_code','product'));
					}
					$tom++;
				}
			}
			//exit;
			/*if(is_array_empty($srcode)){
				echo getdbval($srcode,'DSRName','DSR_Code','dsr');
			} else{
				echo "ALL";
			}*/
			?></th>		-->
		</tr>
	  <tr>
		<th align="center" style="width:10%">Date</th>
		<th align="center" style="width:10%">KD Name</th>
		<th align="center" style="width:10%">SR Name</th>
		<th align="center" style="width:10%">ASM Name</th>
		<th align="center" style="width:10%">RSM Name</th>
		<th align="center" style="width:10%">Brand</th>
		<th align="center" style="width:10%">Product</th>
		<th align="center" style="width:10%">Target
		<table  width="100%"><tr><td>Units</td><td>Naira</td></tr></table>
		</th>
		<th align="center" style="width:10%">Sales
		 <table width="100%"><tr><td>Units</td><td>Naira</td></tr></table>
		</th>
		<th align="center" style="width:10%">Difference
		 <table  width="100%"><tr><td>Units</td><td>Naira</td></tr></table>
		</th>          
  </tr>
  </thead>
 <tbody>

 <?php	$checkfor				=	'';
		$checkoutfor			=	'';
		$checkforkd				=	'';
		$checkoutforkd			=	'';
		$subtotalcheckforkd		=	1;
		$k						=	0;
		$arrcnt					=	count($finalSearchInfo);
		$subtotalcheckfor		=	1;
		$total_target_naira		=	'';
		$total_target_units		=	'';
		$total_SUM_SQ			=	'';
		$total_VALUE_NAIRA		=	'';
		$total_diff_units		=	'';
		$total_diff_naira		=	'';

if($arrcnt > 0) {
 foreach($finalSearchInfo AS $SearchKey=>$SearchVal) { 
	$total_target_naira		+=	$SearchVal["target_naira"];
	$total_target_units		+=	$SearchVal["target_units"];
	$total_SUM_SQ			+=	$SearchVal["SUM_SQ"];
	$total_VALUE_NAIRA		+=	$SearchVal["VALUE_NAIRA"];
	$total_diff_units		+=	$SearchVal["diff_units"];
	$total_diff_naira		+=	$SearchVal["diff_naira"];

	if($k != 0) {

		//echo $kdcodecheck ."==". $SearchVal["KD_Code"] ."&&". $datecodecheck ."==". $SearchVal["DateVal"]."<br>";
		if($kdcodecheck == $SearchVal["KD_Code"] && $datecodecheck == $SearchVal["DateVal"]) {
			$target_naira_kd	+=	$SearchVal["target_naira"];
			$target_units_kd	+=	$SearchVal["target_units"];
			$SUM_SQ_kd			+=	$SearchVal["SUM_SQ"];
			$VALUE_NAIRA_kd		+=	$SearchVal["VALUE_NAIRA"];
			$diff_units_kd		+=	$SearchVal["diff_units"];
			$diff_naira_kd		+=	$SearchVal["diff_naira"];

		} else {

		?>	
			<tr>
		 <td colspan="7" align="right"><strong><?php 
		 //echo $target_naira	. " == " . $target_units . " == " . $SUM_SQ . " == " . $VALUE_NAIRA . " == " . $diff_units . " == " . $diff_naira. " == " .  $subtotalcheckforkd. "3dfe<br/>";
		 
		 //echo $checkfor ."==" .$checkoutfor."<br>"; ?> KD Total<strong></td>
		  <td >&nbsp;
		  <table width="100%"><tr><td><?php echo $target_units_kd; ?></td><td><?php echo number_format(trim($target_naira_kd)); ?></td></tr></table>
		  </td>	
		  <td>&nbsp;
		  <table width="100%"><tr><td><?php echo $SUM_SQ_kd; ?></td><td><?php echo number_format(trim($VALUE_NAIRA_kd)); ?></td></tr></table>
		  </td>	
		  <td>&nbsp;
		  <table width="100%"><tr><td><?php echo $diff_units_kd; ?></td><td><?php echo number_format(trim($diff_naira_kd)); ?></td></tr></table>
		  </td>
	 </tr>
		<?php $target_naira_kd	=	$SearchVal["target_naira"];
			$target_units_kd	=	$SearchVal["target_units"];
			$SUM_SQ_kd			=	$SearchVal["SUM_SQ"];
			$VALUE_NAIRA_kd		=	$SearchVal["VALUE_NAIRA"];
			$diff_units_kd		=	$SearchVal["diff_units"];
			$diff_naira_kd		=	$SearchVal["diff_naira"];
		}
	} else {
		$target_naira_kd	+=	$SearchVal["target_naira"];
		$target_units_kd	+=	$SearchVal["target_units"];
		$SUM_SQ_kd			+=	$SearchVal["SUM_SQ"];
		$VALUE_NAIRA_kd		+=	$SearchVal["VALUE_NAIRA"];
		$diff_units_kd		+=	$SearchVal["diff_units"];
		$diff_naira_kd		+=	$SearchVal["diff_naira"];
	}

	$kdcodecheck						=	$SearchVal["KD_Code"];
	$datecodecheck						=	$SearchVal["DateVal"];

	if($checkfor		==	'') {
		$checkfor		=	$SearchVal["DateVal"];
		$checkoutfor	=	$SearchVal["DateVal"];
		
		$target_naira	=	'';
		$target_units	=	'';
		$SUM_SQ			=	'';
		$VALUE_NAIRA	=	'';
		$diff_units		=	'';
		$diff_naira		=	'';

		if($subtotalcheckfor == 2) {
			$subtotalcheckfor = 1;
			$target_naira	+=	$SearchVal["target_naira"];
			$target_units	+=	$SearchVal["target_units"];
			$SUM_SQ			+=	$SearchVal["SUM_SQ"];
			$VALUE_NAIRA	+=	$SearchVal["VALUE_NAIRA"];
			$diff_units		+=	$SearchVal["diff_units"];
			$diff_naira		+=	$SearchVal["diff_naira"];
		}
	} else {
		$checkoutfor	=	$SearchVal["DateVal"];
		if($subtotalcheckfor == 1) {
			$target_naira	+=	$SearchVal["target_naira"];
			$target_units	+=	$SearchVal["target_units"];
			$SUM_SQ			+=	$SearchVal["SUM_SQ"];
			$VALUE_NAIRA	+=	$SearchVal["VALUE_NAIRA"];
			$diff_units		+=	$SearchVal["diff_units"];
			$diff_naira		+=	$SearchVal["diff_naira"];
		}
	}
			
	if((($checkfor == $checkoutfor) && ($checkfor != '' && $checkoutfor !='')) && ($k != $arrcnt)) {  		
		$subtotalcheckfor = 2;
		$target_naira	+=	$SearchVal["target_naira"];
		$target_units	+=	$SearchVal["target_units"];
		$SUM_SQ			+=	$SearchVal["SUM_SQ"];
		$VALUE_NAIRA	+=	$SearchVal["VALUE_NAIRA"];
		$diff_units		+=	$SearchVal["diff_units"];
		$diff_naira		+=	$SearchVal["diff_naira"];
	} else {
		 
	if($k != 0) {
		 //echo $checkfor ."==" .$checkoutfor."<br>";
		 //$checkoutfor		=	$SearchVal["Brand_Name"];
	?>
	 <tr>
		 <td colspan="7" align="right"><strong><?php 
		 //echo $target_naira	. " == " . $target_units . " == " . $SUM_SQ . " == " . $VALUE_NAIRA . " == " . $diff_units . " == " . $diff_naira. " == " .  $subtotalcheckfor. "<br/>";
		 
		 //echo $checkfor ."==" .$checkoutfor."<br>"; ?> Date Total<strong></td>
		  <td >&nbsp;
		  <table width="100%"><tr><td><?php echo $target_units; ?></td><td><?php echo number_format(trim($target_naira)); ?></td></tr></table>
		  </td>	
		  <td>&nbsp;
		  <table width="100%"><tr><td><?php echo $SUM_SQ; ?></td><td><?php echo number_format(trim($VALUE_NAIRA)); ?></td></tr></table>
		  </td>	
		  <td>&nbsp;
		  <table  width="100%"><tr><td><?php echo $diff_units; ?></td><td><?php echo number_format(trim($diff_naira)); ?></td></tr></table>
		  </td>
	 </tr>
<?php
	$checkfor			=	'';
	$subtotalcheckfor	=	'';
	$target_naira	=	$SearchVal["target_naira"];
	$target_units	=	$SearchVal["target_units"];
	$SUM_SQ			=	$SearchVal["SUM_SQ"];
	$VALUE_NAIRA	=	$SearchVal["VALUE_NAIRA"];
	$diff_units		=	$SearchVal["diff_units"];
	$diff_naira		=	$SearchVal["diff_naira"];

	//echo $target_naira	. " == " . $target_units . " == " . $SUM_SQ . " == " . $VALUE_NAIRA . " == " . $diff_units . " == " . $diff_naira. " == " .  $subtotalcheckfor."<br/>";
} }


$checkfor	=	$checkoutfor;

?>
<tr>
	 <td><?php echo ucwords(strtolower($SearchVal[DateVal])); ?></td>
	 <td><?php echo ucwords(strtolower($SearchVal[KD_Name])); ?></td>
	 <td><?php echo ucwords(strtolower($SearchVal[DSR_Name])); ?></td>	
	 <td><?php echo ucwords(strtolower($SearchVal[ASM_Name])); ?></td>
	 <td><?php echo ucwords(strtolower($SearchVal[RSM_Name])); ?></td>	
	 <td><?php echo ucwords(strtolower($SearchVal[Brand_Name])); ?></td>
	 <td><?php echo ucwords(strtolower($SearchVal[Product_Name])); ?></td>	
	 <td>&nbsp;
	 <table width="100%"><tr><td> <?php //echo $k . "+++++" . $arrcnt."<br/>"; echo $checkfor ."==" .$checkoutfor."<br>"; ?> <?php echo $SearchVal[target_units]; ?></td><td><?php echo number_format(trim($SearchVal[target_naira])); ?></td></tr></table>
	  </td>	
	  <td>&nbsp;
	  <table width="100%"><tr><td><?php echo $SearchVal[SUM_SQ]; ?></td><td><?php echo number_format(trim($SearchVal[VALUE_NAIRA])); ?></td></tr></table>
	  </td>	
	  <td>&nbsp;
	  <table  width="100%"><tr><td><?php echo $SearchVal[diff_units]; ?></td><td><?php echo number_format(trim($SearchVal[diff_naira])); ?></td></tr></table>
	  </td>
 </tr>
 
 <?php $k++; } ?>
 <tr>
	 <td colspan="7" align="right"><strong>KD Total<strong></td>
	  <td >&nbsp;
	  <table width="100%"><tr><td><?php echo $target_units_kd; ?></td><td><?php echo number_format(trim($target_naira_kd)); ?></td></tr></table>
	  </td>	
	  <td>&nbsp;
	  <table width="100%"><tr><td><?php echo $SUM_SQ_kd; ?></td><td><?php echo number_format(trim($VALUE_NAIRA_kd)); ?></td></tr></table>
	  </td>	
	  <td>&nbsp;
	  <table  width="100%"><tr><td><?php echo $diff_units_kd; ?></td><td><?php echo number_format(trim($diff_naira_kd)); ?></td></tr></table>
	  </td>
 </tr>
 <tr>
	 <td colspan="7" align="right"><strong>Date Total<strong></td>
	  <td >&nbsp;
	  <table width="100%"><tr><td><?php echo $target_units; ?></td><td><?php echo number_format(trim($target_naira)); ?></td></tr></table>
	  </td>	
	  <td>&nbsp;
	  <table width="100%"><tr><td><?php echo $SUM_SQ; ?></td><td><?php echo number_format(trim($VALUE_NAIRA)); ?></td></tr></table>
	  </td>	
	  <td>&nbsp;
	  <table  width="100%"><tr><td><?php echo $diff_units; ?></td><td><?php echo number_format(trim($diff_naira)); ?></td></tr></table>
	  </td>
 </tr>
 <tr>
	 <td colspan="7" align="right"><strong>Grand Total<strong></td>
	  <td >&nbsp;
	  <table width="100%"><tr><td><?php echo $total_target_units; ?></td><td><?php echo number_format(trim($total_target_naira)); ?></td></tr></table>
	  </td>	
	  <td>&nbsp;
	  <table width="100%"><tr><td><?php echo $total_SUM_SQ; ?></td><td><?php echo number_format(trim($total_VALUE_NAIRA)); ?></td></tr></table>
	  </td>	
	  <td>&nbsp;
	  <table  width="100%"><tr><td><?php echo $total_diff_units; ?></td><td><?php echo number_format(trim($total_diff_naira)); ?></td></tr></table>
	  </td>
 </tr>
 </tbody>	
</table>
<span id="printopen" style="padding-left:580px;padding-top:10px;<?php if($num_rows > 0 ) { echo "display:block;"; } else { echo "display:none;"; } ?>" ><input type="button" name="kdproduct" value="Print" class="buttons" onclick="hideprintbutton();"></span>
<?php } else { ?>
 <tr>
	<td colspan="10" align='center'><strong>NO RECORDS FOUND</strong></td>
 </tr>
<?php } exit(0); ?>