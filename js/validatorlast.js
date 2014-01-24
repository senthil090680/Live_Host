$(document).ready(function() {

//Fadeout for menu page
setTimeout(function(){
  $('.mydiv').remove();
  $('#errormsgdev').hide();
}, 4000);



//Change DSR SR Code  for DSR screen
 // $('#SR_Codes').css('display','none'); 
  $('#SR_Codesr').css('display','none'); 

$("input[type='radio']").change(function() {
            if ($("input[type='radio']:checked").val() == 'DSR'){
				$('#SRS').attr('disabled', 'disabled');
				$('#SR_Codesr').css('display','none'); 
				$('#SR_Code').css('display', 'block');  
				 
				}	
            else if ($("input[type='radio']:checked").val() =='SR'){
				$('#DSRS').attr('disabled', 'disabled');
				$('#SR_Codesr').css('display','block'); 
				$('#SR_Code').css('display', 'none');  
			
				}
});



//Change DSR SR Code  for DSR screen
/*  $('#SR_Codes').css('display','none'); 
  $('#SR_Codesr').css('display','none'); 
 
  $('#sperson').change(function(){
     if ($(this).val() === 'DSR') {
	 $('#SR_Codes').css('display','none');  
	 $('#SR_Codesr').css('display','none'); 
	 $('#SR_Code').css('display', 'block');  
	 $('#DSR_Code').css('display', 'block');  
     }							 
							 
  else if ($(this).val() === 'SR') {
	 $('#SR_Codes').css('display','block'); 
	 $('#SR_Codesr').css('display','block'); 
	 $('#SR_Code').css('display', 'none');  
	 $('#DSR_Code').css('display', 'none');  
	 }

 });*/

//end DSR Change

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


$(".plength").keyup(function(){
    $(".inclength").val($(this).val());
	$('input.inclength').on('enter', function() {
    limitText(this, 29)
});
   
});

function limitText(field, maxChar){
    var ref = $(field),
        val = ref.val();
    if ( val.length >= maxChar ){
        ref.val(function() {
            console.log(val.substr(0, maxChar))
            return val.substr(0, maxChar);       
        });
    }
}

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
		$('#errormsgsalper').hide();
		$('#errormsgkdcov').hide();
		$('#errormsgkdout').hide();
		$('#errormsgtranslist').hide();
		$('#errormsgkdstockled').hide();
		$('#errormsgkdvehstockled').hide();
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
					selectcheck(arr_i[0]);
					
			}

			}
        });
}



