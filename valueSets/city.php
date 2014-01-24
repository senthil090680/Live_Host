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
        $sql =("UPDATE city SET 
        city='$city',
		state_id='$state_id'
	   	WHERE id = '$id'");
		mysql_query( $sql);
header("location:city.php?no=2&page=$page");
}
}
//Insert Data
elseif($_POST['submit']=='Save'){?>
//Check mandatory field is not empty
<form action="" method="post" id="resubmitform">
<input type="hidden" name="city" value="<?php echo $city; ?>" />
<input type="hidden" name="state_id" value="<?php echo $state_id; ?>" />
<input type="hidden" name="no" value="9" />
</form>

<form action="" method="post" id="dataexists">
<input type="hidden" name="city" value="<?php echo $city; ?>" />
<input type="hidden" name="state_id" value="<?php echo $state_id; ?>" />
<input type="hidden" name="no" value="18" />
<input type="hidden" name="page" value="<?php echo $page; ?>" />
</form>
<?php
if($city=='' || $state_id=='')
{?>
<script type="text/javascript">
document.forms['resubmitform'].submit();
</script>
<?php
//header("location:city.php?no=9");exit;
}
else{
$sel="select * from city where city ='$city' And  state_id='$state_id'"; 
$sel_query=mysql_query($sel);
		if(mysql_num_rows($sel_query)==0) {
		$sql="INSERT INTO `city`(`city`,`state_id`)values('$city','$state_id')";
		mysql_query( $sql);
        header("location:city.php?no=1&page=$page");
		}
		else { ?>
        <script type="text/javascript">
		document.forms['dataexists'].submit();
		</script> <?php //header("location:city.php?no=18&page=$page");
		}
}
 }
$id=$_GET['id'];
$list=mysql_query("select * from  city where id= '$id'"); 
while($row = mysql_fetch_array($list)){ 
	$city = $row['city'];
	$state_id = $row['state_id'];
	} 

?>
<!------------------------------- Form -------------------------------------------------->
<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headings">City</div>
<div id="mytable" align="center">
<form action="#" method="post" id="validation">
<table>
  <tr height="50px">
  <td>State*</td>
    <td>
       <?php
       	$list=mysql_query("select * from state order by state asc"); 
        // Show records by while loop. 
	   // End while loop. 
        ?>
       <select name="state_id">
        <option value="">--- Select ---</option>
		<?php
		while($row_list=mysql_fetch_assoc($list)){ 
		?>
       <option value="<?php echo $row_list['id']; ?>" <?php if($row_list['id']==$state_id){ echo "selected"; } ?>><?php echo $row_list['state']; ?></option>
       <?php  } ?>
        </select>         
          </td>
           </tr>
       <tr>
    <td class="pclr" width="50">City*</td>
    <td><input type="text" name="city" value="<?php echo $city; ?>"  autocomplete='off' id="city" size="15" maxlength="50"/></td>
     </tr>      
   <tr align="center" height="100px;">
    <td colspan="10"><input type="submit" name="submit" id="submit" class="buttons" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="reset" name="reset" id="reset"  class="buttons" value="Clear" onclick="return cityClear()";/>&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/></td>
      </tr>
