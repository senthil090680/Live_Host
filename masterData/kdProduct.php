<?php
ob_start();
include('../include/header.php');
//include "../include/ps_pagination.php";
EXTRACT($_REQUEST);	
//Insert Query
$Effective_date=date("Y-m-d",strtotime($Effective_date));

$page=intval($_GET['page']);

if(isset($_POST['submit'])=='Save')
{
	$cnt=count($_POST['checkbox']);
	for($j=0;$j<$cnt;$j++){
	$checkbox=$_POST['checkbox'][$j]; 
	$Price =$_POST['Price'][$j];	
	$sel1=mysql_query("select * from kd_product where Product_code ='$checkbox' AND kd_category='$kd_category'"); 
	$count = mysql_num_rows($sel1);
	if($count == 0) {
	$list=mysql_query("select * from product where Product_code ='$checkbox'");
	$res=mysql_fetch_array($list);
	$Product_description1=$res['Product_description1'];
	$UOM=$res['UOM1'];
	$Price =$_POST['Price'][$j];
	mysql_query("INSERT INTO kd_product(KD_Code,kd_category,UOM1,Product_code,Product_description1,Price,Effective_date)
	VALUES('$KD_Code','$kd_category','$UOM','$checkbox','$Product_description1','$Price','$Effective_date')");
	
	 $query=mysql_query("INSERT INTO price_master(KD_Code,kd_category,Product_code, Product_description1,UOM1,Price,Effective_date)
				VALUES('".$KD_Code."','".$kd_category."','".$checkbox."',
				'".$Product_description1."', '".$UOM."','".$Price."','".$Effective_date."')");
			
	header("location:kdProductCategory.php?no=1&page=$page");
	}
	elseif(isset($_POST['checkbox'])==1){
	//echo "Hi";exit;	
	$sel1=mysql_query("select * from kd_product where Product_code ='$checkbox' AND kd_category='$kd_category'"); 
	$count = mysql_num_rows($sel1);
	if($count!== 0) {
	$list=mysql_query("select * from product where Product_code ='$checkbox'");
	$res=mysql_fetch_array($list);
	$Product_description1=$res['Product_description1'];
	$UOM=$res['UOM1'];
	$Price =$_POST['Price'][$j];
     mysql_query("UPDATE kd_product SET 
				 KD_Code='$KD_Code',
				 kd_category='$kd_category',
				 UOM1='$UOM',
				 Product_code='$checkbox',
				 Product_description1='$Product_description1',
				 Price='$Price',
				 Effective_date='$Effective_date'
				 WHERE Product_code = '".$checkbox."' AND kd_category = $kd_category");
      
	
	
	 $query = mysql_query("UPDATE price_master SET 
				 KD_Code='$KD_Code',
				 kd_category='$kd_category',
				 UOM1='$UOM',
				 Product_code='$checkbox',
				 Product_description1='$Product_description1',
				 Price='$Price',
				 Effective_date='$Effective_date'
				 WHERE Product_code = '".$checkbox."' AND kd_category = $kd_category");
	
	header("location:kdProductCategory.php?no=2&page=$page");
	}	
  }
	}
}


  	



?>
<!------------------------------- Form -------------------------------------------------->


<style type="text/css">
tbody{
	width:1000px;
}

.conscrolls {
	width:100%;
	text-align:left;
	border-collapse:collapse;
	background:#a09e9e;
	margin-left:auto;
	margin-right:auto;
	border-radius:10px;
	overflow:scroll;
	overflow-x:hidden;
	height:250px;
}
.conscrolls th {
	width:22%;
	padding:2px 5px 0 5px;
	font-weight:bold;
	font-size:13px;
	color:#000;
}
.conscrolls td {
	padding:2px 5px 0 5px;
	background:#fff;
	border-collapse:collapse;
	color: #000;
	font-size:13px;
}
.conscrolls tbody tr:hover {
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
<SCRIPT language="javascript">
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




$(function(){
    $("#selectall").click(function () {
       $('.case').attr('checked', this.checked);
    });
    $(".case").click(function(){
 
        if($(".case").length == $(".case:checked").length) {
            $("#selectall").attr("checked", "checked");
        } else {
            $("#selectall").removeAttr("checked");
        }
 
    });
});

function validate() {
	var KDCategory				=	$('#kd_category').val();
	var ProductDescription		=	$('#Product_description1').val();
	var DescriptionLength		=	$('#Product_description_length').val();
	var Brand                   =   $('#brand').val();
	var ProductType             =   $('#product_type').val();
	var ProductCategory         =   $('#product_category').val();
	var Principal         =   $('#principal').val();


	if(KDCategory == ''){
		$('.myaligncol').html('ERR : Select KD Category');
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

	$('#errormsgcol').css('display','none');
	//return false;
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


</SCRIPT>
<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headingskdp">KD Product & Price Category</div>
<div class="mytable3">
<div class="mcf"></div>
  <div id="search">
        <form action="" method="get">
        <input type="text" name="Product_description1" value="<?php $_GET['Product_description1']; ?>" autocomplete='off' placeholder='Search By Product'/>
        <input type="submit" name="submit" class="buttonsg" value="Go"/>
        </form>       
        </div>
<form method="post" action="" name="register" onsubmit="return validate()">
<div class="headfile" align="center">
<table width="80%" align="center">
  <tr>
    <td>KD Product & Price Category*
	<td>
    <select name="kd_category" class="kd_category" id="kd_category"  autocomplete="off"  value="" onchange="return KDCODE()">
			<option value="">--- Select ---</option>
			<?php 
			$list=mysql_query("select * from  kd_category"); 
			while($row=mysql_fetch_assoc($list)){
			$kd=$row['kd_category'];
			?>
			<option value='<?php echo $row['id']; ?>'<?php if($row['id']==$_GET['data']){ echo 'selected'; }?>><?php echo $row['kd_category']; ?></option>
			<?php 
			// End while loop. 
			} 
			?>
			</select>
     
         <input type="hidden" name="KD_Code" id="KD_Code" value="" />
    </td>
    
    
       <td class="align">Effective Date</td>
    <td> <input type="text" name="Effective_date" id="fromdate" onChange="changeDateFormat(this.value,'fromdate')" class="datepicker fromdate" value="<?php echo date('d-m-Y')?>" maxlength="10" autocomplete="off"></td> 
    
  </tr>
</table>
</div>
<?php

if($_REQUEST['submit']!=='')
		{
		$var = @$_REQUEST['Product_description1'] ;
        $trimmed = trim($var);	
	    $qry="SELECT * FROM `product` where Product_description1 like '%".$trimmed."%' order by  Product_description1 asc";
		}  
		else{
		$qry="SELECT * FROM `product` order by  Product_description1 asc";
		}
		$results=mysql_query($qry);
		$num_rows=mysql_num_rows($results);			
		
	?>
        <div id="colviewajaxid">
        <div class="conscrolls" style="width:100%">
        <table width="100%">
		<thead>
		<tr>
 		<th width="5%"><input type="checkbox" id="selectall"/>Select</th>
  		<th width="25%" align="left">Product</th>
        <th width="30%">Product Description</th>
		<th width="10%" align="center">UOM</th>
        <th width="10%" align="center">Price</th>
        </tr>
		</thead>
   
        <tbody>
        <table id="loadpage" width="100%">
       	<?php
		if(!empty($num_rows)){
		$i=1;
		$c=0;$cc=1;
		while($fetch = mysql_fetch_array($results)) {
		if($c % 2 == 0){ $cls =""; } else{ $cls ="class='odd'"; }
		?>		
		<tr>
        <td  width="5%"><input type="checkbox" name="checkbox[]" value="<?php echo $fetch['Product_code'];?>" class="case"></td>
        <td  width="25%"><input type="hidden" name="Product_code[]" value="<?php echo $fetch['Product_code'];?>"><?php echo $fetch['Product_code'];?></td>
		<td  width="30%"><input type="hidden" name="Product_description1[]" value="<?php echo $fetch['Product_description1'];?>"><?php echo $fetch['Product_description1'];?></td>
		<td  width="10%"><input type="hidden" name="UOM1[]" value="<?php echo $fetch['UOM1']?>" autocomplete="off" size="20"><?php echo $fetch['UOM1'];?></td>
        <td  width="10%" align="center"><input type="text" name="Price[]" value="<?php echo $fetch['Price']; ?>" autocomplete="off" size="5"><?php echo $fetch['Price'];?></td>
		</tr>
		<?php $i++; $c++; $cc++; }		 
		}else{echo "<tr><td align='center' colspan='13'><b>No records found</b></td></tr>";}  ?>
         </table>
        </tbody>
       </table>
  		 </div>   
	 </div>
     
<table width="100%" style="clear:both" align="center">
<tr align="center" height="50px;">
<td colspan="10">
<input type="submit" name="submit" id="submit" class="buttons" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="clear" value="Clear" id="clear" class="buttons" window.location='kdproduct.php'/>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="view" value="View" class="buttons" onclick="window.location='kdProductCategory.php'"/>
</td>
</tr>
</table>   
<?php include("../include/error.php");?>
<div id="errormsgcol" style="display:none;clear:both;">
<h3 align="center" class="myaligncol"></h3><button id="closebutton">Close</button></div>
</div>
</form>
</div>
</div>

<?php include('../include/footer.php'); ?>