function selectcheck(KD_Code)
{
	//alert(KD_Code);
	$.ajax({
    type: 'get',
	data : { "KD_Code" : KD_Code },
    url: 'kdproduct_ajax.php',
    success: function(data) {
        $('#loadpage').html(data);

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
/*function getdevtrans(){
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
		$('.myaligndev').html('ERR : Please select SR ID');
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
}*/

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
	//var Salesperson_id	=	$('select[name="Salesperson_id"]').val();
	//var KDCode			=	$('select[name="KDCode"]').val();

	if(kd_id == ''){
		$('.myaligndev').html('ERR : Select KD');
		$('#errormsgdev').css('display','block');
		setTimeout(function() {
			$('#errormsgdev').hide();
		},5000);
		return false;
	} else if(dsr_id == ''){
		$('.myaligndev').html('ERR : Select SR');
		$('#errormsgdev').css('display','block');
		setTimeout(function() {
			$('#errormsgdev').hide();
		},5000);
		return false;
	}
	
	if(fromdate == ''){
		$('.myaligndev').html('ERR : Select From Date');
		$('#errormsgdev').css('display','block');
		setTimeout(function() {
			$('#errormsgdev').hide();
		},5000);
		return false;
	} else if(todate == ''){
		$('.myaligndev').html('ERR : Select To Date');
		$('#errormsgdev').css('display','block');
		setTimeout(function() {
			$('#errormsgdev').hide();
		},5000);
		return false;
	} 
	
	if(todate<=fromdate)
	{
		$('.myaligndev').html('ERR : To date is greater than From date');
		/*$('#errormsgdev').css('display','block');
		setTimeout(function() {
			$('#errormsgdev').hide();
		},5000);
		return false;*/
	}

	/*if(Salesperson_id == ''){
		$('.myaligndev').html('ERR : Please Select Sales Person');
		$('#errormsgdev').css('display','block');
		return false;
	}

	if(KDCode == ''){
		$('.myaligndev').html('ERR : Please Select Device');
		$('#errormsgdev').css('display','block');
		return false;
	}*/

	$('#errormsgdev').css('display','none');
	$.ajax({
		url : "devdashajax.php",
		type: "get",
		dataType: "text",
		data : { "kd_id" : kd_id,"dsr_id": dsr_id,"fromdate" : fromdate,"todate": todate },
		success : function (dataval) {
			var trimval		=	$.trim(dataval);
			$('#tablestr').html(trimval);
		}
	});
}

//Add Header product

function addhquantity(Header_UOM) {
	if($('#ProductHeader').val() == ''){
		$('#showerr').show();
		return false;
	}

	var rowcnth			=	$('#procnth').val();
	var rowcnthcal;
	if(rowcnth == '') {
		rowcnthcal		=	1;
	} else {
		rowcnthcal		=	parseInt(rowcnth) + 1;
	}
	$('#procnth').val(rowcnthcal);
	var HP	=	$('#ProductHeader option:selected').text();
	var HPC = $('#ProductHeader option:selected').val(); 
	 
	$('#showerr').hide();
	$('#proaddheader').show();
	//$('#prolid_'+rowcntcal).show();
   //	$('#ProductHeader')[0].selectedIndex = 0;
	//return;
	if(rowcnth == '') {
		var appenedItems = "<tr><td align='center'><input type='hidden' value='"+HP+"' name='Header_Product_description1_"+rowcnthcal+"' />"+HP+"</td><td align='center'><input type='text' value='"+HPC+"' readonly name='Header_Product_code_"+rowcnthcal+"' /></td><td align='center'><input type='text' value='"+Header_UOM+"' readonly name='Header_UOM_"+rowcnthcal+"' /></td><td align='center'><input type='text' autocomplete='off' value='' name='Header_Quantity_"+rowcnthcal+"' id='qty_"+rowcnthcal+"'/></td></tr>";
		$(appenedItems).appendTo('#addproh');
	} else {
		$('#addproh').append("<tr><td align='center'><input type='hidden' value='"+HP+"' name='Header_Product_description1_"+rowcnthcal+"' />"+HP+"</td><td align='center'><input type='text' value='"+HPC+"' readonly name='Header_Product_code_"+rowcnthcal+"' /></td><td align='center'><input type='text' value='"+Header_UOM+"' readonly name='Header_UOM_"+rowcnthcal+"' /></td><td align='center'><input type='text' autocomplete='off' value='' name='Header_Quantity_"+rowcnthcal+"' id='qty_"+rowcnthcal+"'/></td></tr>");
	}
	return false;
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
	//$('#prohid_'+rowcntcal).show();
  //	$('#Product_names')[0].selectedIndex = 0;
	//return;
	if(rowcnt == '') {
		var appenedItems = "<tr><td align='center'><input type='hidden' value='"+Product_name+"' name='line_Product_Name_"+rowcntcal+"' />"+Product_name+"</td><td align='center'><input type='text' value='"+ProductCode+"' readonly name='line_Product_Code_"+rowcntcal+"' /></td><td align='center'><input type='text' value='"+uom+"' name='line_Product_UOM1_"+rowcntcal+"' /></td><td align='center'><input type='text' autocomplete='off' value='' name='line_Product_quantity_"+rowcntcal+"' id='Qty_"+rowcntcal+"'/></td></tr>";
		$(appenedItems).appendTo('#addpro');
	} else {
		$('#addpro').append("<tr><td align='center'><input type='hidden' value='"+Product_name+"' name='line_Product_Name_"+rowcntcal+"' />"+Product_name+"</td><td align='center'><input type='text' value='"+ProductCode+"' readonly name='line_Product_Code_"+rowcntcal+"' /></td><td align='center'><input type='text' value='"+uom+"' readonly name='line_Product_UOM1_"+rowcntcal+"' /></td><td align='center'><input type='text' autocomplete='off' value='' name='line_Product_quantity_"+rowcntcal+"' id='Qty_"+rowcntcal+"'/></td></tr>");
	}
	return false;
}




/* Added on 16062013 starts here */


function pag_devajax(page,params) { // For pagination of the device transaction ajax result page
	var splitparam		=	params.split("&");	
	$.ajax({
		url : "devtransajax.php",
		type: "get",
		dataType: "text",
		data : { "fromdate" : splitparam[0], "todate" : splitparam[1], "kd_id" : splitparam[2],"dsr_id": splitparam[3], "sortorder" : splitparam[4],"ordercol": splitparam[5], "page" : page },
		success : function(dataval) {
			var trimval		=	$.trim(dataval);
			//alert(trimval);
			$('#tablestr_dev').html(trimval);
		}
	});
}

function getlineitems(transno,transid,transtype,fromdate,todate,KDCode,dsr_id){
	$.ajax({
		type: "get",
		url : "getdevicelineitems.php",
		data : { "transno" : transno, "transtype" : transtype, "fromdate" : fromdate, "todate" : todate,"KDCode" : KDCode, "dsr_id" : dsr_id  },
		dataType: "text",
		success : function(dataval) {
			var actdata		=	$.trim(dataval);
			if(actdata == '') {
				//alert(actdata);
				//$("#"+errid).css("display","block");
				//return;
			}
			//alert(actdata);
			var insertmsg		=	actdata;		
			$(" <div />" ).attr("id","SecondEnq"+transno).addClass("confirmFirstDeviceTrans").html('<p class="closepboxa"><label class="closexbox"><a class="closelink" href="javascript:void(0)" onclick="javascript:return closeSecondEnquiry(this,\''+transno+'\');"><b><img border="0" src="../images/close_button2.png" /></b></a></label></p><p style="font-size:15px;padding-left:30px;" class="addcolor"><div id="SecondEnqMsg'+transno+'"></div></p>').appendTo($( "body" ));
			$("#SecondEnq"+transno).css("display","block");
			$('#SecondEnqMsg'+transno).html(insertmsg);
			$('#backgroundChatPopup').css({"opacity":"0.7"});
			$('#backgroundChatPopup').fadeIn("slow");
			return false;
		}
	});
}

function pag_devlineitemajax(page,params) { // For pagination of the device transaction ajax result page
	var splitparam		=	params.split("&");
	var transno			=	splitparam[0];
	var transtype		=	splitparam[1];
	var fromdate		=	splitparam[2];
	var todate			=	splitparam[3];
	var kdcode			=	splitparam[4];
	var dsr_id			=	splitparam[5];
	var sortorder		=	splitparam[6];
	var ordercol		=	splitparam[7];

	$.ajax({
		url : "getdevicelineitems.php",
		type: "get",
		dataType: "text",
		data : { "transno" : transno, "transtype" : transtype, "fromdate" : fromdate, "todate" : todate,"KDCode" : kdcode,"dsr_id" : dsr_id, "sortorder" : sortorder, "ordercol" : ordercol,    "page" : page },
		success : function(dataval) {
			var actdata		=	$.trim(dataval);
			var insertmsg		=	actdata;		
			$('#SecondEnqMsg'+transno).html(insertmsg);
			return false;			
		}
	});
}

function getcustomerimage(transno,KDCode) {
	$.ajax({
		type: "get",
		url : "getdevicecusimage.php",
		data : { "transno" : transno, "KDCode" : KDCode },
		dataType: "text",
		success : function(dataval) {
			var actdata		=	$.trim(dataval);
			var insertmsg		=	actdata;		
			$(" <div />" ).attr("id","CustImageEnq"+transno).addClass("confirmFirstDeviceImage").html('<p class="closepboxa"><label class="closexbox"><a class="closelink" href="javascript:void(0)" onclick="javascript:return closeCustomerImage(this,\''+transno+'\');"><b><img border="0" src="../images/close_button2.png" /></b></a></label></p><p style="font-size:15px;padding-left:30px;" class="addcolor"><div id="CustImageEnqMsg'+transno+'"></div></p>').appendTo($( "body" ));
			$("#CustImageEnq"+transno).css("display","block");
			$('#CustImageEnqMsg'+transno).html(insertmsg);
			$('#backgroundChatPopup').css({"opacity":"0.7"});
			$('#backgroundChatPopup').fadeIn("slow");
			return false;
		}
	});
}

function getcustomersig(transno,KDCode){
	$.ajax({
		type: "get",
		url : "getdevicesignature.php",
		data : { "transno" : transno, "KDCode" : KDCode },
		dataType: "text",
		success : function(dataval) {
			var actdata		=	$.trim(dataval);
			var insertmsg		=	actdata;		
			$(" <div />" ).attr("id","CustSignatureEnq"+transno).addClass("confirmFirstDeviceSig").html('<p class="closepboxa"><label class="closexbox"><a class="closelink" href="javascript:void(0)" onclick="javascript:return closeCustomerSignature(this,\''+transno+'\');"><b><img border="0" src="../images/close_button2.png" /></b></a></label></p><p style="font-size:15px;padding-left:30px;" class="addcolor"><div id="CustSignatureEnqMsg'+transno+'"></div></p>').appendTo($( "body" ));
			$("#CustSignatureEnq"+transno).css("display","block");
			$('#CustSignatureEnqMsg'+transno).html(insertmsg);
			$('#backgroundChatPopup').css({"opacity":"0.7"});
			$('#backgroundChatPopup').fadeIn("slow");
			return false;
		}
	});
}

function getfeedback(transno,KDCode){
	$.ajax({
		type: "get",
		url : "getdevicefeedback.php",
		data : { "transno" : transno, "KDCode" : KDCode },
		dataType: "text",
		success : function(dataval) {
			var actdata		=	$.trim(dataval);
			var insertmsg		=	actdata;		
			$(" <div />" ).attr("id","CustFeedbackEnq"+transno).addClass("confirmFirstDeviceFeed").html('<p class="closepboxa"><label class="closexbox"><a class="closelink" href="javascript:void(0)" onclick="javascript:return closeCustomerFeedback(this,\''+transno+'\');"><b><img border="0" src="../images/close_button2.png" /></b></a></label></p><p style="font-size:15px;padding-left:30px;" class="addcolor"><div id="CustFeedbackEnqMsg'+transno+'"></div></p>').appendTo($( "body" ));
			$("#CustFeedbackEnq"+transno).css("display","block");
			$('#CustFeedbackEnqMsg'+transno).html(insertmsg);
			$('#backgroundChatPopup').css({"opacity":"0.7"});
			$('#backgroundChatPopup').fadeIn("slow");
			return false;
		}
	});
}

function getbatchcontrol(transid,transline,KDCode){
	$.ajax({
		type: "get",
		url : "getbatchcontrol.php",
		data : { "transno" : transid, "transline" : transline, "KDCode" : KDCode },
		dataType: "text",
		success : function(dataval) {
			var actdata		=	$.trim(dataval);
			var insertmsg		=	actdata;		
			$(" <div />" ).attr("id","ProductBatchControlEnq"+transid).addClass("confirmBatchControl").html('<p class="closepboxa"><label class="closexbox"><a class="closelink" href="javascript:void(0)" onclick="javascript:return closeBatchControl(this,\''+transid+'\');"><b><img border="0" src="../images/close_button2.png" /></b></a></label></p><p style="font-size:15px;padding-left:30px;" class="addcolor"><div id="ProductBatchControlMsg'+transid+'"></div></p>').appendTo($( "body" ));
			$("#ProductBatchControlEnq"+transid).css("display","block");
			$('#ProductBatchControlMsg'+transid).html(insertmsg);
			$('#backgroundChatPopup').css({"opacity":"0.7"});
			$('#backgroundChatPopup').fadeIn("slow");
			return false;
		}
	});
}

function closeCustomerImage(atr,PCode){
	$('#CustImageEnq'+PCode).remove();
	$('#CustImageEnq'+PCode).css('display','none');
	$('#backgroundChatPopup').css({"display":"none"});
}

function closeCustomerSignature(atr,PCode){
	$('#CustSignatureEnq'+PCode).remove();
	$('#CustSignatureEnq'+PCode).css('display','none');
	$('#backgroundChatPopup').css({"display":"none"});
}

function closeCustomerFeedback(atr,PCode){
	$('#CustFeedbackEnq'+PCode).remove();
	$('#CustFeedbackEnq'+PCode).css('display','none');
	$('#backgroundChatPopup').css({"display":"none"});
}

function closeBatchControl(atr,Pcode) {
	$("#ProductBatchControlEnq"+Pcode).remove();
	$("#ProductBatchControlEnq"+Pcode).css({"display":"none"});
	$("#backgroundChatPopup").css({"display":"none"});

}


function pag_devbatchajax(page,params) { // For pagination of the device transaction ajax result page
	var splitparam		=	params.split("&");
	var transno			=	splitparam[0];
	var transline		=	splitparam[1];
	var kdcode			=	splitparam[2];
	$.ajax({
		url : "getbatchcontrol.php",
		type: "get",
		dataType: "text",
		data : { "transno" : transno, "transline" : transline, "KDCode" : kdcode, "page" : page },
		success : function(dataval) {
			var actdata		=	$.trim(dataval);
			var insertmsg		=	actdata;		
			$('#ProductBatchControlEnq'+transid).html(insertmsg);
			return false;			
		}
	});
}

function getdevtrans(){
	var kd_id			=	$('select[name="kd_id"]').val();
	var dsr_id			=	$('select[name="dsr_id"]').val();
	var fromdate		=	$('input[name="fromdate"]').val();
	var todate			=	$('input[name="todate"]').val();
	/*var Salesperson_id	=	$('input[name="Salesperson_id"]').val();
	var KDCode			=	$('select[name="KDCode"]').val();*/

	var fromdate, todate, dt1, dt2, mon1, mon2, yr1, yr2, date1, date2;
	var chkFrom = fromdate;
	var chkTo = todate;				
	dt1 = parseInt(fromdate.substring(8, 10), 10);
	mon1 = (parseInt(fromdate.substring(5, 7), 10)) - 1;
	yr1 = parseInt(fromdate.substring(0, 4), 10);

	dt2 = parseInt(todate.substring(8, 10), 10);
	mon2 = (parseInt(todate.substring(5, 7), 10)) - 1;
	yr2 = parseInt(todate.substring(0, 4), 10);
	date1 = new Date(yr1, mon1, dt1);
	date2 = new Date(yr2, mon2, dt2);

	//alert(KDCode);

	if(kd_id == ''){
		$('.myaligndev').html('ERR : Select KD');
		$('#errormsgdev').css('display','block');
		setTimeout(function() {
			$('#errormsgdev').hide();
		},5000);
		return false;
	} else if(dsr_id == ''){
		$('.myaligndev').html('ERR : Select SR Name');
		$('#errormsgdev').css('display','block');
		setTimeout(function() {
			$('#errormsgdev').hide();
		},5000);
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
		$('.myaligndev').html('ERR : Select From Date');
		$('#errormsgdev').css('display','block');
		setTimeout(function() {
			$('#errormsgdev').hide();
		},5000);
		return false;
	} else if(todate == ''){
		$('.myaligndev').html('ERR : Select To Date');
		$('#errormsgdev').css('display','block');
		setTimeout(function() {
			$('#errormsgdev').hide();
		},5000);
		return false;
	} 
	
	//alert(date2);
	//alert(date1);

	if (date2 <= date1) {
		//alert("To date Should be greater than From date");
		/*$('#fromerr').html('');
		$('#toerr').html('To date Should be greater than From date');
		$('#toerr').css('color','#FF0000');
		document.getElementById(varTo).value = '';
		document.getElementById(varTo).focus();
		return false;*/
		$('.myaligndev').html('ERR : To date Should be greater than From date!');
		$('#errormsgdev').css('display','block');
		setTimeout(function() {
			$('#errormsgdev').hide();
		},5000);
		return false;
	}
	var currentdate = new Date();

	//alert(date2);
	//alert(currentdate);

	if(date2 <= currentdate)
	{
		//alert('Date greater than Today');
	} else {
		//alert('To Date greater than Today');
		/*$('#fromerr').html('');
		$('#toerr').html('To Date greater than Today');
		$('#toerr').css('color','#FF0000');
		return false;*/
		$('.myaligndev').html('ERR : To Date greater than Today!');
		$('#errormsgdev').css('display','block');
		setTimeout(function() {
			$('#errormsgdev').hide();
		},5000);
		return false;
	}
	
	/*if(KDCode == ''){
		$('.myaligndev').html('ERR : Select Device');
		$('#errormsgdev').css('display','block');
		setTimeout(function() {
			$('#errormsgdev').hide();
		},5000);
		return false;
	}*/

	$.ajax({
		url : "devtransajax.php",
		type: "get",
		dataType: "text",
		//data : { "kd_id" : kd_id,"dsr_id": dsr_act_id,"fromdate" : fromdate,"todate": todate,"Salesperson_id" : dsr_sales_id,"KDCode": KDCode },
		data : { "kd_id" : kd_id,"dsr_id": dsr_act_id,"fromdate" : fromdate,"todate": todate },
		success : function (dataval) {
			var trimval		=	$.trim(dataval);
			//alert(trimval);
			$('#tablestr_dev').html(trimval);
		}
	});
}

function changeDateFormat(DateVal,dateelement) {
	//alert(DateVal);
	var datePart	=	DateVal.split('/');

	var dateyear	=	datePart[2];
	var dateday		=	datePart[1];
	var datemon		=	datePart[0];
	
	var DateOrgVal		=	dateyear+"-"+datemon+"-"+dateday;
	//alert(DateOrgVal);
	$('#'+dateelement).val(DateOrgVal);
}

function closeSecondEnquiry(atr,PCode){
	$('#SecondEnq'+PCode).remove();
	$('#SecondEnq'+PCode).css('display','none');
	$('#backgroundChatPopup').css({"display":"none"});
}


function deviceDashPopup(fromdate,todate,KDCode,DSRCode){
	$.ajax({
		type: "get",
		url : "devicedashfeedackajax.php",
		data : { "fromdate" : fromdate, "todate" : todate, "KDCodeVal" : KDCode, "DSR_CodeVal" : DSRCode },
		dataType: "text",
		success : function(dataval) {
			var actdata		=	$.trim(dataval);
			var insertmsg		=	actdata;		
			$(" <div />" ).attr("id","FeedbackEnq"+DSRCode).addClass("confirmFirstDeviceFeed").html('<p class="closepboxa"><label class="closexbox"><a class="closelink" href="javascript:void(0)" onclick="javascript:return closeFeedback(this,\''+DSRCode+'\');"><b><img border="0" src="../images/close_button2.png" /></b></a></label></p><p style="font-size:15px;padding-left:30px;" class="addcolor"><div id="FeedbackEnqMsg'+DSRCode+'"></div></p>').appendTo($( "body" ));
			$("#FeedbackEnq"+DSRCode).css("display","block");
			$('#FeedbackEnqMsg'+DSRCode).html(insertmsg);
			$('#backgroundChatPopup').css({"opacity":"0.7"});
			$('#backgroundChatPopup').fadeIn("slow");
			return false;
		}
	});
}

function pag_dashfeedajax(page,params) { // For pagination of the device transaction ajax result page
	var splitparam		=	params.split("&");
	var fromdate		=	splitparam[0];
	var todate			=	splitparam[1];
	var KDCode			=	splitparam[2];
	var DSRCode			=	splitparam[3];
	$.ajax({
		url : "devicedashfeedackajax.php",
		type: "get",
		dataType: "text",
		data : { "fromdate" : fromdate, "todate" : todate, "KDCodeVal" : KDCode, "DSR_CodeVal" : DSRCode, "page" : page },
		success : function(dataval) {
			var actdata		=	$.trim(dataval);
			var insertmsg		=	actdata;		
			$('#FeedbackEnqMsg'+DSRCode).html(insertmsg);
			return false;			
		}
	});
}

function closeFeedback(atr,Pcode) {
	$("#FeedbackEnq"+Pcode).remove();
	$("#FeedbackEnq"+Pcode).css({"display":"none"});
	$("#backgroundChatPopup").css({"display":"none"});
}

var codevalue					=		'';

function getKDspecific() {
	var kdcodes		=	$("#kdcode").val();
	if(kdcodes == '' || kdcodes == null) {
		$('.myalignsalper').html("ERR : Select KD");
		$('#errormsgsalper').css('display','block');
		$("#kdcode option:selected").attr("selected",false);
		/*$("#brandcode option:selected").attr("selected",false);
		$("#prodcode option:selected").attr("selected",false);*/
		$("#rsmcode option:selected").attr("selected",false);
		$("#asmcode option:selected").attr("selected",false);
		/*var kdprod		=	allproducts(kdcodes);
		var kdbrand		=	allbrands(kdcodes);*/
		var kdasms		=	kdbasedasm(kdcodes,'SRNOT');
		var kdrsms		=	kdbasedrsm(kdcodes,'SRNOT');
		//var kdkds		=	allkds(kdcodes,'SRNOT');
		var kdbranches	=	kdbasedbranch(kdcodes,'SRNOT');
		/*$("#productspan").html(kdprod);
		$("#brandspan").html(kdbrand);*/
		$("#rsmspan").html(kdrsms);
		$("#asmspan").html(kdasms);
		//$("#kdspan").html(kdkds);
		$("#branchspan").html(kdbranches);
		
		setTimeout(function() {
			$('#errormsgsalper').hide();
		},5000);
		return false;
	}
	//alert(kdcodes);
	/*var kdprod		=	kdbasedproducts(kdcodes);
	var kdbrand		=	kdbasedbrands(kdcodes);*/
	var kdasms		=	kdbasedasm(kdcodes,'SRNOT');
	var kdrsms		=	kdbasedrsm(kdcodes,'SRNOT');
	var kdbranches	=	kdbasedbranch(kdcodes,'SRNOT');
	/*$("#productspan").html(kdprod);
	$("#brandspan").html(kdbrand);*/
	$("#rsmspan").html(kdrsms);
	$("#asmspan").html(kdasms);
	$("#branchspan").html(kdbranches);
	//alert(kdprod);	
}

function getbrandspecific() {
	var brandcodes		=	$("#brandcode").val();
	if(brandcodes == '' || brandcodes == null) {
		$('.myalignsalper').html("ERR : Select Brand");
		$('#errormsgsalper').css('display','block');
		$("#brandcode option:selected").attr("selected",false);
		$("#prodcode option:selected").attr("selected",false);
		var brandprod			=	allproducts(brandcodes);
		$("#productspan").html(brandprod);

		setTimeout(function() {
			$('#errormsgsalper').hide();
		},5000);
		return false;
	}
	//alert(kdcodes);
	var brandprod		=	brandbasedproducts(brandcodes);
	$("#productspan").html(brandprod);
	//alert(kdprod);	
}

function getprodspecific() {
	var prodcodes		=	$("#prodcode").val();
	if(prodcodes == '' || prodcodes == null) {
		$('.myalignsalper').html("ERR : Select Product");
		$('#errormsgsalper').css('display','block');
		$("#brandcode option:selected").attr("selected",false);
		$("#prodcode option:selected").attr("selected",false);
		var prodbrand			=	allbrands(prodcodes);
		$("#brandspan").html(prodbrand);

		setTimeout(function() {
			$('#errormsgsalper').hide();
		},5000);
		return false;
	}
	//alert(kdcodes);
	var prodbrand		=	prodbasedbrands(prodcodes);
	$("#brandspan").html(prodbrand);
	//alert(kdprod);	
}

function getasmspecific() {
	var asmcodes		=	$("#asmcode").val();
	if(asmcodes == '' || asmcodes == null) {
		$('.myalignsalper').html("ERR : Select ASM");
		$('#errormsgsalper').css('display','block');
		$("#asmcode option:selected").attr("selected",false);
		var asmrsm				=	asmbasedrsm(asmcodes,'SRNOT');
		var asmkd				=	asmbasedkd(asmcodes,'asm_sp','SRNOT');
		var asmbranch			=	smbasedbranch(asmcodes,'asm_sp','SRNOT');
		$("#rsmspan").html(asmrsm);
		$("#branchspan").html(asmbranch);
		$("#kdspan").html(asmkd);

		setTimeout(function() {
			$('#errormsgsalper').hide();
		},5000);
		return false;
	}
	//alert(kdcodes);
	var asmrsm					=	asmbasedrsm(asmcodes,'SRNOT');
	var asmkd					=	asmbasedkd(asmcodes,'asm_sp','SRNOT');
	var asmbranch				=	smbasedbranch(asmcodes,'asm_sp','SRNOT');
	$("#rsmspan").html(asmrsm);
	$("#kdspan").html(asmkd);
	$("#branchspan").html(asmbranch);
	//alert(kdprod);	
}

function getrsmspecific() {
	var rsmcodes		=	$("#rsmcode").val();
	if(rsmcodes == '' || rsmcodes == null) {
		//alert(rsmcodes);
		$('.myalignsalper').html("ERR : Select RSM");
		$('#errormsgsalper').css('display','block');
		$("#rsmcode option:selected").attr("selected",false);
		var rsmasm				=	rsmbasedasm(rsmcodes,'SRNOT');
		var rsmkd				=	rsmbasedkd(rsmcodes,'rsm_sp','SRNOT');
		var rsmbranch			=	smbasedbranch(rsmcodes,'rsm_sp','SRNOT');
		$("#asmspan").html(rsmasm);
		$("#branchspan").html(rsmbranch);
		$("#kdspan").html(rsmkd);

		setTimeout(function() {
			$('#errormsgsalper').hide();
		},5000);
		return false;
	}
	//alert(rsmcodes);
	var rsmasm				=	rsmbasedasm(rsmcodes,'SRNOT');
	var rsmkd				=	rsmbasedkd(rsmcodes,'rsm_sp','SRNOT');
	var rsmbranch			=	smbasedbranch(rsmcodes,'rsm_sp','SRNOT');
	$("#asmspan").html(rsmasm);
	$("#kdspan").html(rsmkd);
	$("#branchspan").html(rsmbranch);
	//alert(kdprod);
}

function getbranchspecific() {
	var branchcodes		=	$("#branchcode").val();
	if(branchcodes == '' || branchcodes == null) {
		//alert(rsmcodes);
		$('.myalignsalper').html("ERR : Select Branch");
		$('#errormsgsalper').css('display','block');
		$("#rsmcode option:selected").attr("selected",false);
		var branchrsm			=	branchbasedsm(branchcodes,'rsm_sp','SRNOT');
		var branchasm			=	branchbasedsm(branchcodes,'asm_sp','SRNOT');
		var branchkd			=	branchbasedkd(branchcodes,'kd','SRNOT');
		$("#rsmspan").html(branchrsm);
		$("#asmspan").html(branchasm);
		$("#kdspan").html(branchkd);

		setTimeout(function() {
			$('#errormsgsalper').hide();
		},5000);
		return false;
	}
	//alert(rsmcodes);
	var branchrsm			=	branchbasedsm(branchcodes,'rsm_sp','SRNOT');
	var branchasm			=	branchbasedsm(branchcodes,'asm_sp','SRNOT');
	var branchkd			=	branchbasedkd(branchcodes,'kd','SRNOT');
	$("#rsmspan").html(branchrsm);
	$("#asmspan").html(branchasm);
	$("#kdspan").html(branchkd);		
}

function smbasedbranch(codeval,smval,srval) {
	codevalue					=		'';
	$.ajax({
		url			:	"getsmbasedbranch.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,
		data		:	{ "codeval" : codeval, "smval" : smval, "srval" : srval },
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			//alert(codevalue);
		}
	});
	return codevalue;	
}

function branchbasedsm (codeval,smval,srval) {
	codevalue					=		'';
	$.ajax({
		url			:	"getbranchbasedsm.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,
		data		:	{ "codeval" : codeval, "smval" : smval, "srval" : srval },
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			//alert(codevalue);
		}
	});
	return codevalue;	
}

function branchbasedkd (codeval,smval,srval) {
	codevalue					=		'';
	$.ajax({
		url			:	"getbranchbasedkd.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,
		data		:	{ "codeval" : codeval, "smval" : smval, "srval" : srval },
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			//alert(codevalue);
		}
	});
	return codevalue;	
}


