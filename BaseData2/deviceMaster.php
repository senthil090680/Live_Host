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
<div align="center"><h2>Device Master</h2></div>
<div id="search" style="margin-right:70px;">
<form action="" method="get" name="master" id="master">
<input type="text" name="device_code" value="<?php echo $_GET['device_code']; ?>" autocomplete='off' placeholder='Search By Code'/>
<input type="submit" name="submit" value="Go" class="buttonsg"/>
</form>  
</div>
<div class="clearfix"></div>
<div id="containerBD">
  		<?php
		if($_GET['device_id']!='')
		{
	    $qry="SELECT *  FROM `device_master` where  device_id LIKE '%".$_GET['device_code']."%'  order by device_description asc";
		}
		else
		{ 
		$qry="SELECT *  FROM `device_master` order by device_description asc";
		}
		$results=mysql_query($qry);
		$num_rows= mysql_num_rows($results);			
		$pager = new PS_Pagination($bd, $qry,15,15);
		$results = $pager->paginate();
		?>
        <div class="con3">
        <table id="sort"  align="center" width="100%">
  		<thead>
		<tr>
		<th>KD Name</th>
		<th class="rounded tablesorter" valign="top">Description<img src="../images/sort.png" width="13" height="13" /></th>
   		<th>Code</th>
		<th>Specification</th>
<!-- 		<th>SIM</th>
 -->		</tr>
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
		<td><?php echo $fetch['device_description'];?></td>
		<td><?php echo $fetch['device_code'];?></td>
		<td><?php echo $fetch['device_serial_number'];?></td>
<!-- 		<td><?php echo $fetch['device_call_no'];?></td>
 -->       
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