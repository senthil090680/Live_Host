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
if(isset($_REQUEST[reportby]) && $_REQUEST[reportby] !='') {
	
	$datecolvalue	=	$propyears."-".$propmonths;
	$datecol	=	"Date LIKE '".$datecolvalue."%'";

	if($kdcode	==	'' || $kdcode == 'null') {
		$complete_query		=	'';
		$target_query		=	'';
	} elseif($kdcode	!=	'') {
		//$kdcodestr			=	implode("','",$kdcode);
		$kdcodestr				=	$kdcode;
		$complete_query		=	" WHERE KD_Code IN ('".$kdcodestr."')";
		$target_query		.=	" WHERE KD_Code IN ('".$kdcodestr."')";
		$monthplan_query	.=	" WHERE KD_Code IN ('".$kdcodestr."')";
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

	//$DSR_Codestr		=	findSR($wherefordsr,$asmcodecolval);

	if($rsmcode	==	'' || $rsmcode == 'null') {
		$rsmcodecol		=	'';
	} elseif($rsmcode	!=	'') {
		//$rsmcodestr	=	implode("','",$rsmcode);
		$rsmcodestr		=	$rsmcode;
		$rsmcodecol		=	"RSM IN ('".$rsmcodestr."')";
	}

	if($srcode	==	'' || $srcode == 'null') {
		$DSR_Codestr		=	'';
	} elseif($srcode	!=	'') {
		//$DSR_Codestr		=	implode("','",$srcode);
		$DSR_Codestr		=	$srcode;
		//$srcodecol		=	"DSR_Code IN ('".$srcodestr."')";
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
			$target_query		.=	" WHERE SR_Code IN ('".$DSR_Codestr."')";
		}
	} else if($target_query	!=	'') {
		if($DSR_Codestr	==	'') {
			$target_query		.=	"";
		} else {
			$target_query		.=	" AND SR_Code IN ('".$DSR_Codestr."')";
		}
	}

	if($monthplan_query	==	'') {
		$propmonthsval			=	ltrim($propmonths,0);
		$monthplan_query		.=	" WHERE routemonth = '$propmonthsval' AND routeyear = '$propyears'";
	} else if($monthplan_query	!=	'') {
		$propmonthsval			=	ltrim($propmonths,0);
		$monthplan_query		.=	" AND routemonth = '$propmonthsval' AND routeyear = '$propyears'";
	}

	if($monthplan_query	==	'') {
		if($DSR_Codestr	==	'') {
			$monthplan_query		.=	"";
		} else {
			$monthplan_query		.=	" WHERE DSR_Code IN ('".$DSR_Codestr."')";
		}
	} else if($monthplan_query	!=	'') {
		if($DSR_Codestr	==	'') {
			$monthplan_query		.=	"";
		} else {
			$monthplan_query		.=	" AND DSR_Code IN ('".$DSR_Codestr."')";
		}
	}


	if($complete_query	==	'') {
		$complete_query			.=	" WHERE $datecol";
	} else if($complete_query	!=	'') {
		$complete_query			.=	" AND $datecol";
	}

	$query_kdout	=   "SELECT id,KD_Code,DSR_Code,Customer_code,Net_Sale_value AS SALVAL,Collection_Value AS COLVAL,Balance_Due_Value AS BALVAL FROM transaction_hdr $complete_query";
	//echo $query_kdout;
	//exit;

	$res_kdout											=   mysql_query($query_kdout);
	$rowcnt_kdout										=   mysql_num_rows($res_kdout);	
	if($rowcnt_kdout > 0) {
		while($row_kdout								=   mysql_fetch_assoc($res_kdout)) {		
			$kdoutInfo[]								=	$row_kdout;
			$cuscode_kdout[]								=	$row_kdout["Customer_code"];
			$kdcode_kdout[]								=	$row_kdout["KD_Code"];
			$dsrcode_kdout[]							=	$row_kdout["DSR_Code"];
		}
	}	

	$kdcode_kdout		=	array_unique($kdcode_kdout);
	$kdcode_Total		=	implode("','",$kdcode_kdout);

	$dsrcode_kdout		=	array_unique($dsrcode_kdout);
	$dsrcode_Total		=	implode("','",$dsrcode_kdout);

	$cuscode_kdout		=	array_unique($cuscode_kdout);
	$cuscode_Total		=	implode("','",$cuscode_kdout);

	//pre($metricsInfo);
	//exit;
	
	$finalSearchInfo					=	$kdoutInfo;
	$i=0;
	$k=0;

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
			$finalkdInfo[$i]["KD_Code"]								=   $val_kd["KD_Code"];
			$finalkdInfo[$i]["DSRCode"]								=   $val_kd["DSR_Code"];
			$finalkdInfo[$i]["Customer_code"]						=   $val_kd["Customer_code"];
			$finalkdInfo[$i]["SALVAL"]								=   $val_kd["SALVAL"];
			$finalkdInfo[$i]["COLVAL"]								=   $val_kd["COLVAL"];
			$finalkdInfo[$i]["BALVAL"]								=   $val_kd["BALVAL"];
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
			$finaldsrInfo[$i]["KD_Code"]							=   $val_dsr["KD_Code"];
			$finaldsrInfo[$i]["DSRCode"]							=   $val_dsr["DSRCode"];
			$finaldsrInfo[$i]["Customer_code"]						=   $val_dsr["Customer_code"];
			$finaldsrInfo[$i]["SALVAL"]								=   $val_dsr["SALVAL"];
			$finaldsrInfo[$i]["COLVAL"]								=   $val_dsr["COLVAL"];
			$finaldsrInfo[$i]["BALVAL"]								=   $val_dsr["BALVAL"];
			$i++;
		}
		$k++;
	}

	$finalSearchInfo          =   $finaldsrInfo;
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
			$finalasmInfo[$i]["ASM_Id"]								=   $val_asm["ASM_Id"];			
			$finalasmInfo[$i]["DSR_Name"]							=   $val_asm["DSR_Name"];
			$finalasmInfo[$i]["DSRCode"]							=   $val_asm["DSRCode"];
			$finalasmInfo[$i]["KD_Name"]							=   $val_asm["KD_Name"];
			$finalasmInfo[$i]["KD_Code"]							=   $val_asm["KD_Code"];
			$finalasmInfo[$i]["Customer_code"]						=   $val_asm["Customer_code"];
			$finalasmInfo[$i]["SALVAL"]								=   $val_asm["SALVAL"];
			$finalasmInfo[$i]["COLVAL"]								=   $val_asm["COLVAL"];
			$finalasmInfo[$i]["BALVAL"]								=   $val_asm["BALVAL"];
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
			$finalrsmInfo[$i]["DSR_Name"]							=   $val_rsm["DSR_Name"];
			$finalrsmInfo[$i]["DSRCode"]							=   $val_rsm["DSRCode"];
			$finalrsmInfo[$i]["KD_Name"]							=   $val_rsm["KD_Name"];
			$finalrsmInfo[$i]["KD_Code"]							=   $val_rsm["KD_Code"];
			$finalrsmInfo[$i]["Customer_code"]						=   $val_rsm["Customer_code"];
			$finalrsmInfo[$i]["SALVAL"]								=   $val_rsm["SALVAL"];
			$finalrsmInfo[$i]["COLVAL"]								=   $val_rsm["COLVAL"];
			$finalrsmInfo[$i]["BALVAL"]								=   $val_rsm["BALVAL"];			
			$i++;
		}
		$k++;
	}

	$finalSearchInfo          =   $finalrsmInfo;
	//pre($finalSearchInfo);
	//exit;		

	$query_cus										=   "SELECT Customer_Name,customer_code FROM customer WHERE customer_code IN ('".$cuscode_Total."')";
	$res_cus										=   mysql_query($query_cus);
	while($row_cus									=   mysql_fetch_assoc($res_cus)) {
		$cusInfo[$row_cus["customer_code"]]			=	$row_cus;
	}
	
	//pre($dsrInfo);
	//exit;

	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_cus){
		//echo $dsrInfo[$val_dsr["DSRCode"]]["DSR_Code"] . "-". $val_dsr["DSRCode"]."<br>";
		if($cusInfo[$val_cus["Customer_code"]]["customer_code"] == $val_cus["Customer_code"]) {  
			
			$finalcusInfo[$i]["ASM_Name"]							=   $val_cus["ASM_Name"];
			$finalcusInfo[$i]["ASM_Id"]								=   $val_cus["ASM_Id"];
			$finalcusInfo[$i]["RSM_Name"]							=   $val_cus["RSM_Name"];
			$finalcusInfo[$i]["RSM_Id"]								=   $val_cus["RSM_Id"];
			$finalcusInfo[$i]["DSR_Name"]							=   $val_cus["DSR_Name"];
			$finalcusInfo[$i]["DSRCode"]							=   $val_cus["DSRCode"];
			$finalcusInfo[$i]["KD_Name"]							=   $val_cus["KD_Name"];
			$finalcusInfo[$i]["KD_Code"]							=   $val_cus["KD_Code"];
			$finalcusInfo[$i]["Customer_Name"]						=   $cusInfo[$val_cus["Customer_code"]]["Customer_Name"];
			$finalcusInfo[$i]["Customer_code"]						=   $val_cus["Customer_code"];
			$finalcusInfo[$i]["SALVAL"]								=   $val_cus["SALVAL"];
			$finalcusInfo[$i]["COLVAL"]								=   $val_cus["COLVAL"];
			$finalcusInfo[$i]["BALVAL"]								=   $val_cus["BALVAL"];		
			$i++;
		}
		$k++;
	}

	$finalSearchInfo          =   $finalcusInfo;
	//pre($finalSearchInfo);
	//exit;

	$orderbycolumns     =   'Customer_code';
	$orderbysorting     =   'ASC';

	if($orderbysorting == 'DESC') {
		$dir        =   'arsort';               
	} else {
		$dir        =   'asort';   
	}
	$finalSearchInfo	=	subval_sort($finalSearchInfo,$orderbycolumns,$dir);
	//pre($finalSearchInfo);
	//exit;

	//pre($finalSearchInfo);
	$i=0;
	foreach($finalSearchInfo AS $key=>$value) {
		$DSRCode											=	$value[DSRCode];
		$Customer_code										=	$value[Customer_code];
		$check[$DSRCode.$Customer_code]						=	$DSRCode.$Product_code.$KD_Code;

		//echo $check[$DSRCode.$Customer_code] ." == ". $checkagain[$DSRCode.$Customer_code]."<br>";

		if(($check[$DSRCode.$Customer_code] == $checkagain[$DSRCode.$Customer_code]) && ($check[$DSRCode.$Customer_code] != '' &&  $checkagain[$DSRCode.$Customer_code] != '')) {			
			$SALVAL[$DSRCode.$Customer_code]		+=	$value[SALVAL];
			$COLVAL[$DSRCode.$Customer_code]		+=	$value[COLVAL];
			$BALVAL[$DSRCode.$Customer_code]		+=	$value[BALVAL];

		//echo $BALVAL[$DSRCode.$Customer_code]."==". $DSRCode.$Customer_code. "<br>";

			//echo $gettingi[$DSRCode.$Customer_code]-1;
			//echo $BALVAL[$DSRCode.$Customer_code];
			$finalsumInfo[$gettingi[$DSRCode.$Customer_code]]["SALVAL"]				=   $SALVAL[$DSRCode.$Customer_code];
			$finalsumInfo[$gettingi[$DSRCode.$Customer_code]]["COLVAL"]				=   $COLVAL[$DSRCode.$Customer_code];
			$finalsumInfo[$gettingi[$DSRCode.$Customer_code]]["BALVAL"]				=   $BALVAL[$DSRCode.$Customer_code];
		} else {
			$finalsumInfo[$i]["ASM_Name"]					=   $value["ASM_Name"];
			$finalsumInfo[$i]["ASM_Id"]						=   $value["ASM_Id"];
			$finalsumInfo[$i]["RSM_Name"]					=   $value["RSM_Name"];
			$finalsumInfo[$i]["RSM_Id"]						=   $value["RSM_Id"];
			$finalsumInfo[$i]["DSR_Name"]					=   $value["DSR_Name"];
			$finalsumInfo[$i]["DSRCode"]					=   $value["DSRCode"];
			$finalsumInfo[$i]["KD_Name"]					=   $value["KD_Name"];
			$finalsumInfo[$i]["KD_Code"]					=   $value["KD_Code"];
			$finalsumInfo[$i]["Customer_Name"]				=   $value["Customer_Name"];
			$finalsumInfo[$i]["Customer_code"]				=   $value["Customer_code"];
			$finalsumInfo[$i]["SALVAL"]						=   $value["SALVAL"];
			$finalsumInfo[$i]["COLVAL"]						=   $value["COLVAL"];
			$finalsumInfo[$i]["BALVAL"]						=   $value["BALVAL"];
			$SALVAL[$DSRCode.$Customer_code]				+=	$value[SALVAL];
			$COLVAL[$DSRCode.$Customer_code]				+=	$value[COLVAL];
			$BALVAL[$DSRCode.$Customer_code]				+=	$value[BALVAL];
			$gettingi[$DSRCode.$Customer_code]				=	$i;
			$i++;	
			$checkagain[$DSRCode.$Customer_code]			=	$check[$DSRCode.$Customer_code];
		}
		
	}

	$finalSearchInfo	=	$finalsumInfo;
	//pre($finalSearchInfo);
	//exit;

	$orderbycolumns     =   'Customer_code';
	$orderbysorting     =   'ASC';

	if($orderbysorting == 'DESC') {
		$dir        =   'arsort';               
	} else {
		$dir        =   'asort';   
	}
	$finalSearchInfo	=	subval_sort($finalSearchInfo,$orderbycolumns,$dir);

	//pre($finalSearchInfo);
	//exit;

	$dayval					=	"1";	//WHICH WE SET AS DEFAULT DAY 1 FOR MONTH WE CHOOSE FROM DROP DOWN
	$prevmonth				=	ltrim(date("m", mktime(0, 0, 0, $propmonths - 1, $dayval, $propyears)),0);	

	$currmonth				=	$propmonthsval;
	
	if($currmonth == 1) {
		$findyear				=	date("Y", mktime(0, 0, 0, $propmonths, $dayval, $propyears - 1));
	} else {
		$findyear				=	date('Y');
	}

	//$findyear	=	"1999";

	$query_prvout										=   "SELECT customer_id,KD_Code,DSR_Code,total_due FROM customer_outstanding WHERE customer_id IN ('".$cuscode_Total."') AND monthval = '$prevmonth' AND yearval = '$findyear' ORDER BY customer_id";
	//echo $query_prvout;
	//exit;
	$res_prvout											=   mysql_query($query_prvout);
	while($row_prvout									=   mysql_fetch_assoc($res_prvout)) {
		$cusoutInfo[$row_prvout["customer_id"]]				=	$row_prvout;
	}
	
	//pre($dsrInfo);
	//exit;

	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_cusout){
		//echo $dsrInfo[$val_dsr["DSRCode"]]["DSR_Code"] . "-". $val_dsr["DSRCode"]."<br>";
		if($cusoutInfo[$val_cusout["Customer_code"]]["customer_id"] == $val_cusout["Customer_code"]) {  
			
			$finalcusoutInfo[$i]["ASM_Name"]							=   $val_cusout["ASM_Name"];
			$finalcusoutInfo[$i]["ASM_Id"]								=   $val_cusout["ASM_Id"];
			$finalcusoutInfo[$i]["RSM_Name"]							=   $val_cusout["RSM_Name"];
			$finalcusoutInfo[$i]["RSM_Id"]								=   $val_cusout["RSM_Id"];
			$finalcusoutInfo[$i]["DSR_Name"]							=   $val_cusout["DSR_Name"];
			$finalcusoutInfo[$i]["DSRCode"]								=   $val_cusout["DSRCode"];
			$finalcusoutInfo[$i]["KD_Name"]								=   $val_cusout["KD_Name"];
			$finalcusoutInfo[$i]["KD_Code"]								=   $val_cusout["KD_Code"];
			$finalcusoutInfo[$i]["Customer_Name"]						=   $val_cusout["Customer_Name"];
			$finalcusoutInfo[$i]["Customer_code"]						=   $val_cusout["Customer_code"];
			$finalcusoutInfo[$i]["PREVAL"]								=   $cusoutInfo[$val_cusout["Customer_code"]]["total_due"];
			$finalcusoutInfo[$i]["SALVAL"]								=   $val_cusout["SALVAL"];
			$finalcusoutInfo[$i]["COLVAL"]								=   $val_cusout["COLVAL"];
			$finalcusoutInfo[$i]["BALVAL"]								=   $val_cusout["BALVAL"];		
			$i++;
		} else {
			$finalcusoutInfo[$i]["ASM_Name"]							=   $val_cusout["ASM_Name"];
			$finalcusoutInfo[$i]["ASM_Id"]								=   $val_cusout["ASM_Id"];
			$finalcusoutInfo[$i]["RSM_Name"]							=   $val_cusout["RSM_Name"];
			$finalcusoutInfo[$i]["RSM_Id"]								=   $val_cusout["RSM_Id"];
			$finalcusoutInfo[$i]["DSR_Name"]							=   $val_cusout["DSR_Name"];
			$finalcusoutInfo[$i]["DSRCode"]								=   $val_cusout["DSRCode"];
			$finalcusoutInfo[$i]["KD_Name"]								=   $val_cusout["KD_Name"];
			$finalcusoutInfo[$i]["KD_Code"]								=   $val_cusout["KD_Code"];
			$finalcusoutInfo[$i]["Customer_Name"]						=   $val_cusout["Customer_Name"];
			$finalcusoutInfo[$i]["Customer_code"]						=   $val_cusout["Customer_code"];
			$finalcusoutInfo[$i]["PREVAL"]								=   0;
			$finalcusoutInfo[$i]["SALVAL"]								=   $val_cusout["SALVAL"];
			$finalcusoutInfo[$i]["COLVAL"]								=   $val_cusout["COLVAL"];
			$finalcusoutInfo[$i]["BALVAL"]								=   $val_cusout["BALVAL"];		
			$i++;
		}
		$k++;
	}

	$finalSearchInfo			=   $finalcusoutInfo;
	//pre($finalSearchInfo);
	//exit;
	
	$suggestedQty				=	'';
	$suggestedQtyfirst			=	0;
	$suggestedQtysecond			=	0;
	$suggestedQtythird			=	0;
	$routemonth					=	ltrim(date('m'),0);
	$routeyear					=	date('Y');

	$monthyearfirst				=	ltrim(date("m", mktime(0, 0, 0, $propmonths - 1, $dayval, $propyears)),0)."-".$findyear;
	$monthyearsecond			=	ltrim(date("m", mktime(0, 0, 0, $propmonths - 2, $dayval, $propyears)),0)."-".$findyear;
	$monthyearthird				=	ltrim(date("m", mktime(0, 0, 0, $propmonths - 3, $dayval, $propyears)),0)."-".$findyear;

	//$monthyearfirst			=	($routemonth - 1)."-".$routeyear;
	//$monthyearsecond			=	($routemonth - 2)."-".$routeyear;
	//$monthyearthird			=	($routemonth - 3)."-".$routeyear;
	foreach($finalSearchInfo AS $findAvgSales) {
		$suggestedQtyfirst			=	0;
		$suggestedQtysecond			=	0;
		$suggestedQtythird			=	0;
		$Customer_code				=	$findAvgSales[Customer_code];
		$DSRCode					=	$findAvgSales[DSRCode];
		$KD_Code					=	$findAvgSales[KD_Code];
		$qry_avgsalesfirst		=	"SELECT transtype,valueval FROM `sales_list` WHERE customer_id = '$Customer_code' AND KD_Code = '$KD_Code' AND DSR_Code = '$DSRCode' AND monthyear = '$monthyearfirst' ORDER BY customer_id";
		//echo $qry_avgsalesfirst;
		//exit;
		$res_avgsalesfirst			=	mysql_query($qry_avgsalesfirst) or die(mysql_error());	
		
		while($row_avgsalesfirst			=	mysql_fetch_array($res_avgsalesfirst)) {
			$transtype				=	$row_avgsalesfirst[transtype];
			//exit;
			if($transtype == 2) {
				$suggestedQtyfirst	+=	$row_avgsalesfirst['valueval'];
			} elseif ($transtype == 3 || $transtype == 4) {
				$suggestedQtyfirst	-=	$row_avgsalesfirst['valueval'];
			}
		}
		
		//$qry_avgsalessec			=	"SELECT transtype,valueval FROM `sales_list` WHERE route_id = '$route_id' AND DSR_Code = '$DSR_Code' AND Product_code = '$row_supp[Product_code]' AND monthyear = '$monthyearsecond' ORDER BY customer_id";
		$qry_avgsalessec			=	"SELECT transtype,valueval FROM `sales_list` WHERE customer_id = '$Customer_code' AND KD_Code = '$KD_Code' AND DSR_Code = '$DSRCode' AND monthyear = '$monthyearsecond' ORDER BY customer_id";
		//echo $qry_avgsalessec;
		//exit;
		$res_avgsalessec			=	mysql_query($qry_avgsalessec) or die(mysql_error());	
		
		while($row_avgsalessec			=	mysql_fetch_array($res_avgsalessec)) {
			$transtype				=	$row_avgsalessec[transtype];
			if($transtype == 2) {
				$suggestedQtysecond	+=	$row_avgsalessec['valueval'];
			} elseif ($transtype == 3 || $transtype == 4) {
				$suggestedQtysecond	-=	$row_avgsalessec['valueval'];
			}
		}

		//$qry_avgsalesthird			=	"SELECT transtype,valueval FROM `sales_list` WHERE route_id = '$route_id' AND DSR_Code = '$DSR_Code' AND Product_code = '$row_supp[Product_code]' AND monthyear = '$monthyearthird' ORDER BY customer_id";
		$qry_avgsalesthird			=	"SELECT transtype,valueval FROM `sales_list` WHERE customer_id = '$Customer_code' AND KD_Code = '$KD_Code' AND DSR_Code = '$DSRCode' AND monthyear = '$monthyearthird' ORDER BY customer_id";

		//echo $qry_avgsalesthird;
		//exit;
		$res_avgsalesthird			=	mysql_query($qry_avgsalesthird) or die(mysql_error());	
		
		while($row_avgsalesthird	=	mysql_fetch_array($res_avgsalesthird)) {
			$transtype				=	$row_avgsalesthird[transtype];
			if($transtype == 2) {
				$suggestedQtythird	+=	$row_avgsalesthird['valueval'];
			} elseif ($transtype == 3 || $transtype == 4) {
				$suggestedQtythird	-=	$row_avgsalesthird['valueval'];
			}
		}
		
		$firstoptionbefore				=	'';
		$firstoption					=	'';
		$secondoptionbefore				=	'';
		$secondoption					=	'';
		$thirdoptionbefore				=	'';
		$thirdoption					=	'';
		$fourthoptionbefore				=	'';
		$fourthoption					=	'';
		$fifthoptionbefore				=	'';
		$fifthoption					=	'';
		$sixthoptionbefore				=	'';
		$sixthoption					=	'';
		$seventhoptionbefore			=	'';
		$seventhoption					=	'';
		
		/*echo $suggestedQtyfirst."<br/>";
		echo $suggestedQtysecond."<br/>";
		echo $suggestedQtythird."<br/>";*/

		if($suggestedQtythird != 0 && $suggestedQtysecond != 0 && $suggestedQtyfirst != 0) { //first
			$firstoptionbefore		=	(($suggestedQtythird) + ($suggestedQtysecond) + ($suggestedQtyfirst));
			if($firstoptionbefore > 0) {
				$firstoption			=	ceil($firstoptionbefore/3);
				$suggestedQty[$DSRCode.$Customer_code][AVG_SAL]			=	$firstoption;
				$suggestedQty[$DSRCode.$Customer_code][DSR_CUS]			=	$DSRCode.$Customer_code;
			} else {
				$suggestedQty[$DSRCode.$Customer_code][AVG_SAL]			=	0;
				$suggestedQty[$DSRCode.$Customer_code][DSR_CUS]			=	$DSRCode.$Customer_code;
			}
		} else if(($suggestedQtythird == 0) && ($suggestedQtysecond != 0 && $suggestedQtyfirst != 0)) {  //second
			$secondoptionbefore		=	(($suggestedQtysecond) + ($suggestedQtyfirst));
			if($secondoptionbefore > 0) {
				$secondoption			=	ceil($secondoptionbefore/2);
				$suggestedQty[$DSRCode.$Customer_code][AVG_SAL]			=	$secondoption;
				$suggestedQty[$DSRCode.$Customer_code][DSR_CUS]			=	$DSRCode.$Customer_code;
			} else {
				$suggestedQty[$DSRCode.$Customer_code][AVG_SAL]			=	0;
				$suggestedQty[$DSRCode.$Customer_code][DSR_CUS]			=	$DSRCode.$Customer_code;
			}					
		} else if(($suggestedQtysecond == 0) && ($suggestedQtythird != 0 && $suggestedQtyfirst != 0)) { //third
			$thirdoptionbefore		=	(($suggestedQtythird) + ($suggestedQtyfirst));
			if($thirdoptionbefore > 0) {
				$thirdoption			=	ceil($thirdoptionbefore/2);
				$suggestedQty[$DSRCode.$Customer_code][AVG_SAL]			=	$thirdoption;
				$suggestedQty[$DSRCode.$Customer_code][DSR_CUS]			=	$DSRCode.$Customer_code;
			} else {
				$suggestedQty[$DSRCode.$Customer_code][AVG_SAL]			=	0;
				$suggestedQty[$DSRCode.$Customer_code][DSR_CUS]			=	$DSRCode.$Customer_code;
			}					
		} else if(($suggestedQtyfirst == 0) && ($suggestedQtythird != 0 && $suggestedQtysecond != 0)) {  //fourth
			$fourthoptionbefore		=	(($suggestedQtythird) + ($suggestedQtysecond));
			if($fourthoptionbefore > 0) {
				$fourthoption			=	ceil($fourthoptionbefore/2);
				$suggestedQty[$DSRCode.$Customer_code][AVG_SAL]			=	$fourthoption;
				$suggestedQty[$DSRCode.$Customer_code][DSR_CUS]			=	$DSRCode.$Customer_code;
			} else {
				$suggestedQty[$DSRCode.$Customer_code][AVG_SAL]			=	0;
				$suggestedQty[$DSRCode.$Customer_code][DSR_CUS]			=	$DSRCode.$Customer_code;
			}
		} else if(($suggestedQtyfirst == 0 && $suggestedQtythird == 0) && ($suggestedQtysecond != 0)) { //fifth
			$fifthoptionbefore		=	($suggestedQtysecond);
			if($fifthoptionbefore > 0) {
				$fifthoption			=	ceil($fifthoptionbefore);
				$suggestedQty[$DSRCode.$Customer_code][AVG_SAL]			=	$fifthoption;
				$suggestedQty[$DSRCode.$Customer_code][DSR_CUS]			=	$DSRCode.$Customer_code;
			} else {
				$suggestedQty[$DSRCode.$Customer_code][AVG_SAL]			=	0;
				$suggestedQty[$DSRCode.$Customer_code][DSR_CUS]			=	$DSRCode.$Customer_code;
			}
		} else if(($suggestedQtyfirst == 0 && $suggestedQtysecond == 0) && ($suggestedQtythird != 0)) {  //sixth
			$sixthoptionbefore		=	($suggestedQtythird);
			if($sixthoptionbefore > 0) {
				$sixthoption			=	ceil($sixthoptionbefore);
				$suggestedQty[$DSRCode.$Customer_code][AVG_SAL]			=	$sixthoption;
				$suggestedQty[$DSRCode.$Customer_code][DSR_CUS]			=	$DSRCode.$Customer_code;
			} else {
				$suggestedQty[$DSRCode.$Customer_code][AVG_SAL]			=	0;
				$suggestedQty[$DSRCode.$Customer_code][DSR_CUS]			=	$DSRCode.$Customer_code;
			}
		} else if(($suggestedQtysecond == 0 && $suggestedQtythird == 0) && ($suggestedQtyfirst != 0)) {  //seventh
			$seventhoptionbefore		=	($suggestedQtyfirst);
			if($seventhoptionbefore > 0) {
				$seventhoption			=	ceil($seventhoptionbefore);
				$suggestedQty[$DSRCode.$Customer_code][AVG_SAL]			=	$seventhoption;
				$suggestedQty[$DSRCode.$Customer_code][DSR_CUS]			=	$DSRCode.$Customer_code;
			} else {
				$suggestedQty[$DSRCode.$Customer_code][AVG_SAL]			=	0;
				$suggestedQty[$DSRCode.$Customer_code][DSR_CUS]			=	$DSRCode.$Customer_code;
			}
		} else {  //Eighth
			$suggestedQty[$DSRCode.$Customer_code][AVG_SAL]			=	0;
			$suggestedQty[$DSRCode.$Customer_code][DSR_CUS]			=	$DSRCode.$Customer_code;
		}
	
		$Customer_code				=	'';
		$DSRCode					=	'';
		$KD_Code					=	'';
	}

	$i=0;
	foreach($finalSearchInfo as $val_avg){
		$DSRVAL							=	$val_avg["DSRCode"];
		$CUSCODEVAL						=	$val_avg["Customer_code"];
		//echo $routestring[$val_route["DSRCode"]][DSRID] . "-". $val_route["DSRCode"]."<br>";
		if($suggestedQty[$DSRVAL.$CUSCODEVAL][DSR_CUS] == $DSRVAL.$CUSCODEVAL) {                                     
			$finalavgInfo[$i]["ASM_Name"]							=   $val_avg["ASM_Name"];
			$finalavgInfo[$i]["ASM_Id"]								=   $val_avg["ASM_Id"];
			$finalavgInfo[$i]["RSM_Name"]							=   $val_avg["RSM_Name"];
			$finalavgInfo[$i]["RSM_Id"]								=   $val_avg["RSM_Id"];
			$finalavgInfo[$i]["DSR_Name"]							=   $val_avg["DSR_Name"];
			$finalavgInfo[$i]["DSRCode"]							=   $val_avg["DSRCode"];
			$finalavgInfo[$i]["KD_Name"]							=   $val_avg["KD_Name"];
			$finalavgInfo[$i]["KD_Code"]							=   $val_avg["KD_Code"];
			$finalavgInfo[$i]["Customer_Name"]						=   $val_avg["Customer_Name"];
			$finalavgInfo[$i]["Customer_code"]						=   $val_avg["Customer_code"];
			$finalavgInfo[$i]["PREVAL"]								=   $val_avg["PREVAL"];
			$finalavgInfo[$i]["AVG_SAL"]							=   $suggestedQty[$DSRVAL.$CUSCODEVAL]["AVG_SAL"];
			$finalavgInfo[$i]["SALVAL"]								=   $val_avg["SALVAL"];
			$finalavgInfo[$i]["COLVAL"]								=   $val_avg["COLVAL"];
			$finalavgInfo[$i]["BALVAL"]								=   $val_avg["BALVAL"];		
			$finalavgInfo[$i]["TOTALBAL"]							=   $finalavgInfo[$i]["PREVAL"]+$finalavgInfo[$i]["BALVAL"];
			$finalavgInfo[$i]["OSSALE"]								=   ceil($finalavgInfo[$i]["TOTALBAL"]/$finalavgInfo[$i]["AVG_SAL"]);
			$i++;
		}
	}
	$finalSearchInfo          =   $finalavgInfo;
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
} else {
	$nextrecval			=	"";
}
$num_rows		=	count($finalSearchInfo);