function allkds(codeval,srval) {
	codevalue					=		'';
	$.ajax({
		url			:	"getallkds.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,
		data		:	{ "codeval" : codeval, "srval" : srval },
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			//alert(trimval);
		}
	});
	return codevalue;
}

function allproducts(codeval) {
	codevalue					=		'';
	$.ajax({
		url			:	"getallproducts.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,
		data		:	{ "codeval" : codeval },
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			//alert(trimval);
		}
	});
	return codevalue;
}

function allbrands(codeval) {
	codevalue					=		'';
	$.ajax({
		url			:	"getallbrands.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,
		data		:	{ "codeval" : codeval },
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			//alert(trimval);
		}
	});
	return codevalue;	
}

function brandbasedproducts(codeval) {
	codevalue					=		'';
	$.ajax({
		url			:	"getbrandbasedproducts.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,
		data		:	{ "codeval" : codeval },
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			//alert(trimval);
		}
	});
	return codevalue;
}

function prodbasedbrands(codeval) {
	codevalue					=		'';
	$.ajax({
		url			:	"getprodbasedbrands.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,
		data		:	{ "codeval" : codeval },
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			//alert(trimval);
		}
	});
	return codevalue;	
}

function asmbasedkd(codeval,smval,srval) {
	codevalue					=		'';
	$.ajax({
		url			:	"getsmbasedkd.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,
		data		:	{ "codeval" : codeval, "smval" : smval, "srval" : srval },
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			//alert(trimval);
		}
	});
	return codevalue;	
}

