<?php
ob_start();
require_once('../include/header.php');
require_once "../include/ps_pagination.php";
require_once "../include/ajax_pagination.php";
//echo "hjisdfes";


//error_reporting(E_ALL & ~E_NOTICE);
//ini_set("display_errors",true);

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

$query_Prod 						=	"select id,Product_description1,Product_code from product";
$res_Prod 							=	mysql_query($query_Prod) or die(mysql_error());

$query_brand 						=	"select id,brand from brand";
$res_brand 							=	mysql_query($query_brand) or die(mysql_error());

$query_RSM 							=	"select id,DSRName,DSR_Code from rsm_sp";
$res_RSM 							=	mysql_query($query_RSM) or die(mysql_error());

$query_ASM 							=	"select id,DSRName,DSR_Code from asm_sp";
$res_ASM 							=	mysql_query($query_ASM) or die(mysql_error());

$query_branch 						=	"select id,branch from branch";
$res_branch 						=	mysql_query($query_branch) or die(mysql_error());

$kdstr								=	getdbstr('KD_Code','kd');
$rsmstr								=	getdbstr('id','rsm_sp');
$asmstr								=	getdbstr('DSR_Code','asm_Sp');
$branchstr							=	getdbstr('id','branch');

$productstr							=	getdbstr('Product_code','product');
$brandstr							=	getdbstr('id','brand');

