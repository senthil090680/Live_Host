<?php
session_start();
ob_start();
include('../include/header.php');
include "../include/ps_pagination.php";
include('func.php');
if(isset($_GET['logout'])){
session_destroy();
header("location:../index.php");
}

EXTRACT($_POST);
$TransactionNumber =$_POST['Transaction_Number'];
$GPS = $latitude.','.$longitude;

$signimage =   $_FILES["signimage"]["name"];
@move_uploaded_file($_FILES["signimage"]['tmp_name'],"../../../signs/".$signimage);
$Signature_Image = $_FILES["signimage"]["name"]; 

$shopimage =   $_FILES["shopimage"]["name"];
@move_uploaded_file($_FILES["shopimage"]['tmp_name'],"../../../signs/".$shopimage);
$Shop_Image = $_FILES["shopimage"]["name"]; 


$page=intval($_REQUEST['page']);
$id=$_REQUEST['id'];
if(($_POST['submit'])=='Save'){
$sel="select * from transaction_hdr where Transaction_Number ='$Transaction_Number'";
$sel_query=mysql_query($sel);
if(mysql_num_rows($sel_query)=='0') {
$Date=date("Y-m-d",strtotime($Date));

$sql="INSERT INTO `transaction_hdr`(`KD_Code`,`DSR_Code`,`device_code`,`Date`,`Time`,`GPS`,`Customer_code`,`Transaction_type`,`Transaction_Number`,`transaction_Reference_Number`,`currency`,`Product_Line_count`,`Transaction_Value`,`Discount`,`Discount_Value`,`Net_Sale_value`,`Collection_Value`,`Balance_Due_Value`,`Shop_Image`,`Image_Capture`,`Signature_Image`,`return_reason`,`RSM`,`branch_id`)
values('$KD_Code','$DSR_Code','$Device_Code','$Date','$Time','$GPS','$Customer_code','$Transaction_type','$Transaction_Number','$transaction_Reference_Number','$currency','$Product_Line_count','$Tranaction_Value','$Discount','$Discount_Value','$Net_Sale_value','$Collection_Value','$Balance_Due_Value','$Shop_Image','$Image_Capture','$Signature_Image','$return_reason','$RSM','$branch_id')";
mysql_query($sql);
	   header("location:transactionentry.php?no=1&$page=$page");
   }
   else{
	   header("location:transactionentry.php?no=18&$page=$page"); 
   }
}

$id=$_GET['id'];
$list=mysql_query("select * from customer where id= '$id'"); 
while($row = mysql_fetch_array($list)){ 
	$KD_Code = $row['KD_Code'];
	$DSR_Code = $row['DSR_Code'];
	$device_code = $row['device_code'];
	$Date = $row['Date'];
	$Time = $row['Time'];
	$latitude = $row['latitude'];
	$longitude = $row['longitude'];
	$Customer_code = $row['Customer_code'];
	$Transaction_type = $row['Transaction_type'];
	$Transaction_Number = $row['Transaction_Number'];
	$transaction_Reference_Number = $row['transaction_Reference_Number'];
	$currency = $row['currency'];
	$Product_Line_count = $row['Product_Line_count'];
	$Transaction_Value = $row['Transaction_Value'];
	$Discount = $row['Discount'];
	$Discount_Value = $row['Discount_Value'];
	$Net_Sale_value = $row['Net_Sale_value'];
	$Collection_Value = $row['Collection_Value'];
	$Balance_Due_Value = $row['Balance_Due_Value'];
	$Shop_Image = $row['Shop_Image'];
	$Image_Capture = $row['Image_Capture'];
	$Signature_Image= $row['Signature_Image'];
	$return_reason = $row['return_reason'];
	$RSM = $row['RSM'];
	$branch_id = $row['branch_id'];
	}
	

?>


<!------------------------------- Form -------------------------------------------------->
<link type="text/css" rel="stylesheet" href="../css/popup.css" />
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
  
 
#mytableformtrans{
background:#fff;
width:95%;
margin-left:auto;
margin-right:auto;
height:450px;
}   

