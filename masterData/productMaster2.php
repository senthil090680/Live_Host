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

$pi=mysql_query("select * from uom");	
while($row = mysql_fetch_array($pi)){ 
$UOM1=$row['UOM_code'];
}	


$id=$_REQUEST['id'];
$page=intval($_REQUEST['page']);

if($_GET['id']!=''){
if($_POST['submit']=='Save'){
/*	
if(($Effective_from!='0000-00-00') && ($Effective_to!='0000-00-00')){
//mydate = date('d-m-Y', strtotime($row['date']));
$Effective_from=date("Y-m-d",strtotime($Effective_from));
$Effective_to=date("Y-m-d",strtotime($Effective_to));	
}else{
 $Effective_from ='0000-00-00';
 $Effective_to ='0000-00-00';
}	*/
//$Effective_from=date("Y-m-d",strtotime($Effective_from));
//$Effective_to=date("Y-m-d",strtotime($Effective_to));	


if($Focus == 'Yes'){
//mydate = date('d-m-Y', strtotime($row['date']));
$Effective_from=date("Y-m-d",strtotime($Effective_from));
$Effective_to=date("Y-m-d",strtotime($Effective_to));	
}else{
 $Effective_from ='0000-00-00';
 $Effective_to = '0000-00-00';
}

echo $sql=("UPDATE product SET 
          Product_code= '$Product_code', 
          Product_description1='$Product_description1', 
          Product_description_length='$Product_description_length',
		  Product_display_description='$Product_display_description',
		  UOM1='$UOM1',
	      UOM2='$UOM2',
		  UOM_Conversion='$UOM_Conversion',
		  product_type='$product_type',
		  product_category='$product_category',
		  principal='$principal',
		  Focus='$Focus',
		  Effective_from='$Effective_from',
	      Effective_to='$Effective_to',
		  batch_ctrl='$batch_ctrl',
		  brand='$brand'
		  WHERE id = $id");
mysql_query( $sql);
header("location:productview.php?no=2&page=$page");
}
}
elseif($_POST['submit']=='Save'){?>
<form action="" method="post" id="resubmitform">
<input type="hidden" name="Product_code" value="<?php echo $Product_code; ?>" />
<input type="hidden" name="Product_description1" value="<?php echo $Product_description1; ?>" />
<input type="hidden" name="Product_description_length" value="<?php echo $Product_description_length; ?>" />
<input type="hidden" name="Product_display_description" value="<?php echo $Product_display_description; ?>" />
<input type="hidden" name="UOM1" value="<?php echo $UOM1; ?>" />
<input type="hidden" name="UOM2" value="<?php echo $UOM2; ?>" />
<input type="hidden" name="UOM_Conversion" value="<?php echo $UOM_Conversion; ?>" />
<input type="hidden" name="product_type" value="<?php echo $product_type; ?>" />
<input type="hidden" name="product_category" value="<?php echo $product_category; ?>" />
<input type="hidden" name="principal" value="<?php echo $principal; ?>" />
<input type="hidden" name="Focus" value="<?php echo $Focus; ?>" />
<input type="hidden" name="Effective_from" value="<?php echo $Effective_from; ?>" />
<input type="hidden" name="Effective_to" value="<?php echo $Effective_to; ?>" />
<input type="hidden" name="batch_ctrl" value="<?php echo $batch_ctrl; ?>" />
<input type="hidden" name="brand" value="<?php echo $brand; ?>" />
<input type="hidden" name="no" value="9" />
 
</form>
<form action="" method="post" id="dataexists">
<input type="hidden" name="Product_code" value="<?php echo $Product_code; ?>" />
<input type="hidden" name="Product_description1" value="<?php echo $Product_description1; ?>" />
<input type="hidden" name="Product_description_length" value="<?php echo $Product_description_length; ?>" />
<input type="hidden" name="Product_display_description" value="<?php echo $Product_display_description; ?>" />
<input type="hidden" name="UOM1" value="<?php echo $UOM1; ?>" />
<input type="hidden" name="UOM2" value="<?php echo $UOM2; ?>" />
<input type="hidden" name="UOM_Conversion" value="<?php echo $UOM_Conversion; ?>" />
<input type="hidden" name="product_type" value="<?php echo $product_type; ?>" />
<input type="hidden" name="product_category" value="<?php echo $product_category; ?>" />
<input type="hidden" name="principal" value="<?php echo $principal; ?>" />
<input type="hidden" name="Focus" value="<?php echo $Focus; ?>" />
<input type="hidden" name="Effective_from" value="<?php echo $Effective_from; ?>" />
<input type="hidden" name="Effective_to" value="<?php echo $Effective_to; ?>" />
<input type="hidden" name="batch_ctrl" value="<?php echo $batch_ctrl; ?>" />
<input type="hidden" name="brand" value="<?php echo $brand; ?>" />
<input type="hidden" name="no" value="18" />
<input type="hidden" name="page" value="<?php echo $page; ?>" />
</form>

<?php
if($Product_code=='' || $Product_description1==''  || $brand=='' || $product_type=='' || $Focus =='')
{?>

<script type="text/javascript">
document.forms['resubmitform'].submit();
</script>
<?php //header("location:productMaster.php?no=9");exit;
}
else{
/*$Effective_from=date("Y-m-d",strtotime($Effective_from));
$Effective_to=date("Y-m-d",strtotime($Effective_to));	*/

if($Focus == 'Yes'){
//mydate = date('d-m-Y', strtotime($row['date']));
$Effective_from=date("Y-m-d",strtotime($Effective_from));
$Effective_to=date("Y-m-d",strtotime($Effective_to));	
}else{
 $Effective_from ='0000-00-00';
 $Effective_to = '0000-00-00';
}
	
$sel="select * from product where Product_code ='$Product_code'";
$sel_query=mysql_query($sel);
		if(mysql_num_rows($sel_query)=='0') {
	
	 $sql="INSERT IGNORE INTO `product`(`Product_code`,`Product_description1`,`Product_description_length`,`Product_display_description`,`UOM1`,`UOM2`,`UOM_Conversion`,`product_type`,`product_category`,`principal`,`Focus`,`Effective_from`,`Effective_to`,`batch_ctrl`,`brand`)
values('$Product_code','$Product_description1','$Product_description_length','$Product_display_description','$UOM1','$UOM2','$UOM_Conversion','$product_type','$product_category','$principal','$Focus','$Effective_from','$Effective_to','$batch_ctrl','$brand')";
mysql_query($sql);
        header("location:productview.php?no=1&page=$page");
		}
		else {?>
         <script type="text/javascript">
		document.forms['dataexists'].submit();
		</script>
        <?php }
}
}
$id=$_GET['id'];
$list=mysql_query("select * from product where id= '$id'"); 
while($row = mysql_fetch_array($list)){ 
	$Product_code = $row['Product_code'];
	$Product_description1 = $row['Product_description1'];
	$Product_description_length = $row['Product_description_length'];
	$Product_display_description = $row['Product_display_description'];
	$UOM1 = $row['UOM1'];
	$UOM2 = $row['UOM2'];
	$batch_ctrl = $row['batch_ctrl'];
	$Uom_conversion = $row['UOM_Conversion'];
	$product_type = $row['product_type'];
	$product_category = $row['product_category'];
	$principal = $row['principal'];
	$Focus = $row['Focus'];
	$brand = $row['brand'];
	$Effective_from = $row['Effective_from'];
	$Effective_to = $row['Effective_to'];
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
  
#principalname{
/*	display:block;
	border:1px solid;
	width:100px;
	background:#FFF;*/
}

#mainareaproduct {
	width:100%;
	height:500px;
	background:#ebebeb;
}

