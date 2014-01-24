<?php
ob_start();
include('../include/header.php');
include ("../include/ps_pagination.php");
EXTRACT($_POST);	
$id=$_REQUEST['id'];
if($_REQUEST['id']!=''){
	if($_POST['submit']=='Save'){
		if($Scheme_Description=='')
		{
			header("location:productscheme.php?no=9&id=$id");exit;
		}
		else{
			
			    for($h=1; $h <= $procnth; $h++) { 
                $Header_Product_description1	=	$_POST["Header_Product_description1_".$h];
			    $Header_Product_code        	=	$_POST["Header_Product_code_".$h];
				$Header_UOM	                	=	$_POST["Header_UOM_".$h];
				$Header_Quantity	        	=	$_POST["Header_Quantity_".$h];
									
				if($Header_Quantity=='')
				{
					header("location:productschemeview.php?no=9&id=$id");exit;
				}
			
	
			    for($k=1; $k <= $procnt; $k++) { 
			
             	$line_Product_Name			    =	$_POST["line_Product_Name_".$k];
				$line_Product_Code			    =	$_POST["line_Product_Code_".$k];
				$line_Product_UOM1		        =	$_POST["line_Product_UOM1_".$k];
				$line_Product_quantity		    =	$_POST["line_Product_quantity_".$k];

				if($line_Product_quantity=='')
				{
					header("location:productschemeview.php?no=9&id=$id");exit;
				}
				$sql="UPDATE product_scheme_master SET 
				Scheme_Description='$Scheme_Description',
				Scheme_code= '$Scheme_code',
				SchemeType= '$SchemeType',
				Header_Product_description1='$Header_Product_description1',
				Header_Product_code='$Header_Product_code',
				Header_UOM='$Header_UOM',
				Header_Quantity='$Header_Quantity',
				line_Product_Name='$line_Product_Name',
				line_Product_Code='$line_Product_Code',
				line_Product_UOM1='$line_Product_UOM1',
				Effective_from='$Effective_from',
				Effective_to='$Effective_to', 
				rebate='$rebate', 
				rebateunits='$rebateunits', 
				rebatevalue='$rebatevalue'
				WHERE id = '$id'";
			}				
			mysql_query( $sql) or die(mysql_error());
			header("location:productschemeview.php?no=2");
		}
	}
	}

}

elseif($_POST['submit']=='Save'){
	if($Scheme_Description=='')
	{
		//echo "Hi";
		//exit;
		header("location:productscheme.php?no=9");exit;
	}
	else{
		$sel="select * from  product_scheme_master where Scheme_code ='$Scheme_code'";
		$sel_query=mysql_query($sel) or die(mysql_error());
		if(mysql_num_rows($sel_query)=='0') {
			
			//$KD_Code="KD001";
			$ins_val	=	'';
			for($k=1; $k <= $procnt; $k++) { 

				$line_Product_Name			    =	$_POST["line_Product_Name_".$k];
				$line_Product_Code			    =	$_POST["line_Product_Code_".$k];
				$line_Product_UOM1		        =	$_POST["line_Product_UOM1_".$k];
				$line_Product_quantity		    =	$_POST["line_Product_quantity_".$k];
						
				if($line_Product_quantity=='')
				{
					header("location:productschemeview.php?no=9&id=$id");exit;
				}
				
				for($h=1; $h <= $procnth; $h++) { 


                $Header_Product_description1	=	$_POST["Header_Product_description1_".$h];
			    $Header_Product_code        	=	$_POST["Header_Product_code_".$h];
				$Header_UOM	                	=	$_POST["Header_UOM_".$h];
				$Header_Quantity	        	=	$_POST["Header_Quantity_".$h];
									
				if($Header_Quantity=='')
				{
					header("location:productschemeview.php?no=9&id=$id");exit;
				}

				if($k == $procnt AND $h == $procnth) {
					$ins_val	.=	"('$Scheme_Description','$Scheme_code','$SchemeType','$Header_Product_description1','$Header_Product_code','$Header_UOM','$Header_Quantity','$line_Product_Name','$line_Product_Code','$line_Product_UOM1','$line_Product_quantity','$Effective_from','$Effective_to','$rebate','$rebateunits','$rebatevalue')";
				} else {
					$ins_val	.=	"('$Scheme_Description','$Scheme_code','$SchemeType','$Header_Product_description1','$Header_Product_code','$Header_UOM','$Header_Quantity','$line_Product_Name','$line_Product_Code','$line_Product_UOM1','$line_Product_quantity','$Effective_from','$Effective_to','$rebate','$rebateunits','$rebatevalue'),";
				}
			}
		}	
			//echo $ins_val;
			//exit;
         $sql="INSERT INTO `product_scheme_master`(`Scheme_Description`,`Scheme_code`,`SchemeType`,`Header_Product_description1`,`Header_Product_code`,`Header_UOM`,`Header_Quantity`,`line_Product_Name`,`line_Product_Code`,`line_Product_UOM1`,`line_Product_quantity`,`Effective_from`,`Effective_to`,`rebate`,`rebateunits`,`rebatevalue`) values $ins_val";
			mysql_query($sql) or die(mysql_error());
			header("location:productschemeview.php?no=1&id='$id'");
		}
		else {
			header("location:productscheme.php?no=18");
		}
	}
}

