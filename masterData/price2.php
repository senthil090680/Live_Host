<?php 
ob_start();
include('../include/header.php');
include "../include/ps_pagination.php";
EXTRACT($_POST);	
  if($_POST['submit']=='Save')
{
			if($Kd_Category=='' || $Price=='')
			{
			//echo "Enter Mandatory Fields";
			header("location:price.php?no=9"); 
			}
			else
			{				
			    $cnt=count($_POST['Product_code']);
		        for($j=0;$j<$cnt;$j++){
				$Product_codes=$_POST['Product_code'][$j];
						
				$sel1="select * from price_master where Product_code ='$Product_code' AND Kd_Category='$Kd_Category'"; 
				$sel_query1=mysql_query($sel1);
				$row=mysql_num_rows($sel_query1);
				if($row=='0') {
			    echo mysql_query("INSERT INTO 'price_master'(KD_Code, Kd_Category, Product_code,Product_description1,UOM1,Price,Effective_date,Status_price_master)VALUES('KD001','$Kd_Category','$Product_codes','$Product_description1','$UOM1','$Price','$Effective_date','Checked'");
				
				mysql_query("UPDATE product SET 
					  Status_price_master='Checked_price'
					  WHERE Product_code = '$Product_code'"); 
  				header("location:price.php?no=1");
				}
				else
				{
				header("location:price.php?no=51");exit;
				}
		}
			}
		
        }          
        
      
?>
<!------------------------------- Form -------------------------------------------------->
<SCRIPT language="javascript">
$(document).ready(function() {

$(function(){
    // add multiple select / deselect functionality
    $("#selectall").click(function () {
	// alert("selectall");

          $('.Product_code').attr('checked', this.checked);
    });
 	$(".Product_code").click(function(){

		if($(".Product_code").length == $(".Product_code:checked").length) {
			$("#selectall").attr("checked", "checked");
		} else {
			$("#selectall").removeAttr("checked");
		}

	});

});
</SCRIPT>

<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headingskdp">Price</div>
<div class="mytable3">
  <div id="search">
        <form action="" method="get">
        <input type="text" name="Product_description1" value="<?php $_GET['Product_description1']; ?>" autocomplete='off' placeholder='Search By Product'/>
        <input type="submit" name="submit" class="buttonsg" value="Go"/>
        </form>       
        </div>
<form method="post" action="" name="register">
<div class="headfile" align="center">
<table width="100%" align="center">
  <tr>
    <td width="50px">KD Category*<input type="hidden" name="update_date" value="" autocomplete="off" id="hdnData" readonly></td>
    <td width="50px">
    <select name="Kd_Category" id="user" autocomplete="off" value="">
			<option value="">--- Select ---</option>
			<?php 
			$list=mysql_query("select * from  kd_category"); 
			while($row=mysql_fetch_assoc($list)){
			?>
			<option value='<?php echo $row['kd_category']; ?>'<?php if($row['kd_category']==$kdpdt1_row['Kd_Category']){ echo 'selected' ; }?>
			><?php echo $row['kd_category']; ?></option>
			<?php 
			// End while loop. 
			} 
			?>
			</select>
       
            </td>
            
    <td class="align" width="50px">Effective Date</td>
    <td width="50px">
    <input type="text"  name="Effective_date" id="Effective_dateup" value="<?php echo date("Y-m-d");?>" autocomplete="off" size="20" maxlength="20" disabled>
	</td>  
  </tr>
</table>
</div>
<?php
if($_GET['submit']!=='')
		{
		$var = @$_GET['Product_description1'] ;
        $trimmed = trim($var);	
	    $qry="SELECT * FROM `product` where Product_description1 like '%".$trimmed."%' order by  Product_description1 asc";
		}  
		else{
		$qry="SELECT  * FROM `product` order by  Product_description1 asc";
		}
		$results=mysql_query($qry);
		$num_rows= mysql_num_rows($results);			
		$pager = new PS_Pagination($bd, $qry,10,10);
		$results = $pager->paginate();
		?>
        <div class="con">
        <table id="sort" class="tablesorter" align="center" width="100%">
		<thead>
		<tr>
 		<th>Select</th>
  		<th>Product<img src="../images/sort.png" width="13" height="13" /></th>
		<th>UOM</th>
		<th>Price*</th>
   		
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
        
            <td ><input name="Product_code[]" type="checkbox" id="checkbox[]" value="<?php echo $fetch['Product_code']; ?>"></td>
	<!--	<td>
        
    
        <input type="checkbox" id="prd_code_<?php echo $cc; ?>" onClick="inputcheck(<?php echo $cc; ?>);" name="Product_code[]" value="<?php echo $fetch['Product_code'];?>" class="Product_code" <?php if($_GET['no']=='1' || $hid_cat!=''){echo $fetch['Status_price_master'];}else{ echo 'Checked';}?>></td>-->
        
        
	    <td><input type="hidden" name="Product_description1[]" value="<?php echo $fetch['Product_description1'];?>"><?php echo $fetch['Product_description1'];?></td>
        
		<td><input type="hidden" name="UOM1[]" value="<?php echo $fetch['UOM1']?>" autocomplete="off" size="20" maxlength="20"><?php echo $fetch['UOM1'];?></td>
        
		<td><input type="text"  value="<?php echo $fetch['Price']?>" name="Price[]" autocomplete='off'></td>
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

<table width="100%" style="clear:both" align="center">
<tr align="center" height="50px;">
<td colspan="10">
<input type="submit" name="submit" id="submit" class="buttons" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="clear" value="Clear" id="clear" class="buttons" onclick="return price();" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/menu.php'"/></td> 
</td>
</tr>
</table>  
<?php include("../include/error.php");?>
</form> 
</div>
<div class="clearfix"></div>
<?php include('../include/footer.php'); ?>