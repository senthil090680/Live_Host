<?php 
ob_start();
include('../include/header.php');
include "../include/ps_pagination.php";
EXTRACT($_POST);	
if($submit=='Save')
{
			if($Kd_Category=='')
			{
			//echo "Enter Mandatory Fields";
			header("location:kdProduct_POSM.php?no=9"); 
			}
			else
			{				
				$Effective_date=date("Y-m-d");	
				if($_POST['Effective_date']==''){
				$cnt=count($_POST['Product_code']);
		for($j=0;$j<$cnt;$j++){
				$Product_code=$_POST['Product_code'][$j];
				$sel1="select * from kd_product where Product_code ='$Product_code' AND Kd_Category='$Kd_Category'"; 
				$sel_query1=mysql_query($sel1);
				$row=mysql_num_rows($sel_query1);
				if($row=='0') {
				//echo "INSERT INTO kd_product(KD_Code,Kd_Category,UOM1,Product_code,Effective_date,Status_kd_product)VALUES('','$Kd_Category','$UOM1','$Product_code','$Effective_date','Checked')"; exit;
			    mysql_query("INSERT INTO kd_product(Kd_Category,UOM1,Product_code,Effective_date,product_type,Status_kd_product)VALUES('$Kd_Category','$UOM1','$Product_code','$Effective_date','POSM','Checked')");
				mysql_query("UPDATE product SET 
					  Status='Checked'
					  WHERE Product_code = '$Product_code'"); 
  				header("location:kdProduct_POSM.php?no=1");
				}
				else
				{
				header("location:kdProduct_POSM.php?no=51");exit;
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
			mysql_query("UPDATE kd_product SET Kd_Category='$Kd_Category',Effective_date='$updateDate' 
			WHERE Product_code='$Product_code'");
			} 

			//echo "Updated Successfully";
			header("location:kdProduct_POSM.php?no=2");
			}
			}
?>
<!------------------------------- Form -------------------------------------------------->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>KD Product</title>
<SCRIPT language="javascript">
$(document).ready(function() {
//For check Box
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
// For multiple Effective date 
$(".Effective_date_update_submit").click(function(){
//alert("kl");
		var txtData = [];
		$(".Effective_date_update").each(function() {
		txtData.push($(this).val());
		});
		$("#hdnData").val(txtData.join("|"));
		//alert(txtData);
      //  e.preventDefault();
});
$('.test').click(function(){return false; });
});

//For checkbox Hide Image Link
function inputcheck(id)
{
var newid="prd_code_"+id;
if(document.getElementById(newid).checked==true)
{
//alert("LP");
$('.test').unbind('click');
//document.getElementById("date_"+id).disabled = false;
//document.getElementById("date_"+id).value = Effective_date;
//document.getElementById("Effective_dateup").disabled = false;
return false;
}
else
{
//alert("LP12");
$('.test').bind('click', function(){ return false; });
document.getElementById("date_"+id).disabled = true;
document.getElementById("Effective_dateup").disabled = true;
return false;
}
}
//After image link Activate
function inputcheck1(id){
var newid="prd_code_"+id;
var Kd_Category=$('#Kd_Category option:selected').val();
if(Kd_Category=='')
{
alert("Please Enter KD Category");
}
if(document.getElementById(newid).checked==true)
{
var Effective_date=$('.Effective_date').val();
document.getElementById("date_"+id).disabled = false;
document.getElementById("date_"+id).value = Effective_date;
document.getElementById("Effective_dateup").disabled = false;
return false;
}
if(document.getElementById(newid).checked==false)
{
//alert("LPP");
alert("Please Check Checkbox");
document.getElementById("date_"+id).disabled = true;
document.getElementById("Effective_dateup").disabled = true;
return false;
}
}
</SCRIPT>
</head>

<body>
<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headingskdp">KD Product</div>
<div class="mytable3">
<form method="post" action="" name="register">
<div class="headfile" align="center">
<table width="100%" align="center">
  <tr>
    <td width="157">KD Category*
		<!-- For Multiple Effective Date -->
	<input type="hidden" name="update_date" value="" autocomplete="off" id="hdnData" readonly></td>
    <td width="121">
    <select name="Kd_Category" class="Kd_Category" id="Kd_Category"  autocomplete="off" style="width:100%;" value="" onChange="ajaxcategory_posm();">
			<option value="">--- Select ---</option>
			<?php 
			$list=mysql_query("select * from  kd_category"); 
			while($row=mysql_fetch_assoc($list)){
			?>
			<option value='<?php echo $row['kd_category']; ?>'<?php if($row['kd_category']==$_GET['data']){ echo 'selected' ; }?>
			><?php echo $row['kd_category']; ?></option>
			<?php 
			// End while loop. 
			} 
			?>
			</select>
    </td>
    <td class="align" width="148">Effective Date</td>
    <td width="161"><input type="text"  name="Effective_date" id="Effective_dateup" value="<?php echo date("Y-m-d");?>" class="datepickerkdpdt Effective_date" autocomplete="off" size="20" maxlength="20" disabled>
	</td>
	<td width="165" class="align">Product Type</td>
		<td width="192"><select name="product_type" id="user"  autocomplete="off" style="width:100%;" value="" ONCHANGE="location = this.options[this.selectedIndex].value;">
			<option value="">--- Select ---</option>
			<option value="kdProduct_standard.php">Standard</option>
			<option value="kdProduct_POSM.php" selected>POSM</option>
			<option value="kdProduct.php">ALL</option>
			</select></td>
  </tr>
</table>
</div>
<?php
		$qry="SELECT  * FROM `product` where product_type='POSM' order by id  asc";
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
   		<th>Effective Date</th>
<!-- 		<th>Edit</th>
 -->		<th>Mod</th>
		
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
		<input type="text" id="date_<?php echo $cc; ?>" class="Effective_date_update" value="<?php echo date("Y-m-d");?>" name="Effective_date" disabled>
		</td>
	   <td>
		<a id="link_<?php echo $cc; ?>" href="kdProduct_POSM.php?Product_code=<?php echo $fetch['Product_code'];?>&hid_id=<?php echo $cc; ?>" class="test" onClick="inputcheck1(<?php echo $cc; ?>);">
		<img src="../images/user_edit.png" alt="" title="" width="11" height="11"/></a>
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
<td colspan="10"><input type="submit" name="submit" id="submit" class="buttons Effective_date_update_submit" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="clear" value="Clear" id="clear" class="buttons" onclick="return kdpdt_POSM();" />&nbsp;&nbsp;&nbsp;&nbsp;
<a href="../include/menu.php" style="text-decoration:none"><input type="button" name="cancel" id="cancel"  class="buttons" value="Cancel"/></a></td>
</tr>
</table>   
        <?php include("../include/error.php");?>
     
</form>
</div>
<div class="clearfix"></div>

<?php include('../include/footer.php'); ?>