$id=$_REQUEST['id'];
$list=mysql_query("select * from  product_scheme_master where id= '$id'"); 
while($row = mysql_fetch_array($list)){ 
    $Scheme_Description = $row['Scheme_Description'];
	$Scheme_code = $row['Scheme_code'];
    $SchemeType = $row['SchemeType'];
	$Header_Product_description1 = $row['Header_Product_description1'];
	$Header_Product_code = $row['Header_Product_code'];
	$Header_UOM = $row['Header_UOM'];
	$Header_Quantity = $row['Header_Quantity'];
	$line_Product_Name = $row['line_Product_Name'];
	$line_Product_Code = $row['line_Product_Code'];
	$line_Product_UOM1 = $row['line_Product_UOM1'];
	$line_Product_quantity = $row['line_Product_quantity'];
	$Effective_from = $row['Effective_from'];
	$Effective_to = $row['Effective_to'];
}


?>

<!------------------------------- Form -------------------------------------------------->
<style type="text/css">
.headingsprscheme {
	background:#a09e9e;
	width:95%;
	margin-left:auto;
	margin-right:auto;
	height:25px;
	padding-top:5px;
	border-radius:6px;
	font-weight:bold;
	font-size:14px;
}


#mytablescproductscheme{
background:#fff;
width:95%;
margin-left:auto;
margin-right:auto;
height:450px;
}

.conscrollp {
	width:100%;
	text-align:left;
	border-collapse:collapse;
	background:#a09e9e;
	margin-left:auto;
	margin-right:auto;
	border-radius:10px;
	overflow:scroll;
	overflow-x:hidden;
	height:100px;
}
.conscrollp th {
	width:22%;
	padding:2px 5px 0 5px;
	font-weight:bold;
	font-size:13px;
	color:#000;
}
.conscrollp td {
	padding:2px 5px 0 5px;
	background:#fff;
	border-collapse:collapse;
	color: #000;
	font-size:13px;
}
.conscrollp tbody tr:hover {
	background: #c1c1c1;
}
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
</style>
<script type="text/javascript">

$(function(){
     $('#rebate').change(function(){
							 
     if($(this).val()==0) {
	 $('#rebateunits').css('display','none');
	 $('#rebatevalue').css('display','none');
	 $('#rebateunitsh').hide();
	 $('#rebatevalueh').hide();
	 }
   else if($(this).val()==1) {
	 $('#rebateunits').css('display','block');
	 $('#rebatevalue').css('display','block');
	 $('#rebateunitsh').show();
	 $('#rebatevalueh').show();
    }
 });
});


function validateprosch() {
	//alert(232);
	var Schemedescription	=	$('#Scheme_Description').val();
	var Schemetype			=	$('#SchemeType').val();
	var procnth						=	$('#procnth').val();
	var procnt						=	$('#procnt').val();
	var rebate						=	$('#rebate').val();
	if(Schemedescription == ''){
		$('.myaligncol').html('ERR : Select Scheme Description');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
			$('#errormsgcol').hide();
		},5000);
		return false;
	}
	
	if(Schemetype == ''){
		$('.myaligncol').html('ERR : Select Scheme Type');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}

if(procnth == '') {
		$('.myaligncol').html('ERR : Add Products!');
		$('#errormsgcol').css('display','block');
		setTimeout(function () {
			$('#errormsgcol').hide();
		},5000);
		return false;
	}
	
if(rebate == '') {
		$('.myaligncol').html('ERR : Select Rebate');
		$('#errormsgcol').css('display','block');
		setTimeout(function () {
			$('#errormsgcol').hide();
		},5000);
		return false;
	}

	
