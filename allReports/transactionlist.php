<?php
ob_start();
include('../include/header.php');
include "../include/ps_pagination.php";
require_once "../include/ajax_pagination.php";

//ini_set("display_errors",false);
//echo ini_get("display_errors");
if(isset($_GET['logout'])){
	session_destroy();
	header("Location:../index.php");
}
extract($_REQUEST);
$msg								=	'';
$query_DSR 							=	"select id,DSRName,DSR_Code from dsr";
$res_DSR 							=	mysql_query($query_DSR) or die(mysql_error());

$query_KD 							=	"select id,KD_Name,KD_Code from kd";
$res_KD 							=	mysql_query($query_KD) or die(mysql_error());

$query_cus 							=	"select id,customer_code,Customer_Name from customer";
$res_cus 							=	mysql_query($query_cus) or die(mysql_error());

$kdstr								=	getdbstr('KD_Code','kd');
$srstr								=	getdbstr('DSR_Code','dsr');
$cusstr								=	getdbstr('customer_code','customer');

$id									=	isset($_REQUEST['id']);
?>
<!------------------------------- Form -------------------------------------------------->



<!--  DROPBOX LIST JS AND CSS STARTS HERE -->

<link rel="stylesheet" type="text/css" href="../css/droplist/jquery-ui-1.8.13.custom.css">
<link rel="stylesheet" type="text/css" href="../css/droplist/ui.dropdownchecklist.themeroller.css">

<script type="text/javascript" src="../js/droplist/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="../js/droplist/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="../js/droplist/ui.dropdownchecklist.js"></script>

