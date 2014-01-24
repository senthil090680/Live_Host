<?php
session_start();
ob_start();
include('../include/header.php');
include "../include/ps_pagination.php";
if(isset($_GET['logout'])){
session_destroy();
header("Location:../index.php");
}
EXTRACT($_POST);
$page=intval($_GET['page']);
$id=$_GET['id'];
	    if($_GET['id']!=''){
		if(isset($_POST['Update'])){
       $sql=("UPDATE price_master SET
		KD_Code ='$KD_Code',
		kd_category='$kd_category',
		Product_code='$Product_code',
		Product_description1='$Product_description1',
		UOM1='$UOM1',
		Price='$Price',
		Effective_date='$Effective_date'
		WHERE Product_code = '$Product_code' ");
		mysql_query( $sql);
		header("location:priceview.php?no=2&page=$page");
		}
		}
		 
?>
<!------------------------------- Form -------------------------------------------------->
<div id="mainarea">
<div class="mcf"></div>
<div><h2 align="center">Price</h2></div>
<div id="containerBD">

  <div id="search">
        <form action="" method="get">
        <input type="text" name="Product_description1" value="<?php $_GET['Product_description1']; ?>" autocomplete='off' placeholder='Search By Product'/>
        <input type="submit" name="submit" class="buttonsg" value="Go"/>
        </form>       
        </div>
<input type="button" name="kdproduct" value="Back" class="buttons" onclick="window.location='price.php'">
        <div class="clearfix"></div>
		<?php
		if($_GET['del']!=''){
			if($_POST['submit']=='ConfirmDelete'){
				$id = $_GET['del'];
				$query = "DELETE FROM `price_master` WHERE id = $id";
				//Run the query
				$result = mysql_query($query) or die(mysql_error());
				header("location:priceview.php?no=3");
			}
		 }
		?> 
	    <?php
		if($_GET['submit']!='')
		{
		$var = @$_GET['Product_description1'] ;
		$trimmed = trim($var);	
		$qry="SELECT * FROM `price_master` where Product_description1 like '%".$trimmed."%' order by  Product_description1 asc";
		}
		else
		{ 
		$qry="SELECT *  FROM `price_master` order by  Product_description1 asc"; 
		}
		$results=mysql_query($qry);
		$pager = new PS_Pagination($bd, $qry,10,10);
		$results = $pager->paginate();
		$num_rows= mysql_num_rows($results);			
		?>
        <div class="conscroll">
        <table id="sort" class="tablesorter" width="100%">
		<thead>
		<tr>
		<th nowrap="nowrap">KD Category</th>
		<th nowrap="nowrap" class="rounded">Product Code<img src="../images/sort.png" width="13" height="13" /></th>
        <th nowrap="nowrap">Product Description</th>
  		<th nowrap="nowrap">UOM1</th>
        <th nowrap="nowrap">Price(Naira)</th>
        <th nowrap="nowrap">Effective Date</th>
        <th align="right">Edit/Del</th>
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
		<td style="text-align:justify"><?php echo $fetch['kd_category'];?></td>
		<td style="text-align:justify"><?php echo $fetch['Product_code'];?></td>
	    <td style="text-align:justify"><?php echo $fetch['Product_description1'];?></td>
     	<td style="text-align:justify"><?php echo $fetch['UOM1'];?></td>
        <td style="text-align:justify"><?php echo $fetch['Price'];?></td>
        <td style="text-align:justify"><?php echo $fetch['Effective_date'];?></td>
  
       	<td align="right">
        <a href="priceview.php?id=<?php echo $fetch['id'];?>
&page=<?php echo intval($_GET['page']);?>"><img src="../images/user_edit.png" alt="" title="" width="11" height="11"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="priceview.php?del=<?php echo $fetch['id'];?>&id=<?php echo $fetch['id'];?>
&page=<?php echo intval($_GET['page']);?>"><img src="../images/trash.png" alt="" title="" width="11" height="11" /></a>
        </td>
        </tr>
		<?php $c++; $cc++; }		 
		}else{  echo "<tr><td align='center' colspan='13'><b>No records found</b></td></tr>";}  ?>
		</tbody>
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
      
<div id="form_bottom" <?php if($_GET['id']!=''){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?> align="center">

     
    
       <?php 
	    $id=$_GET['id'];
        $list=mysql_query("select * from  price_master  where id= '$id'"); 
        while($row = mysql_fetch_array($list)){ 
		$KD_Code=$row['KD_Code'];
	    $kd_category=$row['kd_category'];
		$Product_code=$row['Product_code'];
		$Product_description1=$row['Product_description1'];
		$UOM1=$row['UOM1'];
		$Price=$row['Price'];
		$Effective_date=$row['Effective_date'];
       }
   
        ?>
        <div class="con">
        <table id="sort" class="tablesorter" width="100%">
        <thead>
		<tr>
        <th nowrap="nowrap">kd_category</th>
		<th nowrap="nowrap">Product Code</th>
        <th nowrap="nowrap">Product Description</th>
  		<th nowrap="nowrap">UOM1</th>
        <th nowrap="nowrap">Price(Naira)</th>
        <th align="right">Update</th>
		</tr>
		</tr>
		</thead>
        <tr>
        
		<td>
        <form method="post">
        <input type="hidden" name="KD_Code" value="<?php echo $KD_Code;?>" size="10" />
        <input type="hidden" name="kd_category" value="<?php echo $kd_category;?>" size="10" /><?php echo $kd_category;?></td>
		<td><input type="hidden" name="Product_code" value="<?php echo $Product_code;?>" size="10" /><?php echo $Product_code;?></td>
	    <td><input type="hidden" name="Product_description1" value="<?php echo $Product_description1;?>" size="10" /><?php echo $Product_description1;?></td>
     	<td><input type="hidden" name="UOM1" value="<?php echo $UOM1;?>" size="10" /><?php echo $UOM1;?></td>
        <td><input type="text" name="Price" value="<?php echo $Price;?>" size="10" autocomplete='off'/></td>
         <td width=100>
         <input type="text" name="Effective_date" id="fromdate" onChange="changeDateFormat(this.value,'fromdate')" class="datepicker fromdate" value="<?php echo date('Y-m-d')?>" maxlength="10" autocomplete="off">
         </td>
       	<td><input type="submit" name="Update" value="Update" class="buttons" /></td>
        </form>
        </tr>
		</tbody>
         
		</table>
      </div>   
  
</div>
 <div class="clearfix"></div>     
      
      
     <div class="msg" align="center" <?php if($_GET['del']!=''){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
     <form action="" method="post">
     <input type="submit" name="submit" id="submit" class="buttonsdel" value="ConfirmDelete" />&nbsp;&nbsp;&nbsp;&nbsp;
     <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='priceview.php'"/>
      </form>
     </div>    
<!--Messages-->
</div>
<?php include("../include/error.php");?>  
</div>
<?php include('../include/footer.php'); ?>