.headingsprotrans{
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

.alignment{
width:95%;
padding-left:10px;
margin-left:10px;
font-size:16px;
}


.loadingstyle {
	display:none;
	position:absolute;
	top:250px;
	left:470px;
	z-index:3;
}
.buttons_prod{
	-webkit-box-shadow:rgba(0,0,0,0.2) 0 1px 0 0;
	-moz-box-shadow:rgba(0,0,0,0.2) 0 1px 0 0;
	box-shadow:rgba(0,0,0,0.2) 0 1px 0 0;
	border-bottom-color:#333;
	border:1px solid #686868;
	background-color:#c1c1c1;
	border-radius:5px;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	color:#000;
	font-family:Calibri;
	font-size:12px;
	padding:3px;
	cursor:pointer;
	width:200px;
	height:25px;
}
.displayprod {
	margin:0 auto;
	display:none;
	background:#FFFFFF;
	color:#000;
	width:1000px;
	height:550px;
	position:fixed;
	left:172px;
	top:100px;
	border:1px solid #EEEEEE;
	z-index:2;
	border-radius:5px 5px 5px 5px;
}
.condaily_prod{
	width:100%;
	text-align:left;
	height:420px;
	border-collapse:collapse;
	background:#a09e9e;
	margin-left:auto;
	margin-right:auto;
	border-radius:10px;
	overflow:scroll;
	overflow-x:hidden;
}
.condaily_prod th {
	padding:2px 5px 0 5px;
	font-weight:bold;
	font-size:14px;
	color:#000;
}

.condaily_prod td {
	padding:2px 5px 0 5px;
	background:#fff; !important;
	border-collapse:collapse;
	padding-left:10px;
	color:#000; 
	font-size:14px;
}

.condaily_prod {
	background: #c1c1c1;
}
#errormsgpopupprod{
	width:38%;
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
.myalignprod {
	padding-top:8px;
	margin:0 auto;
	color:#000;
}

#closebutton_cus {
  position:relative;
  top:-35px;
  color:transparent;
  right:-190px;
  border:none;
  clear:both;
  height:100%;
  min-height:100%;
  background:url(../images/close_pop.png) no-repeat;
}
.bgclass td{
	background-color:#faf9f9;
}
  
</style>

<script type="text/javascript">
$(document).ready(function() {
	$('#KD_Code').change(function(){
	   $.get("func.php", {
		func: "KD_Code",
		KD_Code: $('#KD_Code').val()
      }, function(response){
         setTimeout("kd('DSR_Code', '"+escape(response)+"')", 400);
      });
    	return false;
	});
	
	$('#DSR_Code').change(function(){
	 $.get("func.php", {
		func: "cuscode",
		DSR_Code: $('#DSR_Code').val()
      }, function(responsec){
		 setTimeout("cus('Customer_code', '"+escape(responsec)+"')", 400);
      });
    	return false;
	});
	

	$('#DSR_Code').change(function(){
	   $.get("func.php", {
		func: "DSR_Code",
		DSR_Code: $('#DSR_Code').val()
      }, function(responses){
		 setTimeout("dsr('Device_Code', '"+escape(responses)+"')", 400);
      });
    	return false;
	});
	
		
	   $('#DSR_Code').change(function(){
	   $.get("func.php", {
	   func: "dsrcode",
		DSR_Code: $('#DSR_Code').val()
      }, function(responser){
		 setTimeout("rsm('RSM', '"+escape(responser)+"')", 400);
      });
    	return false;
	});
	
});


function kd(id, response) {
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
}

function dsr(id, responses) {
  $('#'+id).html(unescape(responses));
  $('#'+id).fadeIn();
}

function cus(id, responsec) {
  $('#'+id).html(unescape(responsec));
  $('#'+id).fadeIn();
}

function rsm(id, responser) {
  $('#'+id).html(unescape(responser));
  $('#'+id).fadeIn();
}

function transconfirm() {
	
	$("#view").click(function() {
	$('#transvalid').attr("target","_blank"); 
	$('#transvalid').attr("action","printtrans.php");
	$("#transvalid").val("View");  
	$("#submithidden").val("800"); 
    $('#transvalid').submit();
	return false;
  });
}

function addlinepro() {

	//alert($('#linecount').val());
	var TransactionNumber = $("#Transaction_Number").val();
	var Linecount	      =	$("#linecount").val();
	var KDCode	          =	$("#KD_Code").val();
	var DSRCode           =	$("#DSR_Code").val();
	var Transactiontype	  =	$("#Transaction_type").val();
	
	if($('#linecount').val() == ''){
		$('.myaligncol').html('ERR : Enter Line Count');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
			$('#errormsgcol').hide();
		},5000);
		return false;
	}
	$.ajax({
		
		url			:	"lineproduct.php",
		type		:	"post",
		dataType	:	"text",
		data : { "TransactionNumber" : TransactionNumber,"Linecount": Linecount,"KDCode": KDCode,"DSRCode": DSRCode,"Transactiontype": Transactiontype },  
		success		:	function(ajaxdata) { 
		var trimdata	=	$.trim(ajaxdata);
			//alert(trimdata);
			$("#totval").html();
			$("#productshow").html(trimdata);
			$("#productshow").css({"display":"block"});
			$("#backgroundChatPopup").fadeIn("slow");
			$("#backgroundChatPopup").css({"opacity" : "0.7"});
		}
	});			
	return false;
}