</table>
</form>
</div>
<div class="mcf"></div>
<?php include("../include/error.php");?>
<div id="search">
<form action="#" method="get">
<input type="text" name="city" value="<?php $_GET['city']; ?>" autocomplete='off' placeholder='Search By City'/>
<input type="submit" name="submit" class="buttonsg" value="GO"/>
</form>       
</div>  
<div class="mcf"></div>
<div id="container">
      	<?php
		//Delete city and check when is assigned to lga
		if($_GET['delID']!=''){
	    $id = $_GET['delID'];
		$id1 = $_GET['id'];
		$city_sql="select a.*,b.* from lga as a,city as b where a.city_id='$id' AND b.city='$id'";
		$rescity=mysql_query($city_sql);
		$cnt=mysql_num_rows($rescity);
		if($cnt=='1'){
        header("location:city.php?no=21&lga=ass&id=$id1&page=$page"); 
		  }
		}
		if($_POST['submit']=='ConfirmDelete'){
		$query1 =mysql_query("DELETE FROM city WHERE city ='$city'");
		$query=mysql_query("update lga set city_id='Undefined' where city_id='$city'"); 
		header("location:city.php?no=3&page=$page");
		}
		//Check whether City is assigned to any masters
		if($_GET['delID']!=''){
	    $id = $_GET['delID'];
		//Check city is Assigned to customer
		$cityc="select a.*,b.* from customer as a,city as b where a.city='$city' AND b.city='$id'";
		$resProvince=mysql_query($cityc);
		$cnt=mysql_num_rows($resProvince);
		if($cnt=='1'){
        header("location:city.php?no=26&page=$page"); 
		  }
		elseif($_GET['delID']!=''){
		//Check kd_product is Assigned to kd_category
		$cityd="select a.*,b.* from dsr as a,city as b where a.city='$city' AND b.city='$id'";
		$dsr=mysql_query($cityd);
		$cnt=mysql_num_rows($dsr);
		if($cnt=='1'){
        header("location:city.php?no=27&page=$page"); 
		  }
		else{
		//Check price_master is Assigned to kd_category
	    $citykd="select a.*,b.* from kd as a,city as b where a.city='$city' AND b.city='$id'";
		$dsr=mysql_query($citykd);
		$cnt=mysql_num_rows($dsr);
		if($cnt=='1'){
        header("location:city.php?no=28&page=$page"); 
		  }
		   }
		 }
		}
	
		?> 
		<?php
		if($_GET['submit']!='')
		{
		$var = @$_GET['city'] ;
        $trimmed = trim($var);	
	    $qry="SELECT * FROM `city` where city like '%".$trimmed."%' order by city ASC,state_id asc";
		}
		else
		{
		$qry="SELECT * FROM `city` order by city ASC,state_id ASC";  
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
        <th>State<img src="../images/sort.png" width="13" height="13" /></th>
		<th class="rounded">City*<img src="../images/sort.png" width="13" height="13" /></th>
		<th align="right">Edit</th>
		</tr>
		</tr>
		</thead>
		<tbody>
		<?php
		if(!empty($num_rows)){
		$c=0;$cc=1;
		while($fetch = mysql_fetch_array($results)) {
		if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }
		$ids= $fetch['id'];
		$state_id=$fetch['state_id'];
		?>
		<tr>
		<td><?php
		$sql=mysql_query("select * from state where id = '$state_id'");
		$rowp = mysql_fetch_array($sql);
	    $ids=$rowp['id'];
		$stat=$rowp['state'];

		if($state_id = $ids) {
		 echo $stat;
		}
		?>
		</td>
        <td><?php echo $fetch['city'];?></td>
		<td align="right">
        <a href="city.php?id=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']);?>"><img src="../images/user_edit.png" alt="" title="" width="11" height="11"/></a>
   <!--     <a href="city.php?id=<?php echo $fetch['id'];?>&delID=<?php echo $fetch['city'];?>&page=<?php echo intval($_GET['page']);?>"><img src="../images/trash.png" alt="" title="" width="11" height="11" /></a>-->
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
		<th class="pagination">          
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
 <!--   Confirm Delete Box   -->
     <div class="msg" align="center" <?php if($_GET['delID']!=''||$_GET['lga']=='ass'){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
     <form action="" method="post">
     <a href="city.php?delID=<?php echo $fetch['delID'];?>"><input type="submit" name="submit" id="submit" class="buttonsdel" value="ConfirmDelete" /></a>&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='city.php'"/>
        </form>
     </div>       
    </div>
</div>
<?php include('../include/footer.php'); ?>