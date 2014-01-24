$(document).ready(function() {

//Fadeout for menu page
setTimeout(function(){
  $('.mydiv').remove();
  $('#errormsgdev').hide(); 
}, 4000);


// hide or show by default
if($("#Data_Transfer").val()==='0') {
	$('#Data_Transfer').selectedIndex = '0';
	$("#textbox1").attr("disabled", "disabled"); 
	$("#start").attr("disabled", "disabled"); 
	$("#end").attr("disabled", "disabled"); 
 }
if($("#Data_Transfer").val()==='1') {
	$('#Data_Transfer').selectedIndex = '1';
	$("#textbox1").attr("enabled", "enabled"); 
	$("#start").attr("enabled", "enabled"); 
	$("#end").attr("enabled", "enabled"); 
 } 

//setup param kd
$(function(){
  // hide or show by default
 if( $('.data').val() === 'Numeric'){
  $('.alpha').css('display', 'none');  
 }
else if( $('.data').val() === 'AlphaNumeric'){
  $('.alpha').css('display', 'block');   	
}		   
//Value Selected Hide show		   
  $('.data').change(function(){
   if ($(this).val() === 'Numeric') {
	 $('.alpha').css('display', 'none');  
     
   }
  else if($(this).val() === 'AlphaNumeric') {
	  $('.alpha').css('display', 'block'); 
      }
 });
});	


//setup param scheme
$(function(){

 if( $('.datasc').val() === 'Numeric'){
  $('.alphasc').css('display', 'none');  
 }
else if( $('.datasc').val() === 'AlphaNumeric'){
  $('.alphasc').css('display', 'block');   	
}

  $('.datasc').change(function(){
   if ($(this).val() === 'Numeric') {
	 $('.alphasc').css('display', 'none');  
     
   }
  else if($(this).val() === 'AlphaNumeric') {
	  $('.alphasc').css('display', 'block'); 
     }
 });
});	



//setup param SR
$(function(){
  // hide or show by default
 if( $('.datasr').val() === 'Numeric'){
  $('.alphasr').css('display', 'none'); 
 }
else if( $('.datasr').val() === 'AlphaNumeric'){
  $('.alphasr').css('display', 'block');   	
}

  $('.datasr').change(function(){
   if ($(this).val() === 'Numeric') {
	 $('.alphasr').css('display', 'none'); 
   }
  else if($(this).val() === 'AlphaNumeric') {
	  $('.alphasr').css('display', 'block'); 
     }
 });
});	

//Fancy Box
$('a[rel*=facebox]').facebox(); 
$('.ask').jConfirmAction();

   $(function() {
        $( "#closebutton" ).button({
            icons: {
                primary: "../images/close_pop.png"
            },
            text: false
        });

        $( "#closebutton" ).click(function(event)
        {
            $("#errormsg").hide();
		    $("#errorbigmsg").hide();
			$('#errormsgdev').hide();

        });
        
    });
   	
      $(function() {
        $( "#closebutton_blue" ).button({
            icons: {
                primary: "../images/close_button_blue.png"
            },
            text: false
        });

        $( "#closebutton_blue" ).click(function(event)
        {
            $("#errormsg").hide();
		    $("#errorbigmsg").hide();

        });
        
    });

$(function() {
	  if ($.browser.msie && $.browser.version.substr(0,1)<7)
	  {
		$('li').has('ul').mouseover(function(){
			$(this).children('ul').show();
			}).mouseout(function(){
			$(this).children('ul').hide();
			})
	  }
	}); 	


//Focus on Product Master
$(function(){
  $('#madate').change(function(){
   if($(this).val() === '1') {
	 $(".datepicker").attr("enabled", "enabled"); 
   }
  else if($(this).val() === '0') {
	$('.datepicker').attr('disabled', 'disabled');
   }
   
 });
});	


//Sorting MYSQL Result SET
//$("#rounded-corner").tablesorter({sortList: [[0,0], [1,0]]}); 

$("#sort").tablesorter({sortList: [[1,1], [0,0]]}); 

//popup
$(function() {
	$( "#datepicker" ).datepicker();
	
});	

$(function() {
	$( ".datepicker" ).datepicker();
	$( ".datepicker" ).datepicker({dateFormat:'dd-mm-yy'}).val();
	
});	


	
//popup
$(function() {
	$( ".datepickerkdpdt" ).datepicker({ dateFormat:'dd-mm-yy' }).val();
	
});	

//product Validation
$("#validation").validate({
    invalidHandler: function(form, validator) {
      var errors = validator.numberOfInvalids();
	  if (errors) {
        var message ='&nbsp;&nbsp;Please Enter ALL Mandatory Fields';
        $("#messageBox").html(message);
        $("#messageBox").show();
      } else {
        $("#messageBox").hide();
      }
    },
    showErrors: function(errorMap, errorList) {
    },
submitHandler: function() {
	 $("#messageBox").hide(); 
	//alert("Submit!") 
	 if ($(form).valid()) 
     form.submit(); 
     return false; // prevent normal form posting
}
});

});


