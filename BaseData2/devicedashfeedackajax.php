<?php
session_start();
ob_start();
require_once "../include/config.php";
require_once "../include/ajax_pagination.php";
if(isset($_GET['logout'])){
	session_destroy();
	header("Location:../index.php");
}
extract($_GET);
$params=$fromdate."&".$todate."&".$KDCodeVal."&".$DSR_CodeVal;
if(isset($_GET[KDCodeVal]) && $_GET[KDCodeVal] !='') {
	$nextrecval		=	"WHERE (Date >= '$fromdate' AND Date <= '$todate' AND KD_Code = '$KDCodeVal' AND DSR_Code = '$DSR_CodeVal')";						 
} else {
	echo "Invalid Query"; exit(0);
}
$where		=	"$nextrecval";

if(isset($_GET) && $_GET !='')
{
	$qry="SELECT * FROM `feedback` $where";
}
else
{ 
	echo "Invalid Query";
	exit;
}
$results_dsr=mysql_query($qry) or die(mysql_error());
//$pager = new PS_Pagination($bd, $qry,5,5);
//$results = $pager->paginate();
$num_rows= mysql_num_rows($results_dsr) or die(mysql_error());
//$row_dsr= mysql_fetch_array($results_dsr); 


/********************************pagination start***********************************/
$strPage = $_REQUEST[page];
//$params = $_REQUEST[params];

//if($_REQUEST[mode]=="Listing"){
//$Num_Rows = mysql_num_rows ($res_search);

########### pagins

$Per_Page = 1;   // Records Per Page

$Page = $strPage;
if(!$strPage)
{
$Page=1;
}

$Prev_Page = $Page-1;
$Next_Page = $Page+1;

$Page_Start = (($Per_Page*$Page)-$Per_Page);
if($num_rows<=$Per_Page)
{
$Num_Pages =1;
}
else if(($num_rows % $Per_Page)==0)
{
$Num_Pages =($num_rows/$Per_Page) ;
}
else
{
$Num_Pages =($num_rows/$Per_Page)+1;
$Num_Pages = (int)$Num_Pages;
}
$qry.="  LIMIT $Page_Start , $Per_Page";
$results_dsr = mysql_query($qry) or die(mysql_error());
/********************************pagination***********************************/

?>
<div class="conitems">
	<table id="sort" class="tablesorter" width="100%">
	<thead>
	<tr>
		<th align="center" colspan="11"><h2>Feedback</h2></th>
	</tr>
	<tr>
		<th align="center">Feedback Category</th>
		<th align="center">Date</th>
		<th align="center">Feedback</th>
	</tr>
	</thead>
	<tbody>
	<?php
	if(!empty($num_rows)){
	$c=0;$cc=1;$totalval=0;
	while($fetch = mysql_fetch_array($results_dsr)) {
	if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }
	$devtransactionid			=		$fetch['id'];
	$DateVal					=		$fetch['Date'];
	$Feedback_type				=		$fetch['Feedback_type'];
	$Feedback					=		$fetch['Feedback'];
	?>
	<tr>
		<td align="center"><?php $sel_feedtype	=	"SELECT * FROM `feedback_type` WHERE id = '$Feedback_type'";
$results_feedtype	=	mysql_query($sel_feedtype);
$rowcnt_feedtype	=	mysql_num_rows($results_feedtype);
	if($rowcnt_feedtype > 0) { 
		$row_feedtype	=	mysql_fetch_array($results_feedtype);
		echo $row_feedtype[feedback_type]; 
	} ?></td>
		<td align="center"><?php echo $DateVal;?></td>
		<td align="center"><?php echo $Feedback;?></td>
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
<div class="paginationfile" align="center">
	<table>
		<tr>
			<th class="pagination" scope="col">          
				<?php 				
			if(!empty($num_rows)){									
				/*
				//Display the link to first page: First
				echo $pager->renderFirst()."&nbsp; ";
				//Display the link to previous page: <<
				echo $pager->renderPrev();
				//Display page links: 1 2 3
				echo $pager->renderNav();
				//Display the link to next page: >>
				echo $pager->renderNext()."&nbsp; ";
				//Display the link to last page: Last
				echo $pager->renderLast(); } else{ echo "&nbsp;"; */				
				rend_devdashfeedajaxpag($Num_Pages,$Page,$Prev_Page,$Next_Page,$params);
			}				
			?>      
			</th>
		</tr>
	</table>
</div>
<?php //print_r($row_dsr);
exit(0); ?>