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
<div align="center"><h3>Currency</h3></div>
<div class="mcf"></div>
<div id="container">
      
		<?php
		$qry="SELECT * FROM `currency` order by id desc"; 
		$results=mysql_query($qry);
		$pager = new PS_Pagination($bd, $qry,5,5);
		$results = $pager->paginate();
		$num_rows= mysql_num_rows($results);			
		?>
        <div class="con2">
        <table id="sort" class="tablesorter" width="100%">
		<thead>
		<tr>
		<th class="rounded">Currency<img src="../images/sort.png" width="13" height="13" /></th>
        <th class="rounded">Symbol</th>
		</tr>
		</tr>
		</thead>
		<tbody>
		<?php
		if(!empty($num_rows)){
		$c=0;$cc=1;
		while($fetch = mysql_fetch_array($results)) {
		if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }
		$id= $fetch['id'];
		?>
		<tr>
		<td><?php echo $fetch['currency'];?></td>
        <td><img src="../currency/<?php echo $fetch['symbol'];?>" width="13" height="13" /></td>
		</tr>
		<?php $c++; $cc++; }		 
		}else{  echo "<tr><td align='center' colspan='13'><b>No records found</b></td></tr>";}  ?>
		</tbody>
        
        <tr align="center">
        <td colspan="10">
        <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/>
        </td>
        </tr>
		</table>
       </div> 
        <div class="paginationfile" align="center">
         <table>
		<tr>
		<th class="pagination" scope="col">          
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
		</th>
		</tr>
        </table>
        </div>   
</div>
</div>
<?php include('../include/footer.php'); ?>