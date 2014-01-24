<?php
ob_start();
include('../include/header.php');
include "../include/ps_pagination.php";
EXTRACT($_POST);	
//Insert Query

$Product_code = $_POST['Product_code'];
$page=intval($_GET['page']);
$id=$_REQUEST['id'];
if($_GET['Product_code']!=''){
if($_POST['submit']=='Save'){
if($kd_category==''|| $Price=='' || $Effective_date=='')
{
header("location:price.php?no=9");
}
else{
$sql=("UPDATE price_master SET
		KD_Code= '$KD_Code',
		kd_category='$kd_category',
		kdprice='$kdprice',
		Product_code='$Product_code[$i]',
		Product_description1='$Product_description1[$i]',
		UOM1='$UOM1',
		Price='$Price[$i]',
		Effective_date='$Effective_date'
		WHERE id = '$id'");
mysql_query( $sql);
header("location:priceview.php?no=2&$page=$page");
}
}
}
else if($_POST['submit']=='Save')
{?>

<form action="" method="post" id="resubmitform">
<input type="hidden" name="kd_category" value="<?php echo $kd_category; ?>" />
<input type="hidden" name="kdprice" value="<?php echo $kdprice; ?>" />
<input type="hidden" name="Effective_date" value="<?php echo $Effective_date; ?>" />
<input type="hidden" name="Product_code[]" value="<?php echo $Product_code; ?>" />
<input type="hidden" name="Product_description1[]" value="<?php echo $Product_description1; ?>" />
<input type="hidden" name="UOM1" value="<?php echo $UOM1; ?>" />
<input type="hidden" name="Price[]" value="<?php echo $Price; ?>" />
<input type="hidden" name="no" value="9" />
 
</form>
<form action="" method="post" id="dataexists">
<input type="hidden" name="kd_category" value="<?php echo $kd_category; ?>" />
<input type="hidden" name="kdprice" value="<?php echo $kdprice; ?>" />
<input type="hidden" name="Effective_date" value="<?php echo $Effective_date; ?>" />
<input type="hidden" name="Product_code[]" value="<?php echo $Product_code; ?>" />
<input type="hidden" name="Product_description1[]" value="<?php echo $Product_description1; ?>" />
<input type="hidden" name="UOM1" value="<?php echo $UOM1; ?>" />
<input type="hidden" name="Price[]" value="<?php echo $Price; ?>" />
<input type="hidden" name="no" value="18" />
<input type="hidden" name="page" value="<?php echo $page; ?>" />
</form>
<?php
if($kd_category==''|| $Price=='' || $Effective_date=='')
			{?>
			<script type="text/javascript">
			document.forms['resubmitform'].submit();
			return false;
            </script>
			 <?php //header("location:price.php?no=9");
			}
			else
			{	
			  	$sel1="select * from price_master where kd_category='$kd_category'"; 
				$sel_query1=mysql_query($sel1);
				$row=mysql_num_rows($sel_query1);
				for($i=0;$i<sizeof($Product_code);$i++){
				if($row === 0) {
				$query=mysql_query("INSERT INTO price_master(KD_Code,kd_category,kdprice,Product_code, Product_description1, UOM1,Price,Effective_date)
				VALUES('".$KD_Code."','".$kd_category."','".$kdprice."','".$Product_code[$i]."',
				'".$Product_description1[$i]."', '".$UOM1."','".$Price[$i]."','".$Effective_date."')");
				header("location:priceview.php?no=1&page=$page");
                 }
				else
				{ ?>
				<script type="text/javascript">
                document.forms['dataexists'].submit();
				</script>
                <?php
				//header("location:price.php?no=18&page=$page");exit;
			}
		}
	}
}

$id=$_GET['id'];
$list=mysql_query("select * from price_master where id= '$id'"); 
while($row = mysql_fetch_array($list)){ 
    $kd_category = $row['kd_category']; 
	$kdprice = $row['kdprice']; 
	$Product_code = $row['Product_code'];
	$Product_description1 = $row['Product_description1'];
	$UOM1 = $row['UOM1'];
	$Price = $row['Price'];
	$Effective_date = $row['Effective_date'];
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
</style>

<script type="text/javascript">

function validateform() {
	var kdcategory				=	$('#kd_category').val();
	var kdprice          		=	$('#kdprice').val();
	var fromdate        		=	$('#fromdate').val();
	var price                   =   $('#price').val();
	

	
	if(kdcategory == ''){
		$('.myaligncol').html('ERR : Enter Product Code');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}

	if(kdprice == ''){
		$('.myaligncol').html('ERR : Enter kdprice');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}

  	if(fromdate == ''){
		$('.myaligncol').html('ERR : Enter Effective Date');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}

   
   if(price == ''){
	 	$('.myaligncol').html('ERR : Enter Price');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		} ,5000);
		return false;
	 }
	 
  	$('#errormsgcol').css('display','none');
	//return false;
	
}


//Load Price Page
				logProgress(Product_code);
				function logProgress(Product_code)
				{
					//alert(Product_code); 
					var process = $("#kd_category").val();
					var posting = $.post("log.php", {process: process,"Product_code" : Product_code});
					posting.done(function(data) {
						$("#log").html(data);
						
                       	//$('#kd_category')[0].selectedIndex = 0;
					});
					
					
			var val=$('#kd_category option:selected').text();
	        $.ajax({
            url: 'get_kdcodeproduct.php?val=' + val,
            success: function(data) {
				//alert(data);
				var value=$.trim(data);//To Remove White Space in string
				var value1=data.substring(0,value.length-1);//To return part of the string
				var list= value1.split("|"); 
				for (var i=0; i<list.length; i++) {
					var arr_i= list[i].split("^");
					//alert(arr_i[6]);
					$("#KD_Code").val(arr_i[0]);
					//alert(arr_i[0]);
					$("#Product_Code").val(arr_i[1]);
					
			}

			}
        });
}
</script>
<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headingskdp">Price</div>
<div class="mytable3">
<div class="mcf"></div>
<form method="post" onsubmit="return validateform()">
<div class="headfile" align="center">
<table width="90%" align="center">
  <tr>
    <td width="100">KD Category*
	<td>
   
    <select name="kd_category" class="kd_category" id="kd_category"  autocomplete="off"  value="" onchange="logProgress()"; > 
			<option value="">--- Select ---</option>
			<?php 
			$list=mysql_query("select * from  kd_category order by  kd_category asc"); 
			while($row=mysql_fetch_assoc($list)){
			?>
			<option value='<?php echo $row['kd_category']; ?>'<?php if($row['kd_category']==$kd_category){ echo 'selected' ; }?>
			><?php echo $row['kd_category']; ?></option>
			<?php 
			// End while loop. 
			} 
			?>
			</select>
        <input type="hidden" name="KD_Code" id="KD_Code" value="" />  
        <input type="hidden" name="Product_Code" id="Product_Code" value="" />     
    </td>
    
     <td width="50" class="align">KD Price*
	<td>
   
    <select name="kdprice" class="kdprice" id="kdprice"  autocomplete="off"  value="" > 
			<option value="">--- Select ---</option>
			<?php 
			$list=mysql_query("select * from  kdprice order by  kdprice asc"); 
			while($row=mysql_fetch_assoc($list)){
			?>
			<option value='<?php echo $row['id']; ?>'<?php if($row['id']==$kdprice){ echo 'selected' ; }?>
			><?php echo $row['kdprice']; ?></option>
			<?php 
			// End while loop. 
			} 
			?>
			</select>
        <input type="hidden" name="KD_Code" id="KD_Code" value="" />  
        <input type="hidden" name="Product_Code" id="Product_Code" value="" />     
    </td>
    
     <td class="align">Effective Date</td>
    <td> <input type="text" name="Effective_date" id="fromdate" onChange="changeDateFormat(this.value,'fromdate')" class="datepicker fromdate" value="<?php echo date('Y-m-d')?>" maxlength="10" autocomplete="off"></td> 
  </tr>
</table>
</div>
<?php

if($_GET['submit']!=='')
		{
		$var = @$_GET['Product_description1'] ;
        $trimmed = trim($var);	
	    $qry="SELECT * FROM `kd_product` where Product_description1 like '%".$trimmed."%' order by Product_description1 asc";
		}  
		$results=mysql_query($qry);
		$num_rows= mysql_num_rows($results);			
		$pager = new PS_Pagination($bd, $qry,8,8);
		$results = $pager->paginate();
		?>
        
        
   <div id="log"> </div>    
   
    
<!--Pagination  -->
 
		<?php 
		if($num_rows > 10){?>     
        <div class="paginationfile" align="center">
	    <?php 
		//Display the link to first page: First
		echo $pager->renderFirst()."&nbsp; ";
		//Display the link to previous page: <<
		echo $pager->renderPrev();
		//Display page links: 1 2 3
		echo $pager->renderNav();
		//Display the link to next page: >>
		echo $pager->renderNext()."&nbsp; ";
		//Display the link to last page: Last
		echo $pager->renderLast();  ?>      
		</div>   
		<?php } else{ echo "&nbsp;"; }?>
        
        
<table width="100%" style="clear:both" align="center">
<tr align="center" height="50px;">
<td colspan="10">
<input type="submit" name="submit" id="submit" class="buttons" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="clear" value="Clear" id="clear" class="buttons" onclick="return priclr();" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="view" value="View" class="buttons" onclick="window.location='priceview.php'"/>
</td>
</tr>
</table>   
<?php include("../include/error.php");?>
</form>
</div>
<div id="errormsgcol" style="display:none;clear:both;">
<h3 align="center" class="myaligncol"></h3><button id="closebutton">Close</button></div>
</div>   
</div>
<?php include('../include/footer.php'); ?>