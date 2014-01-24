<?php
//Connect to database from here
include "../include/config.php";
include "../include/ps_pagination.php";

EXTRACT($_POST);
$sel="SELECT *  FROM `sales_representative` where DSR_mapped='yes'";
$sel_query=mysql_query($sel);
$fetch=mysql_fetch_array($sel_query);
$sr=$fetch['Salesperson_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/admin.css" rel="stylesheet" type="text/css" />
<title>Host </title>
</head>
<body topmargin="0">
<h2 align="center">DSR Master </h2>
        <div class="clearfix"></div>
		<?php
		$qry="SELECT *  FROM `dsr` Where Salesperson_id = '$sr'";
		$results=mysql_query($qry);
		$num_rows= mysql_num_rows($results);			
		$pager = new PS_Pagination($bd, $qry,15,15);
		$results = $pager->paginate();
		?>
        <div class="con3" style="width:100%">
        <table id="sort" class="tablesorter" align="center" border="0" width="100%">
		<thead>
		<tr>
		<th width="11%">KD Name</th>
   		<th width="14%" class="rounded">DSR Name<img src="../images/sort.png" width="13" height="13" /></th>
  		<th width="8%">Code</th>
   		<th width="45%">Contact Number</th>
		<th width="6%">City</th>
        <th width="6%">SalesPerson ID</th>
	
		</tr>
		</thead>
		<tbody>
		<?php
		if(!empty($num_rows)){
		$c=0;$cc=1;
		while($fetch = mysql_fetch_array($results)) {
		if($c % 2 == 0){ $cls =""; } else{ $cls ="class='odd'"; }
		?>		
		<tr>
		<td><?php echo $fetch['KD_Name'];?></td>
		<td><?php echo $fetch['DSRName'];?></td>
		<td><?php echo $fetch['DSR_Code'];?></td>
		<td><?php echo $fetch['Contact_Number'];?></td>
        <td><?php echo $fetch['city'];?></td>
    	<td><?php echo $fetch['Salesperson_id'];?></td>
       </tr>
		<?php $c++; $cc++; }		 
		}else{  echo "<tr><td align='center' colspan='13'><b>No records found</b></td></tr>";}  ?>
		</tbody>
		</table>
</div>
<!--Pagination  -->
 
		<?php 
		if($num_rows > 10){?>     
        <div class="paginationfile" align="center">
	    <?php 
		if(!empty($num_rows)){
		//Display the link to first page: First
		echo $pager->renderFirst()."&nbsp; ";
		//Display the link to previous page: <<
		echo $pager->renderPrev();
		//Display page links: 1 2 3
		echo $pager->renderNav();
		//Display the link to next page: >>
		echo $pager->renderNext()."&nbsp; ";
		//Display the link to last page: Last
		echo $pager->renderLast(); } else{ echo "&nbsp;"; } ?>      
		</div>   
		<?php } else{ echo "&nbsp;"; }?>



