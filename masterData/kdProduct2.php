<?php 
ob_start();
include('../include/header.php');
include "../include/ps_pagination.php";
EXTRACT($_POST);	
//Insert Query

$page=intval($_GET['page']);
if($submit=='Save')
{
			if($kd_category=='')
			{
			//echo "Enter Mandatory Fields";
			header("location:kdProduct.php?no=9"); 
			}
			else
			{				
				echo $cnt=count($_POST['checkbox']);
				/*echo "<pre>";
				print_r($_REQUEST);
				echo "</pre>";
				exit;*/
		        for($j=0;$j<$cnt;$j++){
				
				/*if($_POST['Product_code'][$j] == $_POST['checkbox'][$j]) {
				 echo $_POST['Product_code'][$j]."<br/>";				
				}*/
				echo $checkbox=$_POST['checkbox'][$j];
				$sel1="select * from kd_product where Product_code ='$checkbox' AND kd_category='$kd_category'"; 
				$sel_query1=mysql_query($sel1);
				$row=mysql_num_rows($sel_query1);
				if($row=='0') {
			    $list=mysql_query("select * from  product where Product_code ='$checkbox'");
				$res=mysql_fetch_array($list);
			    $Product_description1=$res['Product_description1'];
				$UOM=$res['UOM1'];
				mysql_query("INSERT INTO kd_product(KD_Name,KD_Code,kd_category,UOM1,Product_code,Product_description1)VALUES('$KD_Name','$KD_Code','$kd_category','$UOM','$checkbox','$Product_description1')");
		

				header("location:kdProductCategory.php?no=1&page=$page");
				}
				else
				{
				header("location:kdProduct.php?no=51&page=$page");exit;
				}
		} //for loop 
		exit;
			} //else 
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
<div align="center" class="headingskdp">KD Product</div>
<div class="mytable3">
<div class="mcf"></div>
  <div id="search">
        <form action="" method="get">
        <input type="text" name="Product_description1" value="<?php $_GET['Product_description1']; ?>" autocomplete='off' placeholder='Search By Product'/>
        <input type="submit" name="submit" class="buttonsg" value="Go"/>
        </form>       
        </div>
<form method="post" action="" name="register">
<div class="headfile" align="center">
<table width="80%" align="center">
  <tr>
   <td width="50">KD Name*
	<td width="121">
    <select name="KD_Name" class="KD_Name" id="KD_Name"  autocomplete="off"  value="" onChange="return KDCODE();" >
			<option value="">--- Select ---</option>
			<?php 
			$list=mysql_query("select * from  kd order by KD_Name"); 
			while($row=mysql_fetch_assoc($list)){
			$kd=$row['kd_category'];
			?>
			<option value='<?php echo $row['KD_Name']; ?>'<?php if($row['KD_Name']==$KD_Name){ echo 'selected' ; }?>
			><?php echo $row['KD_Name']; ?></option>
			<?php 
			// End while loop. 
			} 
			?>
			</select>
    </td>
    <td width="50">KD Category*
	<td width="121">
      <input type="text" name="kd_category" id="kd_category" value="" />
      <input type="hidden" name="KD_Code" id="KD_Code" value="" />   
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
		$pager = new PS_Pagination($bd, $qry,8,8);
		$results = $pager->paginate();
		?>
        <div class="conscroll">
        <table id="sort" class="tablesorter" align="center" width="100%">
		<thead>
		<tr>
 		<th><input type="checkbox" id="selectall"/>Select</th>
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
        <td><input type="checkbox" name="checkbox[]" value="<?php echo $fetch['Product_code'];?>" class="case"></td>
        <td><input type="hidden" name="Product_code[]" value="<?php echo $fetch['Product_code'];?>"><?php echo $fetch['Product_code'];?></td>
		<td><input type="hidden" name="Product_description1[]" value="<?php echo $fetch['Product_description1'];?>"><?php echo $fetch['Product_description1'];?></td>
		<td><input type="hidden" name="UOM1[]" value="<?php echo $fetch['UOM1']?>" autocomplete="off" size="20" maxlength="20"><?php echo $fetch['UOM1'];?></td>
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
<input type="button" name="clear" value="Clear" id="clear" class="buttons" onclick="return kdpdt();" />&nbsp;&nbsp;&nbsp;&nbsp;
<a href="../include/empty.php" style="text-decoration:none"><input type="button" name="cancel" id="cancel"  class="buttons" value="Cancel"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="view" value="View" class="buttons" onclick="window.location='kdProductCategory.php'"/>
</td>
</tr>
</table>   
<?php include("../include/error.php");?>
     
</form>
</div>
<div class="clearfix"></div>

<?php include('../include/footer.php'); ?>