function validatetrans() {
	//alert('hi');
	var KD_Code		                         	=	$('#KD_Code').val();
	var DSR_Code         	                  	=	$('#DSR_Code').val();
	var device_code    	                        =	$('#device_code').val();
	var Dates        		                    =	$('#Date').val();
	var Time        		                    =	$('#Time').val();
	var latitude                                =	$('#latitude').val();
	var longitude                               =	$('#longitude').val();
	var Customer_code                           =	$('#Customer_code').val();
	var Transaction_type                        =	$('#Transaction_type').val();
	var Transaction_Number                      =	$('#Transaction_Number').val();
	var transaction_Reference_Number       	    =	$('#transaction_Reference_Number').val();
	var currency                        	    =	$('#currency').val();
	var Product_Line_count          	        =	$('#Product_Line_count').val();
	var Transaction_Value       	            =	$('#Transaction_Value').val();
	var Discount       	                        =	$('#Discount').val();
	var Discount_Value                   	    =	$('#Discount_Value').val();
	var Net_Sale_value                  	    =	$('#Net_Sale_value').val();
	var Collection_Value                  	    =	$('#Collection_Value').val();
	var Balance_Due_Value                  	    =	$('#Balance_Due_Value').val();
	var Shop_Image                  	        =	$('#Shop_Image').val();
	var Image_Capture                  	        =	$('#Image_Capture').val();
	var Signature_Image                  	    =	$('#Signature_Image').val();
	var return_reason                    	    =	$('#return_reason').val();
		

	if(KD_Code == ''){
		$('.myaligncol').html('ERR : Select KD Code');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}

	if(DSR_Code == ''){
		$('.myaligncol').html('ERR : Select Location');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}

  	if(device_code == ''){
		$('.myaligncol').html('ERR : Select LGA');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}
	
	
  	if(Dates == ''){
		$('.myaligncol').html('ERR : Select City');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}
	
	if(Time == ''){
		$('.myaligncol').html('ERR : Select State');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}
	
	if(latitude == ''){
		$('.myaligncol').html('ERR : Enter latitude');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}
	
	if(longitude == ''){
		$('.myaligncol').html('ERR : Enter longitude');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}
	
	if(Customer_code == ''){
		$('.myaligncol').html('ERR : Enter Customer_code');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}

	if(Transaction_type == ''){
		$('.myaligncol').html('ERR : Enter Transaction_type');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}
	
	
   	if(Transaction_Number == ''){
		$('.myaligncol').html('ERR : Enter Transaction Number');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}
	
	
    if(Product_Line_count == ''){
		$('.myaligncol').html('ERR : Enter Product Line count');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}	
	
	
	 if(Transaction_Value == ''){
		$('.myaligncol').html('ERR : Enter Transaction Value');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}
	
	
	 if(Net_Sale_value == ''){
		$('.myaligncol').html('ERR : Enter Net Sale value');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}
	
	 if(Collection_Value == ''){
		$('.myaligncol').html('ERR : Enter Collection Value');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}
	
	 if(Balance_Due_Value == ''){
		$('.myaligncol').html('ERR : Enter Balance Due Value');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}
	
	
	 if(Shop_Image == ''){
		$('.myaligncol').html('ERR : Choose Shop Image');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}
	
	
	 if(Signature_Image == ''){
		$('.myaligncol').html('ERR : Choose Signature Image');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}

	$('#errormsgcol').css('display','none');
	//return false;
}
</script>

