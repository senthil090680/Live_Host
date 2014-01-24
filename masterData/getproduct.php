<?php
$menu=intval($_GET['menu']);
if (isset($_GET['menu']) && intval($_GET['menu'])>0) {
		$qry="SELECT * FROM `kd_product` where kd_category='$menu' order by Product_description1 asc";
		}
		$result=mysql_query($qry);
		$num_rows= mysql_num_rows($result);		
		$pager = new PS_Pagination($bd, $qry,8,8);
		$results = $pager->paginate();
		?>
        <div class="conscroll">
        <table id="sort" class="tablesorter" align="center" width="100%">
		<thead>
		<tr>
 		
        <th>Product Code</th>
  		<th>Product<img src="../images/sort.png" width="13" height="13" /></th>
		<th>UOM</th>
        <th>Price</th>
				
 </tr>
		</thead>
		<tbody>
		<?php
		if(!empty($num_rows)){
		$i=1;
		$c=0;$cc=1;
		while($fetch = mysql_fetch_array($result)) {
		if($c % 2 == 0){ $cls =""; } else{ $cls ="class='odd'"; }
		?>		
		<tr>
        <td><input type="hidden" name="Product_code[]" value="<?php echo $fetch['Product_code'];?>"><?php echo $fetch['Product_code'];?></td>
         
		<td><input type="hidden" name="Product_description1[]" value="<?php echo $fetch['Product_description1'];?>"><?php echo $fetch['Product_description1'];?></td>
        
		<td><input type="hidden" name="UOM1" value="<?php echo $fetch['UOM1'];?>" autocomplete="off" size="20" maxlength="20"><?php echo $fetch['UOM1'];?></td>
        
        <td><input type="text" name="Price[]" value="<?php echo $Price;?>" autocomplete="off" size="20" maxlength="20"><?php echo $fetch['Price'];?></td>
		</tr>
		<?php $i++; $c++; $cc++; }		 
		}else{  echo "<tr><td align='center' colspan='13'><b>No records found</b></td></tr>";}  ?>
		</tbody>
		</table>
        </div>