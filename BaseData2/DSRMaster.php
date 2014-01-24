<?php
session_start();
ob_start();
include('../include/header.php');
include "../include/ps_pagination.php";
if(isset($_GET['logout'])){
session_destroy();
header("Location:../index.php");
}
?>
<!------------------------------- Form -------------------------------------------------->
<div id="mainarea">
<div class="mcf"></div>
<div><h2 align="center">DSR Master</h2></div>
    <div id="search" style="margin-right:70px;">
    <form action="" method="get" name="master" id="master">
    <input type="text" name="DSRName" value="<?php echo $_GET['DSRName']; ?>" autocomplete='off' placeholder='Search By Name'/>
    <input type="submit" name="submit" value="Go" class="buttonsg"/>
    </form>  
    </div>
<div id="containerBD">
        <div class="clearfix"></div>
		<?php
		if($_GET['Salesrep_name']!='')
		{
	    $qry="SELECT *  FROM `dsr` where DSRName LIKE '%".$_GET['DSRName']."%'  order by DSRName asc";
		}
		else
		{ 
		$qry="SELECT *  FROM `dsr` order by DSRName asc";
		}	
		$results=mysql_query($qry);
		$num_rows= mysql_num_rows($results);			
		$pager = new PS_Pagination($bd, $qry,15,15);
		$results = $pager->paginate();
		?>
        <div class="con3">
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

	</div>   
        
<!--Messages-->
</div>
<?php include('../include/footer.php'); ?>