<?php
session_start();
ob_start();
include('../include/config.php');
include "../include/ps_pagination.php";
require_once "../include/ajax_pagination.php";
if(isset($_GET['logout'])){
	session_destroy();
	header("Location:../index.php");
}
$KD_Code = $_POST['KDCode'];
$line_number = $_POST['Linecount'];
$DSR_Code = $_POST['DSRCode'];
$Transaction_type = $_POST['Transactiontype'];
$Transaction_number = $_POST['TransactionNumber'];
//pre($_REQUEST);
//exit;
EXTRACT($_REQUEST);
$id=$_REQUEST['id'];

if($_GET[id] == '' && !isset($_GET[id])) {
$sql="select * from price_master";
$price=mysql_query($sql);
while($row=mysql_fetch_array($price)){
	
	 $price_val = $row['Price'];
	
}

}



?>
<!------------------------------- Form -------------------------------------------------->
<style type="text/css">
#errormsgcol {
	display:none;
	width:40%;
	height:30px;
	background:#c1c1c1;
	margin-left:auto;
	margin-right:auto;
	border-radius:10px;
	padding-top:0px;
	-moz-border-radius:10px;
	-webkit-border-radius:10px;
	-ms-border-radius:10px;
	-o-border-radius:10px;
	text-align:center;
}

.myaligncol {
	 clear:both;
	padding-top:10px;
	margin:0 auto;
	color:#FF0000;
}

#closebutton {
  position:relative;
  top:-35px;
  right:-190px;
  border:none;
  background:url(../images/close_pop.png) no-repeat;
  color:transparent;
  }
  
.conscroll {
	width:100%;
	text-align:left;
	border-collapse:collapse;
	background:#a09e9e;
	margin-left:auto;
	margin-right:auto;
	border-radius:10px;
	overflow:scroll;
	overflow-x:hidden;
	height:130px;
}
.conscroll th {
	width:22%;
	padding:2px 5px 0 5px;
	font-weight:bold;
	font-size:13px;
	color:#000;
}
.conscroll td {
	padding:2px 5px 0 5px;
	background:#fff;
	border-collapse:collapse;
	color: #000;
	font-size:13px;
}
.conscroll tbody tr:hover {
	background: #c1c1c1;
}  
 </style> 
  

<script type="text/javascript">

function insertfunction() {
									//alert($("input:text[name=Sold_quantity[]]").val());
				//alert('$('#KD_Code').val()');					
    var KD_Code					=	$('#KDCode').val();
	var DSR_Code				=	$('#DSRCode').val();
	var Transaction_number		=	$('#Transactionnumber').val();
	var Transaction_type		=	$('#Transactiontype').val();
	var line_number	        	=	$('#linenumber').val();
	var FocusFlag	        	=	$('#FocusFlag').val();
	var POSMFlag	        	=	$('#POSMFlag').val();
	var CustomerStockCheck	   	=	$('#CustomerStockCheck').val();
	var CustomerStockquantity	=	$('#CustomerStockquantity').val();
	var SchemeFlag	        	=	$('#SchemeFlag').val();
	var SchemeCode	        	=	$('#SchemeCode').val();
	var ProductSchemeFlag	   	=	$('#ProductSchemeFlag').val();
	var prodcnt					=	$('#prodcnt').val();
	
	var serializedData = $('#lineprovalidate').serialize();
	//alert(serializedData);
	//var datastring = $("#contactForm").serialize();
	
	if(KD_Code == ''){
		$('.myaligncol').html('ERR : Enter KD Code');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
			$('#errormsgcol').hide();
		},5000);
		return false;
	}
	
	if(DSR_Code == ''){
		$('.myaligncol').html('ERR : Enter DSR Code');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
			$('#errormsgcol').hide();
		},5000);
		return false;
	}
	
	if(Transaction_number == ''){
		$('.myaligncol').html('ERR : Enter Transaction Number');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
			$('#errormsgcol').hide();
		},5000);
		return false;
	}
	
	if(Transaction_type == ''){
		$('.myaligncol').html('ERR : Enter Transaction Type');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
			$('#errormsgcol').hide();
		},5000);
		return false;
	}
	
	 var w=0;
     var qtypat	= /^[0-9]+$/;
		for(var k=1; k <= prodcnt; k++) {
				var SoldQuantity			=	parseInt($('#Sold_quantity_'+k).val());
				var Value			        =	parseInt($('#Value_'+k).val());
				var product_code_val	    =	$('#pcode_'+k).val();
				if(SoldQuantity ==''){
					$('.myaligncol').html('ERR : Enter SoldQuantity for '+product_code_val);
					$('#errormsgcol').css('display','block');
					setTimeout(function() {
						$('#errormsgcol').hide();
					},5000);
					$('#SoldQuantity_'+k).focus();
					return false;
				}
				
				if(isNaN(SoldQuantity)){
					$('.myaligncol').html('ERR : Only Numerals for '+product_code_val);
					$('#errormsgcol').css('display','block');
					//alert(Loaded_Qty);
					setTimeout(function() {
						$('#errormsgcol').hides();
					},5000);
					$('#SoldQuantity_'+k).focus();
					return false;
				}
				if(!qtypat.test(SoldQuantity)){
					$('.myaligncol').html('ERR : Only Numerals for '+product_code_val);
					$('#errormsgcol').css('display','block');
					setTimeout(function() {
						$('#errormsgcol').hide();
					},5000);
					$('#SoldQuantity_'+k).focus();
					return false;
				}
				if(SoldQuantity == 0){
					$('.myaligncol').html('ERR : No Zero for '+product_code_val);
					$('#errormsgcol').css('display','block');
					setTimeout(function() {
						$('#errormsgcol').hide();
					},5000);
					$('#SoldQuantity_'+k).focus();
					return false;
				}
	
		}
	
    $.ajax({
		    url: "insertdatahdr.php",
            type: "POST",
          	dataType: "text",
		    data	:	{ "serializedData" : serializedData },     
            success: function(data) {
				var trimData	=	$.trim(data);  
				//alert(trimData);
				//alert(data);
				alert('Data Inserted Successfully');
				$("#productshow").css({"display":"none"});
			    $("#backgroundChatPopup").fadeIn("slow");
			    $("#backgroundChatPopup").css({"opacity" : "0.7"});
			    setTimeout(function() {
				 $('#backgroundChatPopup').hide();
					},5000);
            },
            error: function(){
                  alert('error handing here');
            }
			
        });
	 return false;
	$("#transvalid").submit();       
}