<script type="text/javascript">
$(document).ready(function() {

	//$( "#datepicker" ).datepicker();

	$( ".datepicker" ).datepicker();

	//$("#srcode").dropdownchecklist( width: 250 } ); 

	 $("#kdcode").dropdownchecklist( { textFormatFunction: function(options) {
                var selectedOptions = options.filter(":selected");
                var countOfSelected = selectedOptions.size();
				var listCnt		=	options.size() - 1;
                switch(countOfSelected) {
                    case 0: { 
						return "---KD---";
					}
                    case 1: return selectedOptions.text();
                    case listCnt: return "ALL";
                    default: {
						var kdcodes		=	$("#kdcode").val();
						if($.isArray(kdcodes)) {
							var myArray = $("#kdcode option:selected").map(function() {
								 return $(this).text();
							  }).get();
							 
							//alert(myArray);
							if(myArray.indexOf(" ALL") != -1) {			
								return " ALL";
							} else {
								if(myArray.indexOf("---KD---") != -1) {			
									if(countOfSelected == 2) {
										var textval			=	selectedOptions.text();
										textval = textval.replace("---KD---", "");
										//alert(textval);
										return textval;
									} else {
										//alert(countOfSelected);
										//alert(listCnt);
										return " Multiple";
									}
								} else {
									//alert('23');
									//alert(countOfSelected);
									//alert(listCnt);
									var listCntVal		=	listCnt - 1;
									if(countOfSelected == listCntVal) {
										return " ALL";
									} else {
										return " Multiple";
									}
								}
							}
						}											
					}
                }
	 },width:170 });


	$("#srcode").dropdownchecklist( { textFormatFunction: function(options) {
                var selectedOptions = options.filter(":selected");
                var countOfSelected = selectedOptions.size();
				var listCnt		=	options.size() - 1;
                switch(countOfSelected) {
                    case 0: { 
						return "---SR---";
					}
                    case 1: return selectedOptions.text();
                    case listCnt: return "ALL";
                    default: {
						var srcodes		=	$("#srcode").val();
						if($.isArray(srcodes)) {
							var myArray = $("#srcode option:selected").map(function() {
								 return $(this).text();
							  }).get();
							 
							//alert(myArray);
							if(myArray.indexOf(" ALL") != -1) {			
								return " ALL";
							} else {
								if(myArray.indexOf("---SR---") != -1) {			
									if(countOfSelected == 2) {
										var textval			=	selectedOptions.text();
										textval = textval.replace("---SR---", "");
										//alert(textval);
										return textval;
									} else {
										//alert(countOfSelected);
										//alert(listCnt);
										return " Multiple";
									}
								} else {
									//alert('23');
									//alert(countOfSelected);
									//alert(listCnt);
									var listCntVal		=	listCnt - 1;
									if(countOfSelected == listCntVal) {
										return " ALL";
									} else {
										return " Multiple";
									}
								}
							}
						}											
					}
                }
	 },width:170 });

	$("#cuscode").dropdownchecklist( { textFormatFunction: function(options) {
                var selectedOptions = options.filter(":selected");
                var countOfSelected = selectedOptions.size();
				var listCnt		=	options.size() - 1;
                switch(countOfSelected) {
                    case 0: { 
						return "---CUSTOMER---";
					}
                    case 1: return selectedOptions.text();
                    case listCnt: return "ALL";
                    default: {
						var cuscodes		=	$("#cuscode").val();
						if($.isArray(cuscodes)) {
							var myArray = $("#cuscode option:selected").map(function() {
								 return $(this).text();
							  }).get();
							 
							//alert(myArray);
							if(myArray.indexOf(" ALL") != -1) {			
								return " ALL";
							} else {
								if(myArray.indexOf("---CUSTOMER---") != -1) {			
									if(countOfSelected == 2) {
										var textval			=	selectedOptions.text();
										textval = textval.replace("---CUSTOMER---", "");
										//alert(textval);
										return textval;
									} else {
										//alert(countOfSelected);
										//alert(listCnt);
										return " Multiple";
									}
								} else {
									//alert('23');
									//alert(countOfSelected);
									//alert(listCnt);
									var listCntVal		=	listCnt - 1;
									if(countOfSelected == listCntVal) {
										return " ALL";
									} else {
										return " Multiple";
									}
								}
							}
						}											
					}
                }
	 },width:170 });

	

	$("#kdcode").live("change", function() {
		
		$("#ddcl-kdcode-i0").attr("checked",false);

		//alert('1232');
		var kdcodes		=	$("#kdcode").val();

		if($.isArray(kdcodes)) {

			var myArray = $("#kdcode option:selected").map(function() {
				 return $(this).text();
			  }).get();
			 
			//alert(myArray);
			if(myArray.indexOf(" ALL") != -1) {			
				//alert('2323');				
				var srlength	=	$('#kdcode option').length;
				$("#kdcode").get(0).selectedIndex = 1;

				for(var c = 0; c <= srlength; c++) {
					if(c != 1) {
						$("#ddcl-kdcode-i"+c).attr("checked",false);
					}
				}
				//srcodes			=	$("#srcode").val();
				//alert(srcodes);
			}
		}

		 $("#srcode").dropdownchecklist( { textFormatFunction: function(options) {
					var selectedOptions = options.filter(":selected");
					var countOfSelected = selectedOptions.size();
					//alert(options.size());
					var listCnt		=	options.size() - 1;
					switch(countOfSelected) {						
						case 0: return "---SR---";
						case 1: return selectedOptions.text();
						case listCnt: return "ALL";
						default: {
							var srcodes		=	$("#srcode").val();
							if($.isArray(srcodes)) {
								var myArray = $("#srcode option:selected").map(function() {
									 return $(this).text();
								  }).get();
								 
								//alert(myArray);
								if(myArray.indexOf(" ALL") != -1) {			
									return " ALL";
								} else {
									if(myArray.indexOf("---SR---") != -1) {			
										if(countOfSelected == 2) {
											var textval			=	selectedOptions.text();
											textval = textval.replace("---SR---", "");
											//alert(textval);
											return textval;
										} else {
											return " Multiple";
										}
									} else {
										//alert(countOfSelected);
										//alert(listCnt);
										var listCntVal		=	listCnt - 1;
										if(countOfSelected == listCntVal) {
											return " ALL";
										} else {
											return " Multiple";
										}
									}
								}
							}											
						}
					}
		 },width:170   });
	});

	$("#srcode").live("change", function() {
		 $("#ddcl-srcode-i0").attr("checked",false);

		//alert('1232');
		var srcodes		=	$("#srcode").val();

		if($.isArray(srcodes)) {

			var myArray = $("#srcode option:selected").map(function() {
				 return $(this).text();
			  }).get();
			 
			//alert(myArray);
			if(myArray.indexOf(" ALL") != -1) {			
				//alert('2323');				
				var branchlength	=	$('#srcode option').length;
				$("#srcode").get(0).selectedIndex = 1;

				for(var c = 0; c <= branchlength; c++) {
					if(c != 1) {
						$("#ddcl-srcode-i"+c).attr("checked",false);
					}
				}
				//srcodes			=	$("#srcode").val();
				//alert(srcodes);
			}
		}

		$("#kdcode").dropdownchecklist( { textFormatFunction: function(options) {
					var selectedOptions = options.filter(":selected");
					var countOfSelected = selectedOptions.size();
					var listCnt		=	options.size() - 1;
					switch(countOfSelected) {
						case 0: return "---KD---";
						case 1: return selectedOptions.text();
						case listCnt: return "ALL";
						default: {
							var kdcodes		=	$("#kdcode").val();
							if($.isArray(kdcodes)) {
								var myArray = $("#kdcode option:selected").map(function() {
									 return $(this).text();
								  }).get();
								 
								//alert(myArray);
								if(myArray.indexOf(" ALL") != -1) {			
									return " ALL";
								} else {
									if(myArray.indexOf("---KD---") != -1) {			
										if(countOfSelected == 2) {
											var textval			=	selectedOptions.text();
											textval = textval.replace("---KD---", "");
											//alert(textval);
											return textval;
										} else {
											//alert(countOfSelected);
											//alert(listCnt);
											return " Multiple";
										}
									} else {
										//alert('23');
										//alert(countOfSelected);
										//alert(listCnt);
										var listCntVal		=	listCnt - 1;
										if(countOfSelected == listCntVal) {
											return " ALL";
										} else {
											return " Multiple";
										}
									}
								}
							}											
						}
					}
		 },width:170   });
	});

	$("#cuscode").live("change", function() {
		
		$("#ddcl-cuscode-i0").attr("checked",false);

		//alert('1232');
		var cuscodes		=	$("#cuscode").val();

		if($.isArray(cuscodes)) {

			var myArray = $("#cuscode option:selected").map(function() {
				 return $(this).text();
			  }).get();
			 
			//alert(myArray);
			if(myArray.indexOf(" ALL") != -1) {			
				//alert('2323');				
				var srlength	=	$('#cuscode option').length;
				$("#cuscode").get(0).selectedIndex = 1;

				for(var c = 0; c <= srlength; c++) {
					if(c != 1) {
						$("#ddcl-cuscode-i"+c).attr("checked",false);
					}
				}
				//srcodes			=	$("#srcode").val();
				//alert(srcodes);
			}
		}
	});


	/* FOR CLOSE BUTTON FOR THE ERROR MESSAGES STARTS HERE */

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
	/* FOR CLOSE BUTTON FOR THE ERROR MESSAGES ENDS HERE */
	
});
</script>