//Clear Field Value For ALL Forms
function valClear()
{
	document.location.href='register.php';
}
function userPwd()
{
	document.location.href='userchangePassword.php';
}

function forgot_clear()
{
	document.location.href='forgotPassword.php';
}

function changePWD_clear()
{
	document.location.href='changePassword.php';
}

function provinceClear()
{
	document.location.href='province.php';
}

function stateClear()
{
	document.location.href='state.php';
}

function cityClear()
{
	document.location.href='city.php';
}

function feedClear()
{
	document.location.href='feedbackType.php';
}

function cat1Clear()
{
	document.location.href='customerCategory1.php';
}

function cat2Clear()
{
	document.location.href='customerCategory2.php';
}

function cat3Clear()
{
	document.location.href='customerCategory3.php';
}

function custype()
{
	document.location.href='CustomerType.php';
}

function brandclr()
{
	document.location.href='brand.php';
}

function priclr()
{
	document.location.href='price.php';
}
function kdcat()
{
	document.location.href='kdCategory.php';
}

function lga()
{
	document.location.href='lga.php';
}

function loc()
{
	document.location.href='location.php';
}

function kd()
{
	document.location.href='kd.php';
}

function pro()
{
	document.location.href='productMaster.php';
}

function sch()
{
	document.location.href='scheme.php';
}

function sr()
{
	document.location.href='SalesRep.php';
}


function systemParam()
{
	document.location.href='setupParam.php';
}

function kdpdt()
{
	document.location.href='kdProduct.php';
}
function kdpdt_category()
{
	document.location.href='kdProduct_category.php';
}
function kdpdt_standard()
{
	document.location.href='kdProduct_standard.php';
}
function kdpdt_POSM()
{
	document.location.href='kdProduct_POSM.php';
}

function productScheme()
{
	document.location.href='productscheme.php';
}

function price()
{
	document.location.href='price.php';
}

function custclr()
{
	document.location.href='customertypeproductview.php';
}

function custTypeclr()
{
	document.location.href='customertypeproduct.php';
}


function baseinfclr()
{
	document.location.href='base_register.php';
}


//Change Password
function changePwd(val)
{
	//alert("dfds");
        $.ajax({
            url: 'get_changePassword.php?val=' + val,
            success: function(data) {
				//alert(data);
				var value=$.trim(data);//To Remove White Space in string
				var value1=data.substring(0,value.length-1);//To return part of the string
				var list= value1.split("|"); 
				var newHTML = [];
				var newHTML1 = [];
				newHTML.push("<option value='' selected='selected'>Select email</option>");
				newHTML1.push("<option value='' selected='selected'>Select password</option>");
				for (var i=0; i<list.length; i++) {
					var arr_i= list[i].split("^");
					$(".email").val(arr_i[1]);
					$(".old_pass").val(arr_i[2]);
					$(".access").val(arr_i[3]);
					$(".user_id").val(arr_i[4]);
					}

			}
        });
}	//End Of Change Password

//Set Up Parameters
function param()
{
var val1=$('#mastercode option:selected').text();
	if(val1=='Product'){
	$(".pdt").show();
	$(".scheme").hide();
	$(".productScheme").hide();
	}
	else if(val1=='Scheme')
	{
	$(".scheme").show();
	$(".pdt").hide();
	$(".productScheme").hide();
	}
	else if(val1=='Product Scheme')
	{
	$(".productScheme").show();
	$(".pdt").hide();
	$(".scheme").hide();
	}
}	//End Of Set Up Parameters

//Download Upload configuration
function DUConfig()
{
var val=$('#uploaddownload option:selected').text();
if(val=='Download'){
$(".folderName").val('Download From Channel Partner');
$(".username").val('Admin');
$(".password").val('Admin');
$(".servername").val('Host.com');
}
else
{
$(".folderName").val('Upload to Channel Partner');
$(".username").val('Admin');
$(".password").val('Admin');
$(".servername").val('Host.com');
}
}	//End Of Download Upload configuration


//Download Upload Status
function DUStatus()
{
var val=$('#uploaddownload option:selected').text();
if(val=='Download'){
$(".status").show();
$(".statusU").hide();
}
else
{
$(".statusU").show();
$(".status").hide();
}
}	//End Of Download Upload Status