function getprice()
{
 var val=$('#product_names option:selected').text();
	//alert("hi");
	 $.ajax({
			
            url:'getprice.php?val=' + val,
		     success: function(data){
				//alert(data);
				var value=$.trim(data);//To Remove White Space in string
				var value1=data.substring(0,value.length-1);//To return part of the string
				var list= value1.split("|"); 
				//alert(value);
				$("#Price").val(list[0]);
			 }
        });
}

function multiply() {
	
	
 	var rowcnt			=	$('#prodcnt').val();
	for(var k=1; k <= rowcnt; k++) {
			//alert($('#Value_'+k).val());
				var SoldQuantity			=	parseInt($('#Sold_quantity_'+k).val());
				var Value        			=	parseInt($('#Value_'+k).val());
				var pricevalue              =   parseInt($('#Price_'+k).val());
				var result = parseInt(SoldQuantity) * parseInt(pricevalue);
				
            if (!isNaN(result)) {
				//alert($('#Value_'+k).val());	
			   $('#Value_'+k).val(result);
            }
        }
}		

function closeProductShow() {
	//$('#productshow').remove();
	$('#productshow').css('display','none');
	$('#backgroundChatPopup').fadeOut('slow');
}



function addproduct(UOM) {
	if($('#product_names').val() == ''){
		$('.myaligndev').html('ERR : Choose Product');
		$('#errormsgdev').css('display','block');
		setTimeout(function() {
			$('#errormsgdev').hide();
		},5000);
		return false;
	}

	var rowcnt			=	$('#prodcnt').val();
	var row			
	var rowcntcal;
	if(rowcnt == '') {
		rowcntcal		=	1;
	} else {
		rowcntcal		=	parseInt(rowcnt) + 1;
	}
	$('#prodcnt').val(rowcntcal);
	var product_code	=	$('#product_names').val();
	var linenumber	    =	$('#linenumber').val();
	var Price        	=	$('#Price').val();
	var product_name	=	$('#product_names option:selected').text();
	
	
	$('#showerr').hide();
	$('#productsadd').show();

	if(rowcnt == linenumber) {
	alert('Only linenumber value is allowed');
	return false;
	$('#productsadded').append("<tr><td align='center'><input type='hidden' value='"+product_code+"' readonly name='pcode_"+rowcntcal+"' />"+product_code+"</td><td align='left'><input type='hidden' value='"+product_name+"' readonly name='pname_"+rowcntcal+"' />"+product_name+"</td><td align='center'><input type='hidden' value='"+UOM+"' readonly name='UOM_"+rowcntcal+"' />"+UOM+"</td><td align='center'><input type='text' value='' autocomplete='off' name='Order_quantity_"+rowcntcal+"' id='Order_quantity_"+rowcntcal+"' /></td><td align='center'><input type='text' value='' autocomplete='off' name='Sold_quantity_"+rowcntcal+"' id='Sold_quantity_"+rowcntcal+"'/></td><td align='center'><input type='hidden' value='"+Price+"' readonly name='Price_"+rowcntcal+"' id='Price_"+rowcntcal+"'/>"+Price+"</td><td align='center'><input type='text' value='' onclick='multiply();' autocomplete='off' name='Value_"+rowcntcal+"' id='Value_"+rowcntcal+"' /></td></tr>");
	} else {
		$('#productsadded').append("<tr><td align='center'><input type='hidden' value='"+product_code+"' readonly name='pcode_"+rowcntcal+"' />"+product_code+"</td><td align='left'><input type='hidden' value='"+product_name+"' readonly name='pname_"+rowcntcal+"' />"+product_name+"</td><td align='center'><input type='hidden' value='"+UOM+"' readonly name='UOM_"+rowcntcal+"' />"+UOM+"</td><td align='center'><input type='text' value='' autocomplete='off' name='Order_quantity_"+rowcntcal+"' id='Order_quantity_"+rowcntcal+"' /></td><td align='center'><input type='text' value='' autocomplete='off' name='Sold_quantity_"+rowcntcal+"' id='Sold_quantity_"+rowcntcal+"' /></td><td align='center'><input type='hidden' value='"+Price+"' readonly name='Price_"+rowcntcal+"' id='Price_"+rowcntcal+"'/>"+Price+"</td><td align='center'><input type='text' value='' onclick='multiply();' autocomplete='off' name='Value_"+rowcntcal+"' id='Value_"+rowcntcal+"' /></td></tr>");
	}
	return false;
}

