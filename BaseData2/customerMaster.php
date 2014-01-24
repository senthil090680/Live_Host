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
<div><h2 align="center">Customer Master</h2></div>
<div id="search" style="margin-right:70px;">
<form action="" method="get" name="master" id="master">
<input type="text" name="Customer_Name" value="<?php echo $_GET['Customer_Name']; ?>" autocomplete='off' placeholder='Search By Name'/>
<input type="submit" name="submit" value="Go" class="buttonsg"/>
</form>  
</div>	
<div id="containerBD">
        <div class="clearfix"></div>
		<?php
		if($_GET['Customer_Name']!='')
		{
	    $qry="SELECT *  FROM `customer` where Customer_Name LIKE '%".$_GET['Customer_Name']."%' order by id asc";
		}
		else
		{ 
		$qry="SELECT *  FROM `customer` order by id asc";
		}
		$results=mysql_query($qry);
		$num_rows= mysql_num_rows($results);			
		$pager = new PS_Pagination($bd, $qry,10,10);
		$results = $pager->paginate();
		?>
        <div class="con3">
        <table id="sort" class="tablesorter" align="center">
		<thead>
		<tr>
		<th>KD Name</th>
   		<th class="rounded">Customer Name<img src="../images/sort.png" width="13" height="13" /></th>
   		<th>Code</th>
		<th>LGA</th>
		<th>City</th>
		<th>DSR</th>
		<th>Contact Person</th>
		<th>Contact Number</th>
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
		<td><?php echo $fetch['Customer_Name'];?></td>
		<td><a href="viewCustomerID.php?customer_code=<?php echo $fetch['customer_code']; ?>" class="customerCode" id="cus_code"><?php echo $fetch['customer_code'];?></a></td>
		<td><?php echo $fetch['lga'];?></td>
		<td><?php echo $fetch['City'];?></td>
		<td><?php echo $fetch['DSRName'];?></td>
		<td><?php echo $fetch['contactperson'];?></td>
		<td><?php echo $fetch['contactnumber'];?></td>
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
		//Display the link to first page: First
		echo $pager->renderFirst()."&nbsp; ";
		//Display the link to previous page: <<
		echo $pager->renderPrev();
		//Display page links: 1 2 3
		echo $pager->renderNav();
		//Display the link to next page: >>
		echo $pager->renderNext()."&nbsp; ";
		//Display the link to last page: Last
		echo $pager->renderLast();  ?>     
    	</div>   
		<?php } else{ echo "&nbsp;"; }?>

	</div>   
        
<!--Messages-->
</div>
<?php include('../include/footer.php'); ?>