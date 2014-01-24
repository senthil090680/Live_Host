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
$sql =("UPDATE category2 SET 
       category2='$category2'
       WHERE id = $id");
mysql_query( $sql);
header("location:customercategory2.php?no=2&page=$page");
}
}
elseif($_POST['submit']=='Save'){
if($category2=='')
{
header("location:customercategory2.php?no=9");exit;
}
else
{
$sel="select * from category2 where category2 ='$category2'";
$sel_query=mysql_query($sel);
		if(mysql_num_rows($sel_query)=='0') {
		$sql="INSERT INTO `category2`(`category2`)values('$category2')";
        mysql_query( $sql);
        header("location:customercategory2.php?no=1&page=$page");
		}
		else {
		header("location:customercategory2.php?no=18&page=$page");
	}
}

}

$id=$_GET['id'];
$list=mysql_query("select * from category2 where id= '$id'"); 
while($row = mysql_fetch_array($list)){ 
	$category2 = $row['category2'];
	} 


?>
<!------------------------------- Form -------------------------------------------------->
<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headings">Customer Category2</div>
<div id="mytable" align="center">
<form action="" method="post" id="validation">
<table>
  <tr height="60px">
    <td class="pclr">Customer Category2*</td>
    <td><input type="text" name="category2" value="<?php echo $category2; ?>" autocomplete='off' maxlength="20"/></td>
   </tr>
 
<tr height="130px;" align="center">
<td colspan="10" >
<input type="submit" name="submit" id="submit" class="buttons" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="reset" name="reset" class="buttons" value="Clear" id="clear" onclick="return cat2Clear();" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/>
</td>
     </tr>
</table>
</form>
</div>
<?php include("../include/error.php");?>
<div id="search">
<form action="" method="get">
<input type="text" name="category2" value="<?php $_GET['category2']; ?>" autocomplete='off' placeholder='Search By Cate2'/>
<input type="submit" name="submit" class="buttonsg" value="GO"/>
</form>       
</div>
<div class="mcf"></div>
<div id="container">
        <?php
		if($_GET['delID']!=''){
	    $id = $_GET['delID'];
		$cat_sql="select a.*,b.* from customer as a,category2 as b where a.category2='$category2' AND b.id='$id'";
		$rescat=mysql_query($cat_sql);
		$cnt=mysql_num_rows($rescat);
		if($cnt=='1'){
        header("location:customercategory2.php?no=33&page=$page"); 
		  }
		}
		if($_GET['delID']!=''){
		if($_POST['submit']=='ConfirmDelete'){
		$id = $_GET['delID'];
		$query = "DELETE FROM category2 WHERE id = $id";
        //Run the query
        $result = mysql_query($query) or die(mysql_error());
        header("location:customercategory2.php?no=3&page=$page");
		}
		 }
		 
		?>  
	      
		<?php
		if($_GET['submit']!=='')
		{
		$var = @$_GET['category2'] ;
        $trimmed = trim($var);		
	    $qry="SELECT * FROM `category2` where category2 like '%".$trimmed."%' order by category2 asc";
		}
		else
		{ 
		$qry="SELECT * FROM `category2` order by category2 asc";  
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
		<th class="rounded">Customer Category2<img src="../images/sort.png" width="13" height="13" /></th>
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
		<td><?php echo $fetch['category2'];?></td>
		<td align="right">
        <a href="customercategory2.php?id=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']);?>"><img src="../images/user_edit.png" alt="" title="" width="11" height="11"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="customercategory2.php?id=<?php echo $fetch['id'];?>&delID=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']);?>"><img src="../images/trash.png" alt="" title="" width="11" height="11" /></a>
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
      <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='customercategory2.php'"/>
        </form>
     </div>       
   </div>
</div>
<?php include('../include/footer.php'); ?>