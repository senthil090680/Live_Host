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
		$kdcodestr			=	$kdcode;
		/*if(is_array($kdcode)) {
			$kdcodestr			=	implode("','",$kdcode);
		} else {
			$kdcodestr			=	str_replace(",","','",$kdcode);
		}
		echo $kdcodestr;*/
		$complete_query		=	" WHERE KD_Code IN ('".$kdcodestr."')";
		$target_query		.=	" WHERE KD_Code IN ('".$kdcodestr."')";
		$monthplan_query	.=	" WHERE KD_Code IN ('".$kdcodestr."')";
	}


	if($asmcode	==	'' || $asmcode == 'null') {
		$asmcodecol		=	'';
		$wherefordsr	=	'';
	} elseif($asmcode	!=	'') {
		//$asmcodestr		=	implode("','",$asmcode);
		$asmcodestr		=	$asmcode;
		$asmcodecol		=	"ASM IN ('".$asmcodestr."')";
		$asmcodecolval	=	"DSR_Code IN ('".$asmcodestr."')";
		$wherefordsr	=	'WHERE';
	}

	//$DSR_Codestr		=	findSR($wherefordsr,$asmcodecolval);

	if($rsmcode	==	'' || $rsmcode == 'null') {
		$rsmcodecol		=	'';
	} elseif($rsmcode	!=	'') {
		//$rsmcodestr		=	implode("','",$rsmcode);
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
	
	if($target_query	==	'') {		
		$propmonthsval		=	ltrim($propmonths,0);
		$target_query		.=	" WHERE monthval = '$propmonthsval' AND yearval = '$propyears'";
	} else if($target_query	!=	'') {
		$propmonthsval			=	ltrim($propmonths,0);
		$target_query		.=	" AND monthval = '$propmonthsval' AND yearval = '$propyears'";
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

	$query_dsrmetrics	=   "SELECT id,KD_Code,DSR_Code,sum(visit_Count) AS VISIT_CNT,SUM(Invoice_Count) AS INVOICE_CNT,SUM(effective_Count) AS EFF_CNT ,SUM(productive_Count) AS PRO_CNT FROM dsr_metrics $complete_query GROUP BY DSR_Code";
	//echo $query_dsrmetrics;
	//exit;

	$res_dsrmetrics											=   mysql_query($query_dsrmetrics);
	$rowcnt_dsrmetrics										=   mysql_num_rows($res_dsrmetrics);	
	if($rowcnt_dsrmetrics > 0) {
		while($row_dsrmetrics								=   mysql_fetch_assoc($res_dsrmetrics)) {		
			$metricsInfo[]									=	$row_dsrmetrics;
			$kdcode_metrics[]								=	$row_dsrmetrics["KD_Code"];
			$dsrcode_metrics[]								=	$row_dsrmetrics["DSR_Code"];
		}
	}	

	$kdcode_metrics		=	array_unique($kdcode_metrics);
	$kdcode_Total		=	implode("','",$kdcode_metrics);

	$dsrcode_metrics		=	array_unique($dsrcode_metrics);
	$dsrcode_Total		=	implode("','",$dsrcode_metrics);

	//pre($metricsInfo);
	//exit;
	
	$finalSearchInfo					=	$metricsInfo;
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
			$finalkdInfo[$i]["VISIT_CNT"]							=   $val_kd["VISIT_CNT"];
			$finalkdInfo[$i]["INVOICE_CNT"]							=   $val_kd["INVOICE_CNT"];
			$finalkdInfo[$i]["EFF_CNT"]								=   $val_kd["EFF_CNT"];
			$finalkdInfo[$i]["PRO_CNT"]								=   $val_kd["PRO_CNT"];
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
			$finaldsrInfo[$i]["VISIT_CNT"]							=   $val_dsr["VISIT_CNT"];
			$finaldsrInfo[$i]["INVOICE_CNT"]						=   $val_dsr["INVOICE_CNT"];
			$finaldsrInfo[$i]["EFF_CNT"]							=   $val_dsr["EFF_CNT"];
			$finaldsrInfo[$i]["PRO_CNT"]							=   $val_dsr["PRO_CNT"];
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
			$finalasmInfo[$i]["VISIT_CNT"]							=   $val_asm["VISIT_CNT"];
			$finalasmInfo[$i]["INVOICE_CNT"]						=   $val_asm["INVOICE_CNT"];
			$finalasmInfo[$i]["EFF_CNT"]							=   $val_asm["EFF_CNT"];
			$finalasmInfo[$i]["PRO_CNT"]							=   $val_asm["PRO_CNT"];
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
			$finalrsmInfo[$i]["VISIT_CNT"]							=   $val_rsm["VISIT_CNT"];
			$finalrsmInfo[$i]["INVOICE_CNT"]						=   $val_rsm["INVOICE_CNT"];
			$finalrsmInfo[$i]["EFF_CNT"]							=   $val_rsm["EFF_CNT"];
			$finalrsmInfo[$i]["PRO_CNT"]							=   $val_rsm["PRO_CNT"];			
			$i++;
		}
		$k++;
	}

	$finalSearchInfo          =   $finalrsmInfo;
	//pre($finalSearchInfo);
	//exit;		

	$query_route										=   "SELECT id,KD_Code,DSR_Code,day1,day2,day3,day4,day5,day6,day7,day8,day9,day10,day11,day12,day13,day14,day15,day16,day17,day18,day19,day20,day21,day22,day23,day24,day25,day26,day27,day28,day29,day30,day31 FROM routemonthplan $monthplan_query";
	//echo $query_route;
	//exit;

	$res_route											=   mysql_query($query_route);
	while($row_route									=   mysql_fetch_assoc($res_route)) {
		//$routeInfo[$row_route["DSR_Code"]]				=	array_filter(array_unique(array($row_route[day1],$row_route[day2],$row_route[day3],$row_route[day4],$row_route[day5],$row_route[day6],$row_route[day7],$row_route[day8],$row_route[day9],$row_route[day10],$row_route[day11],$row_route[day12],$row_route[day13],$row_route[day14],$row_route[day15],$row_route[day16],$row_route[day17],$row_route[day18],$row_route[day19],$row_route[day20],$row_route[day21],$row_route[day22],$row_route[day23],$row_route[day24],$row_route[day25],$row_route[day26],$row_route[day27],$row_route[day28],$row_route[day29],$row_route[day30],$row_route[day31])));
		$routeInfoCount[$row_route["DSR_Code"]]				=	array_filter(array($row_route[day1],$row_route[day2],$row_route[day3],$row_route[day4],$row_route[day5],$row_route[day6],$row_route[day7],$row_route[day8],$row_route[day9],$row_route[day10],$row_route[day11],$row_route[day12],$row_route[day13],$row_route[day14],$row_route[day15],$row_route[day16],$row_route[day17],$row_route[day18],$row_route[day19],$row_route[day20],$row_route[day21],$row_route[day22],$row_route[day23],$row_route[day24],$row_route[day25],$row_route[day26],$row_route[day27],$row_route[day28],$row_route[day29],$row_route[day30],$row_route[day31])); // to find the 
	}

	//pre($routeInfo);
	//exit;
	
	/*foreach($routeInfo AS $routeInx=>$routeArr) {
		$routestr		=	implode("','",$routeArr);
		$routestring[$routeInx][CNTID]	=	findCustomerCount($routestr,$routeInx);
		$routestring[$routeInx][DSRID]	=	$routeInx;
	}*/
	
	
	foreach($routeInfoCount AS $routeFindKey=>$routeFind) {
		$routeCntCus[$routeFindKey]		=	array_count_values($routeFind);
	}
	//pre($routeCntCus);
	//exit;
	foreach($routeCntCus AS $rtecntKey=>$rtecntVal) {
		foreach($rtecntVal AS $rtevalKey=>$rtevalVal) {
			$actualcus						=	findCustomerCount($rtevalKey,$rtecntKey);
			//echo $actualcus."<br>";
			//echo $rtevalVal."<br>";
			$routestring[$rtecntKey][CNTID]			+=	($actualcus*$rtevalVal);
			$routestring[$rtecntKey][DSRID]			=	$rtecntKey;
		}
		//$routeCntCust[$rtecntKey.]		=	;
	}

	//pre($routestring);
	//exit;

	$i=0;
	$k=0;
	foreach($finalSearchInfo as $val_route){
		//echo $routestring[$val_route["DSRCode"]][DSRID] . "-". $val_route["DSRCode"]."<br>";
		if($routestring[$val_route["DSRCode"]][DSRID] == $val_route["DSRCode"]) {                                     
			$finalrouteInfo[$i]["ASM_Name"]							=   $val_route["ASM_Name"];
			$finalrouteInfo[$i]["ASM_Id"]							=   $val_route["ASM_Id"];
			$finalrouteInfo[$i]["RSM_Name"]							=   $val_route["RSM_Name"];
			$finalrouteInfo[$i]["RSM_Id"]							=   $val_route["RSM_Id"];
			$finalrouteInfo[$i]["DSR_Name"]							=   $val_route["DSR_Name"];
			$finalrouteInfo[$i]["DSRCode"]							=   $val_route["DSRCode"];
			$finalrouteInfo[$i]["KD_Name"]							=   $val_route["KD_Name"];
			$finalrouteInfo[$i]["KD_Code"]							=   $val_route["KD_Code"];
			$finalrouteInfo[$i]["VISIT_CNT"]						=   $val_route["VISIT_CNT"];
			$finalrouteInfo[$i]["INVOICE_CNT"]						=   $val_route["INVOICE_CNT"];
			$finalrouteInfo[$i]["EFF_CNT"]							=   $val_route["EFF_CNT"];
			$finalrouteInfo[$i]["PRO_CNT"]							=   $val_route["PRO_CNT"];			
			$finalrouteInfo[$i]["TOTALCUS"]							=   $routestring[$val_route["DSRCode"]][CNTID];
			$finalrouteInfo[$i]["COVACT"]							=   round($finalrouteInfo[$i]["EFF_CNT"]/$finalrouteInfo[$i]["TOTALCUS"]);
			$finalrouteInfo[$i]["EFFACT"]							=   round($finalrouteInfo[$i]["PRO_CNT"]/$finalrouteInfo[$i]["TOTALCUS"]);
			$finalrouteInfo[$i]["PROACT"]							=   round($finalrouteInfo[$i]["INVOICE_CNT"]/$finalrouteInfo[$i]["VISIT_CNT"]);
			$i++;
		}
		$k++;
	}

	$finalSearchInfo          =   $finalrouteInfo;



	$orderbycolumns     =   'DSR_Code';
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
	$query_target									=   "SELECT KD_Code,SR_Code,monthval,yearval,coverage_percent,productive_percent,effective_percent,cov_visit,prod_visit,eff_visit,cov_status,prod_status,eff_status,tgtTypeCov,tgtTypeProd,tgtTypeEff FROM coverage_target_setting $target_query ORDER BY SR_Code";
	//echo $query_target;
	//exit;
	$res_target													=   mysql_query($query_target);
	while($row_target											=   mysql_fetch_assoc($res_target)) {
		//$targetNaira[$SR_Code.$KD_Code]["coverage_percent"]		=	0;
		//$targetUnits[$SR_Code.$KD_Code]["effective_percent"]	=	0;
		$SR_Code												=	$row_target[SR_Code];
		$KD_Code												=	$row_target[KD_Code];
		if($row_target["coverage_percent"] == '') { 
			$targetNaira[$SR_Code.$KD_Code]["coverage_percent"]		=	0;
		} else {
			$targetNaira[$SR_Code.$KD_Code]["coverage_percent"]		=	$row_target["coverage_percent"];
		}
		if($row_target["effective_percent"] == '') {
			$targetUnits[$SR_Code.$KD_Code]["effective_percent"]	=	0;
		} else {
			$targetUnits[$SR_Code.$KD_Code]["effective_percent"]	=	$row_target["effective_percent"];
		}
		
		$targetInfo[$SR_Code.$KD_Code]							=	$SR_Code.$KD_Code;
	}

	
	//pre($targetInfo);
	//pre($targetNaira);
	//pre($targetUnits);
	//pre($finalSearchInfo);
	//exit;
	$i=0;
	foreach($finalSearchInfo as $val_target)	{
		$SRCODEVAL			=	$val_target["DSRCode"];
		$KD_CODE			=	$val_target["KD_Code"];

		$INDEX_VAL			=	$SRCODEVAL.$KD_CODE;
		//echo	$targetInfo[$INDEX_VAL]	. "==".	$INDEX_VAL."<br>"; 
		if($targetInfo[$INDEX_VAL]	==	$INDEX_VAL) {
			$finalSearchInfo[$i]["COV_TGT"]			=   $targetNaira[$INDEX_VAL]["coverage_percent"];
			$finalSearchInfo[$i]["EFF_TGT"]			=   $targetUnits[$INDEX_VAL]["effective_percent"];
		}
		$i++;
	}
	//pre($finalSearchInfo);
	//exit;

	//echo $reportby;
	//exit;

	if($reportby == 'SR_Name') {
		$orderbycolumns     =   "DSR_Name";
	} else {
		$orderbycolumns     =   $reportby;
	}
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


