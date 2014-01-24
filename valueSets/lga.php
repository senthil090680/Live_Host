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
        $sql =("UPDATE lga SET 
        lga='$lga',
		city_id='$city_id'
	   	WHERE id = '$id'");
		mysql_query( $sql);
header("location:lga.php?no=2$page=$page");
}
}
//Insert Data
elseif($_POST['submit']=='Save'){ ?>
<form action="" method="post" id="resubmitform">
<input type="hidden" name="lga" value="<?php echo $lga; ?>" />
<input type="hidden" name="city_id" value="<?php echo $city_id; ?>" />
<input type="hidden" name="no" value="9" />
</form>

<form action="" method="post" id="dataexists">
<input type="hidden" name="city" value="<?php echo $city; ?>" />
<input type="hidden" name="state_id" value="<?php echo $state_id; ?>" />
<input type="hidden" name="no" value="18" />
<input type="hidden" name="page" value="<?php echo $page; ?>" />
</form>

<?php
//Check mandatory field is not empty
if($lga=='' || $city_id=='')
{ ?>
<script type="text/javascript">
document.forms['resubmitform'].submit();
</script>
<?php //header("location:lga.php?no=9");exit;
}
else{
$sel="select * from lga where lga ='$lga' And  city_id='$city_id'"; 
$sel_query=mysql_query($sel);
		if(mysql_num_rows($sel_query)==0) {
		$sql="INSERT INTO `lga`(`lga`,`city_id`)values('$lga','$city_id')";
		mysql_query( $sql);
        header("location:lga.php?no=1$page=$page");
		}
		else { ?>
        <script type="text/javascript">
		document.forms['dataexists'].submit();
		</script> <?php //header("location:lga.php?no=18$page=$page");
		
		}
}
 }

$id=$_GET['id'];
$list=mysql_query("select * from lga where id='$id'"); 
while($row = mysql_fetch_array($list)){ 
	$lga = $row['lga'];
	$city_id = $row['city_id'];
	
	} 
?>
<!------------------------------- Form -------------------------------------------------->
<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headings">LGA</div>
<div id="mytable" align="center">
<form action="" method="post" id="validation">
<table>
 <tr height="60px">
  
  <td>City</td>
    <td>
		  <?php 
        include('../include/config.php');
		$list=mysql_query("select * from city order by city asc"); 
        // Show records by while loop. 
	// End while loop. 
        ?>
       <select name="city_id">
        <option value="">--- Select ---</option>
		<?php 		
		while($row_list=mysql_fetch_assoc($list)){ 
		$id=$row_list['id'];
		?>
        <option value="<?php echo $row_list['id']; ?>" <?php if($row_list['id']==$city_id){ echo "selected"; } ?>><?php echo $row_list['city']; ?></option>
        <?php  } ?>
        </select>         
          </td></tr>
  <tr>
    <td class="pclr" width="50">LGA*</td>
     <td><input type="text" name="lga" value="<?php echo $lga; ?>" id="lga" size="15" autocomplete='off' maxlength="20	"/></td>
    </tr>
 
   <tr align="center" height="70px;">
    <td colspan="10">
    <input type="submit" name="submit" id="submit" class="buttons" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="reset" name="reset" id="Clear"  class="buttons" value="Clear" onclick='return lga();'/>&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/></td>
      </tr>
</table>
</form>
</div>
<?php include("../include/error.php");?>
<div id="search">
<form action="" method="get">
<input type="text" name="lga" value="<?php $_GET['lga']; ?>" autocomplete='off' placeholder='Search By LGA'/>
<input type="submit" name="submit" class="buttonsg" value="GO"/>
</form>       
</div>
<div class="mcf"></div>
<div id="container">
        <?php
		//Delete lga and check when is assigned to loc
		if($_GET['delID']!=''){
	    $id = $_GET['delID'];
		$id1 = $_GET['id'];
		$loc_sql="select a.*,b.* from location as a,lga as b where a.lga_id='$id' AND b.lga='$id'";
		$resloc=mysql_query($loc_sql);
		$cnt=mysql_num_rows($resloc);
		if($cnt=='1'){
        header("location:lga.php?no=22&loc=ass&id=$id1&page=$page"); 
		  }
		}
		if($_POST['submit']=='ConfirmDelete'){
		echo "Hi";
		
		$list=mysql_query("select * from lga"); 
  		$query1 =mysql_query("DELETE FROM lga WHERE lga ='$lga'");
		$query=mysql_query("update location set lga_id='Undefined' where lga_id='$lga'"); 	
        header("location:lga.php?no=3&page=$page");
		}
		
		if($_GET['delID']!=''){
	    $id = $_GET['delID'];
		$cat_sql="select a.*,b.* from customer as a,lga as b where a.lga='$lga' AND b.lga='$id'";
		$rescat=mysql_query($cat_sql);
		$cnt=mysql_num_rows($rescat);
		if($cnt=='1'){
        header("location:lga.php?no=31$page=$page"); 
		  }
		}
	 
		?> 
 		<?php
		if($_GET['submit']!='')
		{
		$var = @$_GET['lga'] ;
        $trimmed = trim($var);
		$qry="SELECT * FROM `lga` where lga like '%".$trimmed."%' order by city_id asc,lga asc";
		}
		else
		{ 
	    $qry="SELECT * FROM `lga` order by city_id asc,lga asc";  
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
        <th>City<img src="../images/sort.png" width="13" height="13" /></th>
		<th class="rounded">LGA<img src="../images/sort.png" width="13" height="13" /></th>
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
		$id= $fetch['id'];
		$city_id=$fetch['city_id'];
		?>
		<tr>
        <td>
		<?php 
		$sql=mysql_query("select * from city where id = '$city_id'"); 
		$rowp = mysql_fetch_array($sql);
	    $idc=$rowp['id'];
		$cit=$rowp['city'];

		if($city_id = $idc) {
	    echo $cit;
		}

		?>
        </td>
     	<td><?php echo $fetch['lga'];?></td>
       	<td align="right">
        <a href="lga.php?id=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']);?>"><img src="../images/user_edit.png" alt="" title="" width="11" height="11"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
      <!--  <a href="lga.php?id=<?php echo $fetch['id'];?>&delID=<?php echo $fetch['lga'];?>&page=<?php echo intval($_GET['page']);?>"><img src="../images/trash.png" alt="" title="" width="11" height="11" /></a>-->
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
       <div class="msg" align="center" <?php if($_GET['delID']!=''||$_GET['loc']=='ass'){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
     <form action="" method="post">
     <a href="lga.php?delId=<?php echo $fetch['delId'];?>"><input type="submit" name="submit" id="submit" class="buttonsdel" value="ConfirmDelete" /></a>&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='lga.php'"/>
        </form>
     </div>      
   </div>
</div>
<?php include('../include/footer.php'); ?>