<!--  DROPBOX LIST JS AND CSS ENDS HERE -->






<style type="text/css">
.heading_report{
	background:#a09e9e;
	width:100%;
	margin-left:auto;
	margin-right:auto;
	height:25px;
	padding-top:5px;
	border-radius:6px;
	font-weight:bold;
	font-size:14px;
	clear:both;
}
#mytableform_report{
	background:#fff;
	width:99%;
	margin-left:auto;
	margin-right:auto;
	height:480px;
}
.alignment_report{
width:96%;
padding-left:20px;
margin-left:10px;
font-size:16px;
}
.condaily_routeplan th {
	padding:2px 5px 0 5px;
	font-weight:bold;
	font-size:14px;
	color:#000;
}
.condaily_routeplan td {
	padding:2px 5px 0 5px;
	background:#fff;
	border-collapse:collapse;
	padding-left:10px;
	color:#000;
	font-size:14px;
}
.condaily_routeplan tbody tr:hover td {
	background: #c1c1c1;
}
.condaily_routeplan{
	width:100%;
	text-align:left;
	height:300px;
	border-collapse:collapse;
	background:#a09e9e;
	margin-left:auto;
	margin-right:auto;
	border-radius:10px;
	overflow:scroll;
	overflow-x:auto;
}
#errormsgtranslist {
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
.myaligntranslist {
	padding-top:8px;
	margin:0 auto;
	color:#FF0000;
}