</script>
<p class="closepboxa"><label class="closexbox"><a class="closelink" href="javascript:void(0)" onclick="javascript:return closeProductShow();"><b><img border="0" src="../images/close_button2.png" /></b></a></label></p><p style="font-size:15px;padding-left:30px;" class="addcolor">
<div id="mainareastockstatic">
<div align="center" class="headingsgr">Product Line Count</div>
<div id="mytableformreceipt" align="center">
<form action="" method="post" id="lineprovalidate" >
<table width="50%" align="left">
 <tr>
  <td>
 <fieldset class="alignment">
  <legend><strong>Transaction Details</strong></legend>
  <table>
    <tr height="25">
		<td height="20" width="150">KD Name*</td>
		<td>
		<?php
        $sel="select KD_Code,KD_Name from kd where KD_Code = '$KD_Code'"; 	
        $res=mysql_query($sel);
        while($val=mysql_fetch_array($res)){
        $KD_Name=$val['KD_Name'];
        }
        ?>
		<input type="KD_Code" name="KD_Code" id="KDCode" size="25" value="<?php echo $KD_Name; ?>"  maxlength="10" autocomplete='off'/>
		</td>
    </tr>
    
        <tr height="25">
		<td>DSR*</td>
		<td>
       	<?php
        $sel="select DSR_Code,DSRName from dsr where DSR_Code = '$DSR_Code'"; 	
        $res=mysql_query($sel);
        while($val=mysql_fetch_array($res)){
        $DSRName=$val['DSRName'];
        }
        ?>
        
		<input type="DSR_Code" name="DSR_Code" id="DSRCode" size="15" value="<?php echo $DSRName; ?>"  maxlength="10" autocomplete='off'/>
		</td>
    </tr>
    
    
    <tr height="25">
     <td width="150">Transaction Number*</td>
	 <td><input type="text" name="Transaction_number" id="Transactionnumber" size="30" value="<?php echo $Transaction_number; ?>" maxlength="20" autocomplete='off'/></td>
	 </tr>
     
     <tr height="25">
     <td width="150">Customer Stock Check</td>
	 <td><input type="text" name="Customer_Stock_Check" id="CustomerStockCheck" size="30" value="<?php echo $Customer_Stock_Check; ?>" maxlength="20" autocomplete='off'/></td>
	 </tr>
     
     <tr height="25">
     <td width="150">Product Scheme Flag</td>
     <td><select name="Product_Scheme_Flag" id="ProductSchemeFlag">
     <option value="select">--Select--</option>
     <option value="1" <?php if($Product_Scheme_Flag==1){ echo 'selected';}?>>Yes</option>
     <option value="0" <?php if($Product_Scheme_Flag==0){ echo 'selected';}?>>No</option>
     </select></td>
	</tr>
     
	
   </table>
 </fieldset>
   </td>
 </tr>
