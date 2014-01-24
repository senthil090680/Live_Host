<?php 
ob_start();
include('../include/header.php');
include "../include/ps_pagination.php";
EXTRACT($_POST);	
if(!empty($_REQUEST["Product_code"])){
$sel2="select * from  devicetransactions where Product_code =".$_GET['Product_code']; 
$sel_query2=mysql_query($sel2);
$row2=mysql_num_rows($sel_query2);
if($row2=='0') {
if($_POST['submit']=='ConfirmDelete'){
//echo "LP"; exit;
$delete="delete from `price_master` WHERE `Product_code` = ".$_REQUEST['Product_code']; 
$delete1=mysql_query($delete) or die(mysql_error()); 
header('Location:price.php?no=3');
}
}
else
{
header('Location:price.php?no=50');
}
}
if($submit=='Save')
{
			if($Kd_Category==''||$Price=='')
			{
			//echo "Enter Mandatory Fields";
			header("location:price.php?no=9"); 
			}
			else
			{				
				$Effective_date=date("Y-m-d");	
				if($_POST['Effective_date']==''){
				$cnt=count($_POST['Product_code']);
		for($j=0;$j<$cnt;$j++){
				$Product_code=$_POST['Product_code'][$j];
				$sel1="select * from price_master where Product_code ='$Product_code' AND Kd_Category='$Kd_Category'"; 
				$sel_query1=mysql_query($sel1);
				$row=mysql_num_rows($sel_query1);
				if($row=='0') {
				mysql_query("INSERT INTO price_master(KD_Code,Kd_Category,UOM1,Product_code,Price,Effective_date,Status_price_master)
				VALUES('KD001','$Kd_Category','$UOM1','$Product_code','$Price','$Effective_date','Checked'");
				mysql_query("UPDATE product SET 
					  Status='Checked_price'
					  WHERE Product_code = '$Product_code'"); 
//  				header("location:price.php?no=1");
				}
				else
				{
				header("location:price.php?no=al");exit;
				}
		}
			}
		}
}
			
			// exit;
			if($_POST['Effective_date']!=''){
			if($submit=='Save')
			{
			$cnt=count($_POST['Product_code']);
			for($k=0;$k<$cnt;$k++){
			$sel_query=mysql_query($sel);
			$Product_code=$_POST['Product_code'][$k];
			$updateDate=$_POST['Effective_date']; 
			//echo "UPDATE kd_product SET KD_Code='',Kd_Category='$Kd_Category',Effective_date='$updateDate' 
			//WHERE Product_code='$Product_code'"; 
			mysql_query("UPDATE price_master SET KD_Code='',Kd_Category='$Kd_Category',Price='$Price',Effective_date='$updateDate' 
			WHERE Product_code='$Product_code'");
			} 

			//echo "Updated Successfully";
			header("location:price.php?no=2");
			}
			}
?>
<!------------------------------- Form -------------------------------------------------->
<SCRIPT language="javascript">
$(document).ready(function() {

$(function(){
    // add multiple select / deselect functionality
    $("#selectall").click(function () {
	// alert("selectall");

          $('.Product_code').attr('checked', this.checked);
    });
 	$(".Product_code").click(function(){

		if($(".Product_code").length == $(".Product_code:checked").length) {
			$("#selectall").attr("checked", "checked");
		} else {
			$("#selectall").removeAttr("checked");
		}

	});

});
//KD PRODUCT						   
$(".Effective_date_update_submit").click(function(){
//alert("kl");
		var txtData = [];
		$(".Effective_date_update").each(function() {
		txtData.push($(this).val());
		});
		$("#hdnData").val(txtData.join("|"));
      //  e.preventDefault();
});

});
function inputcheck(id){
var newid="prd_code_"+id;
if(document.getElementById(newid).checked==true){
var Effective_date=$('.Effective_date').val();
document.getElementById("date_"+id).disabled = false;
//alert(Effective_date);
document.getElementById("date_"+id).value = Effective_date;
//$("date_"+id).val(Effective_date);
document.getElementById("Effective_dateup").disabled=false;
//document.getElementById("link_"+id).style.display='block';
}else{
document.getElementById("date_"+id).disabled=true;
document.getElementById("Effective_dateup").disabled=true;
//document.getElementById("link_"+id).style.display='none';
}
}
</SCRIPT>

<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headingskdp">Price</div>
<div class="mytable3">
<form method="post" action="" name="register">
<div class="headfile" align="center">
<table width="100%" align="center">
  <tr>
    <td width="50px">KD Category*<input type="hidden" name="update_date" value="" autocomplete="off" id="hdnData" readonly></td>
    <td width="50px">
    <select name="Kd_Category" id="user"  autocomplete="off" style="width:100%;" value="">
			<option value="">--- Select ---</option>
			<?php 
			$list=mysql_query("select * from  kd_category"); 
			while($row=mysql_fetch_assoc($list)){
			?>
			<option value='<?php echo $row['kd_category']; ?>'<?php if($row['kd_category']==$kdpdt1_row['Kd_Category']){ echo 'selected' ; }?>
			><?php echo $row['kd_category']; ?></option>
			<?php 
			// End while loop. 
			} 
			?>
			</select>
    </td>
    <td class="align" width="50px">Effective Date</td>
    <td width="50px"><input type="text"  name="Effective_date" id="Effective_dateup" value="<?php echo date("Y-m-d");?>" class="datepickerkdpdt Effective_date" autocomplete="off" size="20" maxlength="20" disabled>
	</td>
  </tr>
</table>
</div>
<?php
		$qry="SELECT  * FROM `product` order by id asc";
		$results=mysql_query($qry);
		$num_rows= mysql_num_rows($results);			
		$pager = new PS_Pagination($bd, $qry,10,10);
		$results = $pager->paginate();
		?>
        <div class="con">
        <table id="sort" class="tablesorter" align="center" width="100%">
		<thead>
		<tr>
 		<th><input type="checkbox" name="selectall" value="" id="selectall" checked>&nbsp;&nbsp;Select</th>
  		<th>Product<img src="../images/sort.png" width="13" height="13" /></th>
		<th>UOM</th>
		<th>Price*</th>
   		<th>Effective Date</th>
<!-- 		<th>Edit</th>
 -->		<th>Del</th>
		
 </tr>
		</thead>
		<tbody>
		<?php
		if(!empty($num_rows)){
		$i=1;
		$c=0;$cc=1;
		while($fetch = mysql_fetch_array($results)) {
		if($c % 2 == 0){ $cls =""; } else{ $cls ="class='odd'"; }
		?>		
		<tr>
		<td>
		<input type="checkbox" id="prd_code_<?php echo $cc; ?>" onClick="inputcheck(<?php echo $cc; ?>);" name="Product_code[]" value="<?php echo $fetch['Product_code'];?>" class="Product_code" <?php if($_GET['no']=='1'){echo $fetch['Status'];}else{ echo 'Checked';}?>></td>
		<td><?php echo $fetch['Product_description1'].''.$fetch['Product_description2'];?></td>
		<td><input type="hidden" name="UOM1" value="<?php echo $fetch['UOM1']?>" autocomplete="off" size="20" maxlength="20"><?php echo $fetch['UOM1'];?></td>
		<td>
		<input type="text" class="price" value="" name="price" >
		</td>
		<td>
		<input type="text" id="date_<?php echo $cc; ?>" class="Effective_date_update" value="<?php echo date("Y-m-d");?>" name="Effective_date" disabled>
		</td>
	   <td>
		<a href="price.php?Product_code=<?php echo $fetch['Product_code'];?>">
		<img src="../images/trash.png" alt="" title="" width="11" height="11"/> </a> 
		</td>
        </tr>
		<?php $i++; $c++; $cc++; }		 
		}else{  echo "<tr><td align='center' colspan='13'><b>No records found</b></td></tr>";}  ?>
		</tbody>
		</table>
        </div>
<!--Pagination  -->
 
		<?php 
		if($num_rows > 10){?>     
        <div class="paginationfile" align="center">
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
		</div>   
		<?php } else{ echo "&nbsp;"; }?>

<table width="100%" style="clear:both" align="center">
<tr align="center" height="50px;">
<td colspan="10">
<input type="submit" name="submit" id="submit" class="buttons Effective_date_update_submit" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="clear" value="Clear" id="clear" class="buttons" onclick="return price();" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/menu.php'"/></td> 
</td>
</tr>
</table>   
        <?php include("../include/error.php");?>
     
</form>
     <div class="msg2" align="center" <?php if($_GET['Product_code']!=''){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
     <form action="" method="post">
     <input type="submit" name="submit" id="submit" class="buttonsdel" value="ConfirmDelete" />&nbsp;&nbsp;&nbsp;&nbsp;
     <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='price.php'"/>
         </form>
     </div>  
</div>
<div class="clearfix"></div>

<?php include('../include/footer.php'); ?>