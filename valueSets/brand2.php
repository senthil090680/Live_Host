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
$id=$_REQUEST['id'];
if($_GET['id']!=''){
if($_POST['submit']=='Save'){
$sql =("UPDATE brand SET 
       brand='$brand',
	   principal='$principal'
       WHERE id = $id");
mysql_query( $sql);
header("location:brand.php?no=2&page=$page");
}
}
elseif($_POST['submit']=='Save'){
if($brand=='')
{
header("location:brand.php?no=9");exit;
}
else
{
$sel="select * from brand where brand ='$brand'";
$sel_query=mysql_query($sel);
		if(mysql_num_rows($sel_query)=='0') {
			
	   $sql="INSERT INTO `brand`(`brand`,`principal`)values('$brand','$principal')";
		
        mysql_query( $sql);
		
        header("location:brand.php?no=1&page=$page");
		}
		else {
		header("location:brand.php?no=18&page=$page");
	}
}

}

$id=$_GET['id'];
$list=mysql_query("select * from brand where id= '$id'"); 
while($row = mysql_fetch_array($list)){ 
	$brand = $row['brand'];
	$principal = $row['principal'];
	} 


?>
<!------------------------------- Form -------------------------------------------------->
<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headings">Brand</div>
<div id="mytable" align="center">
<form action="" method="post" id="validation">
<table>
   <tr height="40px">
   <td>Principal</td>
   <td class="align">
    <?php
        $list=mysql_query("select * from  principal order by  principal asc");
        // Show records by while loop.
	   // End while loop.
        ?>
       <select name= "principal">
        <option value="">--- Select ---</option>
		<?php
		while($row_list=mysql_fetch_assoc($list)){
		?>
       <option value="<?php echo $row_list['id']; ?>" <?php if($row_list['id']== $principal){ echo "selected"; } ?>><?php echo $row_list['principal']; ?></option>

        <?php  } ?>
        </select>  
        </td>
        </tr>
  <tr height="40px">
    <td class="pclr">Brand*</td>
    <td><input type="text" name="brand" value="<?php echo $brand; ?>" autocomplete='off' maxlength="50"/></td>
   </tr>
 
<tr height="60px;" align="center">
<td colspan="10" >
<input type="submit" name="submit" id="submit" class="buttons" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="reset" name="reset"  class="buttons" value="Clear" id="clear" onclick="return brandclr();" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/>
</td>
     </tr>
</table>
</form>
</div>
<?php include("../include/error.php");?>
<div id="search">
<form action="" method="get">
<input type="text" name="brand" value="<?php $_GET['brand']; ?>" autocomplete='off' placeholder='Search By Brand'/>
<input type="submit" name="submit" class="buttonsg" value="GO"/>
</form>       
</div>
<div class="mcf"></div>
<div id="container">
        <?php
		if($_GET['delID']!=''){
		if($_POST['submit']=='ConfirmDelete'){
		$id = $_GET['delID'];
		$query = "DELETE FROM brand WHERE id = $id";
        //Run the query
        $result = mysql_query($query) or die(mysql_error());
        header("location:brand.php?no=3&page=$page");
		}
		 }
		?>  
		<?php
		if($_GET['submit']!=='')
		{
		$var = @$_GET['brand'] ;
        $trimmed = trim($var);		
	    $qry="SELECT * FROM `brand` where brand like '%".$trimmed."%' order by brand asc";
		}
		else
		{ 
		$qry="SELECT * FROM `brand` order by brand asc";  
		}
		$results=mysql_query($qry);
		$pager = new PS_Pagination($bd, $qry,5,5);
		$results = $pager->paginate();
		$num_rows= mysql_num_rows($results);			
		?>
        <div class="con2">
        <table id="sort" class="tablesorter" align="center" width="100%">
        <thead>
		<tr>
		<th class="rounded">Brand<img src="../images/sort.png" width="13" height="13" /></th>
        <th class="rounded">Principal<img src="../images/sort.png" width="13" height="13" /></th>
        <th class="rounded">Product Category</th>
		<th align="right">Edit&nbsp;&nbsp;</th>
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
		$principal= $fetch['principal'];
		$product_category= $fetch['product_category'];
		?>
		<tr>
		<td><?php echo $fetch['brand'];?></td>
        <td>
		<?php
		$princi=mysql_query("select * from  principal where id='$principal'");
        $row=mysql_fetch_array($princi);
        $princid=$row['id'];
		$princv=$row['principal'];
		if($principal=$princv){echo $princv;}?>
		</td>
        <td>
        <?php
        $pro=mysql_query("select * from  product_category where id='$product_category'");
        $row=mysql_fetch_array($pro);
        $proid=$row['id'];
        $procv=$row['product_category'];
        if($product_category=$procv){echo $procv;}?>
        </td>
		<td align="right">
        <a href="brand.php?id=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']);?>"><img src="../images/user_edit.png" alt="" title="" width="11" height="11"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
       <!-- <a href="brand.php?id=<?php echo $fetch['id'];?>&delID=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']);?>"><img src="../images/trash.png" alt="" title="" width="11" height="11" /></a>-->
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
		<th  class="pagination">          
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
   <div class="msg" align="center" <?php if($_GET['delID']!=''){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
   <form action="#" method="post">
     <input type="submit" name="submit" id="submit" class="buttonsdel" value="ConfirmDelete" />&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='brand.php'"/>
        </form>
     </div>       
   </div>
</div>
<?php include('../include/footer.php'); ?>