?>
<title>KD CUSTOMER OUTSTANDING REPORT</title>
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
#errormsgkdout {
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
.myalignkdout {
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
  <table border="1" width="100%" style="border-collapse:collapse;">
	<thead>
	 <tr>
		<th align="center" colspan="10">KD CUSTOMER OUTSTANDING REPORT</th>
	  </tr>
	   <tr>
			<!--<th align="left" colspan="19"><?php 
			

			echo "Month & Year : &nbsp;&nbsp;&nbsp;".date('F',mktime(0,0,0,$propmonths))." & ".$propyears."&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;KD : &nbsp;&nbsp;";
						
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
			
			echo "&nbsp;&nbsp;&nbsp;SR : &nbsp;&nbsp;";

			if($srcode == '' || $srcode == 'null') {
				echo "ALL";
			} else {
				$explode_srcode		=	explode(",", str_replace("'","",$srcode));
				$tom	=	0;
				foreach($explode_srcode AS $srval) {
					if($tom	==	0) {
						echo upperstate(getdbval($srval,'DSRName','DSR_Code','dsr'));
					} else {
						echo ",&nbsp;".upperstate(getdbval($srval,'DSRName','DSR_Code','dsr'));
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
			<th align="center" style="width:10%">KD Name</th>
			<th align="center" style="width:10%">SR Name</th>
			<th align="center" style="width:10%">ASM Name</th>
			<th align="center" style="width:10%">RSM Name</th>
			<th align="center" style="width:10%">Customer Name</th>
			<th align="center" style="width:10%">Opening Outstanding(Naira)</th>
			<th align="center" style="width:10%">This Month(Naira)
			 <table  width="100%"><tr><td>Sale</td><td>Collection</td><td>Outstanding</td></tr></table>
			</th> 
			<th align="center" style="width:10%">Total Outsatnding(Naira)</th>
			<th align="center" style="width:10%">AVG Monthly Sale(Naira)</th>
			<th align="center" style="width:10%">O/S As No of Months Sale</th>
	  </tr>
  </thead>
 <tbody>

 <?php	$checkfor				=	'';
		$checkoutfor			=	'';
		$k						=	0;
		$arrcnt					=	count($finalSearchInfo);
		$subtotalcheckfor		=	1;
		$total_preout			=	'';
		$total_salval			=	'';
		$total_colval			=	'';
		$total_balval			=	'';
		$total_totbal			=	'';
		$total_avgsal			=	'';
		$total_osal				=	'';

		$tot_preout				=	'';
		$tot_salval				=	'';
		$tot_colval				=	'';
		$tot_balval				=	'';
		$tot_totbal				=	'';
		$tot_avgsal				=	'';
		$tot_ossal				=	'';

if($arrcnt > 0) {
 foreach($finalSearchInfo AS $SearchKey=>$SearchVal) { 
	$tot_preout				+=	$SearchVal["PREVAL"];
	$tot_salval				+=	$SearchVal["SALVAL"];
	$tot_colval				+=	$SearchVal["COLVAL"];
	$tot_balval				+=	$SearchVal["BALVAL"];
	$tot_totbal				+=	$SearchVal["TOTALBAL"];
	$tot_avgsal				+=	$SearchVal["AVG_SAL"];
	$tot_ossal				+=	$SearchVal["OSSALE"];

	if($reportby == 'KD_Name') {
		if($checkfor		==	'') {
			$checkfor		=	$SearchVal["KD_Name"];
			$checkoutfor	=	$SearchVal["KD_Name"];
			
			$total_preout				=	'';
			$total_salval				=	'';
			$total_colval				=	'';
			$total_balval				=	'';
			$total_totbal				=	'';
			$total_avgsal				=	'';
			$total_ossal				=	'';

			if($subtotalcheckfor == 2) {
				$subtotalcheckfor = 1;
				$total_preout				+=	$SearchVal["PREVAL"];
				$total_salval				+=	$SearchVal["SALVAL"];
				$total_colval				+=	$SearchVal["COLVAL"];
				$total_balval				+=	$SearchVal["BALVAL"];
				$total_totbal				+=	$SearchVal["TOTALBAL"];
				$total_avgsal				+=	$SearchVal["AVG_SAL"];
				$total_ossal				+=	$SearchVal["OSSALE"];
			}
		} else {
			$checkoutfor	=	$SearchVal["KD_Name"];
			if($subtotalcheckfor == 1) {
				$total_preout				+=	$SearchVal["PREVAL"];
				$total_salval				+=	$SearchVal["SALVAL"];
				$total_colval				+=	$SearchVal["COLVAL"];
				$total_balval				+=	$SearchVal["BALVAL"];
				$total_totbal				+=	$SearchVal["TOTALBAL"];
				$total_avgsal				+=	$SearchVal["AVG_SAL"];
				$total_ossal				+=	$SearchVal["OSSALE"];
			}
		}
	} elseif($reportby == 'ASM_Name') {
		if($checkfor		==	'') {
			$checkfor		=	$SearchVal["ASM_Name"];
			$checkoutfor	=	$SearchVal["ASM_Name"];			
			$total_preout				=	'';
			$total_salval				=	'';
			$total_colval				=	'';
			$total_balval				=	'';
			$total_totbal				=	'';
			$total_avgsal				=	'';
			$total_ossal				=	'';
			if($subtotalcheckfor == 2) {
				$subtotalcheckfor = 1;
				$total_preout				+=	$SearchVal["PREVAL"];
				$total_salval				+=	$SearchVal["SALVAL"];
				$total_colval				+=	$SearchVal["COLVAL"];
				$total_balval				+=	$SearchVal["BALVAL"];
				$total_totbal				+=	$SearchVal["TOTALBAL"];
				$total_avgsal				+=	$SearchVal["AVG_SAL"];
				$total_ossal				+=	$SearchVal["OSSALE"];
			}
		} else {
			$checkoutfor	=	$SearchVal["ASM_Name"];
			if($subtotalcheckfor == 1) {
				$total_preout				+=	$SearchVal["PREVAL"];
				$total_salval				+=	$SearchVal["SALVAL"];
				$total_colval				+=	$SearchVal["COLVAL"];
				$total_balval				+=	$SearchVal["BALVAL"];
				$total_totbal				+=	$SearchVal["TOTALBAL"];
				$total_avgsal				+=	$SearchVal["AVG_SAL"];
				$total_ossal				+=	$SearchVal["OSSALE"];
			}
		}
	} elseif($reportby == 'RSM_Name') {
		if($checkfor		==	'') {
			$checkfor		=	$SearchVal["RSM_Name"];
			$checkoutfor	=	$SearchVal["RSM_Name"];
			
			$total_preout				=	'';
			$total_salval				=	'';
			$total_colval				=	'';
			$total_balval				=	'';
			$total_totbal				=	'';
			$total_avgsal				=	'';
			$total_ossal				=	'';

			if($subtotalcheckfor == 2) {
				$subtotalcheckfor = 1;
				$total_preout				+=	$SearchVal["PREVAL"];
				$total_salval				+=	$SearchVal["SALVAL"];
				$total_colval				+=	$SearchVal["COLVAL"];
				$total_balval				+=	$SearchVal["BALVAL"];
				$total_totbal				+=	$SearchVal["TOTALBAL"];
				$total_avgsal				+=	$SearchVal["AVG_SAL"];
				$total_ossal				+=	$SearchVal["OSSALE"];
			}
		} else {
			$checkoutfor	=	$SearchVal["RSM_Name"];
			if($subtotalcheckfor == 1) {
				$total_preout				+=	$SearchVal["PREVAL"];
				$total_salval				+=	$SearchVal["SALVAL"];
				$total_colval				+=	$SearchVal["COLVAL"];
				$total_balval				+=	$SearchVal["BALVAL"];
				$total_totbal				+=	$SearchVal["TOTALBAL"];
				$total_avgsal				+=	$SearchVal["AVG_SAL"];
				$total_ossal				+=	$SearchVal["OSSALE"];
			}
		}		
	} elseif($reportby == 'Customer_Name') {
		if($checkfor		==	'') {
			$checkfor		=	$SearchVal["Customer_Name"];
			$checkoutfor	=	$SearchVal["Customer_Name"];
			
			$total_preout				=	'';
			$total_salval				=	'';
			$total_colval				=	'';
			$total_balval				=	'';
			$total_totbal				=	'';
			$total_avgsal				=	'';
			$total_ossal				=	'';

			if($subtotalcheckfor == 2) {
				$subtotalcheckfor = 1;
				$total_preout				+=	$SearchVal["PREVAL"];
				$total_salval				+=	$SearchVal["SALVAL"];
				$total_colval				+=	$SearchVal["COLVAL"];
				$total_balval				+=	$SearchVal["BALVAL"];
				$total_totbal				+=	$SearchVal["TOTALBAL"];
				$total_avgsal				+=	$SearchVal["AVG_SAL"];
				$total_ossal				+=	$SearchVal["OSSALE"];
			}
		} else {
			$checkoutfor	=	$SearchVal["Customer_Name"];
			if($subtotalcheckfor == 1) {
				$total_preout				+=	$SearchVal["PREVAL"];
				$total_salval				+=	$SearchVal["SALVAL"];
				$total_colval				+=	$SearchVal["COLVAL"];
				$total_balval				+=	$SearchVal["BALVAL"];
				$total_totbal				+=	$SearchVal["TOTALBAL"];
				$total_avgsal				+=	$SearchVal["AVG_SAL"];
				$total_ossal				+=	$SearchVal["OSSALE"];
			}
		}		
	} elseif($reportby == 'DSR_Name') {
		if($checkfor		==	'') {
			$checkfor		=	$SearchVal["DSR_Name"];
			$checkoutfor	=	$SearchVal["DSR_Name"];
			
			$total_preout				=	'';
			$total_salval				=	'';
			$total_colval				=	'';
			$total_balval				=	'';
			$total_totbal				=	'';
			$total_avgsal				=	'';
			$total_ossal				=	'';

			if($subtotalcheckfor == 2) {
				$subtotalcheckfor = 1;
				$total_preout				+=	$SearchVal["PREVAL"];
				$total_salval				+=	$SearchVal["SALVAL"];
				$total_colval				+=	$SearchVal["COLVAL"];
				$total_balval				+=	$SearchVal["BALVAL"];
				$total_totbal				+=	$SearchVal["TOTALBAL"];
				$total_avgsal				+=	$SearchVal["AVG_SAL"];
				$total_ossal				+=	$SearchVal["OSSALE"];
				//echo $target_naira	. " == " . $target_units . " == " . $SUM_SQ . " == " . $VALUE_NAIRA . " == " . $diff_units . " == " . $diff_naira. " == " .  $subtotalcheckfor. "indo<br/>";
			}

			//echo $target_naira	. " == " . $target_units . " == " . $SUM_SQ . " == " . $VALUE_NAIRA . " == " . $diff_units . " == " . $diff_naira. " == " .  $subtotalcheckfor. "good<br/>";
		} else {
			$checkoutfor	=	$SearchVal["DSR_Name"];

			if($subtotalcheckfor == 1) {
				$total_preout				+=	$SearchVal["PREVAL"];
				$total_salval				+=	$SearchVal["SALVAL"];
				$total_colval				+=	$SearchVal["COLVAL"];
				$total_balval				+=	$SearchVal["BALVAL"];
				$total_totbal				+=	$SearchVal["TOTALBAL"];
				$total_avgsal				+=	$SearchVal["AVG_SAL"];
				$total_ossal				+=	$SearchVal["OSSALE"];
			}
			//echo $target_naira	. " == " . $target_units . " == " . $SUM_SQ . " == " . $VALUE_NAIRA . " == " . $diff_units . " == " . $diff_naira. " == " .  $subtotalcheckfor. "nto<br/>";
		}
	}
 
 ?>
 <?php  //echo $checkfor ."==" .$checkoutfor."<br>"; 
 //echo $k . "+++++" . $arrcnt."<br/>";
	if((($checkfor == $checkoutfor) && ($checkfor != '' && $checkoutfor !='')) && ($k != $arrcnt)) {  		
		$subtotalcheckfor = 2;
		$total_preout				+=	$SearchVal["PREVAL"];
		$total_salval				+=	$SearchVal["SALVAL"];
		$total_colval				+=	$SearchVal["COLVAL"];
		$total_balval				+=	$SearchVal["BALVAL"];
		$total_totbal				+=	$SearchVal["TOTALBAL"];
		$total_avgsal				+=	$SearchVal["AVG_SAL"];
		$total_ossal				+=	$SearchVal["OSSALE"];
	} else {
		 
	if($k != 0) {
		 //echo $checkfor ."==" .$checkoutfor."<br>";
		 //$checkoutfor		=	$SearchVal["Brand_Name"];
	?>
	 <tr>
		 <td colspan="5" align="right"><strong><?php 
		 //echo $target_naira	. " == " . $target_units . " == " . $SUM_SQ . " == " . $VALUE_NAIRA . " == " . $diff_units . " == " . $diff_naira. " == " .  $subtotalcheckfor. "<br/>";
		 
		 //echo $checkfor ."==" .$checkoutfor."<br>"; ?> Sub Total<strong></td>
		  <td>&nbsp;<?php echo number_format(trim($total_preout)); ?></td>
		  <td>&nbsp;
		  <table  width="100%"><tr><td><?php echo number_format(trim($total_salval)); ?></td><td><?php echo number_format(trim($total_colval)); ?></td><td><?php echo number_format(trim($total_balval)); ?></td></tr></table>
		  </td>
		  <td>&nbsp;<?php echo number_format(trim($total_totbal)); ?></td>	
		  <td>&nbsp;<?php echo number_format(trim($total_avgsal)); ?></td>	
		  <td>&nbsp;<?php echo number_format(trim($total_ossal)); ?></td>	
	 </tr>
<?php
	$checkfor			=	'';
	$subtotalcheckfor	=	'';
	$total_preout				=	$SearchVal["PREVAL"];
	$total_salval				=	$SearchVal["SALVAL"];
	$total_colval				=	$SearchVal["COLVAL"];
	$total_balval				=	$SearchVal["BALVAL"];
	$total_totbal				=	$SearchVal["TOTALBAL"];
	$total_avgsal				=	$SearchVal["AVG_SAL"];
	$total_ossal				=	$SearchVal["OSSALE"];

	//echo $target_naira	. " == " . $target_units . " == " . $SUM_SQ . " == " . $VALUE_NAIRA . " == " . $diff_units . " == " . $diff_naira. " == " .  $subtotalcheckfor."<br/>";
} }


$checkfor	=	$checkoutfor;

?>
<tr>
	 <td <?php if($reportby == 'KD_Name') { ?> <?php } ?> ><?php echo ucwords(strtolower($SearchVal[KD_Name])); ?></td>
	  <td <?php if($reportby == 'DSR_Name') { ?><?php } ?>><?php echo ucwords(strtolower($SearchVal[DSR_Name])); ?></td>	
	  <td <?php if($reportby == 'ASM_Name') { ?><?php } ?>><?php echo ucwords(strtolower($SearchVal[ASM_Name])); ?></td>
	  <td <?php if($reportby == 'RSM_Name') { ?><?php } ?>><?php echo ucwords(strtolower($SearchVal[RSM_Name])); ?></td>
	  <td <?php if($reportby == 'Customer_Name') { ?> <?php } ?>><?php echo ucwords(strtolower($SearchVal[Customer_Name])); ?></td>	
	 <td ><?php echo $SearchVal[PREVAL]; ?></td>	
	  <td>&nbsp; <table  width="100%"><tr><td><?php echo $SearchVal[SALVAL]; ?></td><td><?php echo $SearchVal[COLVAL]; ?></td><td><?php echo $SearchVal[BALVAL]; ?></td></tr></table></td>
	  <td ><?php echo number_format(trim($SearchVal[TOTALBAL])); ?></td>	
	  <td ><?php echo number_format(trim($SearchVal[AVG_SAL])); ?></td>
	  <td ><?php echo number_format(trim($SearchVal[OSSALE])); ?></td>
 </tr>
 
 <?php $k++; } ?>
   <tr>
	 <td colspan="5" align="right"><strong><?php 
	 //echo $target_naira	. " == " . $target_units . " == " . $SUM_SQ . " == " . $VALUE_NAIRA . " == " . $diff_units . " == " . $diff_naira. " == " .  $subtotalcheckfor. "<br/>";
	 
	 //echo $checkfor ."==" .$checkoutfor."<br>"; ?> Sub Total<strong></td>
	  <td>&nbsp;<?php echo number_format(trim($total_preout)); ?></td>
	  <td>&nbsp;
	  <table  width="100%"><tr><td><?php echo number_format(trim($total_salval)); ?></td><td><?php echo number_format(trim($total_colval)); ?></td><td><?php echo number_format(trim($total_balval)); ?></td></tr></table>
	  </td>
	  <td>&nbsp;<?php echo number_format(trim($total_totbal)); ?></td>	
	  <td>&nbsp;<?php echo number_format(trim($total_avgsal)); ?></td>	
	  <td>&nbsp;<?php echo number_format(trim($total_ossal)); ?></td>	
 </tr>
  <tr>
	<td colspan="5" align="right"><strong><?php 
	 //echo $target_naira	. " == " . $target_units . " == " . $SUM_SQ . " == " . $VALUE_NAIRA . " == " . $diff_units . " == " . $diff_naira. " == " .  $subtotalcheckfor. "<br/>";
	 
	 //echo $checkfor ."==" .$checkoutfor."<br>"; ?> Grand Total<strong></td>
	  <td>&nbsp;<?php echo number_format(trim($tot_preout)); ?></td>
	  <td>&nbsp;
	  <table  width="100%"><tr><td><?php echo number_format(trim($tot_salval)); ?></td><td><?php echo number_format(trim($tot_colval)); ?></td><td><?php echo number_format(trim($tot_balval)); ?></td></tr></table>
	  </td>
	  <td>&nbsp;<?php echo number_format(trim($tot_totbal)); ?></td>	
	  <td>&nbsp;<?php echo number_format(trim($tot_avgsal)); ?></td>	
	  <td>&nbsp;<?php echo number_format(trim($tot_ossal)); ?></td>	
 </tr>
 </tbody>	
</table>
	</div>
<span id="printopen" style="padding-left:580px;padding-top:10px;<?php if($num_rows > 0 ) { echo "display:block;"; } else { echo "display:none;"; } ?>" ><input type="button" name="kdproduct" value="Print" class="buttons" onclick="hideprintbutton();"></span>
<?php } else { ?>
 <tr>
	<td colspan="9" align='center'><strong>NO RECORDS FOUND</strong></td>
 </tr>
<?php } exit(0); ?>