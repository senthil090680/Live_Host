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
$sql=("UPDATE sales_representative SET 
          Salesperson_id= '$Salesperson_id', 
          salesperson_name='$salesperson_name', 
          salesperson_email_id='$salesperson_email_id',
		  salesperson_cont_num='$salesperson_cont_num',
		  role='$role',
		  supervisor='$supervisor'
		  WHERE id = '$id'");
 
mysql_query( $sql);
header("location:SalesRep.php?no=2&page=$page");
}
}
elseif($_POST['submit']=='Save'){?>
<form action="" method="post" id="resubmitform">
<input type="hidden" name="salesperson_name" value="<?php echo $salesperson_name; ?>" />
<input type="hidden" name="Salesperson_id" value="<?php echo $Salesperson_id; ?>" />
<input type="hidden" name="salesperson_cont_num" value="<?php echo $salesperson_cont_num; ?>" />
<input type="hidden" name="salesperson_email_id" value="<?php echo $salesperson_email_id; ?>" />
<input type="hidden" name="DSR_mapped" value="<?php echo $role; ?>" />
<input type="hidden" name="no" value="9" />
 
</form>
<form action="" method="post" id="dataexists">
<input type="hidden" name="salesperson_name" value="<?php echo $salesperson_name; ?>" />
<input type="hidden" name="Salesperson_id" value="<?php echo $Salesperson_id; ?>" />
<input type="hidden" name="salesperson_cont_num" value="<?php echo $salesperson_cont_num; ?>" />
<input type="hidden" name="salesperson_email_id" value="<?php echo $salesperson_email_id; ?>" />
<input type="hidden" name="DSR_mapped" value="<?php echo $role; ?>" />
<input type="hidden" name="no" value="18" />
<input type="hidden" name="page" value="<?php echo $page; ?>" />
</form>
<?php	
if($salesperson_name=='' || $Salesperson_id==''  || $salesperson_cont_num=='' || $salesperson_email_id=='')
{?>

<script type="text/javascript">
document.forms['resubmitform'].submit();
</script>

<?php //header("location:SalesRep.php?no=9");exit;
}
else{
$sel="select * from sales_representative where Salesperson_id ='$Salesperson_id'";
$sel_query=mysql_query($sel);
		if(mysql_num_rows($sel_query)=='0') {
		$sql="INSERT INTO `sales_representative`(`Salesperson_id`,`salesperson_name`,`salesperson_email_id`,`salesperson_cont_num`,`role`,`supervisorasm`,`supervisorsr`)
        values('$Salesperson_id','$salesperson_name','$salesperson_email_id', '$salesperson_cont_num','$role','$supervisorasm','$supervisorsr')";
		mysql_query( $sql);
        header("location:SalesRep.php?no=1&page=$page");
		}
		else {?>
        <script type="text/javascript">
		document.forms['dataexists'].submit();
		</script>
        <?php
		//header("location:SalesRep.php?no=18&page=$page");
		}
    }
}
$id=$_GET['id'];
$list=mysql_query("select * from sales_representative where id= '$id'"); 
while($row = mysql_fetch_array($list)){ 
	$Salesperson_id = $row['Salesperson_id'];
	$salesperson_name = $row['salesperson_name'];
	$salesperson_email_id = $row['salesperson_email_id'];
	$salesperson_cont_num = $row['salesperson_cont_num'];
	$role	=$row['role'];
	}

?>
<!------------------------------- Form -------------------------------------------------->
<script type="text/javascript">

$(function(){
  // hide by default
  $('.suphead').css('display', 'none');
  $('.supervisorasm').css('display', 'none');
  $('.supervisorsr').css('display', 'none');

  $('.role').change(function(){
     if ($(this).val() === 'RSM') {
	 $('.suphead').css('display','none');  
	 $('.supervisorasm').css('display', 'none');  
	 $('.supervisorsr').css('display', 'none');
     }							 
							 
  else if ($(this).val() === 'ASM') {
	 $('.suphead').css('display','block');  
	 $('.supervisorasm').css('display', 'block');  
	  $('.supervisorsr').css('display', 'none');
     }
   else if($(this).val() === 'SR') {
	  $('.suphead').css('display', 'block');  
	 $('.supervisorasm').css('display', 'none');  
     $('.supervisorsr').css('display', 'block');
   }
 });
});

