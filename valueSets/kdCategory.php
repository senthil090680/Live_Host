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
$id=$_REQUEST['id'];
if($_GET['id']!=''){
if($_POST['submit']=='Save'){
$sel="select * from kd_category where kd_category ='$kd_category'";
$sel_query=mysql_query($sel);
if(mysql_num_rows($sel_query)==0) {
$sql =("UPDATE kd_category SET 
       kd_category='$kd_category'
       WHERE id = $id");
mysql_query( $sql);
header("location:kdCategory.php?no=2");
}
else{
header("location:kdCategory.php?no=18");
}
}
}
elseif($_POST['submit']=='Save'){
if($kd_category=='')
{
header("location:kdCategory.php?no=9");exit;
}
else
{
$sel="select * from kd_category where kd_category ='$kd_category'";
$sel_query=mysql_query($sel);
		if(mysql_num_rows($sel_query)==0) {
		$sql="INSERT INTO `kd_category`(`kd_category`)values('$kd_category')";
        mysql_query( $sql);
        header("location:kdCategory.php?no=1");
		}
		else {
		header("location:kdCategory.php?no=18");
	}
}

}

$id=$_GET['id'];
$list=mysql_query("select * from kd_category where id= '$id'"); 
while($row = mysql_fetch_array($list)){ 
	$kd_category = $row['kd_category'];
	} 


?>
<!------------------------------- Form -------------------------------------------------->
<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headings">KD Product & Price Category</div>
<div id="mytable" align="center">
<form action="" method="post" id="validation">
<table>
  <tr height="60px">
    <td class="pclr">KD Product & Price Category*</td>
    <td><input type="text" name="kd_category" value="<?php echo $kd_category; ?>" autocomplete='off' maxlength="20"/></td>
   </tr>
 
<tr height="130px;" align="center">
<td colspan="10" >
<input type="submit" name="submit" id="submit" class="buttons" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="reset" name="reset"  class="buttons" value="Clear" id="clear" onclick="return kdcat();" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/menu.php'"/>
</td>
     </tr>
</table>
</form>
</div>
<?php include("../include/error.php");?>
<div id="search">
<form action="" method="get">
<input type="text" name="kd_category" value="<?php $_GET['kd_category']; ?>" autocomplete='off' placeholder='Search By KD Category'/>
<input type="submit" name="submit" class="buttonsg" value="GO"/>
</form>       
</div>
<div class="mcf"></div>
<div id="container">
        <?php
		if($_GET['delID']!=''){
	    $id = $_GET['delID'];
		//Check kd is Assigned to kd_category
		$kd_sql="select a.*,b.* from kd as a,kd_category as b where a.kd_category='$kd_category' AND b.kd_category='$id'";
		$resProvince=mysql_query($kd_sql);
		$cnt=mysql_num_rows($resProvince);
		if($cnt=='1'){
        header("location:kdCategory.php?no=38"); 
		  }
		elseif($_GET['delID']!=''){
		//Check kd_product is Assigned to kd_category
		$kdp_sql="select a.*,b.* from kd_product as a,kd_category as b where a.kd_category='$kd_category' AND b.kd_category='$id'";
		$dsr=mysql_query($kdp_sql);
		$cnt=mysql_num_rows($dsr);
		if($cnt=='1'){
        header("location:kdCategory.php?no=39"); 
		  	 } 
		elseif($_GET['delID']!=''){
		//Check price_master is Assigned to kd_category
	$pm_sql="select a.*,b.* from price_master as a,kd_category as b where a.kd_category='$kd_category' AND b.Kd_category='$id'";
		$dsr=mysql_query($pm_sql);
		$cnt=mysql_num_rows($dsr);
		if($cnt=='1'){
        header("location:kdCategory.php?no=40"); 
		     }  
	    	}
		 }
		}
		?>  
	    <?php
		if($_GET['id']!=''){
		if($_POST['submit']=='ConfirmDelete'){
		$id = $_GET['id'];
	    $query = "DELETE FROM kd_category WHERE id = $id";
        //Run the query
        $result = mysql_query($query) or die(mysql_error());
        header("location:kdCategory.php?no=3");
		}
		 }
		?>  
          
		<?php
		if($_GET['submit']!=='')
		{
		$var = @$_GET['kd_category'] ;
        $trimmed = trim($var);		
	    $qry="SELECT * FROM `kd_category` where kd_category like '%".$trimmed."%' order by kd_category asc";
		}
		else
		{ 
		$qry="SELECT * FROM `kd_category` order by kd_category asc";  
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
		<th class="rounded">KD Product & Price Category<img src="../images/sort.png" width="13" height="13" /></th>
		<th align="right">Edit&nbsp;</th>
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
		<td><?php echo $fetch['kd_category'];?></td>
		<td align="right">
        <a href="kdCategory.php?id=<?php echo $fetch['id'];?>"><img src="../images/user_edit.png" alt="" title="" width="11" height="11"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
       <!-- <a href="kdCategory.php?id=<?php echo $fetch['id'];?>&delID=<?php echo $fetch['kd_category'];?>"><img src="../images/trash.png" alt="" title="" width="11" height="11" /></a>-->
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
   <form action="" method="post">
     <input type="submit" name="submit" id="submit" class="buttonsdel" value="ConfirmDelete" />&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='kdCategory.php'"/>
        </form>
     </div>       
   </div>
</div>
<?php include('../include/footer.php'); ?>