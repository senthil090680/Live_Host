<?php 
ob_start();
include('../include/header.php');
include "../include/ps_pagination.php";
EXTRACT($_POST);	
//Insert Query
if($submit=='Save')
{
			if($customer_type=='')
			{
			//echo "Enter Mandatory Fields";
			header("location:kdProduct.php?no=9"); 
			}
			else
			{				
				$cnt=count($_POST['Product_code']);
		        for($j=0;$j<$cnt;$j++){
				$Product_code=$_POST['Product_code'][$j];
				$sel1="select * from customertype_product where Product_code ='$Product_code' AND customer_type='$customer_type'"; 
				$sel_query1=mysql_query($sel1);
				$row=mysql_num_rows($sel_query1);
				if($row=='0') {
			    mysql_query("INSERT INTO customertype_product(customer_type,UOM1,Product_id,Product_code,Product_description1,principal,brand)
					 VALUES('$customer_type','$UOM1','$Product_id[$j]','$Product_code','$Product_description1[$j]','$brand[$j]','$principal[$j]')");
				mysql_query("UPDATE product SET 
					  Status='Checked'
					  WHERE Product_code = '$Product_code'"); 
  				header("location:customertypeproductview.php?no=1");
				}
				else
				{
				header("location:customertypeproduct.php?no=51");exit;
				}
		}
			}
		}
	
?>
<!------------------------------- Form -------------------------------------------------->
<SCRIPT language="javascript">
$(function(){
 
    // add multiple select / deselect functionality
    $("#selectall").click(function () {
          $('.case').attr('checked', this.checked);
    });
 
    // if all checkbox are selected, check the selectall checkbox
    // and viceversa
    $(".case").click(function(){
 
        if($(".case").length == $(".case:checked").length) {
            $("#selectall").attr("checked", "checked");
        } else {
            $("#selectall").removeAttr("checked");
        }
 
    });
});
</SCRIPT>
<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headingskdp">Customer Type POSM</div>
<div class="mytable3">
<div class="mcf"></div>
        <div id="search">
        <form action="" method="get">
        <input type="text" name="Product_description1" value="<?php $_GET['Product_description1']; ?>" autocomplete='off' placeholder='Search By Product'/>
        <input type="submit" name="search" class="buttonsg" value="Go"/>
        </form>       
        </div>
<form method="post">
<div class="headfile" align="center">
<table width="50%" align="center">
  <tr>
    <td width="50">Customer Type*
	<td width="121">
    <select name="customer_type" class="customer_type" id="customer_type"  autocomplete="off"  value="">
			<option value="">--- Select ---</option>
			<?php 
			$list=mysql_query("select * from  customer_type"); 
			while($row=mysql_fetch_assoc($list)){
			?>
			<option value='<?php echo $row['id']; ?>'<?php if($row['id']==$_GET['data']){ echo 'selected' ; }?>
			><?php echo $row['customer_type']; ?></option>
			<?php 
			// End while loop. 
			} 
			?>
			</select>
    </td>
  </tr>
</table>
</div>
		<?php
		if(isset($_GET['search'])=='GO')
		{
		$var = @$_GET['Product_description1'] ;
        $trimmed = trim($var);	
	    $qry="SELECT * FROM `product` where product_type='POSM' AND Product_description1 like '%".$trimmed."%' order by Product_description1 asc";
		}
		else{
    	$qry="SELECT * FROM `product` where product_type='POSM' order by Product_description1 asc";
		}
		$results=mysql_query($qry);
		$num_rows= mysql_num_rows($results);			
		$pager = new PS_Pagination($bd, $qry,8,8);
		$results = $pager->paginate();
		?>
        <div class="conscroll">
        <table id="sort" class="tablesorter" align="center" width="100%">
		<thead>
		<tr>
 		<th><input type="checkbox" id="selectall"/>Select</th>
        <th>Product Code</th>
  		<th>Product<img src="../images/sort.png" width="13" height="13" /></th>
		<th>UOM</th>
				
 </tr>
		</thead>
		<tbody>
		<?php
		if(!empty($num_rows)){
		$i=1;
		$c=0;$cc=1;
		while($fetch = mysql_fetch_array($results)) {
		if($c % 2 == 0){ $cls =""; } else{ $cls ="class='odd'"; }
		?>		
        <tr>
        <td><input type="checkbox" class="Product_code case" name="Product_code[]" value="<?php echo $fetch['Product_code'];?>"></td>
        <td><input type="hidden" name="Product_id[]" value="<?php echo $fetch['id'];?>"><?php echo $fetch['Product_code'];?></td>
        <td><input type="hidden" name="Product_description1[]" value="<?php echo $fetch['Product_description1'];?>"><?php echo $fetch['Product_description1'];?></td>
        <td>
        <input type="hidden" name="UOM1" value="<?php echo $fetch['UOM1']?>" autocomplete="off" size="20" maxlength="20"><?php echo $fetch['UOM1'];?>
        <input type="hidden" name="principal[]" value="<?php echo $fetch['principal']?>" autocomplete="off" size="20" maxlength="20">
        <input type="hidden" name="brand[]" value="<?php echo $fetch['brand']?>" autocomplete="off" size="20" maxlength="20">
        </td>
        </tr>
		<?php $i++; $c++; $cc++; }		 
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
        
        
<table width="100%" style="clear:both" align="center">
<tr align="center" height="50px;">
<td colspan="10"><input type="submit" name="submit" id="submit" class="buttons Effective_date_update_submit" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="clear" value="Clear" id="clear" class="buttons" onclick="return custTypeclr();" />&nbsp;&nbsp;&nbsp;&nbsp;
<a href="../include/empty.php" style="text-decoration:none"><input type="button" name="cancel" id="cancel"  class="buttons" value="Cancel"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="view" value="View" class="buttons" onclick="window.location='customertypeproductview.php'"/>
</td>
</tr>
</table>   
<?php include("../include/error.php");?>
     
</form>
</div>
<div class="clearfix"></div>

<?php include('../include/footer.php'); ?>