if(procnth != '') {
		//alert("Hi");
		for(var i=1; i <=procnth; i++) {
			var qtypat	= /^[0-9]+$/;
			if($("#qty_"+i).val() ==''){
				//alert(($("#qty_"+i).val() ==''));
				$('.myaligncol').html('ERR : Enter Quantity!');
				$('#errormsgcol').css('display','block');
				setTimeout(function () {
					$('#errormsgcol').hide();
				},5000);
				return false;
			}
			if(isNaN($("#qty_"+i).val())){
				$('.myaligncol').html('ERR : Only Numerals!');
				$('#errormsgcol').css('display','block');
				setTimeout(function () {
					$('#errormsgcol').hide();
				},5000);
				return false;
			}
			if(!qtypat.test($("#qty_"+i).val())){
				$('.myaligncol').html('ERR : Only Numerals!');
				$('#errormsgcol').css('display','block');
				setTimeout(function () {
					$('#errormsgcol').hide();
				},5000);
				return false;
			}
			if($("#qty_"+i).val() == 0){
				$('.myaligncol').html('ERR : No Zero!');
				$('#errormsgcol').css('display','block');
				setTimeout(function () {
					$('#errormsgcol').hide();
				},5000);
				return false;
			}
		}
	}	
	
	

if(procnt == '') {
		$('.myaligncol').html('ERR : Add Products!');
		$('#errormsgcol').css('display','block');
		setTimeout(function () {
			$('#errormsgcol').hide();
		},5000);
		return false;
	}
	if(procnt != '') {
		for(var m=1; m <=procnt; m++) {
			var qtypat	= /^[0-9]+$/;
			if($("#Qty_"+m).val() ==''){
				$('.myaligncol').html('ERR : Enter Quantity!');
				$('#errormsgcol').css('display','block');
				setTimeout(function () {
					$('#errormsgcol').hide();
				},5000);
				return false;
			}
			if(isNaN($("#Qty_"+m).val())){
				$('.myaligncol').html('ERR : Only Numerals!');
				$('#errormsgcol').css('display','block');
				setTimeout(function () {
					$('#errormsgcol').hide();
				},5000);
				return false;
			}
			if(!qtypat.test($("#Qty_"+m).val())){
				$('.myaligncol').html('ERR : Only Numerals!');
				$('#errormsgcol').css('display','block');
				setTimeout(function () {
					$('#errormsgcol').hide();
				},5000);
				return false;
			}
			if($("#Qty_"+m).val() == 0){
				$('.myaligncol').html('ERR : No Zero!');
				$('#errormsgcol').css('display','block');
				setTimeout(function () {
					$('#errormsgcol').hide();
				},5000);
				return false;
			}
		}
	}	
	
$('#errormsgcol').css('display','none');
	//return false;
}

</script>


