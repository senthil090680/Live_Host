<?php 
ob_start();
include('../include/config.php');
//include "../include/ps_pagination.php";
EXTRACT($_REQUEST);
//Insert Query
//print_r($_REQUEST);
$page=intval($_GET['page']);
//$id = intval($_GET['id']);
if($submit=='Save')
{
			if($kd_category=='')
			{
			//echo "Enter Mandatory Fields";
			header("location:kdProduct.php?no=9"); 
			}
			else
			{				
				$cnt=count($_POST['checkbox']);
				/*echo "<pre>";
				print_r($_REQUEST);
				echo "</pre>";
				exit;*/
		        for($j=0;$j<$cnt;$j++){
			    $checkbox=$_POST['checkbox'][$j];
				$sel1="select * from kd_product where Product_code ='$checkbox' AND kd_category='$kd_category'"; 
				$sel_query1=mysql_query($sel1);
				$count = mysql_num_rows($sel_query1);
				$rows=mysql_fetch_array(sel_query1);
				//$id=$rows['id'];
				if($count == 1)
				{
				$list=mysql_query("select * from  product where Product_code ='$checkbox'");
				$res=mysql_fetch_array($list);
			    $Product_description1=$res['Product_description1'];
				$UOM=$res['UOM1'];
				$Price =$_POST['Price'][$j];	
	        	$lists=mysql_query("select * from  kd_product");
				$row=mysql_fetch_array($lists);
				$Product_code = $row['Product_code'];
				$sql = mysql_query("UPDATE kd_product SET 
							Price='$Price',
							Effective_date='$Effective_date'
							WHERE Product_code = $Product_code");	
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
			} //else 
		}
	
?>
<!------------------------------- Form -------------------------------------------------->
<SCRIPT language="javascript">
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

		<?php
		$qry="SELECT * FROM `product` where product_type='Standard' order by  Product_description1 asc";
		$results=mysql_query($qry);
		$num_rows=mysql_num_rows($results);			
		//$pager = new PS_Pagination($bd, $qry,10,10);
		//$results = $pager->paginate();
		

		if(!empty($num_rows)){
		$i=1;
		$c=0;$cc=1;
		while($fetch = mysql_fetch_array($results)) {
			
			$Product_Code =$fetch['Product_Code'];
			
			$qry_kdspecific 		= 	"SELECT * FROM `kd_product` where KD_Code = '$KD_Code' AND Product_code = '$fetch[Product_code]' ";
			$res_kdspecific 		= 	mysql_query($qry_kdspecific);
			$rowcnt_kdspecific 		= 	mysql_num_rows($res_kdspecific);
			if($rowcnt_kdspecific > 0) {
				while($row_kdspecific		=	mysql_fetch_array($res_kdspecific)) {
					$kdspecific_prod[]	=	$row_kdspecific[Product_code];
					$kdspecific_price	=	$row_kdspecific[Price];
				}
			}
			$kdspecific_prodstr		=	implode(",",$kdspecific_prod);
			$kdspecific_pricestr	=	implode(",",$kdspecific_price);
						
		if($c % 2 == 0){ $cls =""; } else{ $cls ="class='odd'"; }
		?>	
        	
        <table width="100%">
       	<tr>
        <td width="5%"><input type="checkbox" <?php //echo $fetch[Product_code]; echo "_".$kdspecific_prodstr;
		if(strstr($kdspecific_prodstr,$fetch[Product_code])) {
				echo "checked";
		} //else { echo "not"; }
			?> name="checkbox[]" value="<?php echo $fetch['Product_code'];?>" class="case"></td>
        <td width="25%"><input type="hidden" name="Product_code[]" value="<?php echo $fetch['Product_code'];?>"><?php echo $fetch['Product_code'];?></td>
		<td width="30%"><input type="hidden" name="Product_description1[]" value="<?php echo $fetch['Product_description1'];?>"><?php echo $fetch['Product_description1'];?></td>
		<td width="10%"><input type="hidden" name="UOM1[]" value="<?php echo $fetch['UOM1']?>" autocomplete="off" size="20" maxlength="20"><?php echo $fetch['UOM1'];?></td>
        <td width="10%" align="center"><input type="text" name="Price[]" value="<?php //echo $fetch[Product_code]; echo "_".$kdspecific_prodstr;
		if(strstr($kdspecific_prodstr,$fetch[Product_code])) {
				echo "$kdspecific_price";
		} ?>" autocomplete="off" size="5"></td>
		</tr>
        
        
		<?php $i++; $c++; $cc++; }		 
		}else{echo "<tr><td align='center' colspan='13'><b>No records found</b></td></tr>";}  ?>
        </table>
       
      
<?php exit; ?>