#mytableproduc_pro {
	background:#fff;
	width:95%;
	margin-left:auto;
	margin-right:auto;
	height:400px;
}


.headingspro{
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
</style>
<script type="text/javascript">



function getprincipal()
{
 var val=$('#brand option:selected').text();
	//alert("hi");
	 $.ajax({
			
            url:'get_principal.php?val=' + val,
		     success: function(data) {
				//alert(data);
				var value=$.trim(data);//To Remove White Space in string
				var value1=data.substring(0,value.length-1);//To return part of the string
				var list= value1.split("|"); 
				//alert(value);
				$("#principal").val(list[1]);
				//alert((list[1]);
				$("#principalname").val(list[0]);
			 
			 }
        });
}


function getuom()
{
	var val=$('#uom2 option:selected').text();
	 $.ajax({
            url: 'get_uom.php?val=' + val,
			success: function(data) {
				//alert(data);
				var value=$.trim(data);//To Remove White Space in string
				var value1=data.substring(0,value.length-1);//To return part of the string
				var list= value1.split("|"); 
				for (var i=0; i<list.length; i++) {
					var arr_i= list[i].split("^");
					//alert(val(arr_i[0]));
				   $("#UOMConversion").val(arr_i[0]);
					
			}

			}
        });
}



$(function(){
    $('.datepicker').attr('disabled','disabled');
     $('#Focus').change(function(){
							 
     if($(this).val()==0) {
		// alert("Hi");	
	 $('.datepicker').attr('disabled','disabled');
	 }
   else if($(this).val()==1) {
	  //  alert("Hi");
	 $(".datepicker").removeAttr("disabled");
    }
 });
});



function prodvalidate() {
	var Productcode				=	$('#Product_code').val();
	var ProductDescription		=	$('#Product_description1').val();
	var DescriptionLength		=	$('#Product_description_length').val();
	var Brand                   =   $('#brand').val();
	var ProductType             =   $('#product_type').val();
	var ProductCategory         =   $('#product_category').val();
	var Principal         =   $('#principal').val();


	if(Productcode == ''){
		$('.myaligncol').html('ERR : Enter Product Code');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}

	if(ProductDescription == ''){
		$('.myaligncol').html('ERR : Enter Product Description');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}

  	if(DescriptionLength == ''){
		$('.myaligncol').html('ERR : Enter Desc Length');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}

   if(Brand == ''){
		$('.myaligncol').html('ERR : Select Brand');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}

  if(ProductType == ''){
		$('.myaligncol').html('ERR : Select Product Type');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}

	if(Principal == ''){
     $('.myaligncol').html('ERR : Select Principal');
	 $('#errormsgcol').css('display','block');
	 setTimeout(function() {
	  $('#errormsgcol').hide();
		 },5000);
		 return false;
		}

	$('#errormsgcol').css('display','none');
	//return false;
}

function changeDateFormat(DateVal,dateelement) {
	//alert(DateVal);
	var datePart	=	DateVal.split('/');

	var dateyear	=	datePart[2];
	var dateday		=	datePart[1];
	var datemon		=	datePart[0];
	
	var DateOrgVal		=	dateday+"-"+datemon+"-"+dateyear;
	//alert(DateOrgVal);
	$('#'+dateelement).val(DateOrgVal);
}
</script>

<div id="mainareaproduct">
<div class="mcf"></div>
<div align="center" class="headingspro">Product</div>
<div id="mytableproduc_pro" align="center">
<div class="mcf"></div>
<form action="" method="post" onsubmit="return prodvalidate()">
<fieldset class="alignment">
<table  width="100%" height="60">
<legend><strong>Product Datas</strong></legend>
  <tr height="28px">
    <td class="pclr align" >Code*</td>
    <td><input type="text" name="Product_code" size="30" id="Product_code" value="<?php echo $Product_code;?>" maxlength="30"  autocomplete='off'/></td>
    
    
   <td class="align">&nbsp;UOM2<br />(Cartons)</td>
   <td>
   
   <select name="UOM2" id="uom2"  onChange="return getuom();">
    <option value="">--- Select ---</option>
	<?php 
    $list=mysql_query("select * from  uom_conversion"); 
    while($row=mysql_fetch_array($list)){
    ?>
    <option value="<?php echo $row['uom2']; ?>"<?php if($row['uom2']==$UOM2){ echo "selected"; } ?>><?php echo $row['uom2']; ?></option>
    <?php 
    // End while loop. 
    } 
    ?>
	</select>
    
      </td>
    
    
    <td class="align">UOM1<br />(PCS)</td>
    <td><input type="text" name="UOM1" size="10" value="<?php echo $UOM1;?>" readonly="readonly" maxlength="10" autocomplete='off'/></td>
  
    <td class="align">Conversion</td>
    <td><input type="text" name="UOM_Conversion" size="10" id="UOMConversion" value="<?php echo $Uom_conversion; ?>" maxlength="50" autocomplete="off"></td>
    </tr>

  </table>

 <table  width="100%" height="60">
  <tr height="28px" style="clear:both">
      <td class="align">Description*</td>
    <td><input type="text" name="Product_description1" id="Product_description1" class="plength" size="40" maxlength="150" value="<?php echo $Product_description1; ?>"  autocomplete='off'/></td>
     <td>Inv Print Desc *</td>
   <td><input type="text" name="Product_description_length" id="inclength"  class="inclength" size="40" maxlength="29" value="<?php echo $Product_description_length; ?>"  autocomplete='off'/></td>
    </tr>
  
  <tr height="50px" style="clear:both">  
   <td class="align">Display Description*</td>
   <td colspan="8"><input type="text" name="Product_display_description" size="100" maxlength="15" value="<?php echo $Product_display_description; ?>"  autocomplete='off'/></td>
    </tr>
    
    </table>
</fieldset>
<div class="clearfix"></div>
<fieldset class="alignment">
<legend><strong>Product Parameters</strong></legend>
   <table  width="100%" height="60">
    <tr height="28px">
    <td class="align">Brand*</td>
     <td>
      <select name="brand" id="brand"  onChange="return getprincipal();">
        <option value="">--- Select ---</option>
        <?php
        // Get records from database (table "name_list").
        $list=mysql_query("select * from brand order by  brand asc");

        // Show records by while loop.
        while($row_list=mysql_fetch_assoc($list)){
        ?>
        <option value="<?php echo $row_list['id']; ?>" <?php if($row_list['id']==$brand){ echo "selected"; } ?>><?php echo $row_list['brand']; ?></option>
        <?php
        // End while loop.
        }
        ?>
        </select>

    </td>
    
      <td class="align">Principal*</td>
      <td>
   <!--   <span id="principalname" style="padding-left:2px;"></span>-->
   <input type="hidden" name="principal" size="15" id="principal" value="<?php echo $principal ?>"  maxlength="20" autocomplete='off' readonly="readonly"/>
      <input type="text" name="principalname" id="principalname" value="<?php
            $query=mysql_query("select * from principal where id = $principal");
            $row=mysql_fetch_array($query);
            $princid=$row['id'];
            $princv=$row['principal'];
            if($principal=$princid){echo $princv;} elseif($_REQUEST['id']!=''){echo $principal;} ?>" />
      </td>


    <td class="align">Product Type*</td>
    <td width=100>
    <select name="product_type" id="product_type">

        <?php
        // Get records from database (table "name_list").
        $list=mysql_query("select * from  product_type");

        // Show records by while loop.
        while($row_list=mysql_fetch_assoc($list)){
        ?>
        <option value="<?php echo $row_list['product_type']; ?>" <?php if($row_list['product_type']==$product_type){ echo "selected"; } ?>><?php echo $row_list['product_type']; ?></option>
        <?php
        // End while loop.
        }
        ?>
        </select></td>


    <td class="align">Product Category</td>
    <td width=100>
    <select name="product_category" id="product_category">
     <option value="">--- Select ---</option>
        <?php
        // Get records from database (table "name_list").
        $list=mysql_query("select * from  product_category");

        // Show records by while loop.
        while($row_list=mysql_fetch_assoc($list)){
        ?>
        <option value="<?php echo $row_list['id']; ?>" <?php if($row_list['id']==$product_category){ echo "selected"; } ?>><?php echo $row_list['product_category']; ?></option>
        <?php
        // End while loop.
        }
        ?>
        </select>
        </td>

  </tr>
  </table>

  <table  width="100%" height="60">
  <tr height="28px">
   <td class="align">Batch Control*</td>
    <td>
	<?php
		// Get records from database (table "name_list").
		$list=mysql_query("select batchctrl from  parameters");
		// Show records by while loop.
		$row_list=mysql_fetch_assoc($list);
		$batch_cntrl		=	$row_list['batchctrl'];
	?>

    <select name="batch_ctrl"
	<?php 
	if($batch_cntrl == "ON-ALL") { 
			echo "readonly";
		} elseif($batch_cntrl == "ON-SELECT") { 
			echo "";
		} elseif($batch_cntrl == "OFF") { 
			echo "readonly";
		}
	?> >
      
        <option value="<?php echo $batch_cntrl; ?>" <?php if($batch_cntrl==$batch_ctrl){ echo "selected"; } 
		if($batch_cntrl == "ON-ALL") { 
			echo "selected";
		} elseif($batch_cntrl == "ON-SELECT") { 
			echo "selected";
		} elseif($batch_cntrl == "OFF") { 
			echo "selected";
		} 
		
		
		?>><?php 
		if($batch_cntrl == "ON-ALL") { 
			echo "Yes";
		} elseif($batch_cntrl == "ON-SELECT") { 
			echo "No";
		} elseif($batch_cntrl == "OFF") { 
			echo "No";
		} ?></option>
        <?php 
        // End while loop. 
        //} 
        if($batch_cntrl == "ON-SELECT") { 
		?>
		<option value="<?php echo $batch_cntrl; ?>" ><?php 
		if($batch_cntrl == "ON-SELECT") { 
			echo "Yes";
		} ?></option>
		<?php } ?>
		</select>
        </td>
 
     <td class="align">Focus*</td>
     <td>
     <select name="Focus" id="Focus">
     <option value="select">--Select--</option>
     <option value="1" <?php if($Focus==1){ echo 'selected';}?>>Yes</option>
     <option value="0" <?php if($Focus==0){ echo 'selected';}?>>No</option>
     </select>
    </td>
    
     <td class="date align">Effective From</td>
     <td width=100>
      <input type="text" name="Effective_from" id="fromdate" onChange="changeDateFormat(this.value,'fromdate')" class="datepicker fromdate" value="<?php 
	  $id=$_GET['id'];
      $list=mysql_query("select * from product where id= '$id'"); 
      while($row = mysql_fetch_array($list)){ 
	  if(($row['Effective_from'])!='0000-00-00'){echo $row['Effective_from']; }else{echo $Effective_from = "";}}?>" maxlength="10" autocomplete="off" size="10">
     </td>
    
   <td class="date align">Effective To</td>
   <td width=100>
   <input type="text" name="Effective_to" id="todate"  onChange="changeDateFormat(this.value,'todate')" class="datepicker todate" value="<?php  
      $id=$_GET['id'];
      $list=mysql_query("select * from product where id= '$id'"); 
      while($row = mysql_fetch_array($list)){ 
	  if(($row['Effective_to'])!='0000-00-00'){echo $row['Effective_to']; }else{echo $Effective_to = "";}}?>" maxlength="10" autocomplete="off" size="10">  
    </td>
</tr>
</table>
</fieldset>


<table width="100%">
  <tr height="60px;" align="center">
        <td colspan="10"><input type="submit" name="submit" id="submit" class="buttons" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="reset" name="reset" id="Clear"  class="buttons" value="Clear" onclick="window.location='productMaster.php'";/>&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/>&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" name="view" value="view" class="buttons" onclick="window.location='productview.php'"/></td>
        </td>
      </tr>
</table>
</form>

</div>
<?php include("../include/error.php");?>
<div id="errormsgcol" style="display:none;clear:both;">
<h3 align="center" class="myaligncol"></h3><button id="closebutton">Close</button></div>
</div>
<?php include('../include/footer.php'); ?>