<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headingsprscheme">Product Scheme</div>
<div id="mytablescproductscheme" align="center">
<form action="" method="post" onsubmit="return validateprosch();">
 <table bgcolor="#CCCCCC" width="100%" style="padding:10px 0 10px 0px">
  <tr height="28px">
     <td class="align">Scheme</td>
    <td>
    <select name="Scheme_Description" class="Scheme_Description" id="Scheme_Description"  autocomplete="off" style="width:100%;" value="" onChange="return scheme();" >
			<option value="">--- Select ---</option>
			<?php
			$list=mysql_query("select * from  scheme_master"); 
			while($row=mysql_fetch_assoc($list)){
			?>
			<option value='<?php echo $row['Scheme_Description']; ?>'<?php if($row['Scheme_Description']==$Scheme_Description){ echo 'selected' ; }?>><?php echo $row['Scheme_Description']; ?></option>
			<?php
			// End while loop. 
			}
			?>
			</select>
    </td>
    
   <td class="align">Scheme Code</td>
    <td><input type="text"  name="Scheme_code"  readonly="readonly"  value="<?php echo $Scheme_code;?>" class="Scheme_code" autocomplete="off" size="20" maxlength="20">
	</td> 
    
    <td>&nbsp;</td>
    <td>&nbsp;</td>
 </tr>
  
   
  
  <tr height="28px">
    <td class="align">Effective From</td>
    <td><input type="text"  name="Effective_from"  readonly="readonly" value="<?php echo $Effective_from;?>" class="Effective_from" autocomplete="off" size="20" maxlength="20">
	</td>
    <td class="align">Effective To</td>
    <td><input type="text"  name="Effective_to"  readonly="readonly"  value="<?php echo $Effective_to;?>" class="Effective_to" autocomplete="off" size="20" maxlength="20">
	</td>
    
    <td>&nbsp;</td>
    <td>&nbsp;</td>
   </tr>

    <tr  height="20">
     <td class="align">Offer Type*</td>
     <td>
    <select name="SchemeType" class="SchemeType" id="SchemeType">
    <option value="">--- Select ---</option>
    <option value="Individual" <?php if($row['SchemeType']=='Individual'){ echo 'selected'; }?>>Individual</option>
    <option value="Combined" <?php if($row['SchemeType']=='Combined'){ echo 'selected'; }?>>Combined</option>
    <option value="Total" <?php if($row['SchemeType']=='Total'){ echo 'selected'; }?>>Total</option>
    </select>
    </td>
      </td>
      
    <td class="align">Product</td>
    <td  width="120"><select <?php if(isset($_GET[id]) && $_GET[id] != '') { echo "enabled"; } ?> name="Header_Product_description1" id="ProductHeader">
	<option value="" >--Select Header Product--</option>
	<?php $sel_supph	=	"select * from  product";
	$res_supph			=	mysql_query($sel_supph) or die(mysql_error());	
	while($row_supph	=   mysql_fetch_array($res_supph)){ 
	$Header_Product_code = $row_supph[Product_code];
	$Header_UOM = $row_supph[UOM1];
	?>
    <option value="<?php echo $row_supph[Product_code]; ?>" <?php if($Header_Product_description1 == $row_supph[Product_description1]) { echo "selected"; } ?> ><?php echo $row_supph[Product_description1]; ?></option>
     <?php } ?>
    
    </select>
  </td>
   <td>&nbsp; &nbsp; &nbsp;<button class="buttons" <?php if(isset($_GET[id]) && $_GET[id] != '') { echo "disabled"; } ?> onClick="return addhquantity('<?php echo $Header_UOM;?>');">Add</button></td>
    <td>&nbsp;</td>
    </tr>
  
  <table width="100%" height="40"  bgcolor="#999">  
    <tr> 
     <td class="align" width="120">Rebate</td> 
     <td  width="135" align="right"> 
    <select name="rebate" class="rebate" id="rebate">
    <option value="">--- Select ---</option>
    <option value="1" <?php if($row['rebate']=='1'){ echo 'selected'; }?>>Yes</option>
    <option value="0" <?php if($row['rebate']=='0'){ echo 'selected'; }?>>No</option>
    </select>
    </td>
    
    <td class="align" id="rebateunitsh">Rebate UOM</td>
    <td>
    <select name="rebateunits" class="rebateunits" id="rebateunits">
    <option value="">--- Select ---</option>
    <option value="%" <?php if($row['rebateunits']=='%'){ echo 'selected'; }?>>%</option>
    <option value="Naira" <?php if($row['rebateunits']=='Naira'){ echo 'selected'; }?>>Naira</option>
    </select>
    </td>
    
    <td  class="align" id="rebatevalueh">Rebate Value</td>
    <td><input type="text" name="rebatevalue"  id="rebatevalue" value="<?php echo $rebatevalue; ?>" autocomplete="off" size=10></td>
     </tr>
 </table>   
 
	<tr>
		<td><span id="showerr" style="display:none;color:#FF0000;">Choose Product</span><input type="hidden" value="<?php if(isset($_GET[id]) && $_GET[id] != '') { ?> 1 <?php } ?>" name="procnth" id="procnth" /></td>
	</tr>
   </table>
 </fieldset>
   </td>
 </tr>  
 
  <table width="100%" align="left" id="proaddheader" <?php if(!isset($_GET[id]) && $_GET[id] == '') { ?> style="display:none" <?php } if(isset($_GET[id]) && $_GET[id] == '') { ?> style="display:none" <?php } ?>>
  <tr>
  <td>
  <div class="conscrollp">
  <table width="100%">
  <thead>
  <tr>
  <th class='rounded' align='center'>Product Name</th>
  <th align='center'>Product Code</th>
  <th align='center'>UOM</th>
  <th align='center'>Quantity</th>
  </tr></thead>
    
  <tbody id="addproh">
	<?php $t = 1; if(isset($_GET[id]) && $_GET[id] != '') { ?> 
		<tr>
        <td align='center'><input type='hidden' value='<?php echo $Header_Product_description1; ?>' name='Header_Product_description1_<?php echo $t; ?>' /><?php echo $Header_Product_description1; ?></td>
        <td align='center'><input type='hidden' value='<?php echo $Header_Product_code; ?>' name='Header_Product_code_<?php echo $t; ?>' /><?php echo $Header_Product_code; ?></td>        <td align='center'><input type='hidden' value='<?php echo $Header_UOM; ?>' name='Header_UOM_<?php echo $t; ?>' /><?php echo $Header_UOM; ?></td>
        <td align='center'><input type='text'  autocomplete'off' value='<?php echo $Header_Quantity; ?>' name='Header_Quantity_<?php echo $t; ?>' id='qty_<?php echo $t;?>'/></td></tr>
             
	<?php }?>
  </tbody>
   </table>
   </div>
   </td>
 </tr>
