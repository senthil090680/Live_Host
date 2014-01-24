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
$sel="select * from kdprice where kdprice ='$kdprice'";
$sel_query=mysql_query($sel);
if(mysql_num_rows($sel_query)==0) {
$sql =("UPDATE kdprice SET 
       kdprice='$kdprice'
       WHERE id = $id");
mysql_query( $sql);
header("location:kdCategorypriceprice.php?no=2");
}
else{
header("location:kdCategoryprice.php?no=18");
}
}
}
elseif($_POST['submit']=='Save'){
if($kdprice=='')
{
header("location:kdCategoryprice.php?no=9");exit;
}
else
{
$sel="select * from kdprice where kdprice ='$kdprice'";
$sel_query=mysql_query($sel);
		if(mysql_num_rows($sel_query)==0) {
		$sql="INSERT INTO `kdprice`(`kdprice`)values('$kdprice')";
        mysql_query( $sql);
        header("location:kdCategoryprice.php?no=1");
		}
		else {
		header("location:kdCategoryprice.php?no=18");
	}
}

}

$id=$_GET['id'];
$list=mysql_query("select * from kdprice where id= '$id'"); 
while($row = mysql_fetch_array($list)){ 
	$kdprice = $row['kdprice'];
	} 


?>
<!------------------------------- Form -------------------------------------------------->
<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headings">KD Price</div>
<div id="mytable" align="center">
<form action="" method="post" id="validation">
<table>
  <tr height="60px">
    <td class="pclr">KD Price*</td>
    <td><input type="text" name="kdprice" value="<?php echo $kdprice; ?>" autocomplete='off' maxlength="50"/></td>
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
<input type="text" name="kdprice" value="<?php $_GET['kdprice']; ?>" autocomplete='off' placeholder='Search By Cate1'/>
<input type="submit" name="submit" class="buttonsg" value="GO"/>
</form>       
</div>
<div class="mcf"></div>
<div id="container">
        <?php
		if($_GET['delID']!=''){
	    $id = $_GET['delID'];
		//Check kd is Assigned to kdprice
		$kd_sql="select a.*,b.* from kd as a,kdprice as b where a.kdprice='$kdprice' AND b.kdprice='$id'";
		$resProvince=mysql_query($kd_sql);
		$cnt=mysql_num_rows($resProvince);
		if($cnt=='1'){
        header("location:kdCategoryprice.php?no=38"); 
		  }
		elseif($_GET['delID']!=''){
		//Check kd_product is Assigned to kdprice
		$kdp_sql="select a.*,b.* from kd_product as a,kdprice as b where a.kdprice='$kdprice' AND b.kdprice='$id'";
		$dsr=mysql_query($kdp_sql);
		$cnt=mysql_num_rows($dsr);
		if($cnt=='1'){
        header("location:kdCategoryprice.php?no=39"); 
		  	 } 
		elseif($_GET['delID']!=''){
		//Check price_master is Assigned to kdprice
	$pm_sql="select a.*,b.* from price_master as a,kdprice as b where a.kdprice='$kdprice' AND b.kdprice='$id'";
		$dsr=mysql_query($pm_sql);
		$cnt=mysql_num_rows($dsr);
		if($cnt=='1'){
        header("location:kdCategoryprice.php?no=40"); 
		     }  
	    	}
		 }
		}
		?>  
	    <?php
		if($_GET['id']!=''){
		if($_POST['submit']=='ConfirmDelete'){
		$id = $_GET['id'];
	    $query = "DELETE FROM kdprice WHERE id = $id";
        //Run the query
        $result = mysql_query($query) or die(mysql_error());
        header("location:kdCategoryprice.php?no=3");
		}
		 }
		?>  
          
		<?php
		if($_GET['submit']!=='')
		{
		$var = @$_GET['kdprice'] ;
        $trimmed = trim($var);		
	    $qry="SELECT * FROM `kdprice` where kdprice like '%".$trimmed."%' order by kdprice asc";
		}
		else
		{ 
		$qry="SELECT * FROM `kdprice` order by kdprice asc";  
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
		<th class="rounded">KD Price<img src="../images/sort.png" width="13" height="13" /></th>
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
		<td><?php echo $fetch['kdprice'];?></td>
		<td align="right">
        <a href="kdCategoryprice.php?id=<?php echo $fetch['id'];?>"><img src="../images/user_edit.png" alt="" title="" width="11" height="11"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="kdCategoryprice.php?id=<?php echo $fetch['id'];?>&delID=<?php echo $fetch['kdprice'];?>"><img src="../images/trash.png" alt="" title="" width="11" height="11" /></a>
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
      <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='kdCategoryprice.php'"/>
        </form>
     </div>       
   </div>
</div>
<?php include('../include/footer.php'); ?>