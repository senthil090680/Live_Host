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
$sql  =  ("UPDATE uom SET 
          UOM_code= '$UOM_code', 
          UOM_description='$UOM_description'
      	  WHERE id=$id ");
mysql_query($sql);
header("location:uomMaster.php?no=2");
}
}
elseif($_POST['submit']=='Save'){
$sel="select * from uom where UOM_code ='$UOM_code'";
$sel_query=mysql_query($sel);
		if(mysql_num_rows($sel_query)=='0') {
    	$active='active';
		$sql="INSERT IGNORE INTO `uom`(`UOM_code`,`UOM_description`)
        values('$UOM_code','$UOM_description')";
        mysql_query( $sql);
        header("location:uomMaster.php?no=1");
		}
		else {
		header("location:uomMaster.php?no=18");
		}
}
$id=$_GET['id'];
$list=mysql_query("select * from uom where id=1"); 
while($row = mysql_fetch_array($list)){ 
	$UOM_code = $row['UOM_code'];
	$UOM_description = $row['UOM_description'];
	} 

?>
<!------------------------------- Form -------------------------------------------------->
<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headings">UOM 1</div>
<div id="mytable" align="center">
<form action="#" method="post" id="validation">
<table>
  <tr height="50px">
     <td  class="pclr align">UOM1*</td>
     <td><input type="text" class="required" name="UOM_code" id="UOM_code" size="10" value="<?php echo $UOM_code ?> " readonly="readonly"/></td>
   </tr>
   
  <tr>
    <td  class="align">UOM1 Description*</td>
    <td><input type="text" class="required" name="UOM_description" id="UOM_description" size="10" value="<?php echo $UOM_description ?> " readonly="readonly"/></td>
   </tr>
   <tr height="100px;" align="center">
        <td colspan="10">
        <input type="submit" name="submit" id="submit" class="buttons" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="reset" name="reset" id="reset"  class="buttons" value="Clear" />&nbsp;&nbsp;&nbsp;&nbsp;
       <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/></td>
        </tr>
</table>
</form>
</div>
<?php include("../include/error.php");?>
<div class="mcf"></div>    
<div id="container">
	    <?php
		if($_GET['submit']=="")
		{
		$var = @$_GET['UOM_code'] ;
        $trimmed = trim($var);	
	    $qry="SELECT * FROM `uom` where UOM_code like '%".$trimmed."%' order by id asc";
		}
		else
		{ 
		$qry="SELECT * FROM `uom` order by id asc"; 
		}
		$results=mysql_query($qry);
		$pager = new PS_Pagination($bd, $qry,5,5);
		$results = $pager->paginate();
		$num_rows= mysql_num_rows($results);			
		?>
        <div class="con2">
        <table align="center">
     	<thead>
		<tr>
		<th class="rounded">UOM1</th>
		<th>UOM1 Description</th>
     	</tr>
		</tr>
		</thead>
        <tbody>
		<?php
		if(!empty($num_rows)){
		$c=0;$cc=1;
		while($fetch = mysql_fetch_array($results)) {
		if($c % 2 == 0){ $cls =""; } else{ $cls ="class='odd'"; }
		$id= $fetch['id'];
		?>
		<tr>
		<td><?php echo $fetch['UOM_code'];?></td>
	    <td><?php echo $fetch['UOM_description'];?></td>
        </tr>
		<?php $c++; $cc++; }		 
		}else{  echo "<tr><td align='center' colspan='13'><b>No records found</b></td></tr>";}  ?>
		</tbody>
		</table>
        </div>
	</div>       
</div>
<?php include('../include/footer.php'); ?>