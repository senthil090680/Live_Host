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
$sql=("UPDATE base_information SET 
          KD_Code= '$KD_Code', 
          KD_Name='$KD_Name', 
          Base_IP='$Base_IP',
		  Base_Url='$Base_Url',
		  base_id='$base_id',
		  Host_id='$Host_id',
		  branch_id='$branch_id'
		  WHERE id = '$id'");
mysql_query( $sql);
header("location:base_register.php?no=2&page=$page");
}
}
elseif($_POST['submit']=='Save'){?>
<form action="" method="post" id="resubmitform">
<input type="hidden" name="KD_Code" value="<?php echo $KD_Code; ?>" />
<input type="hidden" name="KD_Name" value="<?php echo $KD_Name; ?>" />
<input type="hidden" name="Base_IP" value="<?php echo $Base_IP; ?>" />
<input type="hidden" name="Base_Url" value="<?php echo $Base_Url; ?>" />
<input type="hidden" name="branch_id" value="<?php echo $branch_id; ?>" />
<input type="hidden" name="no" value="9" />
 
</form>
<form action="" method="post" id="dataexists">
<input type="hidden" name="KD_Code" value="<?php echo $KD_Code; ?>" />
<input type="hidden" name="KD_Name" value="<?php echo $KD_Name; ?>" />
<input type="hidden" name="Base_IP" value="<?php echo $Base_IP; ?>" />
<input type="hidden" name="Base_Url" value="<?php echo $Base_Url; ?>" />
<input type="hidden" name="branch_id" value="<?php echo $branch_id; ?>" />
<input type="hidden" name="no" value="18" />
<input type="hidden" name="page" value="<?php echo $page; ?>" />
</form>
<?php
	
if($KD_Name=='' || $KD_Code==''  || $Base_IP=='' || $Base_Url=='')
{?>
<script type="text/javascript">
document.forms['resubmitform'].submit();
</script>
<?php }
else{
$sql="INSERT INTO `base_information`(`KD_Code`,`KD_Name`, `Base_IP`,`Base_Url`,`base_id`,`Host_id`,`branch_id`)
values('$KD_Code','$KD_Name','$Base_IP','$Base_Url','$base_id','$Host_id','$branch_id')";
mysql_query( $sql);
        header("location:base_register.php?no=1&page=$page");
		}?>
		<script type="text/javascript">
		document.forms['dataexists'].submit();
		</script>
		
  <?php  }
   
$id=$_GET['id'];
$list=mysql_query("select * from base_information where id= '$id'"); 
while($row = mysql_fetch_array($list)){ 
	$KD_Code = $row['KD_Code'];
	$KD_Name = $row['KD_Name'];
	$Base_IP = $row['Base_IP'];
	$Base_Url = $row['Base_Url'];
	$branch_id = $row['branch_id'];
  }
?>


<!------------------------------- Form -------------------------------------------------->
<style type="text/css">
#mytablebie {
	background:#fff;
	width:80%;
	margin-left:auto;
	margin-right:auto;
	height:160px;
}

.headingbi {
	background:#a09e9e;
	width:80%;
	margin-left:auto;
	margin-right:auto;
	height:25px;
	padding-top:5px;
	border-radius:6px;
	font-weight:bold;
	font-size:14px;
}

#container {
	padding:0px;
	width:80%;
	margin-left:auto;
	margin-right:auto;
}


.con {
	width:100%;
	text-align:left;
	border-collapse:collapse;
	background:#a09e9e;
	margin-left:auto;
	margin-right:auto;
	border-radius:10px;
}

.con th{
	width:22%;
	padding:2px 5px 0 5px;
	font-weight:bold;
	font-size:13px;
	color:#000;
}
.con td{
	padding:2px 5px 0 5px;
	background:#fff;
	border-collapse:collapse;
	color: #000;
	font-size:13px;
}
.con tbody tr:hover td,{
	background: #c1c1c1;
}

</style>
<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headingbi">Base Information</div>
<div id="mytablebie">
<form action="" method="post" id="validation">
<table width="100%">
    <tr height="30px">
    <td class="pclr align">KD Code*</td>
    <td class="align">
         <select name="KD_Code" id="KD_Code" onchange="return kdselect()">
        <option value="">--- Select ---</option>
        <?php 
        // Get records from database (table "name_list"). 
        $list=mysql_query("select * from  kd  order by  KD_Code  asc"); 
        
        // Show records by while loop. 
        while($row_list=mysql_fetch_assoc($list)){ 
        ?>
        <option value="<?php echo $row_list['KD_Code']; ?>" <?php if($row_list['KD_Code']==$KD_Code){ echo "selected"; } ?>><?php echo $row_list['KD_Code']; ?></option>
        <?php 
        // End while loop. 
        } 
        ?>
        </select>
      </td>
      <td class="align">KD Name</td>
      <td class="align" colspan="10"><input type="text"  name="KD_Name"  id="KD_Name" size="80" value="<?php echo $KD_Name; ?>" autocomplete='off'/></td>  
      </tr>
    
     <tr  height="30px;">
     <td class="align">IP*</td>
     <td class="align"><input type="text" name="Base_IP"  size="10" value="<?php echo $Base_IP; ?>"  autocomplete="off" /></td>



     <td class="align">URL*</td>
    <td  class="align" colspan="10"><input type="text" name="Base_Url"  size="80" value="<?php echo $Base_Url; ?>"  autocomplete="off" /></td>
    </tr>
    
     <tr  height="30px;">
     <td class="align">Branch</td>
     <td  class="align">
    <?php
        $list=mysql_query("select * from branch order by branch asc");
        ?>
        <select name="branch_id" id="branch_id" >
        <option value="">--- Select ---</option>
		<?php
		while($row_list=mysql_fetch_assoc($list)){
		$id=$row_list['branch'];
		?>
        <option value="<?php echo $row_list['id']; ?>" <?php if($row_list['id']==$branch_id){ echo "selected"; } ?>><?php echo $row_list['branch'];?></option>
        <?php  } ?>
        </select>
        </td>
     
     
     <td class="align">Host ID</td>
     <?php $list=mysql_query("select * from host_information");$row=mysql_fetch_assoc($list) ?>
     <td class="align"><input type="text" name="Host_id"  size="10" value="<?php echo $row[Host_id]; ?>"  autocomplete="off" /></td>

     <td class="align">Base ID*</td>
     <td  class="align">
      <?php
  $param=mysql_query("select * from  base_information"); 
  $row=mysql_fetch_array($param);
