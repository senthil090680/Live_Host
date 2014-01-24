<?php
session_start();
ob_start();
include('../include/header.php');
include "../include/ps_pagination.php";
if(isset($_GET['logout'])){
session_destroy();
header("location:../index.php");
}
EXTRACT($_POST);
$page=intval($_GET['page']);
$id=$_REQUEST['id'];
if($_GET['id']!=''){
if($_POST['submit']=='Save'){
        $sql =("UPDATE location SET 
        location='$location',
		lga_id='$lga_id'
	   	WHERE id = '$id'");
		mysql_query( $sql);
header("location:location.php?no=2&page=$page");
}

}
//Insert Data
elseif($_POST['submit']=='Save'){ ?>
<form action="" method="post" id="resubmitform">
<input type="hidden" name="location" value="<?php echo $location; ?>" />
<input type="hidden" name="lga_id" value="<?php echo $lga_id; ?>" />
<input type="hidden" name="no" value="9" />
</form>

<form action="" method="post" id="dataexists">
<input type="hidden" name="location" value="<?php echo $location; ?>" />
<input type="hidden" name="lga_id" value="<?php echo $lga_id; ?>" />
<input type="hidden" name="no" value="18" />
<input type="hidden" name="page" value="<?php echo $page; ?>" />
</form>

<?php
//Check mandatory field is not empty
if($location=='' || $lga_id=='')
{ ?>
<script type="text/javascript">
document.forms['resubmitform'].submit();
</script>
<?php //header("location:location.php?no=9");exit;
}
else{
$sel="select * from location where location ='$location' And  lga_id='$lga_id'"; 
$sel_query=mysql_query($sel);
		if(mysql_num_rows($sel_query)==0) {
		$sql="INSERT INTO `location`(`location`,`lga_id`)values('$location','$lga_id')";
		mysql_query( $sql);
        header("location:location.php?no=1&page=$page");
		}
		else { ?>
        <script type="text/javascript">
		document.forms['dataexists'].submit();
		</script>
        <?php //header("location:location.php?no=18&page=$page");
		}
}
 }
$id=$_GET['id'];
$list=mysql_query("select * from  location where id= '$id'"); 
while($row = mysql_fetch_array($list)){ 
	$location = $row['location'];
	$lga_id = $row['lga_id'];
	} 

?>
<!------------------------------- Form -------------------------------------------------->
<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headings">Location</div>
<div id="mytable" align="center">
<form action="#" method="post" id="validation">
<table>
  <tr  height="50px">
     <td>LGA</td>
     <td>
	 <?php 
        include('../include/config.php');
		$list=mysql_query("select * from lga order by lga"); 
        // Show records by while loop. 
	   // End while loop. 
        ?>
       <select name="lga_id">
       <option value="">--- Select ---</option>
		<?php 		
		while($row_list=mysql_fetch_assoc($list)){ 
		?>
        <option value="<?php echo $row_list['id']; ?>" <?php if($row_list['id']==$lga_id){ echo "selected"; } ?>><?php echo $row_list['lga']; ?></option>
       <?php  } ?>
        </select>       
   </td>
   </tr>
  <tr>
    <td class="pclr" width="50">Location*</td>
    <td><input type="text" name="location" value="<?php echo $location; ?>" id="location"  maxlength="50" autocomplete='off'/></td>
   </tr>
   
   <tr align="center" height="100px;">
        <td colspan="10"><input type="submit" name="submit" id="submit" class="buttons" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="reset" name="reset" id="Clear"  class="buttons" value="Clear" onclick='return loc();'/>&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/></td>
      </tr>
</table>
</form>
</div>
<?php include("../include/error.php");?>
<div id="search">
<form action="#" method="get">
<input type="text" name="location" value="<?php $_GET['location']; ?>" autocomplete='off' placeholder='Search By location'/>
<input type="submit" name="submit" class="buttonsg" value="GO"/>
</form>       
</div> 
<div class="mcf"></div>
<div id="container">
	    <?php
		if($_GET['delID']!=''){
	    $id = $_GET['delID'];
		$cat_sql="select a.*,b.* from route_master as a,location as b where a.location='$location' AND b.id='$id'";
		$rescat=mysql_query($cat_sql);
		$cnt=mysql_num_rows($rescat);
		if($cnt=='1'){
        header("location:location.php?no=42&page=$page"); 
		  }
		}
		if($_GET['delID']!=''){
		if($_POST['submit']=='ConfirmDelete'){
		$id = $_GET['delID'];
		$query = "DELETE FROM location WHERE id = $id";
        //Run the query
        $result = mysql_query($query) or die(mysql_error());
        header("location:location.php?no=3&page=$page");
		}
		 }
		 
		?>         
    	<?php
		if($_GET['submit']!='')
		{
		$var = @$_GET['location'] ;
        $trimmed = trim($var);
	    $qry="SELECT * FROM `location` where location like '%".$trimmed."%' order by location asc";
		}
		else
		{ 
	    $qry="SELECT * FROM `location` order by location asc";  
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
        <th>LGA<img src="../images/sort.png" width="13" height="13" /></th>
		<th class="rounded">location<img src="../images/sort.png" width="13" height="13" /></th>
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
		$lga_id=$fetch['lga_id'];
		?>
		<tr>
        <td>
        <?php
		$sql=mysql_query("select * from lga where id = '$lga_id'");
		$rowp = mysql_fetch_array($sql);
	    $idl=$rowp['id'];
		$lg=$rowp['lga'];
		if($lga_id = $idl) {
		echo $lg;
		}
		?>
        </td>
		<td><?php echo $fetch['location'];?></td>
		<td align="right">
        <a href="location.php?id=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']);?>"><img src="../images/user_edit.png" alt="" title="" width="11" height="11"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
       <!-- <a href="location.php?id=<?php echo $fetch['id'];?>&delID=<?php echo $fetch['id'];?>&id2=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']);?>"><img src="../images/trash.png" alt="" title="" width="11" height="11" /></a>-->
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
     <div class="msg" align="center" <?php if($_GET['delID']!=''){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
     <form action="" method="post">
     <a href="location.php?id2=<?php echo $fetch['id'];?>"><input type="submit" name="submit" id="submit" class="buttonsdel" value="ConfirmDelete" /></a>&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='location.php'"/>
        </form>
     </div>   
   </div>
</div>
<?php include('../include/footer.php'); ?>