</script>

<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headingspr"  style="padding-right:10px;">Sales Personnel</div>
<div id="mytableproduct" align="center" style="padding-right:10px;">
<form action="" method="post">
<table>
    <tr height="30">
    <td class="pclr align" width="100">Name</td>
    <td colspan="10"><input type="text" name="salesperson_name" size="80" value="<?php echo $salesperson_name; ?>" autocomplete='off' maxlength="20" /></td>
    </tr>
    
    <tr height="30">
    <td class="align" style="text-transform:uppercase">Code</td>
    	<?php
		 if(!isset($_GET[id]) && $_GET[id] == '') {
			$srid					=	"SELECT Salesperson_id	FROM  sales_representative ORDER BY id DESC";			
			$srold					=	mysql_query($srid) or die(mysql_error());
			$srcnt					=	mysql_num_rows($srold);
			//$srcnt					=	0; // comment if live
			if($srcnt > 0) {
				$row_sr					  =	 mysql_fetch_array($srold);
				$srnumber	  =	$row_sr['Salesperson_id'];

				$getsrno						=	abs(str_replace("SR",'',strstr($srnumber,"SR")));
				$getsrno++;
				if($getsrno < 10) {
					$createdcode	=	"00".$getsrno;
				} else if($getsrno < 100) {
					$createdcode	=	"0".$getsrno;
				} else {
					$createdcode	=	$getsrno;
				}

				$Salesperson_id				=	"SR".$createdcode;
			} else {
				$Salesperson_id				=	"SR001";
			}
		}
	?>
    <td><input type="text" name="Salesperson_id" size="10" value="<?php echo $Salesperson_id; ?>"  maxlength="10" autocomplete='off'/></td>
    <td class="align" width="100">Contact Number</td>
    <td><input type="text" name="salesperson_cont_num" size="15" value="<?php echo $salesperson_cont_num; ?>" maxlength="10" autocomplete='off'/>
    </td>     
    </tr>
     
    <tr height="30">
    <td class="align">Email ID</td>
    <td colspan="10" width="100"><input type="text" name="salesperson_email_id" size="80" value="<?php echo $salesperson_email_id; ?>" maxlength="20" autocomplete='off'/>
    </td>
    </tr>
    
    
    <tr height="30">
    <td class="align">Role</td>
    <td width="100">
    <select name="role" class="role">
    <option value="">---Select----</option>
    <option value="RSM" <?php if ($role==RSM) echo 'selected="selected"';?>>RSM</options>
    <option value="ASM" <?php if ($role==ASM) echo 'selected="selected"';?>>ASM</options>
    <option value="SR" <?php if ($role==SR) echo 'selected="selected"';?>>SR</options>
     </select></td>
    <!--<td><a href="viewDSR.php" class="link" rel="facebox">Show DSR</a></td>-->
     <td class="align suphead" style="display:none">Supervisor</td>
     <td> 
     <select name="supervisorsam" style="display:none;" class="supervisorasm">
        <option value="">--- Select ---</option>
        <?php 
        $list=mysql_query("select * from sales_representative where role = 'RSM'"); 
        
        // Show records by while loop. 
        while($row_list=mysql_fetch_assoc($list)){ 
        ?>
        <option value="<? echo $row_list['salesperson_name']; ?>" <? if($row_list['salesperson_name']==$brand){ echo "selected"; } ?>><? echo $row_list['salesperson_name']; ?></option>
        <?php 
        // End while loop. 
        } 
        ?>
        </select>
         
     <select name="supervisorsr" style="display:none;" class="supervisorsr">
        <option value="">--- Select ---</option>
        <?php 
        $list=mysql_query("select * from sales_representative where role = 'ASM'"); 
        
        // Show records by while loop. 
        while($row_list=mysql_fetch_assoc($list)){ 
        ?>
        <option value="<? echo $row_list['salesperson_name']; ?>" <? if($row_list['salesperson_name']==$brand){ echo "selected"; } ?>><? echo $row_list['salesperson_name']; ?></option>
        <?php 
        // End while loop. 
        } 
        ?>
        </select></td>
    
     </tr>
    <tr height="70px"align="center">
    <td colspan="10">
    <input type="submit" name="submit" id="submit" class="buttons" value="Save"/>&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="reset" name="reset"  class="buttons" value="Clear" id="clear" onclick="return sr();" />&nbsp;&nbsp;&nbsp;&nbsp;
     <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/></td>
    </tr>
