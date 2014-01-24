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
$page=intval($_GET['page']);
$id=$_REQUEST['id'];
if($_GET['id']!=''){
if($_POST['submit']=='Save'){
$sql =("UPDATE division SET 
       division='$division'
       WHERE id = $id");
mysql_query( $sql);
header("location:division.php?no=2&page=$page");
}
}
elseif($_POST['submit']=='Save'){
if($division=='')
{
header("location:division.php?no=9");exit;
}
else
{
$sel="select * from division where division ='$division'";
$sel_query=mysql_query($sel);
		if(mysql_num_rows($sel_query)=='0') {
			
		echo $sql="INSERT INTO `division`(`division`)values('$division')";
        mysql_query( $sql);
        header("location:division.php?no=1&page=$page");
		}
		else {
		//header("location:division.php?no=18&page=$page");
	}
  
  }

}

$id=$_GET['id'];
$list=mysql_query("select * from division where id ='$id'"); 
while($row = mysql_fetch_array($list)){ 
	$principal = $row['division'];
	} 


?>
<!------------------------------- Form -------------------------------------------------->
<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headings">Division</div>
<div id="mytable" align="center">
<form action="" method="post" id="validation">
<table>
  <tr height="60px">
    <td class="pclr">Division*</td>
    <td><input type="text" name="division" value="<?php echo $division; ?>" autocomplete='off' maxlength="20"/></td>
   </tr>
 
<tr height="130px;" align="center">
<td colspan="10" >
<input type="submit" name="submit" id="submit" class="buttons" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="reset" name="reset" id="reset"  class="buttons" value="Clear" onclick="window.location='division.php'" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/>
</td>
     </tr>
</table>
</form>
</div>
<?php include("../include/error.php");?>
<div id="search">
<form action="" method="get">
<input type="text" name="division" value="<?php $_GET['division']; ?>" autocomplete='off' placeholder='Search By Division'/>
<input type="submit" name="submit" class="buttonsg" value="GO"/>
</form>       
</div>
<div class="mcf"></div>
<div id="container">
     	<?php
		if($_GET['submit']!=='')
		{
		$var = @$_GET['division'] ;
        $trimmed = trim($var);		
	    $qry="SELECT * FROM `division` where division like '%".$trimmed."%' order by division asc";
		}
		else
		{ 
		$qry="SELECT * FROM `division` order by division asc";  
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
		<th class="rounded">Division<img src="../images/sort.png" width="13" height="13" /></th>
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
		<td><?php echo $fetch['division'];?></td>
		<td align="right">
        <a href="division.php?id=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']);?>"><img src="../images/user_edit.png" alt="" title="" width="11" height="11"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
        </tr>
		<?php $c++; $cc++; }		 
		}else{  echo "<tr><td align='center' colspan='13'><b>No records found</b></td></tr>";}  ?>
		</tbody>
		</table>
        </div>
    <div class="msg" align="center" <?php if($_GET['delID']!=''){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
    <form action="#" method="post">
     <input type="submit" name="submit" id="submit" class="buttonsdel" value="ConfirmDelete" />&nbsp;&nbsp;&nbsp;&nbsp;
     <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='division.php'"/>
        </form>
     </div>       
   </div>
</div>
<?php include('../include/footer.php'); ?>