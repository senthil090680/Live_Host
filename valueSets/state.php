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
$page=intval($_REQUEST['page']);
$id=$_REQUEST['id'];
if($_GET['id']!=''){
if($_POST['submit']=='Save'){
//Check Uniqueness same data not update
$sel="select * from state where state ='$state' And  province_id='$province_id'"; 
$sel_query=mysql_query($sel);
if(mysql_num_rows($sel_query) == '0') {
//update state master
$sql =("UPDATE state SET 
        state='$state',
		province_id='$province_id'
       	WHERE id = '$id'");
mysql_query( $sql);
header("location:state.php?no=2&page=$page");
}
else{
header("location:state.php?no=18");
}
}
}
elseif($_POST['submit']=='Save'){?>
<form action="" method="post" id="resubmitform">
<input type="hidden" name="province_id" value="<?php echo $province_id; ?>" />
<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="no" value="9" />
</form>

<form action="" method="post" id="dataexists">
<input type="hidden" name="province_id" value="<?php echo $province_id; ?>" />
<input type="hidden" name="state" value="<?php echo $state; ?>" />
<input type="hidden" name="no" value="18" />
<input type="hidden" name="page" value="<?php echo $page; ?>" />
</form>

<?php
//Check mandatory field is not empty
if($state==''|| $province_id=='')
{ ?>

<script type="text/javascript">
document.forms['resubmitform'].submit();
</script>
<?php //header("location:state.php?no=9");exit;
}
else{
$sel="select * from state where state ='$state' And  province_id='$province_id'"; 
$sel_query=mysql_query($sel);
		if(mysql_num_rows($sel_query)=='0') {
		$sql="INSERT INTO `state`(`state`,`province_id`)values('$state','$province_id')";
        mysql_query( $sql);
        header("location:state.php?no=1&page=$page");
		}
		else {?>
        <script type="text/javascript">
		document.forms['dataexists'].submit();
		</script>
        <?php //header("location:state.php?no=18&page=$page");
		}
}
 }

$id=$_GET['id'];
$list=mysql_query("select * from state where id= '$id'"); 
while($row = mysql_fetch_array($list)){ 
	$state = $row['state'];
	$province_id = $row['province_id'];
	} 
?>

<!------------------------------- Form -------------------------------------------------->
<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headings">State</div>
<div id="mytable" align="center">
<form action="" method="post" id="validation">
<table>
  <tr height="50px">
  <td>Zone*</td>
     <td>
       <?php
        $list=mysql_query("select * from province order by  province asc");
        // Show records by while loop.
	   // End while loop.
        ?>
       <select name="province_id">
        <option value="">--- Select ---</option>
		<?php
		while($row_list=mysql_fetch_assoc($list)){
		?>
       <option value="<?php echo $row_list['id']; ?>" <?php if($row_list['id']== $province_id){ echo "selected"; } ?>><?php echo $row_list['province']; ?></option>

        <?php  } ?>
        </select>
          </td>
           </tr>
       <tr>
    <td class="pclr" width="50">State*</td>
    <td><input type="text" name="state" autocomplete='off' value="<?php echo $state; ?>" size="15" maxlength="50"/></td>
     </tr>      
   <tr align="center" height="100px;">
    <td colspan="10"><input type="submit" name="submit" id="submit" class="buttons" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="reset" name="reset" class="buttons" value="Clear"  id="clear" onclick='return stateClear();'/>&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/></td>
      </tr>
</table>
</form>

</div>
<?php include("../include/error.php");?>
    <div id="search">
    <form action="#" method="get">
    <input type="text" name="state" value="<?php $_GET['state']; ?>" autocomplete='off' placeholder='Search By State'/>
    <input type="submit" name="submit" class="buttonsg" value="GO"/>
    </form>       
    </div> 
<div class="mcf"></div>
<div id="container">
       <?php
	    //Delete state and check when is assigned to city
		if($_GET['delID']!=''){
	    $id = $_GET['delID'];
		$id1 = $_GET['id'];
		$state_sql="select a.*,b.* from city as a,state as b where a.state_id='$id' AND b.state ='$id'";
		$resProvince=mysql_query($state_sql);
		$cnt=mysql_num_rows($resProvince);
		if($cnt=='1'){
        header("location:state.php?no=20&city=ass&id=$id1&page=$page"); 
		  }
		}
		if($_POST['submit']=='ConfirmDelete'){
		$list=mysql_query("select * from  state"); 
        $row = mysql_fetch_array($list);
	    $sta = $row['state'];
		echo $query1 =mysql_query("DELETE FROM state WHERE state ='$state'");
		$query=mysql_query("update city set state_id='Undefined' where state_id='$state'"); 
		header("location:state.php?no=3&page=$page");
		}
	    //Check State is Assigned to Customer
		if($_GET['delID']!=''){
	    $id = $_GET['delID'];
		$state_sql="select a.*,b.* from customer as a,state as b where a.state='$state' AND b.state='$id'";
		$resProvince=mysql_query($state_sql);
		$cnt=mysql_num_rows($resProvince);
		if($cnt=='1'){
        header("location:state.php?no=24&page=$page"); 
		  }
		else{
		//Check State is Assigned to DSR
		$statedsr="select a.*,b.* from dsr as a,state as b where a.state='$state' AND b.state='$id'";
		$dsr=mysql_query($statedsr);
		$cnt=mysql_num_rows($dsr);
		if($cnt=='1'){
        header("location:state.php?no=25&page=$page"); 
		  }
		 } 
		}
		?> 
		<?php
		if($_GET['submit']!='')
		{
		$var = @$_GET['state'] ;
        $trimmed = trim($var);
	    $qry="SELECT * FROM `state` where state like '%".$trimmed."%' ORDER BY state ASC";
		}
		else
		{ 
        $qry="select * FROM state ORDER BY state ASC";	
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
	    <th>Zone<img src="../images/sort.png" width="13" height="13" /></th>
       	<th scope="col" class="rounded">State<img src="../images/sort.png" width="13" height="13" /></th>
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
	    $id = $fetch['id'];
		$province_id=$fetch['province_id'];
		?>
		<tr>
		<td>
		<?php
		$sql=mysql_query("select * from province where id = '$province_id'");
		$rowp = mysql_fetch_array($sql);
	    $idp=$rowp['id'];
		 $prov=$rowp['province'];

		if($province_id = $idp) {
		 echo $prov;
		}

		?></td>
        <td><?php echo $fetch['state'];?></td>
		<td align="right">
        <a href="state.php?id=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']);?>"><img src="../images/user_edit.png" alt="" title="" width="11" height="11"/></a>
        <!--<a href="state.php?id=<?php echo $fetch['id'];?>&delID=<?php echo $fetch['state'];?>&page=<?php echo intval($_GET['page']) ;?>"><img src="../images/trash.png" alt="" title="" width="11" height="11" /></a>-->
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
     <div class="msg" align="center" <?php if($_GET['delID']!=''||$_GET['city']=='ass'){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
     <form action="" method="post">
     <a href="state.php?delID=<?php echo $fetch['delID'];?>"><input type="submit" name="submit" id="submit" class="buttonsdel" value="ConfirmDelete" /></a>&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='state.php'"/>
        </form>
     </div>
   </div>
</div>
<?php include('../include/footer.php'); ?>