<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headingsprotrans">Device Transaction Entry</div>
<div id="mytableformtrans" align="center">
<form action="" method="post"  onsubmit="return validatetrans();" id="transvalid"  enctype="multipart/form-data">
<table width="50%" align="left">
 <tr>
  <td>
 <fieldset class="alignment">
  <legend><strong>Transaction</strong></legend>
  <table>
  <tr height="22">
   <td width="120" class="pclr">KD Name</td>
   <td>
    <select name="KD_Code" id="KD_Code">
    
      <option value="" selected="selected" >Select KD</option>
      
      <?php getdsrcode(); ?>
    
    </select>
   </td>
   </tr>
    
     <tr height="22">
     <td width="120">DSR Name*</td>
     <td>
     <select name="DSR_Code" id="DSR_Code">
     <option value="" selected="selected" >Select DSR</option>
     </select>
     </td>
     </tr>
     
     
         <tr  height="22">
    <td  width="120">Customer*</td>
 <!--   <td><input type="text" name="Customer_code" isize="10"  readonly="readonly" value="<?php echo $Customer_code; ?>"  autocomplete='off' maxlength="10"/></td>-->
    <td>
     <select name="Customer_code" id="Customer_code">
     <option value="" selected="selected" >Select Customer</option>
     </select>
     </td>
    </tr>
    
    
    <tr height="22">
     <td width="120">Device Code*</td>
     <td>
     <select name="Device_Code" id="Device_Code">
     <option value="" selected="selected" >Select DeviceCode</option>
     </select>
      </td>
     </tr>
     
     <tr height="22">
     <td>RSM</td>
     <td>
     <select name="RSM" id="RSM">
     <option value="" selected="selected" >Select RSM</option>
     </select>
       </td>
     </tr>
     
     
     <tr height="22">
     <td>Date</td>
     <td> <input type="text" name="Date" id="fromdate" onChange="changeDateFormat(this.value,'fromdate')" class="datepicker fromdate" value="<?php echo date('d-m-Y')?>" maxlength="10" autocomplete="off"></td> 
     </tr>
     
     <tr height="22">
     <td>Transaction Type*</td>
     <td> 
        <?php 
        $list=mysql_query("select * from trans_type"); 
        ?>
        <select name="Transaction_type" class="Transaction_type" id="Transaction_type"  autocomplete="off">
        <option value="">--- Select ---</option>
		<?php 		
		while($row_list=mysql_fetch_assoc($list)){ 
		$id=$row_list['KD_Name'];
		?>
        <option value="<?php echo $row_list['id']; ?>" <? if($row_list['trans_type']==$KD_Name){ echo "selected"; } ?>><? echo $row_list['trans_type']; ?></option>
        <?php  } ?>
        </select> 
       </td>
     </tr>
     
    
     
         <?php 
        date_default_timezone_set('Africa/Lagos');
        $Time= date('h:i:s', time());
        ?>
        <td><input type="hidden" name="Time" size="30" value="<?php echo $Time; ?>" autocomplete='off' maxlength="100"/></td>
       

   </table>
 </fieldset>
   </td>
 </tr>
</table>
 <!----------------------------------------------- Left Table End -------------------------------------->