function rsmbasedkd(codeval,smval,srval) {
	codevalue					=		'';
	$.ajax({
		url			:	"getsmbasedkd.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,
		data		:	{ "codeval" : codeval, "smval" : smval, "srval" : srval },
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			//alert(trimval);
		}
	});
	return codevalue;	
}

function asmbasedrsm(codeval,srval) {
	codevalue					=		'';
	$.ajax({
		url			:	"getasmbasedrsm.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,
		data		:	{ "codeval" : codeval, "srval" : srval },
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			//alert(trimval);
		}
	});
	return codevalue;	
}

function rsmbasedasm(codeval,srval) {
	codevalue					=		'';
	$.ajax({
		url			:	"getrsmbasedasm.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,
		data		:	{ "codeval" : codeval, "srval" : srval },
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			//alert(trimval);
		}
	});
	return codevalue;	
}

function kdbasedbranch(codeval,srval) {
	codevalue					=		'';
	$.ajax({
		url			:	"getkdbasedbranch.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,
		data		:	{ "codeval" : codeval, "srval" : srval },
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			//alert(kdasm);
		}
	});
	return codevalue;
}

function kdbasedasm(codeval,srval) {
	codevalue					=		'';
	$.ajax({
		url			:	"getkdbasedasm.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,
		data		:	{ "codeval" : codeval, "srval" : srval },
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			//alert(kdasm);
		}
	});
	return codevalue;
}

function kdbasedrsm(codeval,srval) {
	codevalue					=		'';
	$.ajax({
		url			:	"getkdbasedrsm.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,
		data		:	{ "codeval" : codeval, "srval" : srval },
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			//alert(kdrsm);
		}
	});
	return codevalue;
}



function frequencychange(freqval) {
	if(freqval == 'Daily') {
		$("#dailylabel").css("display","block");
		$("#dailydate").css("display","block");
		$("#weeklabel").css("display","none");
		$("#monthlabel").css("display","none");
		$("#weeklydate").css("display","none");
		$("#monthlydate").css("display","none");
		$("#fromdate").css("display","none");
		$("#todate").css("display","none");
		$("#fromtolabel").css("display","none");
		$("#nofrequency").css("display","none");
	} if(freqval == 'Weekly') {
		$("#weeklabel").css("display","block");
		$("#weeklydate").css("display","block");
		$("#dailylabel").css("display","none");
		$("#monthlabel").css("display","none");
		$("#dailydate").css("display","none");
		$("#monthlydate").css("display","none");
		$("#fromdate").css("display","none");
		$("#todate").css("display","none");
		$("#fromtolabel").css("display","none");
		$("#nofrequency").css("display","none");
	} if(freqval == 'Monthly') {
		$("#monthlabel").css("display","block");
		$("#monthlydate").css("display","block");
		$("#dailylabel").css("display","none");		
		$("#weeklabel").css("display","none");
		$("#dailydate").css("display","none");
		$("#weeklydate").css("display","none");		
		$("#fromdate").css("display","none");
		$("#todate").css("display","none");
		$("#fromtolabel").css("display","none");
		$("#nofrequency").css("display","none");
	} if(freqval == 'Custom') {
		$("#fromdate").css("display","block");
		$("#todate").css("display","block");
		$("#fromtolabel").css("display","block");
		$("#dailylabel").css("display","none");
		$("#weeklabel").css("display","none");
		$("#monthlabel").css("display","none");
		$("#dailydate").css("display","none");
		$("#weeklydate").css("display","none");
		$("#monthlydate").css("display","none");
		$("#nofrequency").css("display","none");
	} 
}