</table>
</form>
</div>
<?php include("../include/error.php");?>
 <div id="search">
    <form action="" method="get">
    <input type="text" name="salesperson_name" value="<?php $_GET['salesperson_name']; ?>" autocomplete='off' placeholder="Search By Name"/>
    <input type="submit" name="submit" class="buttonsg" value="Go"/>
    </form>       
    </div>
<div class="mcf"></div>      
<div id="containerpr">
        <?php
		if($_GET['delID']!=''){
	    $id = $_GET['delID'];
		$cat_sql="select a.*,b.* from dsr as a,sales_representative as b where a.Salesperson_id='$category1' AND b.id='$id'";
		$rescat=mysql_query($cat_sql);
		$cnt=mysql_num_rows($rescat);
		if($cnt=='1'){
        header("location:SalesRep.php?no=49&page=$page"); 
		  }
		}
		if($_GET['delID']!=''){
		$page=intval($_GET['page']);	
		if($_POST['submit']=='ConfirmDelete'){
		$id = $_GET['delID'];
		$query = "DELETE FROM sales_representative WHERE id = $id";
        //Run the query
        $result = mysql_query($query) or die(mysql_error());
        header("location:SalesRep.php?no=3&page=$page");
		}
		 }
		 
		?> 
		<?php
		if($_GET['submit']!=='')
		{
		$var = @$_GET['salesperson_name'] ;
        $trimmed = trim($var);	
	    $qry="SELECT * FROM `sales_representative` where salesperson_name like '%".$trimmed."%' order by salesperson_name asc";
		}
		else
		{ 
	    $qry="SELECT *  FROM `sales_representative` order by salesperson_name asc"; 
		}
		$results=mysql_query($qry);
		$pager = new PS_Pagination($bd, $qry,6,6);
		$results = $pager->paginate();
		$num_rows= mysql_num_rows($results);			
		?>
        <div class="con">
        <table id="sort" class="tablesorter" width="100%">
		<thead>
		<tr>
		<th class="rounded">Code
		<img src="../images/sort.png" width="13" height="13" /></th>
		<th>Name</th>
		<th>Email ID</th>
		<th>Contact Number</th>
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
		<td><?php echo $fetch['Salesperson_id'];?></td>
		<td><?php echo $fetch['salesperson_name'];?></td>
		<td><?php echo $fetch['salesperson_email_id'];?></td>
		<td><?php echo $fetch['salesperson_cont_num'];?></td>
       	<td align="right" width="100"><a href="SalesRep.php?id=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']) ;?>"><img src="../images/user_edit.png" alt="" title="" width="11" height="11"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="SalesRep.php?id=<?php echo $fetch['id'];?>&delID=<?php echo $fetch['id'];?>&page=<?php echo intval($_GET['page']) ;?>"><img src="../images/trash.png" alt="" title="" width="11" height="11" /></a>
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
      <div class="msg" align="center" <?php if($_GET['delID']!=''){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
    <form action="" method="post">
    <input type="submit" name="submit" id="submit" class="buttonsdel" value="ConfirmDelete" />&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='SalesRep.php'"/>
    </form>
    </div>         
   </div>
</div>
<?php include('../include/footer.php'); ?>