.buttons_new{
	-webkit-box-shadow:rgba(0,0,0,0.2) 0 1px 0 0;
	-moz-box-shadow:rgba(0,0,0,0.2) 0 1px 0 0;
	box-shadow:rgba(0,0,0,0.2) 0 1px 0 0;
	border-bottom-color:#333;
	border:1px solid #686868;
	background-color:#31859C;
	border-radius:5px;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	color:#000;
	font-family:Calibri;
	font-size:12px;
	padding:3px;
	cursor:pointer;
	width:160px;
	height:15px;
}
.buttons_gray {
	-webkit-box-shadow:rgba(0,0,0,0.2) 0 1px 0 0;
	-moz-box-shadow:rgba(0,0,0,0.2) 0 1px 0 0;
	box-shadow:rgba(0,0,0,0.2) 0 1px 0 0;
	border-bottom-color:#333;
	border:1px solid #686868;
	background-color:#A09E9E;
	border-radius:5px;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	color:#000;
	font-family:Calibri;
	font-size:12px;
	padding:3px;
	cursor:pointer;
	width:240px;
	height:15px;
}

.align2 {
	padding-left:10px;
}

#span1 {
	width: 30px; 
	float:left;
  }
#span2 { 
    width: 30px; 
	float:right;
	}
	
#colors{
	background-color:#CCC;
}

.alignsize {
	font-size:16px;
}

.pad5 { 
	padding-bottom:7px;
}

.textalg {
	text-align:left;
}

input[type="radio"] {
  margin-top: -1px;
  vertical-align: middle;
}
  
</style>
<body <?php if($dsrcode != '') { ?> onLoad="getDSRRoutes('<?php echo $dsrcode; ?>')" <?php } ?> >
<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="heading_report">TRANSACTION LIST</div>
<div id="mytableform_report" align="center">
<div class="mcf"></div>
<!-- <form method="post" action="" id="routemasterplan"> -->
<table width="100%" style="background-color:#CCC">
 <tr>
    <td align="left" style="width:9%;" class="align alignsize" >KD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
	<td align="left" style="width:10%" class="alignsize">
		<span id="kdspan">
			<select class="dsrname" name="kdcode[]" id="kdcode" multiple onChange="getKDspecifictranslist();">
				<option value="">---KD---</option>
				<option value="<?php echo $kdstr; ?>"> ALL</option>
				<?php while($info = mysql_fetch_assoc($res_KD)){?>
				<option value="<?php echo  $info['KD_Code']; ?>" <?php if($kdcode == $info['KD_Code']) { echo "selected"; } ?> > <?php echo  upperstate($info['KD_Name']); ?></option>
				<?php }?> 
			</select>
		</span>		
		</td>
        
          <td align="left" style="width:9%;" class="align alignsize">SR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
	    <td align="left" nowrap="nowrap" style="width:2%" class="alignsize">
		<span id="srspan">
			<select class="dsrname" name="srcode[]" id="srcode" multiple onChange="getsrtranslist(this.value);">
				<option value="">---SR---</option>
				<option value="<?php echo $srstr; ?>"> ALL</option>
				<?php while($info_sr = mysql_fetch_assoc($res_DSR)) { ?>
				<option value="<?php echo  $info_sr['DSR_Code']; ?>" <?php if($srcode == $info_sr['DSR_Code']) { echo "selected"; } ?> > <?php echo  upperstate($info_sr['DSRName']); ?></option>
				<?php } ?> 
			</select>
		</span>	
		</td>        	   
       	</tr>
<tr>
	<td class="pad5"></td>
</tr>
<tr>       
	
       <td align="left" style="width:9%;" class="align alignsize" >CUSTOMER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
	<td align="left" style="width:10%" class="alignsize">
		<select class="dsrname" name="cuscode[]" id="cuscode" multiple>
	    <option value="">---CUSTOMER---</option>
		<option value="<?php echo $cusstr; ?>"> ALL</option>
		<?php while($info = mysql_fetch_assoc($res_cus)){?>
		<option value="<?php echo  $info['customer_code']; ?>" <?php if($cuscode == $info['customer_code']) { echo "selected"; } ?> > <?php echo  upperstate($info['Customer_Name']); ?></option>
		<?php }?> 
		</select>
		</td>
       	</tr>
<tr>
	<td class="pad5"></td>