function dateRange()
{
	var to_date=$('.todate').val();
	var from_date=$('.fromdate').val();
	if(to_date<=from_date)
	{
alert("To date is greater than From date");
return false;
//alert(to_date);
	}
	else
	{
		return true;

	}
}

function ajaxcategory()
{
	var val=$('.Kd_Category option:selected').text();
	window.location.href="kdProduct_category.php?data="+ val;
}
function ajaxcategory_standard()
{
	var val=$('.Kd_Category option:selected').text();
	window.location.href="kdProduct_standard.php?data="+ val;
}
function ajaxcategory_posm()
{
	var val=$('.Kd_Category option:selected').text();
	window.location.href="kdProduct_POSM.php?data="+ val;
}



//Scheme  Product Code
function productcode()
{
	var val=$('.Product_description1 option:selected').text();
	 $.ajax({
            url: 'get_produccode.php?val=' + val,
            success: function(data) {
				//alert(data);
				var value=$.trim(data);//To Remove White Space in string
				var value1=data.substring(0,value.length-1);//To return part of the string
				var list= value1.split("|"); 
				for (var i=0; i<list.length; i++) {
					var arr_i= list[i].split("^");
					//alert(arr_i[6]);
					$(".Product_code").val(arr_i[0]);
			}

			}
        });
	
}



//Get KD code
function KDCODE()
{
	var val=$('#kd_category option:selected').text();
	 $.ajax({
            url: 'get_kdcode.php?val=' + val,
            success: function(data) {
				//alert(data);
				var value=$.trim(data);//To Remove White Space in string
				var value1=data.substring(0,value.length-1);//To return part of the string
				var list= value1.split("|"); 
				for (var i=0; i<list.length; i++) {
					var arr_i= list[i].split("^");
					//alert(arr_i[6]);
					//$("#kd_category").val(arr_i[0]);
					$("#KD_Code").val(arr_i[0]);
					
			}

			}
        });
	
}



function kdselect()
{
	var val=$('#KD_Code option:selected').text();
	 $.ajax({
            url: 'get_kdname.php?val=' + val,
            success: function(data) {
				//alert(data);
				var value=$.trim(data);//To Remove White Space in string
				var value1=data.substring(0,value.length-1);//To return part of the string
				var list= value1.split("|"); 
				for (var i=0; i<list.length; i++) {
					var arr_i= list[i].split("^");
					//alert(arr_i[6]);
					//$("#kd_category").val(arr_i[0]);
					$("#KD_Name").val(arr_i[0]);
					
			}

			}
        });
	
}



//Scheme Product Scheme Code
function scheme()
{
	var val=$('.Scheme_Description option:selected').text();
	 $.ajax({
            url: 'get_scheme.php?val=' + val,
            success: function(data) {
				//alert(data);
				var value=$.trim(data);//To Remove White Space in string
				var value1=data.substring(0,value.length-1);//To return part of the string
				var list= value1.split("|"); 
				for (var i=0; i<list.length; i++) {
					var arr_i= list[i].split("^");
					//alert(arr_i[6]);
					$(".Scheme_code").val(arr_i[0]);
					$(".Effective_from").val(arr_i[1]);
					$(".Effective_to").val(arr_i[2]);
				}

			}
        });
	
}

//Device Dashboard and Transaction
function getdevtrans(){
	var kd_id			=	$('select[name="kd_id"]').val();
	var dsr_id			=	$('select[name="dsr_id"]').val();
	var fromdate		=	$('input[name="fromdate"]').val();
	var todate			=	$('input[name="todate"]').val();
	var Salesperson_id	=	$('input[name="Salesperson_id"]').val();
	var KDCode			=	$('input[name="KDCode"]').val();

	if(kd_id == ''){
		$('.myaligndev').html('ERR : Please select KD');
		$('#errormsgdev').css('display','block');
		return false;
	} else if(dsr_id == ''){
		$('.myaligndev').html('ERR : Please select DSR ID');
		$('#errormsgdev').css('display','block');
		return false;
	}
	
	if(dsr_id != ''){
		var dsr_split		=	dsr_id.split('~');
		var dsr_act_id		=	dsr_split[0];
		var dsr_sales_id	=	dsr_split[1];
		$('#errormsgdev').css('display','none');
		//$('input[name="Salesperson_id"]').val(dsr_sales_id);
	}
	
	if(fromdate == ''){
		$('.myaligndev').html('ERR : Please select From Date');
		$('#errormsgdev').css('display','block');
		return false;
	} else if(todate == ''){
		$('.myaligndev').html('ERR : Please select To Date');
		$('#errormsgdev').css('display','block');
		return false;
	} else if(KDCode == ''){
		$('.myaligndev').html('ERR : Please Enter Device ID');
		$('#errormsgdev').css('display','block');
		return false;
	}

	$.ajax({
		url : "devtransajax.php",
		type: "get",
		dataType: "text",
		data : { "kd_id" : kd_id,"dsr_id": dsr_act_id,"fromdate" : fromdate,"todate": todate,"Salesperson_id" : dsr_sales_id,"KDCode": KDCode },
		success : function (dataval) {
			var trimval		=	$.trim(dataval);
			$('#tablestr').html(trimval);
		}
	});
}