$id									=	isset($_REQUEST['id']);
?>

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


	 $("#prodcode").dropdownchecklist( { textFormatFunction: function(options) {
                var selectedOptions = options.filter(":selected");
                var countOfSelected = selectedOptions.size();
				var listCnt		=	options.size() - 1;
                switch(countOfSelected) {
                    case 0: { 
						return "---PRODUCT---";
					}
                    case 1: return selectedOptions.text();
                    case listCnt: return "ALL";
                    default: {
						var prodcodes		=	$("#prodcode").val();
						if($.isArray(prodcodes)) {
							var myArray = $("#prodcode option:selected").map(function() {
								 return $(this).text();
							  }).get();
							 
							//alert(myArray);
							if(myArray.indexOf(" ALL") != -1) {			
								return " ALL";
							} else {
								if(myArray.indexOf("---KD---") != -1) {			
									if(countOfSelected == 2) {
										var textval			=	selectedOptions.text();
										textval = textval.replace("---PRODUCT---", "");
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

	 $("#brandcode").dropdownchecklist( { textFormatFunction: function(options) {
                var selectedOptions = options.filter(":selected");
                var countOfSelected = selectedOptions.size();
				var listCnt		=	options.size() - 1;
                switch(countOfSelected) {
                    case 0: { 
						return "---BRAND---";
					}
                    case 1: return selectedOptions.text();
                    case listCnt: return "ALL";
                    default: {
						var brandcodes		=	$("#brandcode").val();
						if($.isArray(brandcodes)) {
							var myArray = $("#brandcode option:selected").map(function() {
								 return $(this).text();
							  }).get();
							 
							//alert(myArray);
							if(myArray.indexOf(" ALL") != -1) {			
								return " ALL";
							} else {
								if(myArray.indexOf("---BRAND---") != -1) {			
									if(countOfSelected == 2) {
										var textval			=	selectedOptions.text();
										textval = textval.replace("---BRAND---", "");
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

	 $("#asmcode").dropdownchecklist( { textFormatFunction: function(options) {
                var selectedOptions = options.filter(":selected");
                var countOfSelected = selectedOptions.size();
				var listCnt		=	options.size() - 1;
                switch(countOfSelected) {
                    case 0: return "---ASM---";
                    case 1: return selectedOptions.text();
                    case listCnt: return "ALL";
                    default: {
						var asmcodes		=	$("#asmcode").val();
						if($.isArray(asmcodes)) {
							var myArray = $("#asmcode option:selected").map(function() {
								 return $(this).text();
							  }).get();
							 
							//alert(myArray);
							if(myArray.indexOf(" ALL") != -1) {			
								return " ALL";
							} else {
								if(myArray.indexOf("---ASM---") != -1) {			
									if(countOfSelected == 2) {
										var textval			=	selectedOptions.text();
										textval = textval.replace("---ASM---", "");
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


	 $("#rsmcode").dropdownchecklist( { textFormatFunction: function(options) {
                var selectedOptions = options.filter(":selected");
                var countOfSelected = selectedOptions.size();
				var listCnt		=	options.size() - 1;
                switch(countOfSelected) {
                    case 0: return "---RSM---";
                    case 1: return selectedOptions.text();
                    case listCnt: return "ALL";
                    default: {
						var rsmcodes		=	$("#rsmcode").val();
						if($.isArray(rsmcodes)) {
							var myArray = $("#rsmcode option:selected").map(function() {
								 return $(this).text();
							  }).get();
							 
							//alert(myArray);
							if(myArray.indexOf(" ALL") != -1) {			
								return " ALL";
							} else {
								if(myArray.indexOf("---RSM---") != -1) {			
									if(countOfSelected == 2) {
										var textval			=	selectedOptions.text();
										textval = textval.replace("---RSM---", "");
										//alert(textval);
										return textval;
									} else {
										return " Multiple";
									}
								} else {
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


	 $("#branchcode").dropdownchecklist( { textFormatFunction: function(options) {
                var selectedOptions = options.filter(":selected");
                var countOfSelected = selectedOptions.size();
				var listCnt		=	options.size() - 1;
                switch(countOfSelected) {
                    case 0: return "---BRANCH---";
                    case 1: return selectedOptions.text();
                    case listCnt: return "ALL";
                    default: {
						var branchcodes		=	$("#branchcode").val();
						if($.isArray(branchcodes)) {
							var myArray = $("#branchcode option:selected").map(function() {
								 return $(this).text();
							  }).get();
							 
							//alert(myArray);
							if(myArray.indexOf(" ALL") != -1) {			
								return " ALL";
							} else {
								if(myArray.indexOf("---BRANCH---") != -1) {			
									if(countOfSelected == 2) {
										var textval			=	selectedOptions.text();
										textval = textval.replace("---BRANCH---", "");
										//alert(textval);
										return textval;
									} else {
										return " Multiple";
									}
								} else {
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


	$("#prodcode").live("change", function() {
		
		$("#ddcl-prodcode-i0").attr("checked",false);

		//alert('1232');
		var prodcodes		=	$("#prodcode").val();

		if($.isArray(prodcodes)) {

			var myArray = $("#prodcode option:selected").map(function() {
				 return $(this).text();
			  }).get();
			 
			//alert(myArray);
			if(myArray.indexOf(" ALL") != -1) {			
				//alert('2323');				
				var srlength	=	$('#prodcode option').length;
				$("#prodcode").get(0).selectedIndex = 1;

				for(var c = 0; c <= srlength; c++) {
					if(c != 1) {
						$("#ddcl-prodcode-i"+c).attr("checked",false);
					}
				}
				//srcodes			=	$("#srcode").val();
				//alert(srcodes);
			}
		}

		 $("#brandcode").dropdownchecklist( { textFormatFunction: function(options) {
					var selectedOptions = options.filter(":selected");
					var countOfSelected = selectedOptions.size();
					var listCnt		=	options.size() - 1;
					//alert('2332');
					switch(countOfSelected) {
						case 0: return "---BRAND---";
						case 1: return selectedOptions.text();
						case listCnt: return "ALL";
						default: {
							var brandcodes		=	$("#brandcode").val();
							if($.isArray(brandcodes)) {
								var myArray = $("#brandcode option:selected").map(function() {
									 return $(this).text();
								  }).get();
								 
								//alert(myArray);
								if(myArray.indexOf(" ALL") != -1) {			
									return " ALL";
								} else {
									if(myArray.indexOf("---BRAND---") != -1) {			
										if(countOfSelected == 2) {
											var textval			=	selectedOptions.text();
											textval = textval.replace("---BRAND---", "");
											//alert(textval);
											return textval;
										} else {
											return " Multiple";
										}
									} else {
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

	$("#brandcode").live("change", function() {
		
		$("#ddcl-brandcode-i0").attr("checked",false);

		//alert('1232');
		var brandcodes		=	$("#brandcode").val();

		if($.isArray(brandcodes)) {

			var myArray = $("#brandcode option:selected").map(function() {
				 return $(this).text();
			  }).get();
			 
			//alert(myArray);
			if(myArray.indexOf(" ALL") != -1) {			
				//alert('2323');				
				var srlength	=	$('#brandcode option').length;
				$("#brandcode").get(0).selectedIndex = 1;

				for(var c = 0; c <= srlength; c++) {
					if(c != 1) {
						$("#ddcl-brandcode-i"+c).attr("checked",false);
					}
				}
				//srcodes			=	$("#srcode").val();
				//alert(srcodes);
			}
		}

		 $("#prodcode").dropdownchecklist( { textFormatFunction: function(options) {
					var selectedOptions = options.filter(":selected");
					var countOfSelected = selectedOptions.size();
					var listCnt		=	options.size() - 1;
					//alert('2332');
					switch(countOfSelected) {
						case 0: return "---PRODUCT---";
						case 1: return selectedOptions.text();
						case listCnt: return "ALL";
						default: {
							var prodcodes		=	$("#prodcode").val();
							if($.isArray(prodcodes)) {
								var myArray = $("#prodcode option:selected").map(function() {
									 return $(this).text();
								  }).get();
								 
								//alert(myArray);
								if(myArray.indexOf(" ALL") != -1) {			
									return " ALL";
								} else {
									if(myArray.indexOf("---PRODUCT---") != -1) {			
										if(countOfSelected == 2) {
											var textval			=	selectedOptions.text();
											textval = textval.replace("---PRODUCT---", "");
											//alert(textval);
											return textval;
										} else {
											return " Multiple";
										}
									} else {
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

		 $("#asmcode").dropdownchecklist( { textFormatFunction: function(options) {
					var selectedOptions = options.filter(":selected");
					var countOfSelected = selectedOptions.size();
					//alert(options.size());
					var listCnt		=	options.size() - 1;
					switch(countOfSelected) {						
						case 0: return "---ASM---";
						case 1: return selectedOptions.text();
						case listCnt: return "ALL";
						default: {
							var asmcodes		=	$("#asmcode").val();
							if($.isArray(asmcodes)) {
								var myArray = $("#asmcode option:selected").map(function() {
									 return $(this).text();
								  }).get();
								 
								//alert(myArray);
								if(myArray.indexOf(" ALL") != -1) {			
									return " ALL";
								} else {
									if(myArray.indexOf("---ASM---") != -1) {			
										if(countOfSelected == 2) {
											var textval			=	selectedOptions.text();
											textval = textval.replace("---ASM---", "");
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


		 $("#rsmcode").dropdownchecklist( { textFormatFunction: function(options) {
					var selectedOptions = options.filter(":selected");
					var countOfSelected = selectedOptions.size();
					var listCnt		=	options.size() - 1;
					switch(countOfSelected) {
						case 0: return "---RSM---";
						case 1: return selectedOptions.text();
						case listCnt: return "ALL";
						default: {
							var rsmcodes		=	$("#rsmcode").val();
							if($.isArray(rsmcodes)) {
								var myArray = $("#rsmcode option:selected").map(function() {
									 return $(this).text();
								  }).get();
								 
								//alert(myArray);
								if(myArray.indexOf(" ALL") != -1) {			
									return " ALL";
								} else {
									if(myArray.indexOf("---RSM---") != -1) {			
										if(countOfSelected == 2) {
											var textval			=	selectedOptions.text();
											textval = textval.replace("---RSM---", "");
											//alert(textval);
											return textval;
										} else {
											return " Multiple";
										}
									} else {
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


		 $("#branchcode").dropdownchecklist( { textFormatFunction: function(options) {
					var selectedOptions = options.filter(":selected");
					var countOfSelected = selectedOptions.size();
					var listCnt		=	options.size() - 1;
					//alert('2332');
					switch(countOfSelected) {
						case 0: return "---BRANCH---";
						case 1: return selectedOptions.text();
						case listCnt: return "ALL";
						default: {
							var branchcodes		=	$("#branchcode").val();
							if($.isArray(branchcodes)) {
								var myArray = $("#branchcode option:selected").map(function() {
									 return $(this).text();
								  }).get();
								 
								//alert(myArray);
								if(myArray.indexOf(" ALL") != -1) {			
									return " ALL";
								} else {
									if(myArray.indexOf("---BRANCH---") != -1) {			
										if(countOfSelected == 2) {
											var textval			=	selectedOptions.text();
											textval = textval.replace("---BRANCH---", "");
											//alert(textval);
											return textval;
										} else {
											return " Multiple";
										}
									} else {
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

	$("#asmcode").live("change", function() {

		$("#ddcl-asmcode-i0").attr("checked",false);

		//alert('1232');
		var asmcodes		=	$("#asmcode").val();

		if($.isArray(asmcodes)) {

			var myArray = $("#asmcode option:selected").map(function() {
				 return $(this).text();
			  }).get();
			 
			//alert(myArray);
			if(myArray.indexOf(" ALL") != -1) {			
				//alert('2323');				
				var asmlength	=	$('#asmcode option').length;
				$("#asmcode").get(0).selectedIndex = 1;

				for(var c = 0; c <= asmlength; c++) {
					if(c != 1) {
						$("#ddcl-asmcode-i"+c).attr("checked",false);
					}
				}
				//asmcodes			=	$("#asmcode").val();
				//alert(asmcodes);
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


		 $("#rsmcode").dropdownchecklist( { textFormatFunction: function(options) {
					var selectedOptions = options.filter(":selected");
					var countOfSelected = selectedOptions.size();
					var listCnt		=	options.size() - 1;
					switch(countOfSelected) {
						case 0: return "---RSM---";
						case 1: return selectedOptions.text();
						case listCnt: return "ALL";
						default: {
							var rsmcodes		=	$("#rsmcode").val();
							if($.isArray(rsmcodes)) {
								var myArray = $("#rsmcode option:selected").map(function() {
									 return $(this).text();
								  }).get();
								 
								//alert(myArray);
								if(myArray.indexOf(" ALL") != -1) {			
									return " ALL";
								} else {
									if(myArray.indexOf("---RSM---") != -1) {			
										if(countOfSelected == 2) {
											var textval			=	selectedOptions.text();
											textval = textval.replace("---RSM---", "");
											//alert(textval);
											return textval;
										} else {
											return " Multiple";
										}
									} else {
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


		 $("#branchcode").dropdownchecklist( { textFormatFunction: function(options) {
					var selectedOptions = options.filter(":selected");
					var countOfSelected = selectedOptions.size();
					var listCnt		=	options.size() - 1;
					switch(countOfSelected) {
						case 0: return "---BRANCH---";
						case 1: return selectedOptions.text();
						case listCnt: return "ALL";
						default: {
							var branchcodes		=	$("#branchcode").val();
							if($.isArray(branchcodes)) {
								var myArray = $("#branchcode option:selected").map(function() {
									 return $(this).text();
								  }).get();
								 
								//alert(myArray);
								if(myArray.indexOf(" ALL") != -1) {			
									return " ALL";
								} else {
									if(myArray.indexOf("---BRANCH---") != -1) {			
										if(countOfSelected == 2) {
											var textval			=	selectedOptions.text();
											textval = textval.replace("---BRANCH---", "");
											//alert(textval);
											return textval;
										} else {
											return " Multiple";
										}
									} else {
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

	$("#rsmcode").live("change", function() {

		$("#ddcl-rsmcode-i0").attr("checked",false);

		//alert('1232');
		var rsmcodes		=	$("#rsmcode").val();

		if($.isArray(rsmcodes)) {

			var myArray = $("#rsmcode option:selected").map(function() {
				 return $(this).text();
			  }).get();
			 
			//alert(myArray);
			if(myArray.indexOf(" ALL") != -1) {			
				//alert('2323');				
				var rsmlength	=	$('#rsmcode option').length;
				$("#rsmcode").get(0).selectedIndex = 1;

				for(var c = 0; c <= rsmlength; c++) {
					if(c != 1) {
						$("#ddcl-rsmcode-i"+c).attr("checked",false);
					}
				}
				//rsmcodes			=	$("#rsmcode").val();
				//alert(rsmcodes);
			}
		}

		 $("#asmcode").dropdownchecklist( { textFormatFunction: function(options) {
					var selectedOptions = options.filter(":selected");
					var countOfSelected = selectedOptions.size();
					var listCnt		=	options.size() - 1;
					switch(countOfSelected) {
						case 0: return "---ASM---";
						case 1: return selectedOptions.text();
						case listCnt: return "ALL";
						default: {
							var asmcodes		=	$("#asmcode").val();
							if($.isArray(asmcodes)) {
								var myArray = $("#asmcode option:selected").map(function() {
									 return $(this).text();
								  }).get();
								 
								//alert(myArray);
								if(myArray.indexOf(" ALL") != -1) {			
									return " ALL";
								} else {
									if(myArray.indexOf("---ASM---") != -1) {			
										if(countOfSelected == 2) {
											var textval			=	selectedOptions.text();
											textval = textval.replace("---ASM---", "");
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
		 },width:170  });


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


		 $("#branchcode").dropdownchecklist( { textFormatFunction: function(options) {
					var selectedOptions = options.filter(":selected");
					var countOfSelected = selectedOptions.size();
					var listCnt		=	options.size() - 1;
					switch(countOfSelected) {
						case 0: return "---BRANCH---";
						case 1: return selectedOptions.text();
						case listCnt: return "ALL";
						default: {
							var branchcodes		=	$("#branchcode").val();
							if($.isArray(branchcodes)) {
								var myArray = $("#branchcode option:selected").map(function() {
									 return $(this).text();
								  }).get();
								 
								//alert(myArray);
								if(myArray.indexOf(" ALL") != -1) {			
									return " ALL";
								} else {
									if(myArray.indexOf("---BRANCH---") != -1) {			
										if(countOfSelected == 2) {
											var textval			=	selectedOptions.text();
											textval = textval.replace("---BRANCH---", "");
											//alert(textval);
											return textval;
										} else {
											return " Multiple";
										}
									} else {
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

	$("#branchcode").live("change", function() {
		 $("#ddcl-branchcode-i0").attr("checked",false);

		//alert('1232');
		var branchcodes		=	$("#branchcode").val();

		if($.isArray(branchcodes)) {

			var myArray = $("#branchcode option:selected").map(function() {
				 return $(this).text();
			  }).get();
			 
			//alert(myArray);
			if(myArray.indexOf(" ALL") != -1) {			
				//alert('2323');				
				var branchlength	=	$('#branchcode option').length;
				$("#branchcode").get(0).selectedIndex = 1;

				for(var c = 0; c <= branchlength; c++) {
					if(c != 1) {
						$("#ddcl-branchcode-i"+c).attr("checked",false);
					}
				}
				//srcodes			=	$("#srcode").val();
				//alert(srcodes);
			}
		}
		 				 
		 $("#asmcode").dropdownchecklist( { textFormatFunction: function(options) {
					var selectedOptions = options.filter(":selected");
					var countOfSelected = selectedOptions.size();
					var listCnt		=	options.size() - 1;
					switch(countOfSelected) {
						case 0: return "---ASM---";
						case 1: return selectedOptions.text();
						case listCnt: return "ALL";
						default: {
							var asmcodes		=	$("#asmcode").val();
							if($.isArray(asmcodes)) {
								var myArray = $("#asmcode option:selected").map(function() {
									 return $(this).text();
								  }).get();
								 
								//alert(myArray);
								if(myArray.indexOf(" ALL") != -1) {			
									return " ALL";
								} else {
									if(myArray.indexOf("---ASM---") != -1) {			
										if(countOfSelected == 2) {
											var textval			=	selectedOptions.text();
											textval = textval.replace("---ASM---", "");
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


		 $("#rsmcode").dropdownchecklist( { textFormatFunction: function(options) {
					var selectedOptions = options.filter(":selected");
					var countOfSelected = selectedOptions.size();
					var listCnt		=	options.size() - 1;
					switch(countOfSelected) {
						case 0: return "---RSM---";
						case 1: return selectedOptions.text();
						case listCnt: return "ALL";
						default: {
							var rsmcodes		=	$("#rsmcode").val();
							if($.isArray(rsmcodes)) {
								var myArray = $("#rsmcode option:selected").map(function() {
									 return $(this).text();
								  }).get();
								 
								//alert(myArray);
								if(myArray.indexOf(" ALL") != -1) {			
									return " ALL";
								} else {
									if(myArray.indexOf("---RSM---") != -1) {			
										if(countOfSelected == 2) {
											var textval			=	selectedOptions.text();
											textval = textval.replace("---RSM---", "");
											//alert(textval);
											return textval;
										} else {
											return " Multiple";
										}
									} else {
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
	height:260px;
	border-collapse:collapse;
	background:#a09e9e;
	margin-left:auto;
	margin-right:auto;
	border-radius:10px;
	overflow:scroll;
	overflow-x:hidden;
}
#errormsgsalper {
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
.myalignsalper {
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
<div align="center" class="heading_report">KD SALES PERFORMANCE</div>
<div id="mytableform_report" align="center">
<div class="mcf"></div>
<!-- <form method="post" action="" id="routemasterplan"> -->
<table width="100%" style="background-color:#CCC">
 <tr>
     	<td align="left" style="width:9%;" class="align alignsize" >KD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
	<td align="left" style="width:10%" class="align2 alignsize">
			<span id="kdspan">
				<select class="dsrname" name="kdcode[]" id="kdcode" multiple onChange="getKDspecific();">
					<option value="">---KD---</option>
					<option value="<?php 				
					echo $kdstr; ?>"> ALL</option>
					<?php while($info = mysql_fetch_assoc($res_KD)){?>
					<option value="<?php echo  $info['KD_Code']; ?>" <?php if($kdcode == $info['KD_Code']) { echo "selected"; } ?> > <?php echo  upperstate($info['KD_Name']); ?></option>
					<?php }?> 
				</select>
			</span>
		</td>
		
		<td align="left" style="width:9%" class="align alignsize">BRAND&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>	
	<td align="left" nowrap="nowrap" style="width:20%" class="alignsize">
			<span id="brandspan">
				<select class="dsrname" name="brandcode[]" id="brandcode" multiple onChange="getbrandspecific(this.value);">
					<option value="">---Brand---</option>
					<option value="<?php 				
					echo $brandstr; ?>"> ALL</option>
					<?php while($info = mysql_fetch_assoc($res_brand)){?>
					<option value="<?php echo  $info['id']; ?>" <?php if($brandcode == $info['id']) { echo "selected"; } ?> > <?php echo  upperstate($info['brand']); ?></option>
					<?php } ?> 
				</select>
			</span>
		</td>
		</tr>
<tr>
	<td class="pad5"></td>
</tr>
<tr>

	    <td align="left" style="width:9%;" class="align alignsize">PRODUCT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
	<td align="left" style="width:4%" nowrap="nowrap" class="align2 alignsize">
			<span id="productspan">
				<select class="dsrname" style="width:460px;" name="prodcode[]" id="prodcode" multiple onChange="getprodspecific(this.value);">
					<option value="">----------------------------------------------Product-----------------------------------------</option>
					<option value="<?php 				
					echo $productstr; ?>"> ALL</option>
					<?php while($info = mysql_fetch_assoc($res_Prod)){?>
					<option value="<?php echo  $info['Product_code']; ?>" <?php if($prodcode == $info['Product_code']) { echo "selected"; } ?> > <?php echo  upperstate($info['Product_description1']); ?></option>
					<?php } ?> 		
				</select>
			</span>
		</td>
        
        <td align="left" style="width:9%;" class="align alignsize">RSM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
	    <td align="left" nowrap="nowrap" style="width:2%" class="alignsize">
			<span id="rsmspan">
				<select class="dsrname" name="rsmcode[]" id="rsmcode" multiple onChange="getrsmspecific(this.value);">
					<option value="">---RSM---</option>
					<option value="<?php 				
					echo $rsmstr; ?>"> ALL</option>
					<?php while($info_rsm = mysql_fetch_assoc($res_RSM)) { ?>
					<option value="<?php echo  $info_rsm['id']; ?>" <?php if($rsmcode == $info_rsm['id']) { echo "selected"; } ?> > <?php echo  upperstate($info_rsm['DSRName']); ?></option>
					<?php } ?> 
				</select>
			</span>
		</td>
		</tr>
<tr>
	<td class="pad5"></td>
</tr>
<tr>

    	<td align="left" style="width:9%;" class="align alignsize" >ASM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
	<td align="left" style="width:10%" class="align2 alignsize">
			<span id="asmspan">
				<select class="dsrname" name="asmcode[]" id="asmcode" multiple onChange="getasmspecific(this.value);">
					<option value="">---ASM---</option>
					<option value="<?php 				
					echo $asmstr; ?>"> ALL</option>
					<?php while($info_asm = mysql_fetch_assoc($res_ASM)) { ?>
					<option value="<?php echo  $info_asm['DSR_Code']; ?>" <?php if($asmcode == $info_asm['DSR_Code']) { echo "selected"; } ?> > <?php echo  upperstate($info_asm['DSRName']); ?></option>
					<?php } ?> 
				</select>
			</span>
        </td>         
		
	  <td align="left" style="width:9%;" class="align alignsize">BRANCH&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
	    <td align="left" nowrap="nowrap" style="width:2%" class="alignsize">
		 <span id="branchspan">
			<select class="dsrname" name="branchcode[]" id="branchcode" multiple onChange="getbranchspecific(this.value);">
				<option value="">---BRANCH---</option>
				<option value="<?php 				
				echo $branchstr; ?>"> ALL</option>
				<?php while($info_branch = mysql_fetch_assoc($res_branch)) { ?>
				<option value="<?php echo  $info_branch['id']; ?>" <?php if($branchcode == $info_branch['id']) { echo "selected"; } ?> > <?php echo  upperstate($info_branch['branch']); ?></option>
				<?php } ?> 
			</select>
		</span>
     </td>
	  </tr>

<tr>
	<td class="pad5"></td>
</tr>
<!--</table>
	  
<table style="background-color:#CCC">	  -->
	   <tr>
        <td align="left" style="width:4%" class="align2">
			<select name="reportby" id="reportby">
				<option value="">---REPORT BY---</option>
				<option value="KD_Name" > KD</option>
				<option value="RSM_Name" > RSM</option>
				<option value="ASM_Name" > ASM</option>
				<option value="Brand_Name" > Brand</option>
				<option value="Product_Name" > Product</option>
			</select>
        </td>
        
        <td class="align2">
			<select class="dsrname" name="freqval" id="freqval" onChange="frequencychange(this.value);" >
				<option value="">---Frequency---</option>
				<option value="Daily">Daily</option>
				<option value="Weekly">Weekly</option>
				<option value="Monthly">Monthly</option>
				<option value="Custom">Custom</option>
			</select>
        </td>        
       <td class="align alignsize">
			<div id="dailylabel" style="display:none;">DATE &nbsp;</div>
			<div id="weeklabel" style="display:none;">WEEK START &nbsp;</div>
			<div id="monthlabel" style="display:none;">MONTH & YEAR &nbsp;</div>
			<div id="fromtolabel" style="display:none;">FROM & TO DATE &nbsp;</div>
	   </td>
        <td align="left" nowrap="nowrap" class="alignsize">
			<span id="dailydate" style="display:none;"><input type="text" name="dailydates" id="dailydates" onChange="changeDateFormat(this.value,'dailydates')" class="datepicker" value="<?php echo date('Y-m-d'); ?>" size="15">&nbsp;&nbsp;<input type="button" class="buttons" onClick="kdsalesperform();" value="GO" /></span>

			<span id="weeklydate" style="display:none;"><input type="text" name="weeklydates" id="weeklydates" onChange="changeDateFormat(this.value,'weeklydates')" class="datepicker" value="<?php echo date('Y-m-d'); ?>" size="15">&nbsp;&nbsp;<input type="button" class="buttons" onClick="kdsalesperform();" value="GO" /></span>

			<span id="monthlydate" style="display:none;">
				<select name="propmonth" id="propmonth">
				<?php $curmonthval = date('m'); ?>
					<option value="">--Month--</option>
					<option value="01" <?php if($curmonthval == 01) { echo "selected"; } ?> >January</option>
					<option value="02" <?php if($curmonthval == 02) { echo "selected"; } ?> >February</option>
					<option value="03" <?php if($curmonthval == 03) { echo "selected"; } ?> >March</option>
					<option value="04" <?php if($curmonthval == 04) { echo "selected"; } ?> >April</option>
					<option value="05" <?php if($curmonthval == 05) { echo "selected"; } ?> >May</option>
					<option value="06" <?php if($curmonthval == 06) { echo "selected"; } ?> >June</option>
					<option value="07" <?php if($curmonthval == 07) { echo "selected"; } ?> >July</option>
					<option value="08" <?php if($curmonthval == 08) { echo "selected"; } ?> >August</option>
					<option value="09" <?php if($curmonthval == 09) { echo "selected"; } ?> >September</option>
					<option value="10" <?php if($curmonthval == 10) { echo "selected"; } ?> >October</option>
					<option value="11" <?php if($curmonthval == 11) { echo "selected"; } ?> >November</option>
					<option value="12" <?php if($curmonthval == 12) { echo "selected"; } ?> >December</option>
				</select> &nbsp;&nbsp; 
				<select name="propyear" id="propyear" >
					<option value="">--Year--</option>
					<?php $curyear = date("Y");
					for($i=2010; $i<=$curyear;$i++) { ?>
						<option value="<?php echo $i; ?>" <?php if($curyear == $i) {  echo "selected"; } ?> ><?php echo $i; ?></option>
					<?php } ?>
				</select>&nbsp;&nbsp;<input type="button" class="buttons" onClick="kdsalesperform();" value="GO" />
			</span>
		
		<!--</td>	
		<td height="28" align="left" style="width:20%" colspan="2" nowrap="nowrap" class="align">-->

			<span id="fromdate" style="display:none;"> <input type="text" size="9" readonly class="datepicker" name="fromdates" id="fromdates"  onChange="changeDateFormat(this.value,'fromdates')" value="<?php echo date('Y-m-d'); ?>" />	&nbsp; 
       
		<!--</td>
        
        <td class="align2" nowrap="nowrap">  -->

		    &nbsp;<input type="text" size="9" readonly class="datepicker" name="todates" id="todates" onChange="changeDateFormat(this.value,'todates')" value="<?php echo date('Y-m-d'); ?>" />  &nbsp;&nbsp; <input type="button" class="buttons" onClick="kdsalesperform();" value="GO" /></span>
					
			<span id="nofrequency" ><input type="button" class="buttons" onClick="kdsalesperform();" value="GO" /></span>
		<!--</td>		
		<td class="align2" nowrap="nowrap">  -->		    
		</td>
	  </tr>
	 </table>     
<div class="mcf">
	   <div class="condaily_routeplan"> 
		<span id="ajaxresultpage">
		  <table border="1" width="100%">
			<thead>
			  <tr>
				<th align="center" style="width:10%">KD Name</th>
				<th align="center" style="width:10%">SR Name</th>
				<th align="center" style="width:10%">ASM Name</th>
				<th align="center" style="width:10%">RSM Name</th>
				<th align="center" style="width:10%">Brand</th>
				<th align="center" style="width:10%">Product</th>
				<th align="center" style="width:10%">Target
                <table  width="100%"><tr><td>Units</td><td>Naira</td></tr></table>
                </th>
				<th align="center" style="width:10%">Sales
                 <table width="100%"><tr><td>Units</td><td>Naira</td></tr></table>
                </th>
				<th align="center" style="width:10%">Difference
                 <table  width="100%"><tr><td>Units</td><td>Naira</td></tr></table>
                </th>          
		  </tr>
		  </thead>
		 <tbody>	
         <tr>
			<td colspan="9" align='center'><strong>NO RECORDS FOUND</strong></td>
			 <!-- <td>&nbsp;</td>
			  <td>&nbsp;</td>	
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>	
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>	
			  <td>&nbsp;
			  <table width="100%"><tr><td>1</td><td>2</td></tr></table>
			  </td>	
			  <td>&nbsp;
			  <table width="100%"><tr><td>2</td><td>3</td></tr></table>
			  </td>	
			  <td>&nbsp;
			  <table  width="100%"><tr><td>2</td><td>2</td></tr></table>
			  </td> -->		 
		 </tr>
    	 </tbody>	
		</table>			
		 </span>
		 </div>
</div>
<div class="mcf"></div>
	 <table width="50%" style="clear:both">
		 <tr align="center">
			 <!--<td ><input type="button" name="submit" id="submit" class="buttons" value="Save" onClick="return routemonthpl();"/>&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="reset" name="reset" class="buttons" value="Clear" id="clear" />&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="button" name="cancel" value="Cancel" class="buttons" onClick="window.location='../include/empty.php'"/>&nbsp;&nbsp;&nbsp;&nbsp;
				 <input type="button" name="View" value="View" class="buttons" onClick="window.location='routemonthplview.php'"/></td>
			 </td>-->
		 </tr>
	 </table>
<!-- </form> -->
<?php require_once("../include/error.php"); ?>
<div class="mcf"></div> 
	  <div id="errormsgsalper" style="display:none;"><h3 align="center" class="myalignsalper"></h3><button id="closebutton">Close</button></div>    
     </div>
  </div>
</div>
<?php require_once('../include/footer.php');?>