</tr>
<tr>         
        <td align="left" style="width:9%;" class="align alignsize">FROM & TO DATE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
	    <td align="left" nowrap="nowrap" style="width:2%" class="alignsize">

		<div id="tobecopied" >   <input type="text" size="9" readonly class="datepicker" name="fromdates" id="fromdates"  onChange="changeDateFormat(this.value,'fromdates')" value="<?php echo date('Y-m-d'); ?>" />	&nbsp; &nbsp; <input type="text" size="9" readonly class="datepicker" name="todates" id="todates" onChange="changeDateFormat(this.value,'todates')" value="<?php echo date('Y-m-d'); ?>" /> &nbsp; <input type="button" class="buttons" onClick="kdtranslist();" value="GO" /> </div>	
		</td>
    	 </tr>
</table>
     
<div class="mcf">
	<div class="condaily_routeplan">
	<span id="ajaxresultpage">
		  <table border="1" width="100%">
			<thead>
			  <tr>
                <th align="center" style="width:10%">Date</th>
				<th align="center" style="width:10%">KD</th>
				<th align="center" style="width:10%">SR</th>
				<th align="center" style="width:10%">Tran Type</th>
				<th align="center" style="width:10%">Tran Number</th>
				<th align="center" style="width:10%">Customer</th>
				<th align="center" style="width:10%">Type</th>
				<th align="center" style="width:10%">GPS</th>
				<th align="center" style="width:10%">Line Count</th>
                <th align="center" style="width:10%">Focus Count</th>
				<th align="center" style="width:10%">Scheme Count</th>
                <th align="center" style="width:10%">Value</th>
                <th align="center" style="width:10%">Discount</th>
                <th align="center" style="width:10%">Currency</th>
                <th align="center" style="width:10%">Net Value</th>
                <th align="center" style="width:10%">Collection</th>
				<th align="center" style="width:10%">Balance Due</th>
				<th align="center" style="width:10%">Product</th>
				<th align="center" style="width:10%">Type</th>
				<th align="center" style="width:10%">Scheme Header</th>
				<th align="center" style="width:10%">Stock</th>
				<th align="center" style="width:10%">Sale</th>
				<th align="center" style="width:10%">Price</th>
				<th align="center" style="width:10%">Value</th>
                <th align="center" style="width:10%">Scheme Line</th>                        
		  </tr>
		  </thead>
	     <tbody>
		 <tr><td align="center" colspan="25">NO RECORDS FOUND</td>
         <!-- <tr>
         		 <td>&nbsp;</td>
				 <td>&nbsp;</td>	
				 <td>&nbsp;</td>
				 <td>&nbsp;</td>	
				 <td>&nbsp;</td>
				 <td>&nbsp;</td>	
				 <td>&nbsp;</td>	
				 <td>&nbsp;</td>	
				 <td>&nbsp;</td>	
				 <td>&nbsp;</td>	
				 <td>&nbsp;</td>	
				 <td>&nbsp;</td>	
				 <td>&nbsp;</td>	
				 <td>&nbsp;</td>	
				 <td>&nbsp;</td>
				 <td>&nbsp;</td>	
				 <td>&nbsp;</td>
				 <td>&nbsp;</td>	
				 <td>&nbsp;</td>
				 <td>&nbsp;</td>	
				 <td>&nbsp;</td>	
				 <td>&nbsp;</td>	
				 <td>&nbsp;</td>	
				 <td>&nbsp;</td>	
				 <td>&nbsp;</td>	
		</tr> -->
         </tbody>
		</table>	
	  </span>
	</div>                
</div>
<div class="mcf"></div>
	 <table width="50%" style="clear:both">
		 <tr align="center" >
			<!--  <td ><input type="button" name="submit" id="submit" class="buttons" value="Save" onClick="return routemonthpl();"/>&nbsp;&nbsp;&nbsp;&nbsp;
			 				 <input type="reset" name="reset" class="buttons" value="Clear" id="clear" />&nbsp;&nbsp;&nbsp;&nbsp;
			 				 <input type="button" name="cancel" value="Cancel" class="buttons" onClick="window.location='../include/empty.php'"/>&nbsp;&nbsp;&nbsp;&nbsp;
			 				 <input type="button" name="View" value="View" class="buttons" onClick="window.location='routemonthplview.php'"/></td>
			 </td> -->
		 </tr>
	 </table>
<!-- </form> -->
<?php include("../include/error.php"); ?>
<div class="mcf"></div> 
	  <div id="errormsgtranslist" style="display:none;"><h3 align="center" class="myaligntranslist"></h3><button id="closebutton">Close</button></div>
    
     </div>
  </div>
</div>
<?php include('../include/footer.php');?>