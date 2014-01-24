<?php
include("../include/config.php");
include "../include/ps_pagination.php";

//print_r($_REQUEST);
$process = $_POST['process'];
$Kd_Category = $_GET['kd_category'];

if ($process == $_POST['process']) {
 // DB Connection
$query = "select * from kd_product where Kd_Category ='$process'";
}
		$result = mysql_query( $query);
		$num_rows= mysql_num_rows($result);			
		$pager = new PS_Pagination($bd, $qry,8,8);
		$results = $pager->paginate();
		?>

<style>
td {
	padding: 3px;
}
</style>
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
			 $Product_code = $fetch['Product_code']; 
					
	        $qry_kdprice		= 	"SELECT * FROM `price_master` where Product_code = '$Product_code'";
		
			$res_kdpricespecific 		= 	mysql_query($qry_kdprice);
			$rowcnt_kdpspecific 		= 	mysql_num_rows($res_kdpricespecific);
			if($rowcnt_kdpspecific > 0) {
				while($row_kdpspecific		=	mysql_fetch_array($res_kdpricespecific)) {
					 $kdspecific_price	=	$row_kdpspecific[Price];
					//exit;
				}
			}
			//echo "dere";
			//print_r($kdspecific_prod);
			$kdpspecific_pricestr		=	implode(",",$kdspecific_price);
			//exit;
			
		if($c % 2 == 0){ $cls =""; } else{ $cls ="class='odd'"; }
		?>		
		<tr>
        <td><input type="hidden" name="Product_code[]" value="<?php echo $fetch['Product_code'];?>"><?php echo $fetch['Product_code'];?></td>
         
		<td><input type="hidden" name="Product_description1[]" value="<?php echo $fetch['Product_description1'];?>"><?php echo $fetch['Product_description1'];?></td>
        
		<td><input type="hidden" name="UOM1" value="<?php echo $fetch['UOM1'];?>" autocomplete="off" size="20" maxlength="20"><?php echo $fetch['UOM1'];?></td>
        
        <td style="text-align:justify"><input type="text" id="price" name="Price[]" value="<?php  echo $kdspecific_price; ?>" autocomplete="off" size="10" maxlength="20"><?php echo $fetch['Price'];?></td>
		</tr>
		<?php $i++; $c++; $cc++; }		 
		}else{  echo "<tr><td align='center' colspan='13'><b>No records found</b></td></tr>";}  ?>
		</tbody>
		</table>
        </div>
