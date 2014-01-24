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
$focuscheck_query	=	'';
$target_query		=	'';
if(isset($_REQUEST[fromdatevalue]) && $_REQUEST[fromdatevalue] !='') {
		
	$datecol		=	"(Date >= '".$fromdatevalue."' AND Date <= '".$todatevalue."')";
	$datecolfocus	=	"(LEFT(Date,10) >= '".$fromdatevalue."' AND LEFT(Date,10) <= '".$todatevalue."')";
	
	//$cuscodeStr		=	implode("','",$cuscode);

	if($kdcode	==	'' || $kdcode == 'null') {
		$complete_query		=	'';
		$target_query		=	'';
	} elseif($kdcode	!=	'') {
		$kdcodestr			=	implode("','",$kdcode);
		if(is_array($kdcode)) {
			$kdcodeprint		=	$kdcodestr;
		} else {
			$kdcodeprint		=	$kdcode;		
		}
		$complete_query		=	" WHERE KD_Code IN ('".$kdcodestr."')";
		$target_query		.=	" WHERE KD_Code IN ('".$kdcodestr."')";
	}
		
	if($srcode	==	'' || $srcode == 'null') {
		$DSR_Codestr		=	'';
	} elseif($srcode	!=	'') {
		$DSR_Codestr		=	implode("','",$srcode);
		if(is_array($srcode)) {
			$srcodeprint		=	$DSR_Codestr;
		} else {
			$srcodeprint		=	$srcode;		
		}
		//$srcodecol		=	"DSR_Code IN ('".$srcodestr."')";
	}

	//echo $Custypestr;
	//exit;
	$finalSearchInfo					=	'';
	
	if($focuscheck_query	==	'') {
		if($DSR_Codestr	==	'') {
			$focuscheck_query		.=	"";
		} else {
			$focuscheck_query		.=	" WHERE DSR_Code IN ('".$DSR_Codestr."')";
		}
	} else if($focuscheck_query	!=	'') {
		if($DSR_Codestr	==	'') {
			$focuscheck_query		.=	"";
		} else {
			$focuscheck_query		.=	" AND DSR_Code IN ('".$DSR_Codestr."')";
		}
	}

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

	if($cuscode	==	'' || $cuscode == 'null') {
		$cuscode_query		.=	"";
	} else {
		$cuscodeStr			=	implode("','",$cuscode);
		if(is_array($cuscode)) {
			$cuscodeprint		=	$cuscodeStr;
		} else {
			$cuscodeprint		=	$cuscode;		
		}
		$cuscode_query		.=	" WHERE customer_code IN ('".$cuscodeStr."')";
	}

	if($target_query	==	'') {
		if($DSR_Codestr	==	'') {
			$target_query		.=	"";
		} else {
			$target_query		.=	" WHERE SR_Code IN ('".$DSR_Codestr."')";
		}
	} else if($target_query	!=	'') {
		if($DSR_Codestr	==	'') {
			$target_query		.=	"";
		} else {
			$target_query		.=	" AND SR_Code IN ('".$DSR_Codestr."')";
		}
	}

	if($complete_query	==	'') {
		$complete_query			=	" WHERE $datecol";
		//$complete_query		.=	" WHERE $datecol";
	} else if($complete_query	!=	'') {
		$complete_query			.=	" AND $datecol";
		//$complete_query		.=	" AND $datecol";
	}

	
	if($complete_query	==	'') {

		$complete_query			=	" WHERE $datecol";
		//$complete_query		.=	" WHERE $datecol";
	} else if($complete_query	!=	'') {
		$complete_query			.=	" AND $datecol";
		//$complete_query		.=	" AND $datecol";
	}

	if($complete_query	==	'') {
		if($cuscodeStr	==	'') {
			$complete_query		.=	"";
		} else {
			$complete_query		.=	" WHERE Customer_code IN ('".$cuscodeStr."')";
		}
	} else if($complete_query	!=	'') {
		if($cuscodeStr	==	'') {
			$complete_query		.=	"";
		} else {			
			$complete_query		.=	" AND Customer_code IN ('".$cuscodeStr."')";
		}
	}

	if($focuscheck_query	==	'') {
		$focuscheck_query			.=	" WHERE $datecolfocus";
		//$complete_query		.=	" WHERE $datecol";
	} else if($focuscheck_query	!=	'') {
		$focuscheck_query			.=	" AND $datecolfocus";
		//$complete_query		.=	" AND $datecol";
	}
	
	$query_transhdr													=   "SELECT id,KD_Code,DSR_Code,Date,GPS,Customer_code,Transaction_type,Transaction_Number,transaction_Reference_Number,currency,Product_Line_count,Transaction_Value,Discount,Discount_Value,Net_Sale_value,Collection_Value,Balance_Due_Value FROM transaction_hdr $complete_query ORDER BY Date";
	//echo $query_transhdr;
	//exit;
	$res_transhdr													=   mysql_query($query_transhdr);
	$transno_transhdr												=	array();
	while($row_transhdr												=   mysql_fetch_assoc($res_transhdr)) {		
		$transno_transhdr[]											=   $row_transhdr;
		$transcode_trans[]												=	$row_transhdr["Transaction_Number"];
		$kdcode_trans[]												=	$row_transhdr["KD_Code"];
		$dsrcode_trans[]											=	$row_transhdr["DSR_Code"];
		$cuscode_trans[]											=	$row_transhdr["Customer_code"];
	}	 

	$transcode_trans	=	array_unique($transcode_trans);
	$transcode_Total	=	implode("','",$transcode_trans);

	$kdcode_trans		=	array_unique($kdcode_trans);
	$kdcode_Total		=	implode("','",$kdcode_trans);

	$dsrcode_trans		=	array_unique($dsrcode_trans);
	$dsrcode_Total		=	implode("','",$dsrcode_trans);

	$cuscode_trans		=	array_unique($cuscode_trans);
	$cuscode_Total		=	implode("','",$cuscode_trans);

	//pre($transno_transhdr);
	$finalSearchInfo			=	$transno_transhdr;
	//pre($finalSearchInfo);
	//exit;

	$query_returnline												=   "SELECT KD_Code,DSR_Code,Transaction_Number,Transaction_Line_Number,Product_code,Reurn_quantity FROM transaction_return_line WHERE Transaction_Number IN ('".$transcode_Total."')";
	//echo $query_returnline;
	//exit;
	$res_returnline												=   mysql_query($query_returnline);
	while($row_returnline											=   mysql_fetch_assoc($res_returnline)) {
		$returneachlineInfo[$row_returnline["Transaction_Number"].$row_returnline["Transaction_Line_Number"]]			=	$row_returnline;
		$returnlineInfo[$row_returnline["Transaction_Number"]]			=	$row_returnline;
	}


	$query_trline												=   "SELECT id,KD_Code,DSR_Code,Transaction_type,Transaction_Number,Transaction_Line_Number,Product_code,UOM,Focus_Flag,POSM_Flag,Customer_Stock_Check,Customer_Stock_quantity,Scheme_Flag,Scheme_Code,Product_Scheme_Flag,Order_quantity,Sold_quantity,Price,Value FROM transaction_line WHERE Transaction_Number IN ('".$transcode_Total."') ORDER BY id";
	//echo $query_trline;
	//exit;
	$res_trline													=   mysql_query($query_trline);
	while($row_trline											=   mysql_fetch_assoc($res_trline)) {
		$treachlineInfo[$row_trline["Transaction_Number"].$row_trline["Transaction_Line_Number"]]			=	$row_trline;
		$trlineInfo[$row_trline["Transaction_Number"]]			=	$row_trline;
	}
	 
	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_trline){
		$Product_Line_count				=	$val_trline[Product_Line_count];
		$Trans_type						=	$val_trline[Transaction_type];
		//$trlineInfo[$val_trline["Transaction_Number"]]["Transaction_Number"] ."==". $val_trline[Transaction_Number]."<br>";

		if($Trans_type	== 4){
			if($Product_Line_count	== 1) {
				if($returnlineInfo[$val_trline["Transaction_Number"]]["Transaction_Number"] == $val_trline[Transaction_Number]) {                                     
					$finaltrlineInfo[$i]["TRANSLINO"]							=   $returnlineInfo[$val_trline["Transaction_Number"]]["Transaction_Line_Number"];
					$finaltrlineInfo[$i]["PRODCODE"]							=   $returnlineInfo[$val_trline["Transaction_Number"]]["Product_code"];
					$finaltrlineInfo[$i]["SOQTY"]								=   $returnlineInfo[$val_trline["Transaction_Number"]]["Reurn_quantity"];

					$finaltrlineInfo[$i]["DSRCode"]								=   $val_trline["DSR_Code"];
					$finaltrlineInfo[$i]["KD_Code"]								=   $val_trline["KD_Code"];
					$finaltrlineInfo[$i]["DateVal"]								=   $val_trline["Date"];
					$finaltrlineInfo[$i]["GPSVal"]								=   $val_trline["GPS"];
					$finaltrlineInfo[$i]["FOCUSCNT"]							=   0;
					$finaltrlineInfo[$i]["CUSCODE"]								=   $val_trline["Customer_code"];
					$finaltrlineInfo[$i]["TRANSTYPE"]							=   $val_trline["Transaction_type"];
					$finaltrlineInfo[$i]["TRANSNO"]								=   $val_trline["Transaction_Number"];
					$finaltrlineInfo[$i]["TRREFNO"]								=   $val_trline["transaction_Reference_Number"];
					$finaltrlineInfo[$i]["CUR"]									=   $val_trline["currency"];
					$finaltrlineInfo[$i]["PRODLICNT"]							=   $val_trline["Product_Line_count"];
					$finaltrlineInfo[$i]["TRANSVAL"]							=   $val_trline["Transaction_Value"];
					$finaltrlineInfo[$i]["DIS"]									=   $val_trline["Discount"];
					$finaltrlineInfo[$i]["DISVAL"]								=   $val_trline["Discount_Value"];
					$finaltrlineInfo[$i]["NETVAL"]								=   $val_trline["Net_Sale_value"];
					$finaltrlineInfo[$i]["COLVAL"]								=   $val_trline["Collection_Value"];
					$finaltrlineInfo[$i]["BALVAL"]								=   $val_trline["Balance_Due_Value"];
					$i++;
				}
			} elseif($Product_Line_count > 1) {
				foreach($returneachlineInfo AS $eachretprod) {
					//pre($eachprod);
					if($returnlineInfo[$val_trline["Transaction_Number"]]["Transaction_Number"] == $eachretprod[Transaction_Number]) {  
						$finaltrlineInfo[$i]["TRANSLINO"]							=   $eachretprod["Transaction_Line_Number"];
						$finaltrlineInfo[$i]["PRODCODE"]							=   $eachretprod["Product_code"];
						$finaltrlineInfo[$i]["SOQTY"]								=   $eachretprod["Reurn_quantity"];
						$finaltrlineInfo[$i]["FOCUSCNT"]							=   0;
						$finaltrlineInfo[$i]["DSRCode"]								=   $val_trline["DSR_Code"];
						$finaltrlineInfo[$i]["KD_Code"]								=   $val_trline["KD_Code"];
						$finaltrlineInfo[$i]["DateVal"]								=   $val_trline["Date"];
						$finaltrlineInfo[$i]["GPSVal"]								=   $val_trline["GPS"];
						$finaltrlineInfo[$i]["CUSCODE"]								=   $val_trline["Customer_code"];
						$finaltrlineInfo[$i]["TRANSTYPE"]							=   $val_trline["Transaction_type"];
						$finaltrlineInfo[$i]["TRANSNO"]								=   $val_trline["Transaction_Number"];
						$finaltrlineInfo[$i]["TRREFNO"]								=   $val_trline["transaction_Reference_Number"];
						$finaltrlineInfo[$i]["CUR"]									=   $val_trline["currency"];
						$finaltrlineInfo[$i]["PRODLICNT"]							=   $val_trline["Product_Line_count"];
						$finaltrlineInfo[$i]["TRANSVAL"]							=   $val_trline["Transaction_Value"];
						$finaltrlineInfo[$i]["DIS"]									=   $val_trline["Discount"];
						$finaltrlineInfo[$i]["DISVAL"]								=   $val_trline["Discount_Value"];
						$finaltrlineInfo[$i]["NETVAL"]								=   $val_trline["Net_Sale_value"];
						$finaltrlineInfo[$i]["COLVAL"]								=   $val_trline["Collection_Value"];
						$finaltrlineInfo[$i]["BALVAL"]								=   $val_trline["Balance_Due_Value"];					
						$i++;
					}
				}
			}
		} elseif($Trans_type == 2 || $Trans_type	== 3) {
			if($Product_Line_count	== 1) {
				if($trlineInfo[$val_trline["Transaction_Number"]]["Transaction_Number"] == $val_trline[Transaction_Number]) {                                     
					$finaltrlineInfo[$i]["TRANSLINO"]							=   $trlineInfo[$val_trline["Transaction_Number"]]["Transaction_Line_Number"];
					$finaltrlineInfo[$i]["PRODCODE"]							=   $trlineInfo[$val_trline["Transaction_Number"]]["Product_code"];
					$finaltrlineInfo[$i]["UOM"]									=   $trlineInfo[$val_trline["Transaction_Number"]]["UOM"];
					$finaltrlineInfo[$i]["FOFLAG"]								=   $trlineInfo[$val_trline["Transaction_Number"]]["Focus_Flag"];
					$finaltrlineInfo[$i]["POSMFLAG"]							=   $trlineInfo[$val_trline["Transaction_Number"]]["POSM_Flag"];
					if($finaltrlineInfo[$i]["POSMFLAG"] == 0) {
						$finaltrlineInfo[$i]["PRODTYPE"]						=   "Standard";
					} else if($finaltrlineInfo[$i]["POSMFLAG"] == 1) {
						$finaltrlineInfo[$i]["PRODTYPE"]						=   "POSM";
					}
					$finaltrlineInfo[$i]["SCFLAG"]								=   $trlineInfo[$val_trline["Transaction_Number"]]["Scheme_Flag"];
					$finaltrlineInfo[$i]["SCCODE"]								=   $trlineInfo[$val_trline["Transaction_Number"]]["Scheme_Code"];
					if($finaltrlineInfo[$i]["SCFLAG"] == 1) {
						$schemecodeArr[]										=	$finaltrlineInfo[$i]["SCCODE"];
					}
					$finaltrlineInfo[$i]["PRSCFLAG"]							=   $trlineInfo[$val_trline["Transaction_Number"]]["Product_Scheme_Flag"];
					
					/*if($finaltrlineInfo[$i]["FOFLAG"] == 1) {
						$finaltrlineInfo[$i]["FOCUSCNT"]						=   1;
					} elseif($finaltrlineInfo[$i]["FOFLAG"] == 0) {
						$finaltrlineInfo[$i]["FOCUSCNT"]						=   0;
					}*/

					$finaltrlineInfo[$i]["ORQTY"]								=   $trlineInfo[$val_trline["Transaction_Number"]]["Order_quantity"];
					$finaltrlineInfo[$i]["SOQTY"]								=   $trlineInfo[$val_trline["Transaction_Number"]]["Sold_quantity"];
					$finaltrlineInfo[$i]["PRICEVAL"]							=   $trlineInfo[$val_trline["Transaction_Number"]]["Price"];
					$finaltrlineInfo[$i]["VALUEVAL"]							=   $trlineInfo[$val_trline["Transaction_Number"]]["Value"];
					$finaltrlineInfo[$i]["DSRCode"]								=   $val_trline["DSR_Code"];
					$finaltrlineInfo[$i]["KD_Code"]								=   $val_trline["KD_Code"];
					$finaltrlineInfo[$i]["DateVal"]								=   $val_trline["Date"];
					$finaltrlineInfo[$i]["GPSVal"]								=   $val_trline["GPS"];
					$finaltrlineInfo[$i]["CUSCODE"]								=   $val_trline["Customer_code"];
					$finaltrlineInfo[$i]["TRANSTYPE"]							=   $val_trline["Transaction_type"];
					$finaltrlineInfo[$i]["TRANSNO"]								=   $val_trline["Transaction_Number"];
					$finaltrlineInfo[$i]["TRREFNO"]								=   $val_trline["transaction_Reference_Number"];
					$finaltrlineInfo[$i]["CUR"]									=   $val_trline["currency"];
					$finaltrlineInfo[$i]["PRODLICNT"]							=   $val_trline["Product_Line_count"];
					$finaltrlineInfo[$i]["TRANSVAL"]							=   $val_trline["Transaction_Value"];
					$finaltrlineInfo[$i]["DIS"]									=   $val_trline["Discount"];
					$finaltrlineInfo[$i]["DISVAL"]								=   $val_trline["Discount_Value"];
					$finaltrlineInfo[$i]["NETVAL"]								=   $val_trline["Net_Sale_value"];
					$finaltrlineInfo[$i]["COLVAL"]								=   $val_trline["Collection_Value"];
					$finaltrlineInfo[$i]["BALVAL"]								=   $val_trline["Balance_Due_Value"];
					$i++;
				}
			} elseif($Product_Line_count > 1) {
				foreach($treachlineInfo AS $eachprod) {
					//pre($eachprod);
					if($trlineInfo[$val_trline["Transaction_Number"]]["Transaction_Number"] == $eachprod[Transaction_Number]) {  
						$finaltrlineInfo[$i]["TRANSLINO"]							=   $eachprod["Transaction_Line_Number"];
						$finaltrlineInfo[$i]["PRODCODE"]							=   $eachprod["Product_code"];
						$finaltrlineInfo[$i]["UOM"]									=   $eachprod["UOM"];
						$finaltrlineInfo[$i]["FOFLAG"]								=   $eachprod["Focus_Flag"];
						$finaltrlineInfo[$i]["POSMFLAG"]							=   $eachprod["POSM_Flag"];

						if($finaltrlineInfo[$i]["POSMFLAG"] == 0) {
							$finaltrlineInfo[$i]["PRODTYPE"]							=   "Standard";
						} else if($finaltrlineInfo[$i]["POSMFLAG"] == 1) {
							$finaltrlineInfo[$i]["PRODTYPE"]							=   "POSM";
						}

						$finaltrlineInfo[$i]["SCFLAG"]								=   $eachprod["Scheme_Flag"];
						$finaltrlineInfo[$i]["SCCODE"]								=   $eachprod["Scheme_Code"];
						if($finaltrlineInfo[$i]["SCFLAG"] == 1) {
							$schemecodeArr[]											=	$finaltrlineInfo[$i]["SCCODE"];
						}

						/*if($finaltrlineInfo[$i]["FOFLAG"] == 1) {
							$finaltrlineInfo[$i]["FOCUSCNT"]							=   1;
						} elseif($finaltrlineInfo[$i]["FOFLAG"] == 0) {
							$finaltrlineInfo[$i]["FOCUSCNT"]							=   0;
						}*/

						$finaltrlineInfo[$i]["PRSCFLAG"]							=   $eachprod["Product_Scheme_Flag"];
						$finaltrlineInfo[$i]["ORQTY"]								=   $eachprod["Order_quantity"];
						$finaltrlineInfo[$i]["SOQTY"]								=   $eachprod["Sold_quantity"];
						$finaltrlineInfo[$i]["PRICEVAL"]							=   $eachprod["Price"];
						$finaltrlineInfo[$i]["VALUEVAL"]							=   $eachprod["Value"];
						$finaltrlineInfo[$i]["DSRCode"]								=   $val_trline["DSR_Code"];
						$finaltrlineInfo[$i]["KD_Code"]								=   $val_trline["KD_Code"];
						$finaltrlineInfo[$i]["DateVal"]								=   $val_trline["Date"];
						$finaltrlineInfo[$i]["GPSVal"]								=   $val_trline["GPS"];
						$finaltrlineInfo[$i]["CUSCODE"]								=   $val_trline["Customer_code"];
						$finaltrlineInfo[$i]["TRANSTYPE"]							=   $val_trline["Transaction_type"];
						$finaltrlineInfo[$i]["TRANSNO"]								=   $val_trline["Transaction_Number"];
						$finaltrlineInfo[$i]["TRREFNO"]								=   $val_trline["transaction_Reference_Number"];
						$finaltrlineInfo[$i]["CUR"]									=   $val_trline["currency"];
						$finaltrlineInfo[$i]["PRODLICNT"]							=   $val_trline["Product_Line_count"];
						$finaltrlineInfo[$i]["TRANSVAL"]							=   $val_trline["Transaction_Value"];
						$finaltrlineInfo[$i]["DIS"]									=   $val_trline["Discount"];
						$finaltrlineInfo[$i]["DISVAL"]								=   $val_trline["Discount_Value"];
						$finaltrlineInfo[$i]["NETVAL"]								=   $val_trline["Net_Sale_value"];
						$finaltrlineInfo[$i]["COLVAL"]								=   $val_trline["Collection_Value"];
						$finaltrlineInfo[$i]["BALVAL"]								=   $val_trline["Balance_Due_Value"];					
						$i++;
					}
				}
			}
		}
		$k++;
	}

	$finalSearchInfo          =   $finaltrlineInfo;
	//pre($finalSearchInfo);
	//pre($schemecodeArr);
	//exit;


	$i=0;
	foreach($finalSearchInfo as $val_kd){
		if($val_kd["SCCODE"] !='' && $val_kd["PRODCODE"] !='' && $val_kd["PRODCODE"] !='0' && $val_kd["PRSCFLAG"] == 0) {
			$actual_schemeline[$val_kd["SCCODE"].$val_kd["TRANSNO"].$i]		=	$val_kd[VALUEVAL];
		} if($val_kd["SCCODE"] !='' && $val_kd["PRODCODE"] !='' && $val_kd["PRODCODE"] !='0' && $val_kd["PRSCFLAG"] == 1) {
			$finalSearchInfo[$i]["VALUEVAL"]		=	$val_kd[VALUEVAL];
		} /*else if ($val_kd["SCCODE"] == '' && $val_kd["PRODCODE"] !='' && $val_kd["PRODCODE"] != '0') {
			$finalSearchInfo[$i]["VALUEVAL"]		=	$val_kd[VALUEVAL];
		}*/ 

		if($val_kd["SCCODE"] !='' && $val_kd["PRODCODE"] == '0') {
			for($y=0;$y<1000;$y++){
				if($actual_schemeline[$val_kd["SCCODE"].$val_kd["TRANSNO"].$y] != ''){
					$finalSearchInfo[$y]["VALUEVAL"]		=	($actual_schemeline[$val_kd["SCCODE"].$val_kd["TRANSNO"].$y])+($val_kd[VALUEVAL]);
				}
				//finalSearchInfo$searchvalueinfo[$val_kd["Scheme_Code"].$val_kd["TRANS_NO"]]
			}
			
			/*unset($finalSearchInfo[$i]["DSRCode"]);
			unset($finalSearchInfo[$i]["Scheme_Code"]);
			unset($finalSearchInfo[$i]["TRANS_NO"]);
			unset($finalSearchInfo[$i]["Product_code"]);
			unset($finalSearchInfo[$i]["KD_Code"]);
			unset($finalSearchInfo[$i]["SUM_SQ"]);
			unset($finalSearchInfo[$i]["VALUE_NAIRA"]);
			unset($finalSearchInfo[$i]["trans_id"]);*/

			unset($finalSearchInfo[$i]["TRANSLINO"]);
			unset($finalSearchInfo[$i]["PRODCODE"]);
			unset($finalSearchInfo[$i]["UOM"]);
			unset($finalSearchInfo[$i]["FOFLAG"]);
			unset($finalSearchInfo[$i]["POSMFLAG"]);
			unset($finalSearchInfo[$i]["PRODTYPE"]);
			unset($finalSearchInfo[$i]["SCFLAG"]);
			unset($finalSearchInfo[$i]["SCCODE"]);
			unset($finalSearchInfo[$i]["PRSCFLAG"]);
			unset($finalSearchInfo[$i]["ORQTY"]);
			unset($finalSearchInfo[$i]["SOQTY"]);
			unset($finalSearchInfo[$i]["PRICEVAL"]);
			unset($finalSearchInfo[$i]["VALUEVAL"]);
			unset($finalSearchInfo[$i]["DSRCode"]);
			unset($finalSearchInfo[$i]["KD_Code"]);
			unset($finalSearchInfo[$i]["DateVal"]);
			unset($finalSearchInfo[$i]["GPSVal"]);
			unset($finalSearchInfo[$i]["CUSCODE"]);
			unset($finalSearchInfo[$i]["TRANSTYPE"]);
			unset($finalSearchInfo[$i]["TRANSNO"]);
			unset($finalSearchInfo[$i]["TRREFNO"]);
			unset($finalSearchInfo[$i]["CUR"]);
			unset($finalSearchInfo[$i]["PRODLICNT"]);
			unset($finalSearchInfo[$i]["TRANSVAL"]);
			unset($finalSearchInfo[$i]["DIS"]);
			unset($finalSearchInfo[$i]["DISVAL"]);
			unset($finalSearchInfo[$i]["NETVAL"]);
			unset($finalSearchInfo[$i]["COLVAL"]);
			unset($finalSearchInfo[$i]["BALVAL"]);
		}

		$i++;
	}

	//pre($finalSearchInfo);
	//exit;

	$i=0;
	foreach($finalSearchInfo as $val_check) {
		if(!empty($val_check)) {

			$finalchecklineInfo[$i]["TRANSLINO"]				=	$val_check["TRANSLINO"];
			$finalchecklineInfo[$i]["PRODCODE"]					=	$val_check["PRODCODE"];
			$finalchecklineInfo[$i]["UOM"]						=	$val_check["UOM"];
			$finalchecklineInfo[$i]["FOFLAG"]					=	$val_check["FOFLAG"];
			$finalchecklineInfo[$i]["POSMFLAG"]					=	$val_check["POSMFLAG"];
			$finalchecklineInfo[$i]["PRODTYPE"]					=	$val_check["PRODTYPE"];
			$finalchecklineInfo[$i]["SCFLAG"]					=	$val_check["SCFLAG"];
			$finalchecklineInfo[$i]["SCCODE"]					=	$val_check["SCCODE"];
			$finalchecklineInfo[$i]["PRSCFLAG"]					=	$val_check["PRSCFLAG"];
			$finalchecklineInfo[$i]["ORQTY"]					=	$val_check["ORQTY"];
			$finalchecklineInfo[$i]["SOQTY"]					=	$val_check["SOQTY"];
			$finalchecklineInfo[$i]["PRICEVAL"]					=	$val_check["PRICEVAL"];
			$finalchecklineInfo[$i]["VALUEVAL"]					=	$val_check["VALUEVAL"];
			$finalchecklineInfo[$i]["DSRCode"]					=	$val_check["DSRCode"];
			$finalchecklineInfo[$i]["KD_Code"]					=	$val_check["KD_Code"];
			$finalchecklineInfo[$i]["DateVal"]					=	$val_check["DateVal"];
			$finalchecklineInfo[$i]["GPSVal"]					=	$val_check["GPSVal"];
			$finalchecklineInfo[$i]["CUSCODE"]					=	$val_check["CUSCODE"];
			$finalchecklineInfo[$i]["TRANSTYPE"]				=	$val_check["TRANSTYPE"];
			$finalchecklineInfo[$i]["TRANSNO"]					=	$val_check["TRANSNO"];
			$finalchecklineInfo[$i]["TRREFNO"]					=	$val_check["TRREFNO"];
			$finalchecklineInfo[$i]["CUR"]						=	$val_check["CUR"];
			$finalchecklineInfo[$i]["PRODLICNT"]				=	$val_check["PRODLICNT"];
			$finalchecklineInfo[$i]["TRANSVAL"]					=	$val_check["TRANSVAL"];
			$finalchecklineInfo[$i]["DIS"]						=	$val_check["DIS"];
			$finalchecklineInfo[$i]["DISVAL"]					=	$val_check["DISVAL"];
			$finalchecklineInfo[$i]["NETVAL"]					=	$val_check["NETVAL"];
			$finalchecklineInfo[$i]["COLVAL"]					=	$val_check["COLVAL"];
			$finalchecklineInfo[$i]["BALVAL"]					=	$val_check["BALVAL"];
			$i++;
		}		
	}

	$finalSearchInfo          =   $finalchecklineInfo;
	//pre($finalSearchInfo);
	//exit;

	$schemecodeArr			=	array_unique($schemecodeArr);
	$schemecode_Total		=	implode("','",$schemecodeArr);

	$query_schline												=   "SELECT Scheme_code,Header_Product_description1,Header_Product_code,line_Product_Name,line_Product_Code FROM product_scheme_master WHERE Scheme_code IN ('".$schemecode_Total."')";
	//echo $query_schline;
	//exit;
	$res_schline												=   mysql_query($query_schline);
	while($row_schline											=   mysql_fetch_assoc($res_schline)) {
		//$schlineInfo[$row_schline["Scheme_code"].$row_schline["Header_Product_code"].$row_schline["line_Product_Code"]]			=	$row_schline;
		$schlineInfo[$row_schline["Scheme_code"].$row_schline["Header_Product_code"]]			=	$row_schline;
		$scheachlineInfo[$row_schline["Scheme_code"]]			=	$row_schline;
	}
	
	//pre($schlineInfo);
	//exit;

	//pre($finalSearchInfo);
	//exit;
	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_schline){
		//$schlineInfo[$val_trline["SCCODE"]]["SCCODE"] ."==". $val_trline[SCCODE]."<br>";

		//if($val_schline["SCCODE"] != '') {
			//echo "hi<br>";
			//foreach($schlineInfo AS $eachschprod) {
				//pre($eachprod);
				//if($scheachlineInfo[$val_schline["SCCODE"]]["Scheme_code"]		==	$eachschprod[Scheme_code]) {  


					$finalschlineInfo[$i]["TRANSLINO"]							=   $val_schline["TRANSLINO"];
					$finalschlineInfo[$i]["PRODCODE"]							=   $val_schline["PRODCODE"];
					$finalschlineInfo[$i]["UOM"]								=   $val_schline["UOM"];
					$finalschlineInfo[$i]["FOFLAG"]								=   $val_schline["FOFLAG"];
					$finalschlineInfo[$i]["POSMFLAG"]							=   $val_schline["POSMFLAG"];
					$finalschlineInfo[$i]["PRODTYPE"]							=   $val_schline["PRODTYPE"];
					$finalschlineInfo[$i]["SCFLAG"]								=   $val_schline["SCFLAG"];
					$finalschlineInfo[$i]["SCCODE"]								=   $val_schline["SCCODE"];
					$finalschlineInfo[$i]["PRSCFLAG"]							=   $val_schline["PRSCFLAG"];
					
					if($val_schline["SCCODE"] != '') {
						$finalschlineInfo[$i]["HEDDES"]							=	'';
						$finalschlineInfo[$i]["LINDES"]							=	'';
						$startschhead											=	0;
						$startschline											=	0;
						if($finalschlineInfo[$i]["PRSCFLAG"]	== 1) {
							
							foreach($schlineInfo AS $eachkey=>$eachschprod) {
								//echo $eachkey;
								
								if($scheachlineInfo[$val_schline["SCCODE"]]["Scheme_code"]		==	$eachschprod[Scheme_code]) {  
									
									if($startschhead	==	0) {
										$finalschlineInfo[$i]["HEDDES"]								=   '';
										$finalschlineInfo[$i]["HEDPRO"]								=   '';

										$finalschlineInfo[$i]["LINDES"]								=   $eachschprod["line_Product_Name"];
										$finalschlineInfo[$i]["LINPRO"]								=   $eachschprod["line_Product_Code"];
										$startschhead++;
									} else {
										$finalschlineInfo[$i]["HEDDES"]								=   '';
										$finalschlineInfo[$i]["HEDPRO"]								=   '';

										$finalschlineInfo[$i]["LINDES"]								.=   ",<br>".$eachschprod["line_Product_Name"];
										$finalschlineInfo[$i]["LINPRO"]								=   $eachschprod["line_Product_Code"];
									}
								}
							}														
						} elseif($finalschlineInfo[$i]["PRSCFLAG"]	== 0) {
							foreach($schlineInfo AS $eachkey=>$eachschprod) {
								//echo $eachkey;
								
								if($scheachlineInfo[$val_schline["SCCODE"]]["Scheme_code"]		==	$eachschprod[Scheme_code]) {  
									
									if($startschhead	==	0) {
										$finalschlineInfo[$i]["HEDDES"]								=   $eachschprod["Header_Product_description1"];
										$finalschlineInfo[$i]["HEDPRO"]								=   $eachschprod["Header_Product_code"];

										$finalschlineInfo[$i]["LINDES"]								=   $eachschprod["line_Product_Name"];
										$finalschlineInfo[$i]["LINPRO"]								=   $eachschprod["line_Product_Code"];
										$startschhead++;
									} else {
										$finalschlineInfo[$i]["HEDDES"]								.=   ",<br>".$eachschprod["Header_Product_description1"];
										$finalschlineInfo[$i]["HEDPRO"]								=   $eachschprod["Header_Product_code"];

										$finalschlineInfo[$i]["LINDES"]								.=   ",<br>".$eachschprod["line_Product_Name"];
										$finalschlineInfo[$i]["LINPRO"]								=   $eachschprod["line_Product_Code"];
									}
								}
							}							
						}
					} else {
						$finalschlineInfo[$i]["HEDDES"]							=   '';
						$finalschlineInfo[$i]["HEDPRO"]							=   '';
						$finalschlineInfo[$i]["LINDES"]							=   '';
						$finalschlineInfo[$i]["LINPRO"]							=   '';
					}

					$finalschlineInfo[$i]["ORQTY"]								=   $val_schline["ORQTY"];
					$finalschlineInfo[$i]["FOCUSCNT"]							=	$val_schline["FOCUSCNT"];
					$finalschlineInfo[$i]["SOQTY"]								=   $val_schline["SOQTY"];
					$finalschlineInfo[$i]["PRICEVAL"]							=   $val_schline["PRICEVAL"];
					$finalschlineInfo[$i]["VALUEVAL"]							=   $val_schline["VALUEVAL"];
					$finalschlineInfo[$i]["DSRCode"]							=   $val_schline["DSRCode"];
					$finalschlineInfo[$i]["KD_Code"]							=   $val_schline["KD_Code"];
					$finalschlineInfo[$i]["DateVal"]							=   $val_schline["DateVal"];
					$finalschlineInfo[$i]["GPSVal"]								=   $val_schline["GPSVal"];
					$finalschlineInfo[$i]["CUSCODE"]							=   $val_schline["CUSCODE"];
					$finalschlineInfo[$i]["TRANSTYPE"]							=   $val_schline["TRANSTYPE"];
					$finalschlineInfo[$i]["TRANSNO"]							=   $val_schline["TRANSNO"];
					$finalschlineInfo[$i]["TRREFNO"]							=   $val_schline["TRREFNO"];
					$finalschlineInfo[$i]["CUR"]								=   $val_schline["CUR"];
					$finalschlineInfo[$i]["PRODLICNT"]							=   $val_schline["PRODLICNT"];
					$finalschlineInfo[$i]["TRANSVAL"]							=   $val_schline["TRANSVAL"];
					$finalschlineInfo[$i]["DIS"]								=   $val_schline["DIS"];
					$finalschlineInfo[$i]["DISVAL"]								=   $val_schline["DISVAL"];
					$finalschlineInfo[$i]["NETVAL"]								=   $val_schline["NETVAL"];
					$finalschlineInfo[$i]["COLVAL"]								=   $val_schline["COLVAL"];
					$finalschlineInfo[$i]["BALVAL"]								=   $val_schline["BALVAL"];					
					$i++;
				//}
			//}
		//} 
		
		/*else {

			echo "ieud<br>";
				$finalschlineInfo[$i]["HEDDES"]								=   '';
				$finalschlineInfo[$i]["HEDPRO"]								=   '';
				$finalschlineInfo[$i]["LINDES"]								=   '';
				$finalschlineInfo[$i]["LINPRO"]								=   '';

				$finalschlineInfo[$i]["TRANSLINO"]							=   $val_schline["TRANSLINO"];
				$finalschlineInfo[$i]["PRODCODE"]							=   $val_schline["PRODCODE"];
				$finalschlineInfo[$i]["UOM"]								=   $val_schline["UOM"];
				$finalschlineInfo[$i]["FOFLAG"]								=   $val_schline["FOFLAG"];
				$finalschlineInfo[$i]["FOCUSCNT"]							=	$val_schline["FOCUSCNT"];
				$finalschlineInfo[$i]["POSMFLAG"]							=   $val_schline["POSMFLAG"];
				$finalschlineInfo[$i]["PRODTYPE"]							=   $val_schline["PRODTYPE"];
				$finalschlineInfo[$i]["SCFLAG"]								=   $val_schline["SCFLAG"];
				$finalschlineInfo[$i]["SCCODE"]								=   $val_schline["SCCODE"];
				$finalschlineInfo[$i]["PRSCFLAG"]							=   $val_schline["PRSCFLAG"];
				$finalschlineInfo[$i]["ORQTY"]								=   $val_schline["ORQTY"];
				$finalschlineInfo[$i]["SOQTY"]								=   $val_schline["SOQTY"];
				$finalschlineInfo[$i]["PRICEVAL"]							=   $val_schline["PRICEVAL"];
				$finalschlineInfo[$i]["VALUEVAL"]							=   $val_schline["VALUEVAL"];
				$finalschlineInfo[$i]["DSRCode"]							=   $val_schline["DSRCode"];
				$finalschlineInfo[$i]["KD_Code"]							=   $val_schline["KD_Code"];
				$finalschlineInfo[$i]["DateVal"]							=   $val_schline["DateVal"];
				$finalschlineInfo[$i]["GPSVal"]								=   $val_schline["GPSVal"];
				$finalschlineInfo[$i]["CUSCODE"]							=   $val_schline["CUSCODE"];
				$finalschlineInfo[$i]["TRANSTYPE"]							=   $val_schline["TRANSTYPE"];
				$finalschlineInfo[$i]["TRANSNO"]							=   $val_schline["TRANSNO"];
				$finalschlineInfo[$i]["TRREFNO"]							=   $val_schline["TRREFNO"];
				$finalschlineInfo[$i]["CUR"]								=   $val_schline["CUR"];
				$finalschlineInfo[$i]["PRODLICNT"]							=   $val_schline["PRODLICNT"];
				$finalschlineInfo[$i]["TRANSVAL"]							=   $val_schline["TRANSVAL"];
				$finalschlineInfo[$i]["DIS"]								=   $val_schline["DIS"];
				$finalschlineInfo[$i]["DISVAL"]								=   $val_schline["DISVAL"];
				$finalschlineInfo[$i]["NETVAL"]								=   $val_schline["NETVAL"];
				$finalschlineInfo[$i]["COLVAL"]								=   $val_schline["COLVAL"];
				$finalschlineInfo[$i]["BALVAL"]								=   $val_schline["BALVAL"];					
				$i++;
		}*/
		$k++;
	}

	$finalSearchInfo          =   $finalschlineInfo;
	//pre($finalSearchInfo);
	//exit;

	//echo $kdcode_Total;
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
	foreach($finalSearchInfo as $val_kd) {
		//$transInfo[$val_transno["Transaction_Number"]]["Transaction_Number"];
		if($kdInfo[$val_kd["KD_Code"]]["KD_Code"] == $val_kd[KD_Code]) {                                     
			$finalkdInfo[$i]["KD_Name"]								=   $kdInfo[$val_kd["KD_Code"]]["KD_Name"];			
			$finalkdInfo[$i]["HEDDES"]								=   $val_kd["HEDDES"];
			$finalkdInfo[$i]["HEDPRO"]								=   $val_kd["HEDPRO"];
			$finalkdInfo[$i]["LINDES"]								=   $val_kd["LINDES"];
			$finalkdInfo[$i]["LINPRO"]								=   $val_kd["LINPRO"];

			$finalkdInfo[$i]["TRANSLINO"]							=   $val_kd["TRANSLINO"];
			$finalkdInfo[$i]["PRODCODE"]							=   $val_kd["PRODCODE"];
			$finalkdInfo[$i]["UOM"]									=   $val_kd["UOM"];
			$finalkdInfo[$i]["FOFLAG"]								=   $val_kd["FOFLAG"];
			$finalkdInfo[$i]["FOCUSCNT"]							=	$val_kd["FOCUSCNT"];
			$finalkdInfo[$i]["POSMFLAG"]							=   $val_kd["POSMFLAG"];
			$finalkdInfo[$i]["PRODTYPE"]							=   $val_kd["PRODTYPE"];
			$finalkdInfo[$i]["SCFLAG"]								=   $val_kd["SCFLAG"];
			$finalkdInfo[$i]["SCCODE"]								=   $val_kd["SCCODE"];
			$finalkdInfo[$i]["PRSCFLAG"]							=   $val_kd["PRSCFLAG"];
			$finalkdInfo[$i]["ORQTY"]								=   $val_kd["ORQTY"];
			$finalkdInfo[$i]["SOQTY"]								=   $val_kd["SOQTY"];
			$finalkdInfo[$i]["PRICEVAL"]							=   $val_kd["PRICEVAL"];
			$finalkdInfo[$i]["VALUEVAL"]							=   $val_kd["VALUEVAL"];
			$finalkdInfo[$i]["DSRCode"]								=   $val_kd["DSRCode"];
			$finalkdInfo[$i]["KD_Code"]								=   $val_kd["KD_Code"];
			$finalkdInfo[$i]["DateVal"]								=   $val_kd["DateVal"];
			$finalkdInfo[$i]["GPSVal"]								=   $val_kd["GPSVal"];
			$finalkdInfo[$i]["CUSCODE"]								=   $val_kd["CUSCODE"];
			$finalkdInfo[$i]["TRANSTYPE"]							=   $val_kd["TRANSTYPE"];
			$finalkdInfo[$i]["TRANSNO"]								=   $val_kd["TRANSNO"];
			$finalkdInfo[$i]["TRREFNO"]								=   $val_kd["TRREFNO"];
			$finalkdInfo[$i]["CUR"]									=   $val_kd["CUR"];
			$finalkdInfo[$i]["PRODLICNT"]							=   $val_kd["PRODLICNT"];
			$finalkdInfo[$i]["TRANSVAL"]							=   $val_kd["TRANSVAL"];
			$finalkdInfo[$i]["DIS"]									=   $val_kd["DIS"];
			$finalkdInfo[$i]["DISVAL"]								=   $val_kd["DISVAL"];
			$finalkdInfo[$i]["NETVAL"]								=   $val_kd["NETVAL"];
			$finalkdInfo[$i]["COLVAL"]								=   $val_kd["COLVAL"];
			$finalkdInfo[$i]["BALVAL"]								=   $val_kd["BALVAL"];	
			$i++;
		}
		$k++;
	}

	$finalSearchInfo          =   $finalkdInfo;
	//pre($finalSearchInfo);
	//exit;

	$query_dsr										=   "SELECT DSRName,DSR_Code FROM dsr WHERE DSR_Code IN ('".$dsrcode_Total."')";
	//echo $query_dsr;
	//exit;
	$res_dsr										=   mysql_query($query_dsr);
	while($row_dsr									=   mysql_fetch_assoc($res_dsr)) {
		$dsrInfo[$row_dsr["DSR_Code"]]				=	$row_dsr;
		$asmcode_dsr[]								=	$row_dsr["ASM"];
	}	
	//pre($dsrInfo);
	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_dsr){
		//echo $dsrInfo[$val_dsr["DSRCode"]]["DSR_Code"] . "-". $val_dsr["DSRCode"]."<br>";
		if($dsrInfo[$val_dsr["DSRCode"]]["DSR_Code"] == $val_dsr["DSRCode"]) {                                    
			$finaldsrInfo[$i]["DSRName"]							=   $dsrInfo[$val_dsr["DSRCode"]]["DSRName"];

			$finaldsrInfo[$i]["KD_Name"]							=   $val_dsr["KD_Name"];			
			$finaldsrInfo[$i]["HEDDES"]								=   $val_dsr["HEDDES"];
			$finaldsrInfo[$i]["HEDPRO"]								=   $val_dsr["HEDPRO"];
			$finaldsrInfo[$i]["LINDES"]								=   $val_dsr["LINDES"];
			$finaldsrInfo[$i]["LINPRO"]								=   $val_dsr["LINPRO"];

			$finaldsrInfo[$i]["TRANSLINO"]							=   $val_dsr["TRANSLINO"];
			$finaldsrInfo[$i]["PRODCODE"]							=   $val_dsr["PRODCODE"];
			$finaldsrInfo[$i]["UOM"]								=   $val_dsr["UOM"];
			$finaldsrInfo[$i]["FOFLAG"]								=   $val_dsr["FOFLAG"];
			$finaldsrInfo[$i]["FOCUSCNT"]							=	$val_dsr["FOCUSCNT"];
			$finaldsrInfo[$i]["POSMFLAG"]							=   $val_dsr["POSMFLAG"];
			$finaldsrInfo[$i]["PRODTYPE"]							=   $val_dsr["PRODTYPE"];
			$finaldsrInfo[$i]["SCFLAG"]								=   $val_dsr["SCFLAG"];
			$finaldsrInfo[$i]["SCCODE"]								=   $val_dsr["SCCODE"];
			$finaldsrInfo[$i]["PRSCFLAG"]							=   $val_dsr["PRSCFLAG"];
			$finaldsrInfo[$i]["ORQTY"]								=   $val_dsr["ORQTY"];
			$finaldsrInfo[$i]["SOQTY"]								=   $val_dsr["SOQTY"];
			$finaldsrInfo[$i]["PRICEVAL"]							=   $val_dsr["PRICEVAL"];
			$finaldsrInfo[$i]["VALUEVAL"]							=   $val_dsr["VALUEVAL"];
			$finaldsrInfo[$i]["DSRCode"]							=   $val_dsr["DSRCode"];
			$finaldsrInfo[$i]["KD_Code"]							=   $val_dsr["KD_Code"];
			$finaldsrInfo[$i]["DateVal"]							=   $val_dsr["DateVal"];
			$finaldsrInfo[$i]["GPSVal"]								=   $val_dsr["GPSVal"];
			$finaldsrInfo[$i]["CUSCODE"]							=   $val_dsr["CUSCODE"];
			$finaldsrInfo[$i]["TRANSTYPE"]							=   $val_dsr["TRANSTYPE"];
			$finaldsrInfo[$i]["TRANSNO"]							=   $val_dsr["TRANSNO"];
			$finaldsrInfo[$i]["TRREFNO"]							=   $val_dsr["TRREFNO"];
			$finaldsrInfo[$i]["CUR"]								=   $val_dsr["CUR"];
			$finaldsrInfo[$i]["PRODLICNT"]							=   $val_dsr["PRODLICNT"];
			$finaldsrInfo[$i]["TRANSVAL"]							=   $val_dsr["TRANSVAL"];
			$finaldsrInfo[$i]["DIS"]								=   $val_dsr["DIS"];
			$finaldsrInfo[$i]["DISVAL"]								=   $val_dsr["DISVAL"];
			$finaldsrInfo[$i]["NETVAL"]								=   $val_dsr["NETVAL"];
			$finaldsrInfo[$i]["COLVAL"]								=   $val_dsr["COLVAL"];
			$finaldsrInfo[$i]["BALVAL"]								=   $val_dsr["BALVAL"];	
			$i++;
		}
		$k++;
	}

	$finalSearchInfo          =   $finaldsrInfo;
	//pre($finalSearchInfo);
	//exit;

	$query_cusname									=   "SELECT id,Customer_Name,customer_code,customer_type FROM customer WHERE customer_code IN ('".$cuscode_Total."')";
	//echo $query_cusname;
	//exit;
	$res_cusname									=   mysql_query($query_cusname);
	while($row_cusname								=   mysql_fetch_assoc($res_cusname)) {
		$cusInfo[$row_cusname["customer_code"]]		=	$row_cusname;
		$custype_cus[]								=	$row_cusname["customer_type"];
	}
	
	$custype_Total									=	implode("','",$custype_cus);

	//pre($cusInfo);
	//echo $custype_Total;
	//exit;
	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_cusname){
		//echo $cusInfo[$val_cusname["CUSCODE"]]["customer_code"] . "==". $val_cusname["CUSCODE"]."<br>";
		if($cusInfo[$val_cusname["CUSCODE"]]["customer_code"] == $val_cusname["CUSCODE"]) {                                     
			
			$finalcusInfo[$i]["CUSNAME"]							=   $cusInfo[$val_cusname["CUSCODE"]]["Customer_Name"];
			$finalcusInfo[$i]["CUSTYPE"]							=   $cusInfo[$val_cusname["CUSCODE"]]["customer_type"];
			$finalcusInfo[$i]["DSRName"]							=   $val_cusname["DSRName"];
			$finalcusInfo[$i]["KD_Name"]							=   $val_cusname["KD_Name"];
			
			$finalcusInfo[$i]["HEDDES"]								=   $val_cusname["HEDDES"];
			$finalcusInfo[$i]["HEDPRO"]								=   $val_cusname["HEDPRO"];
			$finalcusInfo[$i]["LINDES"]								=   $val_cusname["LINDES"];
			$finalcusInfo[$i]["LINPRO"]								=   $val_cusname["LINPRO"];

			$finalcusInfo[$i]["TRANSLINO"]							=   $val_cusname["TRANSLINO"];
			$finalcusInfo[$i]["PRODCODE"]							=   $val_cusname["PRODCODE"];
			$finalcusInfo[$i]["UOM"]								=   $val_cusname["UOM"];
			$finalcusInfo[$i]["FOFLAG"]								=   $val_cusname["FOFLAG"];
			$finalcusInfo[$i]["FOCUSCNT"]							=   $val_cusname["FOCUSCNT"];

			$finalcusInfo[$i]["POSMFLAG"]							=   $val_cusname["POSMFLAG"];
			$finalcusInfo[$i]["PRODTYPE"]							=   $val_cusname["PRODTYPE"];
			$finalcusInfo[$i]["SCFLAG"]								=   $val_cusname["SCFLAG"];
			$finalcusInfo[$i]["SCCODE"]								=   $val_cusname["SCCODE"];
			$finalcusInfo[$i]["PRSCFLAG"]							=   $val_cusname["PRSCFLAG"];
			$finalcusInfo[$i]["ORQTY"]								=   $val_cusname["ORQTY"];
			$finalcusInfo[$i]["SOQTY"]								=   $val_cusname["SOQTY"];
			$finalcusInfo[$i]["PRICEVAL"]							=   $val_cusname["PRICEVAL"];
			$finalcusInfo[$i]["VALUEVAL"]							=   $val_cusname["VALUEVAL"];
			$finalcusInfo[$i]["DSRCode"]							=   $val_cusname["DSRCode"];
			$finalcusInfo[$i]["KD_Code"]							=   $val_cusname["KD_Code"];
			$finalcusInfo[$i]["DateVal"]							=   $val_cusname["DateVal"];
			$finalcusInfo[$i]["GPSVal"]								=   $val_cusname["GPSVal"];
			$finalcusInfo[$i]["CUSCODE"]							=   $val_cusname["CUSCODE"];
			$finalcusInfo[$i]["TRANSTYPE"]							=   $val_cusname["TRANSTYPE"];
			$finalcusInfo[$i]["TRANSNO"]							=   $val_cusname["TRANSNO"];
			$finalcusInfo[$i]["TRREFNO"]							=   $val_cusname["TRREFNO"];
			$finalcusInfo[$i]["CUR"]								=   $val_cusname["CUR"];
			$finalcusInfo[$i]["PRODLICNT"]							=   $val_cusname["PRODLICNT"];
			$finalcusInfo[$i]["TRANSVAL"]							=   $val_cusname["TRANSVAL"];
			$finalcusInfo[$i]["DIS"]								=   $val_cusname["DIS"];
			$finalcusInfo[$i]["DISVAL"]								=   $val_cusname["DISVAL"];
			$finalcusInfo[$i]["NETVAL"]								=   $val_cusname["NETVAL"];
			$finalcusInfo[$i]["COLVAL"]								=   $val_cusname["COLVAL"];
			$finalcusInfo[$i]["BALVAL"]								=   $val_cusname["BALVAL"];									
			$i++;
		}
		$k++;
	}

	$finalSearchInfo          =   $finalcusInfo;
	//pre($finalSearchInfo);
	//exit;	

	/*if($cuscode	==	'') {

	} elseif($cuscode	!=	'') {
		$Custypestr		=	implode(",",$cuscode);
		//echo $Custypestr."<br>";

		foreach($finalSearchInfo AS $val_custypekey=>$val_custypecheck)  {
			//pre($val_custypecheck);
			//pre($val_custypekey);
			if(!strstr($Custypestr,$val_custypecheck[Customer_code])) {
				unset($finalSearchInfo[$val_custypekey]);
			} else {
				$custype_val[]			=	$val_custypecheck[customer_type];
			}
		}
	}
	
	if($cuscode	==	'') {
		$custypewhere			=	'';
	} else {
		$custype_val			=	array_unique($custype_val);
		$custype_Total			=	implode("','",$custype_val);
		$custypewhere			=	"WHERE id IN ('".$custype_Total."')";
	}*/
	
	//pre($dateval_Total);
	//pre($finalSearchInfo);
	//exit;

	$query_custype									=   "SELECT id,customer_type FROM customer_type WHERE id IN  ('".$custype_Total."')";
	$res_custype									=   mysql_query($query_custype);
	while($row_custype								=   mysql_fetch_assoc($res_custype)) {
		$custypeInfo[$row_custype["id"]]			=	$row_custype;
	}
	
	//pre($custypeInfo);
	//exit;

	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_custype){
		//echo $custypeInfo[$val_custype["customer_type"]]["id"] . "++++++" . $val_custype["customer_type"]."<br>";
		if($custypeInfo[$val_custype["CUSTYPE"]]["id"] == $val_custype["CUSTYPE"]) {     
			
			$finalcustypeInfo[$i]["CUSTYNAME"]							=   $custypeInfo[$val_custype["CUSTYPE"]]["customer_type"];
			$finalcustypeInfo[$i]["CUSNAME"]							=   $val_custype["CUSNAME"];
			$finalcustypeInfo[$i]["CUSTYPE"]							=   $val_custype["CUSTYPE"];
			$finalcustypeInfo[$i]["DSRName"]							=   $val_custype["DSRName"];
			$finalcustypeInfo[$i]["KD_Name"]							=   $val_custype["KD_Name"];
			
			$finalcustypeInfo[$i]["HEDDES"]								=   $val_custype["HEDDES"];
			$finalcustypeInfo[$i]["HEDPRO"]								=   $val_custype["HEDPRO"];
			$finalcustypeInfo[$i]["LINDES"]								=   $val_custype["LINDES"];
			$finalcustypeInfo[$i]["LINPRO"]								=   $val_custype["LINPRO"];

			$finalcustypeInfo[$i]["TRANSLINO"]							=   $val_custype["TRANSLINO"];
			$finalcustypeInfo[$i]["PRODCODE"]							=   $val_custype["PRODCODE"];
			$finalcustypeInfo[$i]["UOM"]								=   $val_custype["UOM"];
			$finalcustypeInfo[$i]["FOFLAG"]								=   $val_custype["FOFLAG"];
			$finalcustypeInfo[$i]["FOCUSCNT"]							=   $val_custype["FOCUSCNT"];
			$finalcustypeInfo[$i]["POSMFLAG"]							=   $val_custype["POSMFLAG"];
			$finalcustypeInfo[$i]["PRODTYPE"]							=   $val_custype["PRODTYPE"];
			$finalcustypeInfo[$i]["SCFLAG"]								=   $val_custype["SCFLAG"];
			$finalcustypeInfo[$i]["SCCODE"]								=   $val_custype["SCCODE"];
			$finalcustypeInfo[$i]["PRSCFLAG"]							=   $val_custype["PRSCFLAG"];
			$finalcustypeInfo[$i]["ORQTY"]								=   $val_custype["ORQTY"];
			$finalcustypeInfo[$i]["SOQTY"]								=   $val_custype["SOQTY"];
			$finalcustypeInfo[$i]["PRICEVAL"]							=   $val_custype["PRICEVAL"];
			$finalcustypeInfo[$i]["VALUEVAL"]							=   $val_custype["VALUEVAL"];
			$finalcustypeInfo[$i]["DSRCode"]							=   $val_custype["DSRCode"];
			$finalcustypeInfo[$i]["KD_Code"]							=   $val_custype["KD_Code"];
			$finalcustypeInfo[$i]["DateVal"]							=   $val_custype["DateVal"];
			$finalcustypeInfo[$i]["GPSVal"]								=   $val_custype["GPSVal"];
			$finalcustypeInfo[$i]["CUSCODE"]							=   $val_custype["CUSCODE"];
			$finalcustypeInfo[$i]["TRANSTYPE"]							=   $val_custype["TRANSTYPE"];
			$finalcustypeInfo[$i]["TRANSNO"]							=   $val_custype["TRANSNO"];
			$finalcustypeInfo[$i]["TRREFNO"]							=   $val_custype["TRREFNO"];
			$finalcustypeInfo[$i]["CUR"]								=   $val_custype["CUR"];
			$finalcustypeInfo[$i]["PRODLICNT"]							=   $val_custype["PRODLICNT"];
			$finalcustypeInfo[$i]["TRANSVAL"]							=   $val_custype["TRANSVAL"];
			$finalcustypeInfo[$i]["DIS"]								=   $val_custype["DIS"];
			$finalcustypeInfo[$i]["DISVAL"]								=   $val_custype["DISVAL"];
			$finalcustypeInfo[$i]["NETVAL"]								=   $val_custype["NETVAL"];
			$finalcustypeInfo[$i]["COLVAL"]								=   $val_custype["COLVAL"];
			$finalcustypeInfo[$i]["BALVAL"]								=   $val_custype["BALVAL"];
			$prod_code[]												=	$finalcustypeInfo[$i]["PRODCODE"];
			$i++;
		}
		$k++;
	}

	$finalSearchInfo          =   $finalcustypeInfo;
	//pre($finalSearchInfo);
	//exit;

	$prod_code				=	array_unique($prod_code);
	$prodcode_Total			=	implode("','",$prod_code);


	
	$query_product									=   "SELECT Product_code,Product_description1 FROM product WHERE Product_code IN  ('".$prodcode_Total."')";
	$res_product									=   mysql_query($query_product);
	while($row_product								=   mysql_fetch_assoc($res_product)) {
		$productInfo[$row_product["Product_code"]]			=	$row_product;
	}
	
	//pre($custypeInfo);
	//exit;

	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_product){
		//echo $custypeInfo[$val_custype["customer_type"]]["id"] . "++++++" . $val_custype["customer_type"]."<br>";
		if($productInfo[$val_product["PRODCODE"]]["Product_code"] == $val_product["PRODCODE"]) {     
			
			$finalproductInfo[$i]["PRODNAME"]							=   $productInfo[$val_product["PRODCODE"]]["Product_description1"];
			$finalproductInfo[$i]["CUSTYNAME"]							=   $val_product["CUSTYNAME"];
			$finalproductInfo[$i]["CUSNAME"]							=   $val_product["CUSNAME"];
			$finalproductInfo[$i]["CUSTYPE"]							=   $val_product["CUSTYPE"];
			$finalproductInfo[$i]["DSRName"]							=   $val_product["DSRName"];
			$finalproductInfo[$i]["KD_Name"]							=   $val_product["KD_Name"];
			
			$finalproductInfo[$i]["HEDDES"]								=   $val_product["HEDDES"];
			$finalproductInfo[$i]["HEDPRO"]								=   $val_product["HEDPRO"];
			$finalproductInfo[$i]["LINDES"]								=   $val_product["LINDES"];
			$finalproductInfo[$i]["LINPRO"]								=   $val_product["LINPRO"];

			$finalproductInfo[$i]["TRANSLINO"]							=   $val_product["TRANSLINO"];
			$finalproductInfo[$i]["PRODCODE"]							=   $val_product["PRODCODE"];
			$finalproductInfo[$i]["UOM"]								=   $val_product["UOM"];
			$finalproductInfo[$i]["FOFLAG"]								=   $val_product["FOFLAG"];
			$finalproductInfo[$i]["FOCUSCNT"]							=   $val_product["FOCUSCNT"];
			$finalproductInfo[$i]["POSMFLAG"]							=   $val_product["POSMFLAG"];
			$finalproductInfo[$i]["PRODTYPE"]							=   $val_product["PRODTYPE"];
			$finalproductInfo[$i]["SCFLAG"]								=   $val_product["SCFLAG"];
			$finalproductInfo[$i]["SCCODE"]								=   $val_product["SCCODE"];
			$finalproductInfo[$i]["PRSCFLAG"]							=   $val_product["PRSCFLAG"];
			$finalproductInfo[$i]["ORQTY"]								=   $val_product["ORQTY"];
			$finalproductInfo[$i]["SOQTY"]								=   $val_product["SOQTY"];
			$finalproductInfo[$i]["PRICEVAL"]							=   $val_product["PRICEVAL"];
			$finalproductInfo[$i]["VALUEVAL"]							=   $val_product["VALUEVAL"];
			$finalproductInfo[$i]["DSRCode"]							=   $val_product["DSRCode"];
			$finalproductInfo[$i]["KD_Code"]							=   $val_product["KD_Code"];
			$finalproductInfo[$i]["DateVal"]							=   $val_product["DateVal"];
			$finalproductInfo[$i]["GPSVal"]								=   $val_product["GPSVal"];
			$finalproductInfo[$i]["CUSCODE"]							=   $val_product["CUSCODE"];
			$finalproductInfo[$i]["TRANSTYPE"]							=   $val_product["TRANSTYPE"];
			$finalproductInfo[$i]["TRANSNO"]							=   $val_product["TRANSNO"];
			$finalproductInfo[$i]["TRREFNO"]							=   $val_product["TRREFNO"];
			$finalproductInfo[$i]["CUR"]								=   $val_product["CUR"];
			$finalproductInfo[$i]["PRODLICNT"]							=   $val_product["PRODLICNT"];
			$finalproductInfo[$i]["TRANSVAL"]							=   $val_product["TRANSVAL"];
			$finalproductInfo[$i]["DIS"]								=   $val_product["DIS"];
			$finalproductInfo[$i]["DISVAL"]								=   $val_product["DISVAL"];
			$finalproductInfo[$i]["NETVAL"]								=   $val_product["NETVAL"];
			$finalproductInfo[$i]["COLVAL"]								=   $val_product["COLVAL"];
			$finalproductInfo[$i]["BALVAL"]								=   $val_product["BALVAL"];			
		} else {
			$finalproductInfo[$i]["CUSTYNAME"]							=   $val_product["CUSTYNAME"];
			$finalproductInfo[$i]["CUSNAME"]							=   $val_product["CUSNAME"];
			$finalproductInfo[$i]["CUSTYPE"]							=   $val_product["CUSTYPE"];
			$finalproductInfo[$i]["DSRName"]							=   $val_product["DSRName"];
			$finalproductInfo[$i]["KD_Name"]							=   $val_product["KD_Name"];
			
			$finalproductInfo[$i]["HEDDES"]								=   $val_product["HEDDES"];
			$finalproductInfo[$i]["HEDPRO"]								=   $val_product["HEDPRO"];
			$finalproductInfo[$i]["LINDES"]								=   $val_product["LINDES"];
			$finalproductInfo[$i]["LINPRO"]								=   $val_product["LINPRO"];

			$finalproductInfo[$i]["TRANSLINO"]							=   $val_product["TRANSLINO"];
			$finalproductInfo[$i]["PRODCODE"]							=   $val_product["PRODCODE"];
			$finalproductInfo[$i]["UOM"]								=   $val_product["UOM"];
			$finalproductInfo[$i]["FOFLAG"]								=   $val_product["FOFLAG"];
			$finalproductInfo[$i]["FOCUSCNT"]							=   $val_product["FOCUSCNT"];
			$finalproductInfo[$i]["POSMFLAG"]							=   $val_product["POSMFLAG"];
			$finalproductInfo[$i]["PRODTYPE"]							=   $val_product["PRODTYPE"];
			$finalproductInfo[$i]["SCFLAG"]								=   $val_product["SCFLAG"];
			$finalproductInfo[$i]["SCCODE"]								=   $val_product["SCCODE"];
			$finalproductInfo[$i]["PRSCFLAG"]							=   $val_product["PRSCFLAG"];
			$finalproductInfo[$i]["ORQTY"]								=   $val_product["ORQTY"];
			$finalproductInfo[$i]["SOQTY"]								=   $val_product["SOQTY"];
			$finalproductInfo[$i]["PRICEVAL"]							=   $val_product["PRICEVAL"];
			$finalproductInfo[$i]["VALUEVAL"]							=   $val_product["VALUEVAL"];
			$finalproductInfo[$i]["DSRCode"]							=   $val_product["DSRCode"];
			$finalproductInfo[$i]["KD_Code"]							=   $val_product["KD_Code"];
			$finalproductInfo[$i]["DateVal"]							=   $val_product["DateVal"];
			$finalproductInfo[$i]["GPSVal"]								=   $val_product["GPSVal"];
			$finalproductInfo[$i]["CUSCODE"]							=   $val_product["CUSCODE"];
			$finalproductInfo[$i]["TRANSTYPE"]							=   $val_product["TRANSTYPE"];
			$finalproductInfo[$i]["TRANSNO"]							=   $val_product["TRANSNO"];
			$finalproductInfo[$i]["TRREFNO"]							=   $val_product["TRREFNO"];
			$finalproductInfo[$i]["CUR"]								=   $val_product["CUR"];
			$finalproductInfo[$i]["PRODLICNT"]							=   $val_product["PRODLICNT"];
			$finalproductInfo[$i]["TRANSVAL"]							=   $val_product["TRANSVAL"];
			$finalproductInfo[$i]["DIS"]								=   $val_product["DIS"];
			$finalproductInfo[$i]["DISVAL"]								=   $val_product["DISVAL"];
			$finalproductInfo[$i]["NETVAL"]								=   $val_product["NETVAL"];
			$finalproductInfo[$i]["COLVAL"]								=   $val_product["COLVAL"];
			$finalproductInfo[$i]["BALVAL"]								=   $val_product["BALVAL"];			
		}

		$i++;
		$k++;
	}

	$finalSearchInfo          =   $finalproductInfo;
	//pre($finalSearchInfo);
	//exit;


	$query_product									=   "SELECT Product_code,Product_description1 FROM customertype_product WHERE Product_code IN  ('".$prodcode_Total."')";
	$res_product									=   mysql_query($query_product);
	while($row_product								=   mysql_fetch_assoc($res_product)) {
		$productInfoAnot[$row_product["Product_code"]]			=	$row_product;
	}
	
	//pre($custypeInfo);
	//exit;



	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_product){
		//echo $custypeInfo[$val_custype["customer_type"]]["id"] . "++++++" . $val_custype["customer_type"]."<br>";
		if($productInfoAnot[$val_product["PRODCODE"]]["Product_code"] == $val_product["PRODCODE"]) {			
			$finalproductInfo[$i]["PRODNAME"]							=   $productInfoAnot[$val_product["PRODCODE"]]["Product_description1"];
			$finalproductInfo[$i]["CUSTYNAME"]							=   $val_product["CUSTYNAME"];
			$finalproductInfo[$i]["CUSNAME"]							=   $val_product["CUSNAME"];
			$finalproductInfo[$i]["CUSTYPE"]							=   $val_product["CUSTYPE"];
			$finalproductInfo[$i]["DSRName"]							=   $val_product["DSRName"];
			$finalproductInfo[$i]["KD_Name"]							=   $val_product["KD_Name"];
			
			$finalproductInfo[$i]["HEDDES"]								=   $val_product["HEDDES"];
			$finalproductInfo[$i]["HEDPRO"]								=   $val_product["HEDPRO"];
			$finalproductInfo[$i]["LINDES"]								=   $val_product["LINDES"];
			$finalproductInfo[$i]["LINPRO"]								=   $val_product["LINPRO"];

			$finalproductInfo[$i]["TRANSLINO"]							=   $val_product["TRANSLINO"];
			$finalproductInfo[$i]["PRODCODE"]							=   $val_product["PRODCODE"];
			$finalproductInfo[$i]["UOM"]								=   $val_product["UOM"];
			$finalproductInfo[$i]["FOFLAG"]								=   $val_product["FOFLAG"];
			$finalproductInfo[$i]["FOCUSCNT"]							=   $val_product["FOCUSCNT"];
			$finalproductInfo[$i]["POSMFLAG"]							=   $val_product["POSMFLAG"];
			$finalproductInfo[$i]["PRODTYPE"]							=   $val_product["PRODTYPE"];
			$finalproductInfo[$i]["SCFLAG"]								=   $val_product["SCFLAG"];
			$finalproductInfo[$i]["SCCODE"]								=   $val_product["SCCODE"];
			$finalproductInfo[$i]["PRSCFLAG"]							=   $val_product["PRSCFLAG"];
			$finalproductInfo[$i]["ORQTY"]								=   $val_product["ORQTY"];
			$finalproductInfo[$i]["SOQTY"]								=   $val_product["SOQTY"];
			$finalproductInfo[$i]["PRICEVAL"]							=   $val_product["PRICEVAL"];
			$finalproductInfo[$i]["VALUEVAL"]							=   $val_product["VALUEVAL"];
			$finalproductInfo[$i]["DSRCode"]							=   $val_product["DSRCode"];
			$finalproductInfo[$i]["KD_Code"]							=   $val_product["KD_Code"];
			$finalproductInfo[$i]["DateVal"]							=   $val_product["DateVal"];
			$finalproductInfo[$i]["GPSVal"]								=   $val_product["GPSVal"];
			$finalproductInfo[$i]["CUSCODE"]							=   $val_product["CUSCODE"];
			$finalproductInfo[$i]["TRANSTYPE"]							=   $val_product["TRANSTYPE"];
			$finalproductInfo[$i]["TRANSNO"]							=   $val_product["TRANSNO"];
			$finalproductInfo[$i]["TRREFNO"]							=   $val_product["TRREFNO"];
			$finalproductInfo[$i]["CUR"]								=   $val_product["CUR"];
			$finalproductInfo[$i]["PRODLICNT"]							=   $val_product["PRODLICNT"];
			$finalproductInfo[$i]["TRANSVAL"]							=   $val_product["TRANSVAL"];
			$finalproductInfo[$i]["DIS"]								=   $val_product["DIS"];
			$finalproductInfo[$i]["DISVAL"]								=   $val_product["DISVAL"];
			$finalproductInfo[$i]["NETVAL"]								=   $val_product["NETVAL"];
			$finalproductInfo[$i]["COLVAL"]								=   $val_product["COLVAL"];
			$finalproductInfo[$i]["BALVAL"]								=   $val_product["BALVAL"];			
		} else {			
			$finalproductInfo[$i]["PRODNAME"]							=   $val_product["PRODNAME"];
			$finalproductInfo[$i]["CUSTYNAME"]							=   $val_product["CUSTYNAME"];
			$finalproductInfo[$i]["CUSNAME"]							=   $val_product["CUSNAME"];
			$finalproductInfo[$i]["CUSTYPE"]							=   $val_product["CUSTYPE"];
			$finalproductInfo[$i]["DSRName"]							=   $val_product["DSRName"];
			$finalproductInfo[$i]["KD_Name"]							=   $val_product["KD_Name"];
			
			$finalproductInfo[$i]["HEDDES"]								=   $val_product["HEDDES"];
			$finalproductInfo[$i]["HEDPRO"]								=   $val_product["HEDPRO"];
			$finalproductInfo[$i]["LINDES"]								=   $val_product["LINDES"];
			$finalproductInfo[$i]["LINPRO"]								=   $val_product["LINPRO"];

			$finalproductInfo[$i]["TRANSLINO"]							=   $val_product["TRANSLINO"];
			$finalproductInfo[$i]["PRODCODE"]							=   $val_product["PRODCODE"];
			$finalproductInfo[$i]["UOM"]								=   $val_product["UOM"];
			$finalproductInfo[$i]["FOFLAG"]								=   $val_product["FOFLAG"];
			$finalproductInfo[$i]["FOCUSCNT"]							=   $val_product["FOCUSCNT"];
			$finalproductInfo[$i]["POSMFLAG"]							=   $val_product["POSMFLAG"];
			$finalproductInfo[$i]["PRODTYPE"]							=   $val_product["PRODTYPE"];
			$finalproductInfo[$i]["SCFLAG"]								=   $val_product["SCFLAG"];
			$finalproductInfo[$i]["SCCODE"]								=   $val_product["SCCODE"];
			$finalproductInfo[$i]["PRSCFLAG"]							=   $val_product["PRSCFLAG"];
			$finalproductInfo[$i]["ORQTY"]								=   $val_product["ORQTY"];
			$finalproductInfo[$i]["SOQTY"]								=   $val_product["SOQTY"];
			$finalproductInfo[$i]["PRICEVAL"]							=   $val_product["PRICEVAL"];
			$finalproductInfo[$i]["VALUEVAL"]							=   $val_product["VALUEVAL"];
			$finalproductInfo[$i]["DSRCode"]							=   $val_product["DSRCode"];
			$finalproductInfo[$i]["KD_Code"]							=   $val_product["KD_Code"];
			$finalproductInfo[$i]["DateVal"]							=   $val_product["DateVal"];
			$finalproductInfo[$i]["GPSVal"]								=   $val_product["GPSVal"];
			$finalproductInfo[$i]["CUSCODE"]							=   $val_product["CUSCODE"];
			$finalproductInfo[$i]["TRANSTYPE"]							=   $val_product["TRANSTYPE"];
			$finalproductInfo[$i]["TRANSNO"]							=   $val_product["TRANSNO"];
			$finalproductInfo[$i]["TRREFNO"]							=   $val_product["TRREFNO"];
			$finalproductInfo[$i]["CUR"]								=   $val_product["CUR"];
			$finalproductInfo[$i]["PRODLICNT"]							=   $val_product["PRODLICNT"];
			$finalproductInfo[$i]["TRANSVAL"]							=   $val_product["TRANSVAL"];
			$finalproductInfo[$i]["DIS"]								=   $val_product["DIS"];
			$finalproductInfo[$i]["DISVAL"]								=   $val_product["DISVAL"];
			$finalproductInfo[$i]["NETVAL"]								=   $val_product["NETVAL"];
			$finalproductInfo[$i]["COLVAL"]								=   $val_product["COLVAL"];
			$finalproductInfo[$i]["BALVAL"]								=   $val_product["BALVAL"];			
		}
		$i++;
		$k++;
	}

	$finalSearchInfo          =   $finalproductInfo;
	//pre($finalSearchInfo);
	//exit;


	$orderbycolumns     =   'TRANSNO';
	$orderbysorting     =   'ASC';

	if($orderbysorting == 'DESC') {
		$dir        =   'arsort';               
	} else {
		$dir        =   'asort';   
	}
	$finalSearchInfo	=	subval_sort($finalSearchInfo,$orderbycolumns,$dir);
	//pre($finalSearchInfo);
	//exit;

	$finalSearchInfo	=	array_multi_sort($finalSearchInfo, "TRANSNO","TRANSLINO", $order=SORT_ASC);
	//$finalSearchInfo	=	array_multi_sort_three($finalSearchInfo, "TRANSNO","TRANSLINO","PRODCODE", $order=SORT_ASC);
	//pre($finalSearchInfo);
	//exit;
} else {
	$nextrecval			=	"";
}
$num_rows		=	count($finalSearchInfo);
?>
  <table border="1" width="100%" style="border-collapse:collapse">
	<thead>
	  <tr>
		<th align="center" style="width:10%">Date</th>
		<th align="center" style="width:10%">KD</th>
		<th align="center" style="width:10%">SR</th>
		<th align="center" style="width:10%">Tran Type</th>
		<th align="center" style="width:10%">Tran Number</th>
		<th align="center" style="width:10%">Customer</th>
		<th align="center" style="width:10%">Type</th>
		<th align="center" style="width:10%">GPS</th>
		<th align="center" style="width:10%">Line Count</th>
		<th align="center" style="width:10%">Focus Count</th>
		<th align="center" style="width:10%">Scheme Count</th>
		<th align="center" style="width:10%">Value</th>
		<th align="center" style="width:10%">Discount</th>
		<th align="center" style="width:10%">Currency</th>
		<th align="center" style="width:10%">Net Value</th>
		<th align="center" style="width:10%">Collection</th>
		<th align="center" style="width:10%">Balance Due</th>
		<th align="center" style="width:10%" nowrap="nowrap">Product</th>
		<th align="center" style="width:10%">Type</th>
		<th align="center" style="width:10%" nowrap="nowrap">Scheme Header</th>
		<th align="center" style="width:10%">Stock</th>
		<th align="center" style="width:10%">Sale/Return</th>
		<th align="center" style="width:10%">Price</th>
		<th align="center" style="width:10%">Value</th>
		<th align="center" style="width:10%" nowrap="nowrap">Scheme Line</th>  
  </tr>
  </thead>
 <tbody>
