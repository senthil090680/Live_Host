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
$sel="select * from kdanalysis where kdanalysis ='$kdanalysis'";
$sel_query=mysql_query($sel);
if(mysql_num_rows($sel_query)==0) {
$sql =("UPDATE kdanalysis SET 
       kdanalysis='$kdanalysis'
       WHERE id = $id");
mysql_query( $sql);
header("location:kdanalysis.php?no=2");
}
else{
header("location:kdanalysis.php?no=18");
}
}
}
elseif($_POST['submit']=='Save'){
if($kdanalysis=='')
{
header("location:kdanalysis.php?no=9");exit;
}
else
{
$sel="select * from kdanalysis where kdanalysis ='$kdanalysis'";
$sel_query=mysql_query($sel);
		if(mysql_num_rows($sel_query)==0) {
		$sql="INSERT INTO `kdanalysis`(`kdanalysis`)values('$kdanalysis')";
        mysql_query( $sql);
        header("location:kdanalysis.php?no=1");
		}
		else {
		header("location:kdanalysis.php?no=18");
	}
}

}

$id=$_GET['id'];
$list=mysql_query("select * from kdanalysis where id= '$id'"); 
while($row = mysql_fetch_array($list)){ 
	$kdanalysis = $row['kdanalysis'];
	} 


?>
<!------------------------------- Form -------------------------------------------------->
<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headings">KD Analysis</div>
<div id="mytable" align="center">
<form action="" method="post" id="validation">
<table>
  <tr height="60px">
    <td class="pclr">KD Analysis*</td>
    <td><input type="text" name="kdanalysis" value="<?php echo $kdanalysis; ?>" autocomplete='off' maxlength="20"/></td>
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
<input type="text" name="kdanalysis" value="<?php $_GET['kdanalysis']; ?>" autocomplete='off' placeholder='Search By KD Analysis'/>
<input type="submit" name="submit" class="buttonsg" value="GO"/>
</form>       
</div>
<div class="mcf"></div>
<div id="container">
        <?php
		if($_GET['delID']!=''){
	    $id = $_GET['delID'];
		//Check kd is Assigned to kdanalysis
		$kd_sql="select a.*,b.* from kd as a,kdanalysis as b where a.kdanalysis='$kdanalysis' AND b.kdanalysis='$id'";
		$resProvince=mysql_query($kd_sql);
		$cnt=mysql_num_rows($resProvince);
		if($cnt=='1'){
        header("location:kdanalysis.php?no=38"); 
		  }
		elseif($_GET['delID']!=''){
		//Check kd_product is Assigned to kdanalysis
		$kdp_sql="select a.*,b.* from kd_product as a,kdanalysis as b where a.kdanalysis='$kdanalysis' AND b.kdanalysis='$id'";
		$dsr=mysql_query($kdp_sql);
		$cnt=mysql_num_rows($dsr);
		if($cnt=='1'){
        header("location:kdanalysis.php?no=39"); 
		  	 } 
		elseif($_GET['delID']!=''){
		//Check price_master is Assigned to kdanalysis
	$pm_sql="select a.*,b.* from price_master as a,kdanalysis as b where a.kdanalysis='$kdanalysis' AND b.kdanalysis='$id'";
		$dsr=mysql_query($pm_sql);
		$cnt=mysql_num_rows($dsr);
		if($cnt=='1'){
        header("location:kdanalysis.php?no=40"); 
		     }  
	    	}
		 }
		}
		?>  
	    <?php
		if($_GET['id']!=''){
		if($_POST['submit']=='ConfirmDelete'){
		$id = $_GET['id'];
	    $query = "DELETE FROM kdanalysis WHERE id = $id";
        //Run the query
        $result = mysql_query($query) or die(mysql_error());
        header("location:kdanalysis.php?no=3");
		}
		 }
		?>  
          
		<?php
		if($_GET['submit']!=='')
		{
		$var = @$_GET['kdanalysis'] ;
        $trimmed = trim($var);		
	    $qry="SELECT * FROM `kdanalysis` where kdanalysis like '%".$trimmed."%' order by kdanalysis asc";
		}
		else
		{ 
		$qry="SELECT * FROM `kdanalysis` order by kdanalysis asc";  
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
		<th class="rounded">KD Analysis<img src="../images/sort.png" width="13" height="13" /></th>
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
		?>
		<tr>
		<td><?php echo $fetch['kdanalysis'];?></td>
		<td align="right">
        <a href="kdanalysis.php?id=<?php echo $fetch['id'];?>"><img src="../images/user_edit.png" alt="" title="" width="11" height="11"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
       <!-- <a href="kdanalysis.php?id=<?php echo $fetch['id'];?>&delID=<?php echo $fetch['kdanalysis'];?>"><img src="../images/trash.png" alt="" title="" width="11" height="11" /></a>-->
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
      <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='kdanalysis.php'"/>
        </form>
     </div>       
   </div>
</div>
<?php include('../include/footer.php'); ?>