<table width="50%" align="right">
 <tr>
  <td>
   <fieldset class="alignment">
  <legend><strong>Transaction Datas</strong></legend>
  <table>
   
        
      <tr height="25">
      <td>Transaction Number*</td>
     <td>
     <?php
      $q = mysql_query("SELECT MAX(Transaction_Number) as Transaction_Number from `transaction_hdr`");
				$row = mysql_fetch_assoc($q);
				$Number = $row['Transaction_Number'];
				$Transaction_Number = $Number++;
				
		
	  ?>
      <input type="text" name="Transaction_Number" id="Transaction_Number" size="20" value="<?php echo $Number; ?>" autocomplete='off' maxlength="10" readonly="readonly"/>
       </td>
     </tr>
     <tr height="25">
      <td>Product Line Count*</td>
     <td><input type="text" name="Product_Line_count" id="linecount" size="20" value="<?php echo $Product_Line_count; ?>" autocomplete='off' maxlength="10"/></td>
    </tr>
    
     <?php
     $sel="select sum(Value) AS Value from  transaction_line where Transaction_Number = '$Number'"; 	
	 $res=mysql_query($sel);
	 while($val=mysql_fetch_array($res)){
		  $Value=$val['Value'];
	 }

	 ?>
     <tr height="25">
     <td>Transaction Value</td>
     <td><input type="text" name="Transaction_Value" size="20" value="<?php echo $Value; ?>" autocomplete='off' maxlength="10"/></td>
     
    <tr height="25">
    <td>Return Reason</td>
    <td><input type="text" name="return_reason" size="20" value="<?php echo $return_reason; ?>" autocomplete='off' maxlength="30"/></td>
    </tr>

    <tr height="25">
     <td>Discount %</td>
     <td><input type="text" name="Discount"  id="Discount" size="20" value="<?php echo $Discount; ?>" autocomplete='off' maxlength="20"/></td>
     </tr>
     
     <tr height="25">
     <td>Discount Value</td>
     <td><input type="text" name="Discount_Value"  id="Discount_Value" size="20" value="<?php echo $Discount_Value; ?>" autocomplete='off' maxlength="20"/></td>
     </tr> 
 
 
     <?php
     $sel="select sum(Price) AS Price from  transaction_line where Transaction_Number = '$Number'"; 	
	 $res=mysql_query($sel);
	 while($val=mysql_fetch_array($res)){
		  $Net_Sale_value=$val['Price'];
	 }

	 ?>
     <tr height="25">
     <td>Net Sale Value*</td>
     <td>
      <input type="text" name="Net_Sale_value" value="<?php echo $Net_Sale_value; ?>" autocomplete='off' size="20"/></td>
     </tr>
     
     <tr height="25">
     <td>Collection Value*</td>
     <td><input type="text" name="Collection_Value"  id="Collection_Value" size="20" value="<?php echo $Collection_Value; ?>" autocomplete='off' maxlength="20"/></td>
     </tr>
     
     
     <tr height="25">
     <td>Balance Due Value*</td>
     <td><input type="text" name="Balance_Due_Value" id="Balance_Due_Value" size="20" value="<?php echo $Balance_Due_Value; ?>" autocomplete='off' maxlength="20"/></td>
     </tr>
     
      <tr>
    <td>Branch</td>
    <td>
       <?php
        $list=mysql_query("select * from branch order by branch asc");
        ?>
        <select name="branch_id" id="branch_id">
        <option value="">--- Select ---</option>
		<?php
		while($row_list=mysql_fetch_assoc($list)){
		$id=$row_list['branch'];
		?>
        <option selected="selected" value="<?php echo $row_list['id']; ?>" <?php if($row_list['id']==$branch_id){ echo "selected"; } ?>><?php echo $row_list['branch']; ?></option>
        <?php  } ?>
        </select></td>
     </tr>
     
     
     <tr height="25">
     <td>Currency*</td>
     <td><input type="text" name="currency" autocomplete='off' value="Naira" size="10" /> </td>
     </tr>
     
   </table>
 </fieldset>
</td>
</tr>
</table>
 <!----------------------------------------------- Right Table End -------------------------------------->
<table width="50%" align="right">
 <tr>
  <td>
   <fieldset class="alignment">
  <legend><strong>Datas</strong></legend>
  <table>
  
    <tr height="20">
    <td>GPS Latitude</td>
    <td><input type="text" name="latitude" size="30" value="<?php echo $latitude; ?>" autocomplete='off' maxlength="100"/></td>
    </tr>
    
    <tr height="20">
    <td>GPS Longitude</td>
    <td><input type="text" name="longitude" size="30" value="<?php echo $longitude; ?>" autocomplete='off' maxlength="100"/></td>
    </tr>
 
    <tr height="20">
     <td>Shop Image</td>
     <td><input type="File" name="shopimage" size="30" value="<?php echo $Shop_Image; ?>" autocomplete='off' maxlength="100"/></td>
     </tr>
    
	<?php 
    date_default_timezone_set('Africa/Lagos');
    $Image_Capture= date('h:i:s', time());
    ?>
     <td><input type="hidden" name="Image_Capture" size="30" value="<?php echo $Image_Capture; ?>" autocomplete='off' maxlength="100"/></td>
    
    <tr height="20">
     <td>Signature Image</td>
     <td><input type="File" name="signimage" size="30" value="<?php echo $Signature_Image; ?>" autocomplete='off' maxlength="20"/></td>
     </tr>
   </table>
 </fieldset>

</td>
</tr>
</table> 

<div style="clear:both"></div>
 <!----------------------------------------------- last Table End -------------------------------------->
  <div class="mcf"></div> 
 <table width="50%" style="clear:both">
      <tr align="center" height="50px;">
      <td>
      <input type="submit" name="submit" id="submit" class="buttons" value="Save"/>&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="reset" name="reset" class="buttons" value="Clear" id="clear" onclick="window.location='transactionentry.php'"/>&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/>&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="button" value="Show Products" class="buttonsbig"  onClick="return addlinepro();" />
       </td>
      </tr>
 </table>     
</form>
<div id="productshow" class="displayprod"></div>

<div class="mcf"></div>
<?php include("../include/error.php");?>
<div id="errormsgcol" style="display:none;clear:both;"><h3 align="center" class="myaligncol"></h3><button id="closebutton">Close</button></div>


<div id="backgroundChatPopup"></div>
<!---- Form End ----->
</div>
<?php include('../include/footer.php'); ?>