<?php 
	if($num_rows > 0) {
	foreach($finalSearchInfo AS $SearchKey=>$SearchVal) { 
		$Transaction_Number			=	$SearchVal["TRANSNO"];
		$Transaction_type			=	$SearchVal["TRANSTYPE"];
		$TRANSLINO					=	$SearchVal["TRANSLINO"];
?>
<tr>
	 <td ><?php 
	if($TRANSLINO == 1) {
		echo $SearchVal[DateVal]; 
	}	
	?></td>
	 <td ><?php if($TRANSLINO == 1) {
			echo ucwords(strtolower($SearchVal[KD_Name]));
		} ?></td>
	 <td ><?php if($TRANSLINO == 1) {
				echo ucwords(strtolower($SearchVal[DSRName]));
			}	?></td>
	 <td ><?php if($TRANSLINO == 1) {
				if($Transaction_type == 1) {
					echo "No Sales";
				} else if($Transaction_type == 2) {
					echo "Sales";
				} else if($Transaction_type == 3) {
					echo "Cancelled";
				} else if($Transaction_type == 4) {
					echo "Return";
				} else if($Transaction_type == 5) {
					echo "Receipt";
				} 
			}
	?></td>
	 <td><?php if($TRANSLINO == 1) {
			echo $Transaction_Number;
			} ?></td>
	 <td><?php if($TRANSLINO == 1) { 
			echo ucwords(strtolower($SearchVal[CUSNAME]));
		   } ?></td>
	 <td><?php if($TRANSLINO == 1) { 
			 echo ucwords(strtolower($SearchVal[CUSTYNAME])); 
		   }  ?></td>
	 <td><?php if($TRANSLINO == 1) { 
			echo $SearchVal[GPSVal];
		   } ?></td>
	 <td><?php if($TRANSLINO == 1) { echo $SearchVal[PRODLICNT];
		   } ?></td>	
	 <td><?php 
	 /*if($SearchVal["FOCUSCNT"] == 0 || $SearchVal["FOCUSCNT"] == 1) {
		echo $SearchVal["FOCUSCNT"];
	} else {*/
		if($TRANSLINO == 1) {
			$query_focuscnt									=   "SELECT id FROM transaction_line WHERE Transaction_Number = '$SearchVal[TRANSNO]' AND Focus_Flag = '1'";
			//echo $query_focuscnt;
			//exit;
			$res_focuscnt										=   mysql_query($query_focuscnt);
			$rowcnt_focuscnt									=   mysql_num_rows($res_focuscnt);
			echo $rowcnt_focuscnt; 
		}
	//}
	 ?></td>
	 <td><?php if($TRANSLINO == 1) { 
			 $query_schcnt									=   "SELECT id FROM transaction_line WHERE Transaction_Number = '$SearchVal[TRANSNO]' AND Scheme_Flag = '1'";
			//echo $query_schcnt;
			//exit;
			$res_schcnt										=   mysql_query($query_schcnt);
			$rowcnt_schcnt									=   mysql_num_rows($res_schcnt);
			echo $rowcnt_schcnt; 
		 }
		?></td>	
	 <td align="right"><?php if($TRANSLINO == 1) { echo number_format(trim($SearchVal[TRANSVAL]));
		}
	 ?></td>	
	 <td align="right"><?php if($TRANSLINO == 1) { echo number_format(trim($SearchVal[DISVAL])); } ?></td>	
	 <td align="right"><?php if($TRANSLINO == 1) { echo number_format(trim($SearchVal[CUR])); } ?></td>
	 <td align="right"><?php if($TRANSLINO == 1) { echo number_format(trim($SearchVal[NETVAL])); } ?></td>	
	 <td align="right"><?php if($TRANSLINO == 1) { echo number_format(trim($SearchVal[COLVAL])); } ?></td>	
	 <td align="right"><?php if($TRANSLINO == 1) { echo number_format(trim($SearchVal[BALVAL])); } ?></td>		
	 <td nowrap="nowrap"><?php echo $SearchVal[PRODNAME]; ?></td>
	 <td><?php echo $SearchVal[PRODTYPE]; ?></td>	
	 <td nowrap="nowrap"><?php echo $SearchVal[HEDDES]; ?></td>	
	 <td><?php echo $SearchVal[ORQTY]; ?></td>	
	 <td><?php echo $SearchVal[SOQTY]; ?></td>	
	 <td align="right"><?php echo number_format(trim($SearchVal[PRICEVAL])); ?></td>	
	 <td align="right"><?php echo number_format(trim($SearchVal[VALUEVAL])); ?></td>	
	 <td nowrap="nowrap"><?php echo $SearchVal[LINDES]; ?></td>
 </tr>
 <?php $k++; } ?> 
 </tbody>	
</table>
<span id="printopen" style="padding-left:470px;padding-top:10px;<?php if($num_rows > 0 ) { echo "display:block;"; } else { echo "display:none;"; } ?>" ><input type="button" name="kdproduct" value="Print" class="buttons" onclick="print_pages('printtranslistajax');"></span>
<form id="printtranslistajax" target="_blank" action="printtranslistajax.php" method="post">
	<input type="hidden" name="kdcode" id="kdcode" value="<?php echo $kdcodeprint; ?>" />
	<input type="hidden" name="srcode" id="srcode" value="<?php echo $srcodeprint; ?>" />
	<input type="hidden" name="cuscode" id="cuscode" value="<?php echo $cuscodeprint; ?>" />
	<input type="hidden" name="fromdatevalue" id="fromdatevalue" value="<?php echo $fromdatevalue; ?>" />
	<input type="hidden" name="todatevalue" id="todatevalue" value="<?php echo $todatevalue; ?>" />
	<input type="hidden" name="custype" id="custype" value="<?php echo $custype; ?>" />
</form>
<?php } else { ?>
 <tr>
	<td colspan="25" align='center'><strong>NO RECORDS FOUND</strong></td>
 </tr>
<?php } exit(0); ?>