function kdsalesperform() {
	var freqval			=	$("#freqval").val();
	var	reportby		=	$("#reportby").val();
	var	kdcode			=	$("#kdcode").val();
	var	brandcode		=	$("#brandcode").val();
	var	prodcode		=	$("#prodcode").val();
	var	asmcode			=	$("#asmcode").val();
	var	rsmcode			=	$("#rsmcode").val();
	var paramval		=	'';
	if(reportby	==	'') {
		//alert(reportby);
		$('.myalignsalper').html("ERR : Select Report By");
		$('#errormsgsalper').css('display','block');
		setTimeout(function() {
			$('#errormsgsalper').hide();
		},5000);
		return false;
	}
	if(freqval	==	'') {
		$('.myalignsalper').html("ERR : Select Frequency");
		$('#errormsgsalper').css('display','block');
		setTimeout(function() {
			$('#errormsgsalper').hide();
		},5000);
		return false;
	}
	if(freqval != '') {
		if(freqval == 'Daily') {
			var dateval	=	$("#dailydates").val();
			if(dateval == '') {
				$('.myalignsalper').html("ERR : Select Date");
				$('#errormsgsalper').css('display','block');
				setTimeout(function() {
					$('#errormsgsalper').hide();
				},5000);
				return false;
			} else {
				dt2 = parseInt(dateval.substring(8, 10), 10);
				mon2 = (parseInt(dateval.substring(5, 7), 10)) - 1;
				yr2 = parseInt(dateval.substring(0, 4), 10);
				date2		=	new Date(yr2, mon2, dt2);
				currdate	=	new Date();
				getday		=	date2.getDay();
				//alert(date2.getDay());
				if(date2 > currdate) {
					$('.myalignsalper').html("ERR : Date is greater than today date");
					$('#errormsgsalper').css('display','block');
					setTimeout(function() {
						$('#errormsgsalper').hide();
					},5000);
					return false;
				}
			}
		} if(freqval == 'Weekly') {
			var dateval	=	$("#weeklydates").val();
			if(dateval == '') {
				$('.myalignsalper').html("ERR : Select Week Start");
				$('#errormsgsalper').css('display','block');
				setTimeout(function() {
					$('#errormsgsalper').hide();
				},5000);
				return false;
			} else {
				dt2 = parseInt(dateval.substring(8, 10), 10);
				mon2 = (parseInt(dateval.substring(5, 7), 10)) - 1;
				yr2 = parseInt(dateval.substring(0, 4), 10);
				date2		=	new Date(yr2, mon2, dt2);
				currdate	=	new Date();
				getday		=	date2.getDay();
				//alert(date2.getDay());
				if(getday != 1) {
					$('.myalignsalper').html("ERR : Select Monday as the Start Date");
					$('#errormsgsalper').css('display','block');
					setTimeout(function() {
						$('#errormsgsalper').hide();
					},5000);
					return false;
				} if(date2 > currdate) {
					$('.myalignsalper').html("ERR : Date is greater than today date");
					$('#errormsgsalper').css('display','block');
					setTimeout(function() {
						$('#errormsgsalper').hide();
					},5000);
					return false;
				}				
			}
		} if(freqval == 'Monthly') {
			var propmonth	=	$("#propmonth").val();
			var propyear	=	$("#propyear").val();
			if(propmonth == '') {
				$('.myalignsalper').html("ERR : Select Month");
				$('#errormsgsalper').css('display','block');
				setTimeout(function() {
					$('#errormsgsalper').hide();
				},5000);
				return false;
			}
			if(propyear == '') {
				$('.myalignsalper').html("ERR : Select Year");
				$('#errormsgsalper').css('display','block');
				setTimeout(function() {
					$('#errormsgsalper').hide();
				},5000);
				return false;
			}
		} if(freqval == 'Custom') {
			var fromdateval	=	$("#fromdates").val();
			var todateval	=	$("#todates").val();

			var dt1		=	parseInt(fromdateval.substring(8, 10), 10);
			var mon1	=	(parseInt(fromdateval.substring(5, 7), 10)) - 1;
			var yr1		=	parseInt(fromdateval.substring(0, 4), 10);
			var date1	=	new Date(yr1, mon1, dt1);

			var dt2 = parseInt(todateval.substring(8, 10), 10);
			var mon2 = (parseInt(todateval.substring(5, 7), 10)) - 1;
			var yr2 = parseInt(todateval.substring(0, 4), 10);
			var date2		=	new Date(yr2, mon2, dt2);
			
			var splitdate1	=	fromdateval.split("-");
			var splitdate2	=	todateval.split("-");
			var date1mon	=	parseInt(splitdate1[1]);
			var date2mon	=	parseInt(splitdate2[1]);
			var date1year	=	splitdate1[0];
			var date2year	=	splitdate2[0];

			var currdate	=	new Date();
			if(fromdateval == '') {
				$('.myalignsalper').html("ERR : Select From Date");
				$('#errormsgsalper').css('display','block');
				setTimeout(function() {
					$('#errormsgsalper').hide();
				},5000);
				return false;
			} if(todateval == '') {
				$('.myalignsalper').html("ERR : Select To Date");
				$('#errormsgsalper').css('display','block');
				setTimeout(function() {
					$('#errormsgsalper').hide();
				},5000);
				return false;
			}
			if(date1 > currdate) {
				$('.myalignsalper').html("ERR : From Date is greater than today date");
				$('#errormsgsalper').css('display','block');
				setTimeout(function() {
					$('#errormsgsalper').hide();
				},5000);
				return false;
			} if(date2 > currdate) {
				$('.myalignsalper').html("ERR : To Date is greater than today date");
				$('#errormsgsalper').css('display','block');
				setTimeout(function() {
					$('#errormsgsalper').hide();
				},5000);
				return false;
			} if(date1 > date2) {
				$('.myalignsalper').html("ERR : From Date greater than To Date");
				$('#errormsgsalper').css('display','block');
				setTimeout(function() {
					$('#errormsgsalper').hide();
				},5000);
				return false;
			}
			if(date1mon	!=	date2mon) {
				$('.myalignsalper').html("ERR : Choose Dates from Same Month");
				$('#errormsgsalper').css('display','block');
				setTimeout(function() {
					$('#errormsgsalper').hide();
				},5000);
				return false;
			}
			if(date1year	!=	date2year) {
				$('.myalignsalper').html("ERR : Choose Dates from Same Year");
				$('#errormsgsalper').css('display','block');
				setTimeout(function() {
					$('#errormsgsalper').hide();
				},5000);
				return false;
			}
		}
	}
	var ajaxData		=	{ "freqval" : freqval, "reportby" : reportby, "kdcode" : kdcode, "brandcode" : brandcode, "prodcode" : prodcode, "asmcode" : asmcode, "rsmcode" : rsmcode };
	if(freqval  == 'Daily') {
		ajaxData.datevalue = dateval;
		ajaxData.freq = 1;
	} else if(freqval  == 'Weekly') {
		ajaxData.datevalue = dateval;
		ajaxData.freq = 2;
	} else if(freqval  == 'Monthly') {
		ajaxData.propmonths = propmonth;
		ajaxData.propyears = propyear;
		ajaxData.freq = 3;
	} else if(freqval  == 'Custom') {
		ajaxData.fromdatevalue = fromdateval;
		ajaxData.todatevalue = todateval;
		ajaxData.freq = 4;
	}

	$.ajax({
		url			:	"getkdsalesperfreport.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,		
		data		:	ajaxData,
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			$("#ajaxresultpage").html(codevalue);
			//alert(codevalue);
		}
	});
}

function kdsaleslist() {
	var	kdcode			=	$("#kdcode").val();
	var	brandcode		=	$("#brandcode").val();
	var	prodcode		=	$("#prodcode").val();
	var	asmcode			=	$("#asmcode").val();
	var	rsmcode			=	$("#rsmcode").val();
	var paramval		=	'';

	var fromdateval	=	$("#fromdates").val();
	var todateval	=	$("#todates").val();

	var dt1		=	parseInt(fromdateval.substring(8, 10), 10);
	var mon1	=	(parseInt(fromdateval.substring(5, 7), 10)) - 1;
	var yr1		=	parseInt(fromdateval.substring(0, 4), 10);
	var date1	=	new Date(yr1, mon1, dt1);

	var dt2 = parseInt(todateval.substring(8, 10), 10);
	var mon2 = (parseInt(todateval.substring(5, 7), 10)) - 1;
	var yr2 = parseInt(todateval.substring(0, 4), 10);
	var date2		=	new Date(yr2, mon2, dt2);

	var currdate	=	new Date();
	if(fromdateval == '') {
		$('.myalignsalper').html("ERR : Select From Date");
		$('#errormsgsalper').css('display','block');
		setTimeout(function() {
			$('#errormsgsalper').hide();
		},5000);
		return false;
	} if(todateval == '') {
		$('.myalignsalper').html("ERR : Select To Date");
		$('#errormsgsalper').css('display','block');
		setTimeout(function() {
			$('#errormsgsalper').hide();
		},5000);
		return false;
	}
	if(date1 > currdate) {
		$('.myalignsalper').html("ERR : From Date is greater than today date");
		$('#errormsgsalper').css('display','block');
		setTimeout(function() {
			$('#errormsgsalper').hide();
		},5000);
		return false;
	} if(date2 > currdate) {
		$('.myalignsalper').html("ERR : To Date is greater than today date");
		$('#errormsgsalper').css('display','block');
		setTimeout(function() {
			$('#errormsgsalper').hide();
		},5000);
		return false;
	} if(date1 > date2) {
		$('.myalignsalper').html("ERR : From Date greater than To Date");
		$('#errormsgsalper').css('display','block');
		setTimeout(function() {
			$('#errormsgsalper').hide();
		},5000);
		return false;
	}

	var ajaxData		=	{ "kdcode" : kdcode, "brandcode" : brandcode, "prodcode" : prodcode, "asmcode" : asmcode, "rsmcode" : rsmcode,"fromdatevalue" : fromdateval,"todatevalue" : todateval  };

	$.ajax({
		url			:	"getkdsaleslistreport.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,		
		data		:	ajaxData,
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			$("#ajaxresultpage").html(codevalue);
			//alert(codevalue);
		}
	});
}