</table>
 
 
</table>

<div class="mcf"></div>

<table width="50%">
 <tr>
  <td>
  <table>
    <tr  height="20">
    <td>Product</td>
    <td  width="120"><select <?php if(isset($_GET[id]) && $_GET[id] != '') { echo "enabled"; } ?>  name="line_Product_Name" id="Product_names" >
	<option value="" >--Select Line Product--</option>
	<?php $sel_supp		=	"select * from  product";
	$res_supp			=	mysql_query($sel_supp) or die(mysql_error());	
	while($row_supp	= mysql_fetch_array($res_supp)){ 
	$line_Product_code = $row_supp[Product_code];
	$line_Product_UOM1 = $row_supp[UOM1];
	?>
    <option value="<?php echo $row_supp[Product_code]; ?>" <?php if($line_Product_Name == $row_supp[Product_description1]) { echo "selected"; } ?> ><?php echo $row_supp[Product_description1]; ?></option>
     <?php } ?>
    
    </select>
    	
    </td>
     <td>
 &nbsp; &nbsp; &nbsp;<button class="buttons" <?php if(isset($_GET[id]) && $_GET[id] != '') { echo "disabled"; } ?> onClick="return addquantity('<?php echo $line_Product_UOM1;?>');">Add</button></td>
    </tr>
	<tr>
		<td><span id="showerr" style="display:none;color:#FF0000;">Choose Product</span><input type="hidden" value="<?php if(isset($_GET[id]) && $_GET[id] != '') { ?> 1 <?php } ?>" name="procnt" id="procnt" /></td>
	</tr>
   </table>
 </fieldset>
   </td>
 </tr>
</table>

<!----------------------------------------------- last Table End -------------------------------------->
<table width="100%" align="left" id="proadd" <?php if(!isset($_GET[id]) && $_GET[id] == '') { ?> style="display:none" <?php } if(isset($_GET[id]) && $_GET[id] == '') { ?> style="display:none" <?php } ?>>
 <tr>
  <td>
  <div class="conscrollp">
  <table width="100%">
  <thead>
  <tr>
  <th class='rounded' align='center'>Product Name</th>
  <th align='center'>Product Code</th>
  <th align='center'>UOM</th>
  <th align='center'>Quantity</th>
  </tr></thead>  
  <tbody id="addpro">
<?php $s = 1; if(isset($_GET[id]) && $_GET[id] != '') { ?> 
<tr>

<td align='center'><input type='hidden' value='<?php echo $line_Product_Name; ?>' name='line_Product_Name_<?php echo $s; ?>' /><?php echo $line_Product_Name; ?></td>
<td align='center'><input type='hidden' value='<?php echo $line_Product_Code; ?>' name='line_Product_Code_<?php echo $s; ?>' /><?php echo $line_Product_Code; ?></td>
<td align='center'><input type='hidden' value='<?php echo $line_Product_UOM1; ?>' name='line_Product_UOM1_<?php echo $s; ?>' /><?php echo $line_Product_UOM1; ?></td>
<td align='center'><input type='text' autocomplete'off' value='<?php echo $line_Product_quantity; ?>' name='line_Product_quantity_<?php echo $s; ?>'  id='Qty_<?php echo $s; ?>'/></td>
</tr>

<?php }?>
  </tbody>
   </table>
   </div>
   </td>
 </tr>
</table>

<div class="clearfix"></div>
<tr align="center" height="50px;">
<td colspan="10"><!-- KD Category -->
<input type="submit" name="submit" id="submit" class="buttons " value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="clear" value="Clear" id="clear" class="buttons" onclick="return productScheme();" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="cancel" id="cancel"  class="buttons" value="Cancel" onclick="window.location='../include/empty.php'"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="view" id="view"  class="buttons" value="View" onclick="window.location='productschemeview.php'"/>
</td>
</tr>
</table>
</form>
<div class="mcf"></div>
<?php include("../include/error.php");?>
<div id="errormsgcol" style="display:none;clear:both;">
<h3 align="center" class="myaligncol"></h3><button id="closebutton">Close</button></div>
</div>
</div>
<?php include('../include/footer.php'); ?>