<title>KD COVERAGE REPORT</title>
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
#errormsgkdcov {
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
.myalignkdcov {
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
		<th align="center" colspan="10">KD COVERAGE REPORT</th>
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
		<th align="center" style="width:10%">Total Customers Per Plan (A)</th>
		<th align="center" style="width:10%">Total Customers Visited Once (B)</th>
		<th align="center" style="width:10%">Coverage %(B/A)
			 <table  width="100%"><tr><td>Target</td><td>Actual</td></tr></table>
		</th>
		<th align="center" style="width:10%">Total Customers Sold Atleast Once(C)</th>
		 <th align="center" style="width:10%">Effective Coverage%(C/A)
		<table  width="100%"><tr><td>Target</td><td>Actual</td></tr></table>
		</th>
		 <th align="center" style="width:10%">Total Including Repeat Cus Visits
		 <table  width="100%"><tr><td>Visits</td><td>Sale Visits</td><td>Productive Coverage(%)</td></tr></table>
		 </th>        
  </tr>
  </thead>
 <tbody>

 <?php	$checkfor				=	'';
		$checkoutfor			=	'';
		$k						=	0;
		$arrcnt					=	count($finalSearchInfo);
		$subtotalcheckfor		=	1;
		$total_cus_plan			=	'';
		$total_cus_vis			=	'';
		$total_cov_act			=	'';
		$total_cov_tgt			=	'';
		$total_sales_once		=	'';
		$total_eff_act			=	'';
		$total_eff_tgt			=	'';
		$total_vists			=	'';
		$total_sales			=	'';
		$total_prod_cov			=	'';

if($arrcnt > 0) {
 foreach($finalSearchInfo AS $SearchKey=>$SearchVal) { 
	$tot_cus_plan			+=	$SearchVal["TOTALCUS"];
	$tot_cus_vis			+=	$SearchVal["EFF_CNT"];
	$tot_cov_act			+=	$SearchVal["COVACT"];
	$tot_cov_tgt			+=	$SearchVal["COV_TGT"];
	$tot_sales_once		+=	$SearchVal["PRO_CNT"];
	$tot_eff_act			+=	$SearchVal["EFFACT"];
	$tot_eff_tgt			+=	$SearchVal["EFF_TGT"];
	$tot_vists			+=	$SearchVal["VISIT_CNT"];
	$tot_sales			+=	$SearchVal["INVOICE_CNT"];
	$tot_prod_cov			+=	$SearchVal["PROACT"];

	if($reportby == 'KD_Name') {
		if($checkfor		==	'') {
			$checkfor		=	$SearchVal["KD_Name"];
			$checkoutfor	=	$SearchVal["KD_Name"];
			
			$total_cus_plan			=	'';
			$total_cus_vis			=	'';
			$total_cov_act			=	'';
			$total_cov_tgt			=	'';
			$total_sales_once		=	'';
			$total_eff_act			=	'';
			$total_eff_tgt			=	'';
			$total_vists			=	'';
			$total_sales			=	'';
			$total_prod_cov			=	'';

			if($subtotalcheckfor == 2) {
				$subtotalcheckfor = 1;
				$total_cus_plan			+=	$SearchVal["TOTALCUS"];
				$total_cus_vis			+=	$SearchVal["EFF_CNT"];
				$total_cov_act			+=	$SearchVal["COVACT"];
				$total_cov_tgt			+=	$SearchVal["COV_TGT"];
				$total_sales_once		+=	$SearchVal["PRO_CNT"];
				$total_eff_act			+=	$SearchVal["EFFACT"];
				$total_eff_tgt			+=	$SearchVal["EFF_TGT"];
				$total_vists			+=	$SearchVal["VISIT_CNT"];
				$total_sales			+=	$SearchVal["INVOICE_CNT"];
				$total_prod_cov			+=	$SearchVal["PROACT"];
			}
		} else {
			$checkoutfor	=	$SearchVal["KD_Name"];
			if($subtotalcheckfor == 1) {
				$total_cus_plan			+=	$SearchVal["TOTALCUS"];
				$total_cus_vis			+=	$SearchVal["EFF_CNT"];
				$total_cov_act			+=	$SearchVal["COVACT"];
				$total_cov_tgt			+=	$SearchVal["COV_TGT"];
				$total_sales_once		+=	$SearchVal["PRO_CNT"];
				$total_eff_act			+=	$SearchVal["EFFACT"];
				$total_eff_tgt			+=	$SearchVal["EFF_TGT"];
				$total_vists			+=	$SearchVal["VISIT_CNT"];
				$total_sales			+=	$SearchVal["INVOICE_CNT"];
				$total_prod_cov			+=	$SearchVal["PROACT"];
			}
		}
	} elseif($reportby == 'ASM_Name') {
		if($checkfor		==	'') {
			$checkfor		=	$SearchVal["ASM_Name"];
			$checkoutfor	=	$SearchVal["ASM_Name"];
			
			$total_cus_plan			=	'';
			$total_cus_vis			=	'';
			$total_cov_act			=	'';
			$total_cov_tgt			=	'';
			$total_sales_once		=	'';
			$total_eff_act			=	'';
			$total_eff_tgt			=	'';
			$total_vists			=	'';
			$total_sales			=	'';
			$total_prod_cov			=	'';

			if($subtotalcheckfor == 2) {
				$subtotalcheckfor = 1;
				$total_cus_plan			+=	$SearchVal["TOTALCUS"];
				$total_cus_vis			+=	$SearchVal["EFF_CNT"];
				$total_cov_act			+=	$SearchVal["COVACT"];
				$total_cov_tgt			+=	$SearchVal["COV_TGT"];
				$total_sales_once		+=	$SearchVal["PRO_CNT"];
				$total_eff_act			+=	$SearchVal["EFFACT"];
				$total_eff_tgt			+=	$SearchVal["EFF_TGT"];
				$total_vists			+=	$SearchVal["VISIT_CNT"];
				$total_sales			+=	$SearchVal["INVOICE_CNT"];
				$total_prod_cov			+=	$SearchVal["PROACT"];
			}
		} else {
			$checkoutfor	=	$SearchVal["ASM_Name"];
			if($subtotalcheckfor == 1) {
				$total_cus_plan			+=	$SearchVal["TOTALCUS"];
				$total_cus_vis			+=	$SearchVal["EFF_CNT"];
				$total_cov_act			+=	$SearchVal["COVACT"];
				$total_cov_tgt			+=	$SearchVal["COV_TGT"];
				$total_sales_once		+=	$SearchVal["PRO_CNT"];
				$total_eff_act			+=	$SearchVal["EFFACT"];
				$total_eff_tgt			+=	$SearchVal["EFF_TGT"];
				$total_vists			+=	$SearchVal["VISIT_CNT"];
				$total_sales			+=	$SearchVal["INVOICE_CNT"];
				$total_prod_cov			+=	$SearchVal["PROACT"];
			}
		}
	} elseif($reportby == 'RSM_Name') {
		if($checkfor		==	'') {
			$checkfor		=	$SearchVal["RSM_Name"];
			$checkoutfor	=	$SearchVal["RSM_Name"];
			
			$total_cus_plan			=	'';
			$total_cus_vis			=	'';
			$total_cov_act			=	'';
			$total_cov_tgt			=	'';
			$total_sales_once		=	'';
			$total_eff_act			=	'';
			$total_eff_tgt			=	'';
			$total_vists			=	'';
			$total_sales			=	'';
			$total_prod_cov			=	'';

			if($subtotalcheckfor == 2) {
				$subtotalcheckfor = 1;
				$total_cus_plan			+=	$SearchVal["TOTALCUS"];
				$total_cus_vis			+=	$SearchVal["EFF_CNT"];
				$total_cov_act			+=	$SearchVal["COVACT"];
				$total_cov_tgt			+=	$SearchVal["COV_TGT"];
				$total_sales_once		+=	$SearchVal["PRO_CNT"];
				$total_eff_act			+=	$SearchVal["EFFACT"];
				$total_eff_tgt			+=	$SearchVal["EFF_TGT"];
				$total_vists			+=	$SearchVal["VISIT_CNT"];
				$total_sales			+=	$SearchVal["INVOICE_CNT"];
				$total_prod_cov			+=	$SearchVal["PROACT"];
			}
		} else {
			$checkoutfor	=	$SearchVal["RSM_Name"];
			if($subtotalcheckfor == 1) {
				$total_cus_plan			+=	$SearchVal["TOTALCUS"];
				$total_cus_vis			+=	$SearchVal["EFF_CNT"];
				$total_cov_act			+=	$SearchVal["COVACT"];
				$total_cov_tgt			+=	$SearchVal["COV_TGT"];
				$total_sales_once		+=	$SearchVal["PRO_CNT"];
				$total_eff_act			+=	$SearchVal["EFFACT"];
				$total_eff_tgt			+=	$SearchVal["EFF_TGT"];
				$total_vists			+=	$SearchVal["VISIT_CNT"];
				$total_sales			+=	$SearchVal["INVOICE_CNT"];
				$total_prod_cov			+=	$SearchVal["PROACT"];
			}
		}		
	} elseif($reportby == 'SR_Name') {
		if($checkfor		==	'') {
			$checkfor		=	$SearchVal["DSR_Name"];
			$checkoutfor	=	$SearchVal["DSR_Name"];
			
			$total_cus_plan			=	'';
			$total_cus_vis			=	'';
			$total_cov_act			=	'';
			$total_cov_tgt			=	'';
			$total_sales_once		=	'';
			$total_eff_act			=	'';
			$total_eff_tgt			=	'';
			$total_vists			=	'';
			$total_sales			=	'';
			$total_prod_cov			=	'';

			if($subtotalcheckfor == 2) {
				$subtotalcheckfor = 1;
				$total_cus_plan			+=	$SearchVal["TOTALCUS"];
				$total_cus_vis			+=	$SearchVal["EFF_CNT"];
				$total_cov_act			+=	$SearchVal["COVACT"];
				$total_cov_tgt			+=	$SearchVal["COV_TGT"];
				$total_sales_once		+=	$SearchVal["PRO_CNT"];
				$total_eff_act			+=	$SearchVal["EFFACT"];
				$total_eff_tgt			+=	$SearchVal["EFF_TGT"];
				$total_vists			+=	$SearchVal["VISIT_CNT"];
				$total_sales			+=	$SearchVal["INVOICE_CNT"];
				$total_prod_cov			+=	$SearchVal["PROACT"];
				//echo $target_naira	. " == " . $target_units . " == " . $SUM_SQ . " == " . $VALUE_NAIRA . " == " . $diff_units . " == " . $diff_naira. " == " .  $subtotalcheckfor. "indo<br/>";
			}

			//echo $target_naira	. " == " . $target_units . " == " . $SUM_SQ . " == " . $VALUE_NAIRA . " == " . $diff_units . " == " . $diff_naira. " == " .  $subtotalcheckfor. "good<br/>";
		} else {
			$checkoutfor	=	$SearchVal["DSR_Name"];

			if($subtotalcheckfor == 1) {
				$total_cus_plan			+=	$SearchVal["TOTALCUS"];
				$total_cus_vis			+=	$SearchVal["EFF_CNT"];
				$total_cov_act			+=	$SearchVal["COVACT"];
				$total_cov_tgt			+=	$SearchVal["COV_TGT"];
				$total_sales_once		+=	$SearchVal["PRO_CNT"];
				$total_eff_act			+=	$SearchVal["EFFACT"];
				$total_eff_tgt			+=	$SearchVal["EFF_TGT"];
				$total_vists			+=	$SearchVal["VISIT_CNT"];
				$total_sales			+=	$SearchVal["INVOICE_CNT"];
				$total_prod_cov			+=	$SearchVal["PROACT"];
			}
			//echo $target_naira	. " == " . $target_units . " == " . $SUM_SQ . " == " . $VALUE_NAIRA . " == " . $diff_units . " == " . $diff_naira. " == " .  $subtotalcheckfor. "nto<br/>";
		}
	}
 
 ?>
 <?php  //echo $checkfor ."==" .$checkoutfor."<br>"; 
 //echo $k . "+++++" . $arrcnt."<br/>";
	if((($checkfor == $checkoutfor) && ($checkfor != '' && $checkoutfor !='')) && ($k != $arrcnt)) {  		
		$subtotalcheckfor = 2;
		$total_cus_plan			+=	$SearchVal["TOTALCUS"];
		$total_cus_vis			+=	$SearchVal["EFF_CNT"];
		$total_cov_act			+=	$SearchVal["COVACT"];
		$total_cov_tgt			+=	$SearchVal["COV_TGT"];
		$total_sales_once		+=	$SearchVal["PRO_CNT"];
		$total_eff_act			+=	$SearchVal["EFFACT"];
		$total_eff_tgt			+=	$SearchVal["EFF_TGT"];
		$total_vists			+=	$SearchVal["VISIT_CNT"];
		$total_sales			+=	$SearchVal["INVOICE_CNT"];
		$total_prod_cov			+=	$SearchVal["PROACT"];
	} else {
		 
	if($k != 0) {
		 //echo $checkfor ."==" .$checkoutfor."<br>";
		 //$checkoutfor		=	$SearchVal["Brand_Name"];
	?>
	 <tr>
		 <td colspan="4" align="right"><strong><?php 
		 //echo $target_naira	. " == " . $target_units . " == " . $SUM_SQ . " == " . $VALUE_NAIRA . " == " . $diff_units . " == " . $diff_naira. " == " .  $subtotalcheckfor. "<br/>";
		 
		 //echo $checkfor ."==" .$checkoutfor."<br>"; ?> Sub Total<strong></td>
		  <td>&nbsp;<?php echo $total_cus_plan; ?></td>	
		   <td>&nbsp;<?php echo $total_cus_vis; ?></td>	
		  <td>&nbsp;
		  <table width="100%"><tr><td><?php echo $total_cov_tgt; ?></td><td><?php echo $total_cov_act; ?></td></tr></table>
		  </td>	
		  <td>&nbsp;<?php echo $total_sales_once; ?></td>	
		  <td>&nbsp;
		  <table width="100%"><tr><td><?php echo $total_eff_tgt; ?></td><td><?php echo $total_eff_act; ?></td></tr></table>
		  </td>	
		  <td>&nbsp;
		  <table  width="100%"><tr><td><?php echo $total_vists; ?></td><td><?php echo $total_sales; ?></td><td><?php echo $total_prod_cov; ?></td></tr></table>
		  </td>
	 </tr>
<?php
	$checkfor			=	'';
	$subtotalcheckfor	=	'';
	$total_cus_plan			=	$SearchVal["TOTALCUS"];
	$total_cus_vis			=	$SearchVal["EFF_CNT"];
	$total_cov_act			=	$SearchVal["COVACT"];
	$total_cov_tgt			=	$SearchVal["COV_TGT"];
	$total_sales_once		=	$SearchVal["PRO_CNT"];
	$total_eff_act			=	$SearchVal["EFFACT"];
	$total_eff_tgt			=	$SearchVal["EFF_TGT"];
	$total_vists			=	$SearchVal["VISIT_CNT"];
	$total_sales			=	$SearchVal["INVOICE_CNT"];
	$total_prod_cov			=	$SearchVal["PROACT"];

	//echo $target_naira	. " == " . $target_units . " == " . $SUM_SQ . " == " . $VALUE_NAIRA . " == " . $diff_units . " == " . $diff_naira. " == " .  $subtotalcheckfor."<br/>";
} }


$checkfor	=	$checkoutfor;

?>
<tr>
	 <td <?php if($reportby == 'KD_Name') { ?> <?php } ?> ><?php echo ucwords(strtolower($SearchVal[KD_Name])); ?></td>
	  <td <?php if($reportby == 'SR_Name') { ?> <?php } ?> ><?php echo ucwords(strtolower($SearchVal[DSR_Name])); ?></td>	
	  <td <?php if($reportby == 'ASM_Name') { ?> <?php } ?> ><?php echo ucwords(strtolower($SearchVal[ASM_Name])); ?></td>
	  <td <?php if($reportby == 'RSM_Name') { ?> <?php } ?>><?php echo ucwords(strtolower($SearchVal[RSM_Name])); ?></td>	
	  <td ><?php echo $SearchVal[TOTALCUS]; ?></td>	
	  <td ><?php echo $SearchVal[EFF_CNT]; ?></td>	
	  <td>&nbsp;<table  width="100%"><tr><td><?php echo $SearchVal[COV_TGT]; ?></td><td><?php echo $SearchVal[COVACT]; ?></td></tr></table></td>
	  <td ><?php echo $SearchVal[PRO_CNT]; ?></td>
	  <td>&nbsp;<table  width="100%"><tr><td><?php echo $SearchVal[EFF_TGT]; ?></td><td><?php echo $SearchVal[EFFACT]; ?></td></tr></table></td>
	  <td>&nbsp; <table  width="100%"><tr><td><?php echo $SearchVal[VISIT_CNT]; ?></td><td><?php echo $SearchVal[INVOICE_CNT]; ?></td><td><?php echo $SearchVal[PROACT]; ?></td></tr></table></td>
 </tr>
 
 <?php $k++; } ?>
  <tr>
		 <td colspan="4" align="right"><strong><?php 
		 //echo $target_naira	. " == " . $target_units . " == " . $SUM_SQ . " == " . $VALUE_NAIRA . " == " . $diff_units . " == " . $diff_naira. " == " .  $subtotalcheckfor. "<br/>";
		 
		 //echo $checkfor ."==" .$checkoutfor."<br>"; ?> Sub Total<strong></td>
		  <td>&nbsp;<?php echo $total_cus_plan; ?></td>	
		   <td>&nbsp;<?php echo $total_cus_vis; ?></td>	
		  <td>&nbsp;
		  <table width="100%"><tr><td><?php echo $total_cov_tgt; ?></td><td><?php echo $total_cov_act; ?></td></tr></table>
		  </td>	
		  <td>&nbsp;<?php echo $total_sales_once; ?></td>	
		  <td>&nbsp;
		  <table width="100%"><tr><td><?php echo $total_eff_tgt; ?></td><td><?php echo $total_eff_act; ?></td></tr></table>
		  </td>	
		  <td>&nbsp;
		  <table  width="100%"><tr><td><?php echo $total_vists; ?></td><td><?php echo $total_sales; ?></td><td><?php echo $total_prod_cov; ?></td></tr></table>
		  </td>
	 </tr>
  <tr>
		 <td colspan="4" align="right"><strong><?php 
		 //echo $target_naira	. " == " . $target_units . " == " . $SUM_SQ . " == " . $VALUE_NAIRA . " == " . $diff_units . " == " . $diff_naira. " == " .  $subtotalcheckfor. "<br/>";
		 
		 //echo $checkfor ."==" .$checkoutfor."<br>"; ?> Grand Total<strong></td>
		  <td>&nbsp;<?php echo $tot_cus_plan; ?></td>	
		   <td>&nbsp;<?php echo $tot_cus_vis; ?></td>	
		  <td>&nbsp;
		  <table width="100%"><tr><td><?php echo $tot_cov_tgt; ?></td><td><?php echo $tot_cov_act; ?></td></tr></table>
		  </td>	
		  <td>&nbsp;<?php echo $tot_sales_once; ?></td>	
		  <td>&nbsp;
		  <table width="100%"><tr><td><?php echo $tot_eff_tgt; ?></td><td><?php echo $tot_eff_act; ?></td></tr></table>
		  </td>	
		  <td>&nbsp;
		  <table  width="100%"><tr><td><?php echo $tot_vists; ?></td><td><?php echo $tot_sales; ?></td><td><?php echo $tot_prod_cov; ?></td></tr></table>
		  </td>
	 </tr>
 </tbody>	
</table>
<span id="printopen" style="padding-left:580px;padding-top:10px;<?php if($num_rows > 0 ) { echo "display:block;"; } else { echo "display:none;"; } ?>" ><input type="button" name="kdproduct" value="Print" class="buttons" onclick="hideprintbutton();"></span>
<?php } else { ?>
 <tr>
	<td colspan="9" align='center'><strong>NO RECORDS FOUND</strong></td>
 </tr>
<?php } exit(0); ?>