function print_pages(formid) { // For pagination of the device transaction ajax result page
	//alert($('#transno').val());
	document.forms[formid].submit();
}
function hideprintbutton() {
	$("#printopen").css({"display":"none"});
	$("#showviewbutton").css({"display":"none"});
	//$(".paginationfile").css({"display":"none"});
	window.print();
}


function kdsalesfocusperform () {
	var freqval			=	$("#freqval").val();
	var	reportby		=	$("#reportby").val();
	var	kdcode			=	$("#kdcode").val();
	var	brandcode		=	$("#brandcode").val();
	var	prodcode		=	$("#prodcode").val();
	var	asmcode			=	$("#asmcode").val();
	var	rsmcode			=	$("#rsmcode").val();
	var paramval		=	'';
	if(reportby	==	'') {
		//alert(reportby);
		$('.myalignsalper').html("ERR : Select Report By");
		$('#errormsgsalper').css('display','block');
		setTimeout(function() {
			$('#errormsgsalper').hide();
		},5000);
		return false;
	}
	if(freqval	==	'') {
		$('.myalignsalper').html("ERR : Select Frequency");
		$('#errormsgsalper').css('display','block');
		setTimeout(function() {
			$('#errormsgsalper').hide();
		},5000);
		return false;
	}
	if(freqval != '') {
		if(freqval == 'Daily') {
			var dateval	=	$("#dailydates").val();
			if(dateval == '') {
				$('.myalignsalper').html("ERR : Select Date");
				$('#errormsgsalper').css('display','block');
				setTimeout(function() {
					$('#errormsgsalper').hide();
				},5000);
				return false;
			} else {
				dt2 = parseInt(dateval.substring(8, 10), 10);
				mon2 = (parseInt(dateval.substring(5, 7), 10)) - 1;
				yr2 = parseInt(dateval.substring(0, 4), 10);
				date2		=	new Date(yr2, mon2, dt2);
				currdate	=	new Date();
				getday		=	date2.getDay();
				//alert(date2.getDay());
				if(date2 > currdate) {
					$('.myalignsalper').html("ERR : Date is greater than today date");
					$('#errormsgsalper').css('display','block');
					setTimeout(function() {
						$('#errormsgsalper').hide();
					},5000);
					return false;
				}
			}
		} if(freqval == 'Weekly') {
			var dateval	=	$("#weeklydates").val();
			if(dateval == '') {
				$('.myalignsalper').html("ERR : Select Week Start");
				$('#errormsgsalper').css('display','block');
				setTimeout(function() {
					$('#errormsgsalper').hide();
				},5000);
				return false;
			} else {
				dt2 = parseInt(dateval.substring(8, 10), 10);
				mon2 = (parseInt(dateval.substring(5, 7), 10)) - 1;
				yr2 = parseInt(dateval.substring(0, 4), 10);
				date2		=	new Date(yr2, mon2, dt2);
				currdate	=	new Date();
				getday		=	date2.getDay();
				//alert(date2.getDay());
				if(getday != 1) {
					$('.myalignsalper').html("ERR : Select Monday as the Start Date");
					$('#errormsgsalper').css('display','block');
					setTimeout(function() {
						$('#errormsgsalper').hide();
					},5000);
					return false;
				} if(date2 > currdate) {
					$('.myalignsalper').html("ERR : Date is greater than today date");
					$('#errormsgsalper').css('display','block');
					setTimeout(function() {
						$('#errormsgsalper').hide();
					},5000);
					return false;
				}				
			}
		} if(freqval == 'Monthly') {
			var propmonth	=	$("#propmonth").val();
			var propyear	=	$("#propyear").val();
			if(propmonth == '') {
				$('.myalignsalper').html("ERR : Select Month");
				$('#errormsgsalper').css('display','block');
				setTimeout(function() {
					$('#errormsgsalper').hide();
				},5000);
				return false;
			}
			if(propyear == '') {
				$('.myalignsalper').html("ERR : Select Year");
				$('#errormsgsalper').css('display','block');
				setTimeout(function() {
					$('#errormsgsalper').hide();
				},5000);
				return false;
			}
		} if(freqval == 'Custom') {
			var fromdateval	=	$("#fromdates").val();
			var todateval	=	$("#todates").val();

			var dt1		=	parseInt(fromdateval.substring(8, 10), 10);
			var mon1	=	(parseInt(fromdateval.substring(5, 7), 10)) - 1;
			var yr1		=	parseInt(fromdateval.substring(0, 4), 10);
			var date1	=	new Date(yr1, mon1, dt1);

			var dt2 = parseInt(todateval.substring(8, 10), 10);
			var mon2 = (parseInt(todateval.substring(5, 7), 10)) - 1;
			var yr2 = parseInt(todateval.substring(0, 4), 10);
			var date2		=	new Date(yr2, mon2, dt2);

			var splitdate1	=	fromdateval.split("-");
			var splitdate2	=	todateval.split("-");
			var date1mon	=	parseInt(splitdate1[1]);
			var date2mon	=	parseInt(splitdate2[1]);
			var date1year	=	splitdate1[0];
			var date2year	=	splitdate2[0];

			var currdate	=	new Date();
			if(fromdateval == '') {
				$('.myalignsalper').html("ERR : Select From Date");
				$('#errormsgsalper').css('display','block');
				setTimeout(function() {
					$('#errormsgsalper').hide();
				},5000);
				return false;
			} if(todateval == '') {
				$('.myalignsalper').html("ERR : Select To Date");
				$('#errormsgsalper').css('display','block');
				setTimeout(function() {
					$('#errormsgsalper').hide();
				},5000);
				return false;
			}
			if(date1 > currdate) {
				$('.myalignsalper').html("ERR : From Date is greater than today date");
				$('#errormsgsalper').css('display','block');
				setTimeout(function() {
					$('#errormsgsalper').hide();
				},5000);
				return false;
			} if(date2 > currdate) {
				$('.myalignsalper').html("ERR : To Date is greater than today date");
				$('#errormsgsalper').css('display','block');
				setTimeout(function() {
					$('#errormsgsalper').hide();
				},5000);
				return false;
			} if(date1 > date2) {
				$('.myalignsalper').html("ERR : From Date greater than To Date");
				$('#errormsgsalper').css('display','block');
				setTimeout(function() {
					$('#errormsgsalper').hide();
				},5000);
				return false;
			}
			if(date1mon	!=	date2mon) {
				$('.myalignsalper').html("ERR : Choose Dates from Same Month");
				$('#errormsgsalper').css('display','block');
				setTimeout(function() {
					$('#errormsgsalper').hide();
				},5000);
				return false;
			}
			if(date1year	!=	date2year) {
				$('.myalignsalper').html("ERR : Choose Dates from Same Year");
				$('#errormsgsalper').css('display','block');
				setTimeout(function() {
					$('#errormsgsalper').hide();
				},5000);
				return false;
			}
		}
	}
	var ajaxData		=	{ "freqval" : freqval, "reportby" : reportby, "kdcode" : kdcode, "brandcode" : brandcode, "prodcode" : prodcode, "asmcode" : asmcode, "rsmcode" : rsmcode };
	if(freqval  == 'Daily') {
		ajaxData.datevalue = dateval;
		ajaxData.freq = 1;
	} else if(freqval  == 'Weekly') {
		ajaxData.datevalue = dateval;
		ajaxData.freq = 2;
	} else if(freqval  == 'Monthly') {
		ajaxData.propmonths = propmonth;
		ajaxData.propyears = propyear;
		ajaxData.freq = 3;
	} else if(freqval  == 'Custom') {
		ajaxData.fromdatevalue = fromdateval;
		ajaxData.todatevalue = todateval;
		ajaxData.freq = 4;
	}

	$.ajax({
		url			:	"getkdsalesfocusperfreport.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,		
		data		:	ajaxData,
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			$("#ajaxresultpage").html(codevalue);
			//alert(codevalue);
		}
	});
}