?>
   <select name="base_id" >
    <option value="">--- Select ---</option>
    <option value="sfa_base"  <?php if($row['base_id']=='sfa_base'){ echo 'selected'; }?>>sfa_Base</option>
    <option value="sfa_base1" <?php if($row['base_id']=='sfa_base1'){ echo 'selected'; }?>>sfa_Base1</option>
    <option value="sfa_base2" <?php if($row['base_id']=='sfa_base2'){ echo 'selected'; }?>>sfa_Base2</option>
    <option value="sfa_base3" <?php if($row['base_id']=='sfa_base3'){ echo 'selected'; }?>>sfa_Base3</option>
    <option value="sfa_base4" <?php if($row['base_id']=='sfa_base4'){ echo 'selected'; }?>>sfa_Base4</option>
    <option value="sfa_base5" <?php if($row['base_id']=='sfa_base5'){ echo 'selected'; }?>>sfa_Base5</option>
    <option value="sfa_base6" <?php if($row['base_id']=='sfa_base6'){ echo 'selected'; }?>>sfa_Base6</option>
    </select></td>
 
    </tr>
    
     
    <tr height="50px;" align="center">
        <td colspan="10">
     <input type="submit" name="submit" id="submit" class="buttons" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
     <input type="reset" name="reset"  class="buttons" value="Clear" id="clear" onclick="return baseinfclr();" />&nbsp;&nbsp;&nbsp;&nbsp;
     <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/></td> 
           
    </tr>
</table>
</form>
</div>
<?php include("../include/error.php");?>
<div class="mcf"></div>        
<div id="container">
	     <?php
		if($_GET['delID']!=''){
		if($_POST['submit']=='ConfirmDelete'){
		$id = $_GET['delID'];
		$query = "DELETE FROM `scheme_master` WHERE id = $id";
        //Run the query
        $result = mysql_query($query) or die(mysql_error());
        header("location:scheme.php?no=3&page=$page");
		}
		 }
		?> 
		<?php
		$qry="SELECT * FROM `base_information` order by KD_Name asc";
		$results=mysql_query($qry);
		$pager = new PS_Pagination($bd,$qry,4,4);
		$results = $pager->paginate();
		$num_rows= mysql_num_rows($results);			
		?>
        <div class="con">
        <table id="sort" class="tablesorter" width="100%">
		<thead>
		<tr>
		<th style="width:10%">KD Code</th>
		<th style="width:50%">KD Name</th>
        <th style="width:20%">Branch</th>
        <th style="width:10%">IP Address</th>
        <th>URL</th>
        <th style="width:10%">Base ID</th>
        <th style="width:10%">Host ID</th>
      	<th align="right">Mod</th>
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
		$branchid= $fetch['branch_id'];
		?>
		<tr>
		<td><?php echo $fetch['KD_Code'];?></td>
		<td><?php echo $fetch['KD_Name'];?></td>
       	<td>
         <?php
		$sambr=mysql_query("select * from  branch where id= '$branchid'");
        $row=mysql_fetch_array($sambr);
        $branid=$row['id'];
		$branchv=$row['branch'];
		if($branchid=$branchv){echo $branchv;}?>
        </td>
        <td><?php echo $fetch['Base_IP'];?></td>
        <td><?php echo $fetch['Base_Url'];?></td>
        <td><?php echo $fetch['base_id'];?></td>
        <td><?php echo $fetch['Host_id'];?></td>
       	<td align="right">
        <a href="base_register.php?id=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']);?>"><img src="../images/user_edit.png" alt="" title="" width="11" height="11"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
         </td>
        </tr>
		<?php $c++; $cc++; }		 
		}else{  echo "<tr><td align='center' colspan='13'><b>No records found</b></td><td style='display:none' align='center' colspan='13'><b>No records found</b></td><td style='display:none' align='center' colspan='13'><b>No records found</b></td><td style='display:none' align='center' colspan='13'><b>No records found</b></td><td style='display:none' align='center' colspan='13'><b>No records found</b></td></tr>";}  ?>
		</tbody>
		</table>
        </div>
       </div>
</div>
<?php include('../include/footer.php'); ?>