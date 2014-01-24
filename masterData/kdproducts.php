<?php
ob_start();
include('../include/header.php');
//include "../include/ps_pagination.php";
include('../include/ajax_pagination.php');
EXTRACT($_REQUEST);	
//Insert Query

$page=intval($_GET['page']);
//$id=intval($_GET['id']);
//$id=$_REQUEST['id'];
if($submit=='Save')
{
		
    $cnt=count($_POST['checkbox']);
	for($j=0;$j<$cnt;$j++){
	$checkbox=$_POST['checkbox'][$j];
	$Price =$_POST['Price'][$j];
	$id =$_POST['id'][$j];
	$sel1=mysql_query("select * from kd_product where Product_code ='$checkbox' AND kd_category='$kd_category'"); 
	$count = mysql_num_rows($sel1);
	if($count!== 0)
	{
    mysql_query("UPDATE kd_product SET 
				 Price='$Price',
				 Effective_date='$Effective_date'
				 WHERE id = '".$checkbox."'");

	header("location:kdProduct.php?no=2&page=$page");exit;
	}
	
	elseif($count ==0) {
	$list=mysql_query("select * from  product where Product_code ='$checkbox'");
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
	} //for loop 
  	
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

</style>
<SCRIPT language="javascript">
function colviewajax(page,params){   // For pagination and sorting of the Collection Deposited view page
	var splitparam		=	params.split("&");
	var Challan_Number	=	splitparam[0];
	var sortorder		=	splitparam[1];
	var ordercol		=	splitparam[2];
	$.ajax({
		url : "CollectionDepositedviewajax.php",
		type: "get",
		dataType: "text",
		data : { "Challan_Number" : Challan_Number, "sortorder" : sortorder, "ordercol" : ordercol, "page" : page },
		success : function(dataval) {
			var trimval		=	$.trim(dataval);
			//alert(trimval);
			$("#colviewajaxid").html(trimval);
		}
	});
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
<form method="post" action="" name="register">
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
			<option value='<?php echo $row['kd_category']; ?>'<?php if($row['kd_category']==$_GET['data']){ echo 'selected'; }?>
			><?php echo $row['kd_category']; ?></option>
			<?php 
			// End while loop. 
			} 
			?>
			</select>
     
         <input type="hidden" name="KD_Code" id="KD_Code" value="" />
    </td>
    
    
       <td class="align">Effective Date</td>
    <td> <input type="text" name="Effective_date" id="fromdate" onChange="changeDateFormat(this.value,'fromdate')" class="datepicker fromdate" value="<?php echo date('Y-m-d')?>" maxlength="10" autocomplete="off"></td> 
    
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
		//$pager = new PS_Pagination($bd, $qry,10,10);
		//$results = $pager->paginate();
		
$params	=	$Challan_Number."&".$sortorder."&".$ordercol;		
		
/********************************pagination start***********************************/
$strPage = $_REQUEST[page];
//$params = $_REQUEST[params];

//if($_REQUEST[mode]=="Listing"){
//$Num_Rows = mysql_num_rows ($res_search);

########### pagins

$Per_Page = 12;   // Records Per Page

$Page = $strPage;
if(!$strPage)
{
	$Page=1;
}

$Prev_Page = $Page-1;
$Next_Page = $Page+1;

$Page_Start = (($Per_Page*$Page)-$Per_Page);
if($num_rows<=$Per_Page)
{
$Num_Pages =1;
}
else if(($num_rows % $Per_Page)==0)
{
$Num_Pages =($num_rows/$Per_Page) ;
}
else
{
$Num_Pages =($num_rows/$Per_Page)+1;
$Num_Pages = (int)$Num_Pages;
}
if($sortorder == "")
{
	$orderby	=	"ORDER BY id DESC";
} else {
	$orderby	=	"ORDER BY $ordercol $sortorder";
}
$qry.=" $orderby LIMIT $Page_Start,$Per_Page";  //need to uncomment
//exit;
$results_dsr = mysql_query($qry);
/********************************pagination***********************************/
	?>
        <div id="colviewajaxid">
        <div class="conscrolls" style="width:100%">
        <table width="100%">
		<thead>
		<tr>
 		<th width="5%"><input type="checkbox" id="selectall"/>Select</th>
  		<th width="25%" align="left">Product</th>
        			<?php //echo $sortorderby;
				if($sortorder == 'ASC') {
					$sortorderby = 'DESC';
				} elseif($sortorder == 'DESC') {
					$sortorderby = 'ASC';
				} else {
					$sortorderby = 'DESC';
				}
				$paramsval	=	$Challan_Number."&".$sortorderby."&Bank_Name"; ?>
				<th nowrap="nowrap" class="rounded" onClick="colviewajax('<?php echo $Page; ?>','<?php echo $paramsval; ?>');">Bank Name<img src="../images/sort.png" width="13" height="13" /></th>
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
        <td  width="5%">
        <input type="hidden" name="id[]" value="<?php echo $fetch['id'];?>">
        <input type="checkbox" name="checkbox[]" value="<?php echo $fetch['Product_code'];?>" class="case"></td>
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
			 <div class="paginationfile" align="center">
			 <table>
			 <tr>
			 <th class="pagination" scope="col">          
			<?php 
			if(!empty($num_rows)){
				rendering_pagination_common($Num_Pages,$Page,$Prev_Page,$Next_Page,$params,'colviewajax');   //need to uncomment
			} else { 
				echo "&nbsp;"; 
			} ?>      
			</th>
			</tr>
			</table>
		  </div>
       
		 </div>
<!--Pagination  -->
 
<?php /*?>		<?php 
		if($num_rows >10){?>     
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
		<?php } else{ echo "&nbsp;"; }?><?php */?>
      
</div>        
<table width="100%" style="clear:both" align="center">
<tr align="center" height="50px;">
<td colspan="10">
<input type="submit" name="Update" id="submit" value="Update" class="buttons"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" name="submit" id="submit" class="buttons Effective_date_update_submit" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="clear" value="Clear" id="clear" class="buttons" window.location='kdproduct.php'/>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="view" value="View" class="buttons" onclick="window.location='kdProductCategory.php'"/>
</td>
</tr>
</table>   
<?php include("../include/error.php");?>
     
</form>
</div>
</div>

<?php include('../include/footer.php'); ?>