function getKDspecificwithsr() {
	var kdcodes		=	$("#kdcode").val();
	if(kdcodes == '' ||  kdcodes == null) {
		$('.myalignkdcov').html("ERR : Select KD");
		$('#errormsgkdcov').css('display','block');
		$("#kdcode option:selected").attr("selected",false);
		/*$("#brandcode option:selected").attr("selected",false);
		$("#prodcode option:selected").attr("selected",false);*/
		$("#rsmcode option:selected").attr("selected",false);
		$("#asmcode option:selected").attr("selected",false);
		/*var kdprod		=	allproducts(kdcodes);
		var kdbrand		=	allbrands(kdcodes);*/
		var kdasms		=	kdbasedasm(kdcodes,'SRIN');
		var kdrsms		=	kdbasedrsm(kdcodes,'SRIN');
		var kdsrs		=	kdbasedsr(kdcodes,'SRIN');
		//var kdkds		=	allkds(kdcodes,'SRIN');
		var kdbranches	=	kdbasedbranch(kdcodes,'SRIN');
		/*$("#productspan").html(kdprod);
		$("#brandspan").html(kdbrand);*/
		$("#rsmspan").html(kdrsms);
		$("#asmspan").html(kdasms);
		//$("#kdspan").html(kdkds);
		$("#srspan").html(kdsrs);
		$("#branchspan").html(kdbranches);
		
		setTimeout(function() {
			$('#errormsgkdcov').hide();
		},5000);
		return false;
	}
	//alert(kdcodes);
	/*var kdprod		=	kdbasedproducts(kdcodes);
	var kdbrand		=	kdbasedbrands(kdcodes);*/
	var kdasms		=	kdbasedasm(kdcodes,'SRIN');
	var kdrsms		=	kdbasedrsm(kdcodes,'SRIN');
	var kdsrs		=	kdbasedsr(kdcodes,'SRIN');
	var kdbranches	=	kdbasedbranch(kdcodes,'SRNOT');
	/*$("#productspan").html(kdprod);
	$("#brandspan").html(kdbrand);*/
	$("#rsmspan").html(kdrsms);
	$("#asmspan").html(kdasms);
	$("#srspan").html(kdsrs);
	$("#branchspan").html(kdbranches);
	//alert(kdprod);	
}

function getsrspecific() {
	var srcodes		=	$("#srcode").val();
	if(srcodes == '' || srcodes == null) {
		$('.myalignkdcov').html("ERR : Select SR");
		$('#errormsgkdcov').css('display','block');
		$("#srcode option:selected").attr("selected",false);
		var srasm			=	srbasedsm(srcodes,'asm_sp','SRIN');
		var srrsm			=	srbasedsm(srcodes,'rsm_sp','SRIN');
		var srkd			=	srbasedkd(srcodes,'SRIN');
		var srbranch		=	srbasedsm(srcodes,'branch','SRIN');
		$("#asmspan").html(srasm);
		$("#rsmspan").html(srrsm);
		$("#kdspan").html(srkd);
		$("#branchspan").html(srbranch);


		setTimeout(function() {
			$('#errormsgkdcov').hide();
		},5000);
		return false;
	}
	//alert(kdcodes);
	var srasm				=	srbasedsm(srcodes,'asm_sp','SRIN');
	var srrsm				=	srbasedsm(srcodes,'rsm_sp','SRIN');
	var srkd				=	srbasedkd(srcodes,'SRIN');
	var srbranch			=	srbasedsm(srcodes,'branch','SRIN');
	$("#asmspan").html(srasm);
	$("#rsmspan").html(srrsm);
	$("#kdspan").html(srkd);
	$("#branchspan").html(srbranch);
	//alert(kdprod);	
}

function getasmspecificwithsr() {
	var asmcodes		=	$("#asmcode").val();
	if(asmcodes == '' || asmcodes == null) {
		$('.myalignkdcov').html("ERR : Select ASM");
		$('#errormsgkdcov').css('display','block');
		$("#asmcode option:selected").attr("selected",false);
		var asmrsm				=	asmbasedrsm(asmcodes,'SRIN');
		var asmsr				=	smbasedsr(asmcodes,'asm_sp','SRIN');
		var asmkd				=	asmbasedkd(asmcodes,'asm_sp','SRIN');
		var asmbranch			=	smbasedbranch(asmcodes,'asm_sp','SRIN');
		$("#rsmspan").html(asmrsm);
		$("#srspan").html(asmsr);
		$("#branchspan").html(asmbranch);
		$("#kdspan").html(asmkd);

		setTimeout(function() {
			$('#errormsgkdcov').hide();
		},5000);
		return false;
	}
	//alert(kdcodes);
	var asmrsm					=	asmbasedrsm(asmcodes,'SRIN');
	var asmsr					=	smbasedsr(asmcodes,'asm_sp','SRIN');
	var asmkd					=	asmbasedkd(asmcodes,'asm_sp','SRIN');
	var asmbranch				=	smbasedbranch(asmcodes,'asm_sp','SRIN');
	$("#rsmspan").html(asmrsm);
	$("#kdspan").html(asmkd);
	$("#srspan").html(asmsr);
	$("#branchspan").html(asmbranch);
	//alert(kdprod);	
}

function getrsmspecificwithsr() {
	var rsmcodes		=	$("#rsmcode").val();
	if(rsmcodes == '' || rsmcodes == null) {
		//alert(rsmcodes);
		$('.myalignkdcov').html("ERR : Select RSM");
		$('#errormsgkdcov').css('display','block');
		$("#rsmcode option:selected").attr("selected",false);
		var rsmasm				=	rsmbasedasm(rsmcodes,'SRIN');
		var asmsr				=	smbasedsr(rsmcodes,'rsm_sp','SRIN');
		var rsmkd				=	rsmbasedkd(rsmcodes,'rsm_sp','SRIN');
		var rsmbranch			=	smbasedbranch(rsmcodes,'rsm_sp','SRIN');
		$("#asmspan").html(rsmasm);
		$("#srspan").html(asmsr);
		$("#kdspan").html(rsmkd);
		$("#branchspan").html(rsmbranch);

		setTimeout(function() {
			$('#errormsgkdcov').hide();
		},5000);
		return false;
	}
	//alert(rsmcodes);
	var rsmasm		=	rsmbasedasm(rsmcodes,'SRIN');
	var rsmsr		=	smbasedsr(rsmcodes,'rsm_sp','SRIN');
	var rsmkd		=	rsmbasedkd(rsmcodes,'rsm_sp','SRIN');
	var rsmbranch	=	smbasedbranch(rsmcodes,'rsm_sp','SRIN');
	$("#asmspan").html(rsmasm);
	$("#kdspan").html(rsmkd);
	$("#srspan").html(rsmsr);
	$("#branchspan").html(rsmbranch);
	//alert(kdprod);	
}

function getbranchspecificwithsr() {
	var branchcodes		=	$("#branchcode").val();
	if(branchcodes == '' || branchcodes == null) {
		//alert(rsmcodes);
		$('.myalignsrsta').html("ERR : Select Branch");
		$('#errormsgsrsta').css('display','block');
		$("#rsmcode option:selected").attr("selected",false);
		var branchrsm			=	branchbasedsm(branchcodes,'rsm_sp','SRIN');
		var branchasm			=	branchbasedsm(branchcodes,'asm_sp','SRIN');
		var branchsr			=	branchbasedsm(branchcodes,'dsr','SRIN');
		var branchkd			=	branchbasedkd(branchcodes,'kd','SRIN');
		$("#rsmspan").html(branchrsm);
		$("#asmspan").html(branchasm);
		$("#srspan").html(branchsr);
		$("#kdspan").html(branchkd);

		setTimeout(function() {
			$('#errormsgsrsta').hide();
		},5000);
		return false;
	}
	//alert(rsmcodes);
	var branchrsm			=	branchbasedsm(branchcodes,'rsm_sp','SRIN');
	var branchasm			=	branchbasedsm(branchcodes,'asm_sp','SRIN');
	var branchsr			=	branchbasedsm(branchcodes,'dsr','SRIN');
	var branchkd			=	branchbasedkd(branchcodes,'kd','SRIN');
	$("#rsmspan").html(branchrsm);
	$("#asmspan").html(branchasm);
	$("#srspan").html(branchsr);
	$("#kdspan").html(branchkd);
	//alert(kdprod);	
}

function branchbasedsm (codeval,smval,srval) {
	codevalue					=		'';
	$.ajax({
		url			:	"getbranchbasedsm.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,
		data		:	{ "codeval" : codeval, "smval" : smval, "srval" : srval },
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			//alert(codevalue);
		}
	});
	return codevalue;	
}

function srbasedsm(codeval,smval,srval) {
	codevalue					=		'';
	$.ajax({
		url			:	"getsrbasedsm.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,
		data		:	{ "codeval" : codeval, "smval" : smval, "srval" : srval },
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			//alert(codevalue);
		}
	});
	return codevalue;	
}

function smbasedsr(codeval,smval,srval) {
	codevalue					=		'';
	$.ajax({
		url			:	"getsmbasedsr.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,
		data		:	{ "codeval" : codeval, "smval" : smval, "srval" : srval },
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			//alert(codevalue);
		}
	});
	return codevalue;	
}


function kdbasedsr(codeval,srval) {
	codevalue					=		'';
	$.ajax({
		url			:	"getkdbasedsr.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,
		data		:	{ "codeval" : codeval, "srval" : srval },
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			//alert(kdrsm);
		}
	});
	return codevalue;
}