</table>

<!----------------------------------------------- Left Table End -------------------------------------->
<table width="50%" align="left">
 <tr>
  <td>
 <fieldset class="alignment">
  <legend><strong>Data</strong></legend>
  <table>
    
	<tr height="20">
     <td width="150">Transaction Type*</td>
     <td>
        <?php 
        $list=mysql_query("select * from trans_type where id = '$Transaction_type'"); 
        ?>
        <select name="Transaction_type" class="Transaction_type" id="Transactiontype"  autocomplete="off">
        <option value="">--- Select ---</option>
		<?php 		
		while($row_list=mysql_fetch_assoc($list)){ 
		$id=$row_list['trans_type'];
		?>
        <option value="<?php echo $row_list['id']; ?>" <? if($row_list['trans_type']==$id){ echo "selected"; } ?>><? echo $row_list['trans_type']; ?></option>
        <?php  } ?>
        </select> 
     </td>
	</tr>
	<tr height="20">
     <td>Line Number*</td>
     <td><input type="text" name="line_number" id="linenumber" size="20" value="<?php echo $line_number; ?>" maxlength="20" autocomplete='off'/></td>
	</tr>
    
    <tr height="20">
     <td width="150">Focus Flag*</td>
     <td><select name="Focus_Flag" id="FocusFlag">
     <option value="select">--Select--</option>
     <option value="1" <?php if($Focus_Flag==1){ echo 'selected';}?>>Yes</option>
     <option value="0" <?php if($Focus_Flag==0){ echo 'selected';}?>>No</option>
     </select></td>
	</tr>
    
     <tr height="20">
     <td width="150">POSM Flag</td>
     <td ><select name="POSM_Flag" id="POSMFlag">
     <option value="select">--Select--</option>
     <option value="1" <?php if($POSM_Flag==1){ echo 'selected';}?>>Yes</option>
     <option value="0" <?php if($POSM_Flag==0){ echo 'selected';}?>>No</option>
     </select></td>
	</tr>
    
    
     <tr height="20">
     <td width="150">Scheme Flag</td>
     <td><select name="Scheme_Flag" id="SchemeFlag">
     <option value="select">--Select--</option>
     <option value="1" <?php if($Scheme_Flag==1){ echo 'selected';}?>>Yes</option>
     <option value="0" <?php if($Scheme_Flag==0){ echo 'selected';}?>>No</option>
     </select></td>
     </tr>
     
      <tr height="20">
     <td width="100">Scheme Code</td>
     <td>
     
       <?php 
        $list=mysql_query("select * from scheme_master"); 
        ?>
        <select name="Scheme_Code" class="Scheme_Code" id="Scheme_Code"  autocomplete="off">
        <option value="">--- Select ---</option>
        <option value="0" <?php if($Scheme_Flag==0){ echo 'selected';}?>>No</option>
		<?php 		
		while($row_list=mysql_fetch_assoc($list)){ 
		$id=$row_list['Scheme_code'];
		?>
        <option value="<?php echo $row_list['Scheme_code']; ?>" <? if($row_list['Scheme_code']==$Scheme_code){ echo "selected"; } ?>><? echo $row_list['Scheme_code']; ?></option>
       
        <?php  } ?>
        </select> 
        </td>
	</tr>
    
   </table>
 </fieldset>
   </td>
 </tr>
</table>