function getsalesid(salesid) {
	var dsr_split		=	salesid.split('~');
	var dsr_act_id		=	dsr_split[0];
	var dsr_sales_id	=	dsr_split[1];

	//alert(dsr_act_id);alert(dsr_sales_id);
	$('input[name="Salesperson_id"]').val(dsr_sales_id);
}

function getdevdash() {
	var kd_id			=	$('select[name="kd_id"]').val();
	var dsr_id			=	$('select[name="dsr_id"]').val();
	var fromdate		=	$('input[name="fromdate"]').val();
	var todate			=	$('input[name="todate"]').val();
	var Salesperson_id	=	$('select[name="Salesperson_id"]').val();
	var KDCode			=	$('select[name="KDCode"]').val();

	if(kd_id == ''){
		$('.myaligndev').html('ERR : Please select KD');
		$('#errormsgdev').css('display','block');
		return false;
	} else if(dsr_id == ''){
		$('.myaligndev').html('ERR : Please select DSR ID');
		$('#errormsgdev').css('display','block');
		return false;
	}
	
	if(fromdate == ''){
		$('.myaligndev').html('ERR : Please select From Date');
		$('#errormsgdev').css('display','block');
		return false;
	} else if(todate == ''){
		$('.myaligndev').html('ERR : Please select To Date');
		$('#errormsgdev').css('display','block');
		return false;
	} 
	
	if(todate<=fromdate)
	{
		$('.myaligndev').html('ERR : To date is greater than From date');
		$('#errormsgdev').css('display','block');
		//alert(todate);
		return false;
	}

	if(Salesperson_id == ''){
		$('.myaligndev').html('ERR : Please Select Sales Person');
		$('#errormsgdev').css('display','block');
		return false;
	}

	if(KDCode == ''){
		$('.myaligndev').html('ERR : Please Select Device');
		$('#errormsgdev').css('display','block');
		return false;
	}

	$('#errormsgdev').css('display','none');
	$.ajax({
		url : "devdashajax.php",
		type: "get",
		dataType: "text",
		data : { "kd_id" : kd_id,"dsr_id": dsr_id,"fromdate" : fromdate,"todate": todate,"Salesperson_id" : Salesperson_id,"KDCode": KDCode },
		success : function (dataval) {
			var trimval		=	$.trim(dataval);
			$('#tablestr').html(trimval);
		}
	});
}

//Adding Dynamic Texbox for Quantity

function addquantity(uom) {
	if($('#Product_names').val() == ''){
		$('#showerr').show();
		return false;
	}

	var rowcnt			=	$('#procnt').val();
	var rowcntcal;
	if(rowcnt == '') {
		rowcntcal		=	1;
	} else {
		rowcntcal		=	parseInt(rowcnt) + 1;
	}
	$('#procnt').val(rowcntcal);
	var Product_name	=	$('#Product_names option:selected').text();
	var ProductCode = $('#Product_names option:selected').val(); 
	 
	$('#showerr').hide();
	$('#proadd').show();
	$('#Product_names')[0].selectedIndex = 0;
	if(rowcnt == '') {
		var appenedItems = "<tr><td align='center'><input type='hidden' value='"+Product_name+"' name='line_Product_Name_"+rowcntcal+"' />"+Product_name+"</td><td align='center'><input type='text' value='"+ProductCode+"' readonly name='line_Product_Code_"+rowcntcal+"' /></td><td align='center'><input type='text' value='"+uom+"' name='line_Product_UOM1"+rowcntcal+"' /></td><td align='center'><input type='text' autocomplete='off' value='' name='line_Product_quantity_"+rowcntcal+"' /></td></tr>";
		$(appenedItems).appendTo('#addpro');
	} else {
		$('#addpro').append("<tr><td align='center'><input type='hidden' value='"+Product_name+"' name='line_Product_Name_"+rowcntcal+"' />"+Product_name+"</td><td align='center'><input type='text' value='"+ProductCode+"' readonly name='line_Product_Code_"+rowcntcal+"' /></td><td align='center'><input type='text' value='"+uom+"' readonly name='line_Product_UOM1"+rowcntcal+"' /></td><td align='center'><input type='text' autocomplete='off' value='' name='line_Product_quantity_"+rowcntcal+"' /></td></tr>");
	}
	return false;
}