function srbasedkd(codeval,srval) {
	codevalue					=		'';
	$.ajax({
		url			:	"getsrbasedkd.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,
		data		:	{ "codeval" : codeval, "srval" : srval },
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			//alert(kdrsm);
		}
	});
	return codevalue;
}

function kdcoveragecheck() {
	var propmonth		=	$("#propmonth").val();
	var propyear		=	$("#propyear").val();
	var	reportby		=	$("#reportby").val();
	var	kdcode			=	$("#kdcode").val();
	var	asmcode			=	$("#asmcode").val();
	var	rsmcode			=	$("#rsmcode").val();
	var	srcode			=	$("#srcode").val();
	if(propmonth == '') {
		$('.myalignkdcov').html("ERR : Select Month");
		$('#errormsgkdcov').css('display','block');
		setTimeout(function() {
			$('#errormsgkdcov').hide();
		},5000);
		return false;
	}
	if(propyear == '') {
		$('.myalignkdcov').html("ERR : Select Year");
		$('#errormsgkdcov').css('display','block');
		setTimeout(function() {
			$('#errormsgkdcov').hide();
		},5000);
		return false;
	}
	if(reportby	==	'') {
		//alert(reportby);
		$('.myalignkdcov').html("ERR : Select Report By");
		$('#errormsgkdcov').css('display','block');
		setTimeout(function() {
			$('#errormsgkdcov').hide();
		},5000);
		return false;
	}
	var ajaxData		=	{ "reportby" : reportby, "propmonths" : propmonth, "propyears" : propyear, "kdcode" : kdcode, "srcode" : srcode, "asmcode" : asmcode, "rsmcode" : rsmcode };

	$.ajax({
		url			:	"getkdcoveragereport.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,		
		data		:	ajaxData,
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			$("#ajaxresultpage").html(codevalue);
			//alert(codevalue);
		}
	});
}

function kdoutstanding() {
	var propmonth		=	$("#propmonth").val();
	var propyear		=	$("#propyear").val();
	var	reportby		=	$("#reportby").val();
	var	kdcode			=	$("#kdcode").val();
	var	asmcode			=	$("#asmcode").val();
	var	rsmcode			=	$("#rsmcode").val();
	var	srcode			=	$("#srcode").val();
	if(propmonth == '') {
		$('.myalignkdout').html("ERR : Select Month");
		$('#errormsgkdout').css('display','block');
		setTimeout(function() {
			$('#errormsgkdout').hide();
		},5000);
		return false;
	}
	if(propyear == '') {
		$('.myalignkdout').html("ERR : Select Year");
		$('#errormsgkdout').css('display','block');
		setTimeout(function() {
			$('#errormsgkdout').hide();
		},5000);
		return false;
	}
	if(reportby	==	'') {
		//alert(reportby);
		$('.myalignkdout').html("ERR : Select Report By");
		$('#errormsgkdout').css('display','block');
		setTimeout(function() {
			$('#errormsgkdout').hide();
		},5000);
		return false;
	}
	var ajaxData		=	{ "reportby" : reportby, "propmonths" : propmonth, "propyears" : propyear, "kdcode" : kdcode, "srcode" : srcode, "asmcode" : asmcode, "rsmcode" : rsmcode };

	$.ajax({
		url			:	"getkdoutreport.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,		
		data		:	ajaxData,
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			$("#ajaxresultpage").html(codevalue);
			//alert(codevalue);
		}
	});
}


function getKDspecifictranslist() {
	var kdcodes		=	$("#kdcode").val();
	if(kdcodes == '') {
		$('.myaligntranslist').html("ERR : Select KD");
		$('#errormsgtranslist').css('display','block');
		$("#kdcode option:selected").attr("selected",false);
		$("#srcode option:selected").attr("selected",false);
		var kdsrs		=	kdbasedsr(kdcodes,'SRTRANS');
		//var kdkds		=	allkds(kdcodes,'SRTRANS');
		//$("#kdspan").html(kdkds);
		$("#srspan").html(kdsrs);
		
		setTimeout(function() {
			$('#errormsgtranslist').hide();
		},5000);
		return false;
	}
	var kdsrs		=	kdbasedsr(kdcodes,'SRTRANS');
	$("#srspan").html(kdsrs);
}

function getsrtranslist() {
	var srcodes		=	$("#srcode").val();
	if(srcodes == '') {
		$('.myaligntranslist').html("ERR : Select SR");
		$('#errormsgtranslist').css('display','block');
		$("#srcode option:selected").attr("selected",false);
		var srkd			=	srbasedkd(srcodes,'SRTRANS');
		//var srsrs			=	allsrs(srcodes,'SRTRANS');
		$("#kdspan").html(srkd);
		//$("#srspan").html(srsrs);

		setTimeout(function() {
			$('#errormsgtranslist').hide();
		},5000);
		return false;
	}
	//alert(kdcodes);
	var srkd		=	srbasedkd(srcodes,'SRTRANS');
	$("#kdspan").html(srkd);
	//alert(kdprod);	
}

function allsrs(codeval,srval) {
	codevalue					=		'';
	$.ajax({
		url			:	"getallsrs.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,
		data		:	{ "codeval" : codeval, "srval" : srval },
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			//alert(trimval);
		}
	});
	return codevalue;
}

function kdtranslist() {
	var	kdcode			=	$("#kdcode").val();
	var	srcode			=	$("#srcode").val();
	var	cuscode			=	$("#cuscode").val();

	var fromdateval	=	$("#fromdates").val();
	var todateval	=	$("#todates").val();

	var dt1		=	parseInt(fromdateval.substring(8, 10), 10);
	var mon1	=	(parseInt(fromdateval.substring(5, 7), 10)) - 1;
	var yr1		=	parseInt(fromdateval.substring(0, 4), 10);
	var date1	=	new Date(yr1, mon1, dt1);

	var dt2 = parseInt(todateval.substring(8, 10), 10);
	var mon2 = (parseInt(todateval.substring(5, 7), 10)) - 1;
	var yr2 = parseInt(todateval.substring(0, 4), 10);
	var date2		=	new Date(yr2, mon2, dt2);

	var currdate	=	new Date();
	if(fromdateval == '') {
		$('.myaligntranslist').html("ERR : Select From Date");
		$('#errormsgtranslist').css('display','block');
		setTimeout(function() {
			$('#errormsgtranslist').hide();
		},5000);
		return false;
	} if(todateval == '') {
		$('.myaligntranslist').html("ERR : Select To Date");
		$('#errormsgtranslist').css('display','block');
		setTimeout(function() {
			$('#errormsgtranslist').hide();
		},5000);
		return false;
	}
	if(date1 > currdate) {
		$('.myaligntranslist').html("ERR : From Date is greater than today date");
		$('#errormsgtranslist').css('display','block');
		setTimeout(function() {
			$('#errormsgtranslist').hide();
		},5000);
		return false;
	} if(date2 > currdate) {
		$('.myaligntranslist').html("ERR : To Date is greater than today date");
		$('#errormsgtranslist').css('display','block');
		setTimeout(function() {
			$('#errormsgtranslist').hide();
		},5000);
		return false;
	} if(date1 > date2) {
		$('.myaligntranslist').html("ERR : From Date greater than To Date");
		$('#errormsgtranslist').css('display','block');
		setTimeout(function() {
			$('#errormsgtranslist').hide();
		},5000);
		return false;
	}

	var ajaxData		=	{ "fromdatevalue" : fromdateval, "todatevalue" : todateval, "kdcode" : kdcode, "srcode" : srcode, "cuscode" : cuscode };

	$.ajax({
		url			:	"gettranslistreport.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,		
		data		:	ajaxData,
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			$("#ajaxresultpage").html(codevalue);
			//alert(codevalue);
		}
	});
}

function getKDstockledger() {
	var kdcode	=	$("#kdcode").val();
	//alert(kdcode);
	if(kdcode == '') {
		$('.myalignkdstockled').html("ERR : Select KD");
		$('#errormsgkdstockled').css('display','block');
		$("#kdcode").focus();
		setTimeout(function() {
			$('#errormsgkdstockled').hide();
		},5000);
		return false;
	}
	var ajaxData		=	{ "kdcode" : kdcode };
	$.ajax({
		url			:	"getkdstockledger.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,		
		data		:	ajaxData,
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			$("#ajaxresultpage").html(codevalue);
			//alert(codevalue);
		}
	});
}

function getKDvehiclestockledger() {
	var kdcode	=	$("#kdcode").val();
	//alert(kdcode);
	if(kdcode == '') {
		$('.myalignkdvehstockled').html("ERR : Select KD");
		$('#errormsgkdvehstockled').css('display','block');
		$("#kdcode").focus();
		setTimeout(function() {
			$('#errormsgkdvehstockled').hide();
		},5000);
		return false;
	}
	$("#loadingmessagediv").show();
	var ajaxData		=	{ "kdcode" : kdcode };
	$.ajax({
		url			:	"getkdvehstockledger.php",
		type		:	"get",
		dataType	:	"text",
		async		:	false,		
		data		:	ajaxData,
		complete: function() {
            $("#loadingmessagediv").hide();
		},
		success		:	function(dataval) {
			codevalue		=	$.trim(dataval);
			$("#ajaxresultpage").html(codevalue);
			//alert(codevalue);
		}
	});
}


/* Added on 16062013 ends here */