<!----------------------------------------------- Right Table End -------------------------------------->
<table width="50%" align="left">
 <tr>
  <td>
 <fieldset class="alignment">
  <legend><strong>Product</strong></legend>
  <table>
    <tr  height="20">
   <td><input type="hidden" id="Price" name="Price" value="<?php echo $Price; ?>" /></td>    
     <!--<td><input type="text" id="Soldquantity" name="Soldquantity" value="<?php echo $Soldquantity; ?>"  onkeyup="multiply()"/></td>    
    <td><input type="text" id="value" name="value" value="<?php echo $value; ?>"  /></td>    -->
    <td  width="120"><select <?php if(isset($_GET[id]) && $_GET[id] != '') { echo "disabled"; } ?> name="product_names" id="product_names" onchange="return getprice()">
	<option value="" >--Select Product--</option>
	<?php $sel_supp		=	"SELECT * from kd_product GROUP BY Product_code";
	$res_supp			=	mysql_query($sel_supp) or die(mysql_error());	
	while($row_supp  	= mysql_fetch_array($res_supp)){ 
   	$UOM=$row_supp[UOM1];
	?>
	<option value="<?php echo $row_supp[Product_code]; ?>" <?php if($Product_code == $row_supp[Product_code]) { echo "selected"; } ?> ><?php echo ucwords(strtolower($row_supp[Product_description1])); ?></option>
    
	<?php } ?>
	</select>
     </td>
      <td><button class="buttons" <?php if(isset($_GET[id]) && $_GET[id] != '') { echo "disabled"; } ?> onClick="return addproduct('<?php echo $UOM;?>');">Add</button></td>
    </tr>
	<tr>
		<td height="10"><span id="showerr" style="display:none;color:red;">Choose Product</span><input type="hidden" value="<?php if(isset($_GET[id]) && $_GET[id] != '') { ?> 1 <?php } ?>" name="prodcnt" id="prodcnt" /></td>
	</tr>
   </table>
 </fieldset>
   </td>
 </tr>
</table>

<!----------------------------------------------- last Table End -------------------------------------->
<table width="100%" align="left" id="productsadd" <?php if(!isset($_GET[id]) && $_GET[id] == '') { ?> style="display:none" <?php } if(isset($_GET[id]) && $_GET[id] == '') { ?> style="display:none" <?php } ?>>
 <tr>
  <td>
  <div class="conscroll">
  <table>
  <thead>
	<tr>
		
		<th width="5%" class='rounded' align='center'>Product Code</th>
		<th width="50%" align='center'>Product Name</th>
		<th width="5%" align='center'>UOM</th>
        <th width="10%" align='center'>Ordered Quantity</th>
        <th width="10%" align='center'>Sold Quantity</th>
        <th width="10%" align='center'>Price</th>
		<th width="10%" align='center'>Value</th>
	</tr>
  </thead>  
  <tbody id="productsadded">
  
  
	<?php $t = 1; if(isset($_GET[id]) && $_GET[id] != '') { ?> 
		<tr>
			
			<td align='center'><input type='hidden' value='<?php echo $Product_code; ?>' name='pcode_<?php echo $t; ?>' id='pcode_<?php echo $t; ?>'/><?php echo $Product_code; ?></td>
			<td align='center'><input type='hidden' value='<?php echo $Product_name; ?>' name='pname_<?php echo $t; ?>' /><?php echo $Product_name; ?></td>
			<td align='center'><input type='hidden' value='<?php echo $UOM; ?>' name='UOM_<?php echo $t; ?>'  id='UOM_<?php echo $t; ?>'/><?php echo $UOM; ?></td>
            <td align='center'><input type='text' value='<?php echo $Order_quantity; ?>' name='Order_quantity_<?php echo $t; ?>' id='Order_quantity_<?php echo $t; ?>'/></td>
            <td align='center'><input type='text' value='<?php echo $Sold_quantity; ?>' name='Sold_quantity_<?php echo $t;?>' id='Sold_quantity_<?php echo $t; ?>'/></td>
           	<td align='center'><input type='hidden' value='<?php echo $Price; ?>' name='Price_<?php echo $t; ?>' id='Price_<?php echo $t; ?>' /><?php echo $Price; ?></td>
			<td align='center'><input type='text' value='' autocomplete='off' name='Value_<?php echo $t; ?>' id='Value_<?php echo $t; ?>' /></td>
		</tr>
	<?php } ?>
  </tbody>
   </table>
   </div>
   </td>
 </tr>
</table>

<table width="50%" style="clear:both">
      <tr align="center" height="50px;">
      <td>
     <!-- <a id="insert1" href="javascript:void(0);" onclick="insertfunction();" class="buttons" >Insert</a>&nbsp;&nbsp;&nbsp;&nbsp;-->
     <input type="button" name="submit" id="submit" class="buttons" value="Confirm"  onclick="insertfunction()"/>&nbsp;&nbsp;&nbsp;&nbsp;
     <input type="reset" name="reset" class="buttons" value="Clear" id="clear" />&nbsp;&nbsp;&nbsp;&nbsp;
     <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='transactionentry.php'"/>&nbsp;&nbsp;&nbsp;&nbsp;
	 </td>
	 </td>
      </tr>
 </table>     
</form>


</div>

   
<?php include("../include/error.php");?>
<div id="errormsgcol" style="display:none;clear:both;"><h3 align="center" class="myaligncol"></h3><button id="closebutton">Close</button></div>
   </div>
</div>
