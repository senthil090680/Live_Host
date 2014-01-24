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
$page=intval($_REQUEST['page']);
$id=$_REQUEST['id'];
if($_GET['id']!=''){
if($_POST['submit']=='Save'){
if(isset($_POST['SR'])){	
$sql=("UPDATE dsr SET
          KD_Code= '$KD_Code',
		  KD_Name= '$KD_Name', 
		  sperson='$SR', 
          DSR_Code='$DSR_Code',
		  DSRName='$DSRName',
		  SR_Code='$SR_Code',
		  SR_Name='$SR_Name',
	      Contact_Number='$Contact_Number',
		  email_id='$email_id',
		  ASM='$ASM',
		  RSM='$RSM',
		  RSMName='$rsmname'
		  WHERE id = '$id'");
}
elseif(isset($_POST['DSR'])){	
$sql=("UPDATE dsr SET
          KD_Code= '$KD_Code', 
		  KD_Name= '$KD_Name', 
		  sperson= '$DSR'
          DSR_Code='$DSR_Code',
		  DSRName='$DSRName',
		  SR_Code='$SR_Code',
		  SR_Name='$SR_Name',
	      Contact_Number='$Contact_Number',
		  email_id='$email_id',
		  ASM='$ASM',
		  RSM='$RSM',
		  RSMName='$rsmname'
		  WHERE id = '$id'");
}
mysql_query( $sql);
header("location:dsrview.php?no=2&page=$page");
}
}
elseif($_POST['submit']=='Save'){?>
<form action="" method="post" id="resubmitform">
<input type="hidden" name="KD_Code" value="<?php echo $KD_Code; ?>" />
<input type="hidden" name="KD_Name" value="<?php echo $KD_Name; ?>" />
<input type="hidden" name="DSR_Code" value="<?php echo $DSR_Code; ?>" />
<input type="hidden" name="DSRName" value="<?php echo $DSRName; ?>" />
<input type="hidden" name="SR_Code" value="<?php echo $SR_Code; ?>" />
<input type="hidden" name="SR_Name" value="<?php echo $SR_Name; ?>" />
<input type="hidden" name="Contact_Number" value="<?php echo $Contact_Number; ?>" />
<input type="hidden" name="email_id" value="<?php echo $email_id; ?>" />
<input type="hidden" name="ASM" value="<?php echo $ASM; ?>" />
<input type="hidden" name="RSM" value="<?php echo $RSM; ?>" />
<input type="hidden" name="rsmname" value="<?php echo $rsmname; ?>" />
<input type="hidden" name="no" value="9" />
 
</form>
<form action="" method="post" id="dataexists">
<input type="hidden" name="KD_Code" value="<?php echo $KD_Code; ?>" />
<input type="hidden" name="KD_Name" value="<?php echo $KD_Name; ?>" />
<input type="hidden" name="DSR_Code" value="<?php echo $DSR_Code; ?>" />
<input type="hidden" name="DSRName" value="<?php echo $DSRName; ?>" />
<input type="hidden" name="SR_Code" value="<?php echo $SR_Code; ?>" />
<input type="hidden" name="SR_Name" value="<?php echo $SR_Name; ?>" />
<input type="hidden" name="Contact_Number" value="<?php echo $Contact_Number; ?>" />
<input type="hidden" name="email_id" value="<?php echo $email_id; ?>" />
<input type="hidden" name="ASM" value="<?php echo $ASM; ?>" />
<input type="hidden" name="RSM" value="<?php echo $RSM; ?>" />
<input type="hidden" name="rsmname" value="<?php echo $rsmname; ?>" />
<input type="hidden" name="no" value="18" />
<input type="hidden" name="page" value="<?php echo $page; ?>" />
</form>

<form action="" method="post" id="email">
<input type="hidden" name="KD_Code" value="<?php echo $KD_Code; ?>" />
<input type="hidden" name="KD_Name" value="<?php echo $KD_Name; ?>" />
<input type="hidden" name="DSR_Code" value="<?php echo $DSR_Code; ?>" />
<input type="hidden" name="DSRName" value="<?php echo $DSRName; ?>" />
<input type="hidden" name="SR_Code" value="<?php echo $SR_Code; ?>" />
<input type="hidden" name="SR_Name" value="<?php echo $SR_Name; ?>" />
<input type="hidden" name="Contact_Number" value="<?php echo $Contact_Number; ?>" />
<input type="hidden" name="email_id" value="<?php echo $email_id; ?>" />
<input type="hidden" name="ASM" value="<?php echo $ASM; ?>" />
<input type="hidden" name="RSM" value="<?php echo $RSM; ?>" />
<input type="hidden" name="rsmname" value="<?php echo $rsmname; ?>" />
<input type="hidden" name="no" value="11" />
<input type="hidden" name="page" value="<?php echo $page; ?>" />
</form>

<?php	
if($DSRName=='')
{?>

<script type="text/javascript">
document.forms['resubmitform'].submit();
</script>

<?php //header("location:SalesRep.php?no=9");exit;
}
else{
$sel="select * from dsr where DSR_Code ='$DSR_Code'";
$sel_query=mysql_query($sel);
		if(mysql_num_rows($sel_query) == 0) {
			
		if(isset($_POST['SR'])){
		
	    $sql="INSERT INTO `dsr`(`KD_Code`,`KD_Name`,`sperson`,`DSR_Code`,`DSRName`,`SR_Code`,`SR_Name`,`Contact_Number`,`email_id`,`ASM`,`RSM`,`RSMName`)
                         values('$KD_Code','$KD_Name','$SR','$DSR_Code','$DSRName','$SR_Codesr','$SR_Name','$Contact_Number','$email_id','$ASM','$RSM','$rsmname')";	
		mysql_query( $sql);
			}
		elseif(isset($_POST['DSR'])){
			
        $sql="INSERT INTO `dsr`(`KD_Code`,`KD_Name`,`sperson`,`DSR_Code`,`DSRName`,`SR_Code`,`SR_Name`,`Contact_Number`,`email_id`,`ASM`,`RSM`,`RSMName`)
                        values('$KD_Code','$KD_Name','$DSR','$DSR_Code','$DSRName','$SR_Code','$SR_Name','$Contact_Number','$email_id','$ASM','$RSM','$rsmname')";
		mysql_query( $sql);
		}
		
	    header("location:dsrview.php?no=1&page=$page");
		}
		
		else {?>
        <script type="text/javascript">
		document.forms['dataexists'].submit();
		</script>
        <?php
		//header("location:SalesRep.php?no=18&page=$page");
		}
    }

}
$id=$_GET['id'];
$list=mysql_query("select * from  dsr where id= '$id'");
while($row = mysql_fetch_array($list)){ 
	$KD_Code = $row['KD_Code'];
	$KD_Name = $row['KD_Name'];
	$DSR_Code = $row['DSR_Code'];
	$DSRName = $row['DSRName'];
	$SR_Code = $row['SR_Code'];
	$SR_Name = $row['SR_Name'];
	$sperson = $row['sperson'];
	$Contact_Number	=$row['Contact_Number'];
	$email_id	=$row['email_id'];
	$ASM	=$row['ASM'];
	$RSM	=$row['RSM'];
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

function rsmcode()
{
	var val=$('#asm option:selected').text();
	 $.ajax({
            url: 'get_kdcodesr.php?val=' + val,
            success: function(data) {
				//alert(data);
				var value=$.trim(data);//To Remove White Space in string
				var value1=data.substring(0,value.length-1);//To return part of the string
				//alert(value);
				var list= value1.split("|");
				$("#RSM").val(list[1]);
				//alert(arr_i[0]);
				$("#rsmname").val(list[0]);
			}
    });
}


function kdcode()
{
	var val=$('#KD_Code option:selected').text();
	 $.ajax({
            url: 'get_rsmkdname.php?val=' + val,
            success: function(data) {
				//alert(data);
				var value=$.trim(data);//To Remove White Space in string
				var value1=data.substring(0,value.length-1);//To return part of the string
				var list= value1.split("|"); 
				for (var i=0; i<list.length; i++) {
					var arr_i= list[i].split("^");
					//alert(arr_i[6]);
					//$("#kd_category").val(arr_i[0]);
					$("#kdname").val(arr_i[0]);
					//selectcheck(arr_i[0]);
					
			}

			}
        });
}


function srcode()
{
	var val=$('#SR_Codesr option:selected').text();
	 $.ajax({
            url: 'get_codesr.php?val=' + val,
            success: function(data) {
				//alert(data);
				var value=$.trim(data);//To Remove White Space in string
				var value1=data.substring(0,value.length-1);//To return part of the string
				var list= value1.split("|"); 
				for (var i=0; i<list.length; i++) {
					var arr_i= list[i].split("^");
					//alert(arr_i[6]);
					$("#DSRName").val(arr_i[0]);
					$("#SR_name").val(arr_i[0]);
					$("#SR_Codes").val(arr_i[1]);
					$("#Contact_Number").val(arr_i[2]);
					$("#email_id").val(arr_i[3]);
					
				}

			}
        });
}


function srcodes()
{
	var val=$('#SR_Code option:selected').text();
	 $.ajax({
            url: 'get_codesr.php?val=' + val,
            success: function(data) {
				//alert(data);
				var value=$.trim(data);//To Remove White Space in string
				var value1=data.substring(0,value.length-1);//To return part of the string
				var list= value1.split("|"); 
				for (var i=0; i<list.length; i++) {
					var arr_i= list[i].split("^");
					//alert(arr_i[6]);
					$("#SR_name").val(arr_i[0]);
								
				}

			}
        });
}


function validatedsr() {
	var Sperson				=	$('#sperson').val();
	var DSRName				=	$('#DSRName').val();
    var ASM					=	$('#asm').val();
	var SRCodess            =   $('#SR_Codes').val();
	var KDCode			    =	$('#KD_Code').val();
	var email_id			=	$('#email_id').val();
	var Contactnumber       =   $('#Contact_Number').val();
	var amtpat	= /^[0-9.]+$/;
	
   if(Sperson == ''){
		$('.myaligncol').html('ERR :Select DSR/SR');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}
 
 /* if(SRCodess == ''){
		$('.myaligncol').html('ERR : Select SR Code');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}
*/

    if(DSRName == ''){
		$('.myaligncol').html('ERR : Enter DSR Name');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}


if (Contactnumber !== "") { 
  if(!amtpat.test(Contactnumber)){
			$('.myaligncol').html('ERR : Enter Only Numeric Contact No!');
			$('#errormsgcol').css('display','block');
			setTimeout(function() {
				$('#errormsgcol').hide();
			},5000);
			return false;
		}
}
		
if (email_id !== "") {  // If something was entered
    if (!isValidEmailAddress(email_id)) {
      		$('.myaligncol').html('ERR : Enter Valid Email Id!');
			$('#errormsgcol').css('display','block');
			setTimeout(function() {
				$('#errormsgcol').hide();
			},5000);
        return false;  
    }
} 

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
};	
	
	if(ASM == ''){
     $('.myaligncol').html('ERR : Select ASM');
	 $('#errormsgcol').css('display','block');
	 setTimeout(function() {
	  $('#errormsgcol').hide();
		 },5000);
		 return false;
		}
		
	 if(KDCode == ''){
     $('.myaligncol').html('ERR : Select KDCODE');
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
<div align="center" class="headingspro"  style="padding-right:10px;">DSR</div>
<div id="mytableproduc_pro" align="center" style="padding-right:10px;">
<form action="" method="post" onsubmit="return validatedsr()">
  <fieldset class="alignment">
  <legend><strong>DSR Parameters</strong></legend>    
  <table width="100%"> 
    <tr height="70">
    <td class="align">
    DSR*&nbsp;&nbsp;<input type="radio"  name="DSR" value="DSR" <?php echo ($sperson == 'DSR')?"checked" : "" ;  ?> id="DSRS">
    </td>
    <td class="align">
    SR*&nbsp;&nbsp;<input type="radio" name="SR" value="SR" <?php echo ($sperson == 'SR')?"checked" : "" ;  ?> id="SRS">
    </td>

   
    <td class="align">SR Code*</td>
     <td>
		<?php 
        $list=mysql_query("select * from  sr  order by SR_Code asc"); 
        ?>
        <select name="SR_Code" id="SR_Code"  onchange="return srcodes()">
        <option value="">--- SR ---</option>
		<?php 		
		while($row_list=mysql_fetch_assoc($list)){ 
		$id=$row_list['SR_Name'];
		?>
        <option value="<?php echo $row_list['SR_Code']; ?>" <?php if($row_list['SR_Code']==$SR_Code){ echo "selected"; } ?>><?php echo $row_list['SR_Code']; ?></option>
        <?php  } ?>
        </select>   
        
        
        <?php 
        $list=mysql_query("select * from  sr  order by SR_Code asc"); 
        ?>
        <select name="SR_Codesr" id="SR_Codesr" onchange="return srcode()">
        <option value="">--- SR ---</option>
		<?php 		
		while($row_list=mysql_fetch_assoc($list)){ 
		$id=$row_list['SR_Name'];
		?>
        <option value="<?php echo $row_list['SR_Code']; ?>" <?php if($row_list['SR_Code']==$SR_Code){ echo "selected"; } ?>><?php echo $row_list['SR_Code']; ?></option>
        <?php  } ?>
        </select>           
        </td> 
        
        
          
   <td>SR Name</td>
   <td><input type="text" name="SR_Name" id="SR_name"  value="<?php echo $SR_Name; ?>" autocomplete='off'/></td>  
    
    
    <td class="align" style="text-transform:uppercase">DSR Code</td>
    	<?php
		 if(!isset($_GET[id]) && $_GET[id] == '') {
			$srid					=	"SELECT DSR_Code FROM dsr ORDER BY id DESC";
			$srold					=	mysql_query($srid) or die(mysql_error());
			$srcnt					=	mysql_num_rows($srold);
			//$srcnt					=	0; // comment if live
			if($srcnt > 0) {
				$row_sr					  =	 mysql_fetch_array($srold);
				$srnumber	  =	$row_sr['DSR_Code'];

				$getsrno						=	abs(str_replace("DSR",'',strstr($srnumber,"DSR")));
				$getsrno++;
				if($getsrno < 10) {
					$createdcode	=	"00".$getsrno;
				} else if($getsrno < 100) {
					$createdcode	=	"0".$getsrno;
				} else {
					$createdcode	=	$getsrno;
				}

				$DSR_Code				=	"DSR".$createdcode;
			} else {
				$DSR_Code				=	"DSR001";
			}
		}
	?>
    <td>
    <input type="text" name="DSR_Code" size="10"  id="DSR_Code" value="<?php echo $DSR_Code; ?>"   readonly="readonly"  maxlength="10" autocomplete='off'/>
    </td>
    </tr>
    </table>
</fieldset>



<fieldset class="alignment">
<legend><strong>DSR Datas</strong></legend>
<table width="100%">
    <tr height="70">
    <td class="pclr align">Name*</td>
    <td><input type="text" name="DSRName"  id="DSRName" size="30" value="<?php echo $DSRName; ?>" autocomplete='off' maxlength="40" /></td>

    
    <td class="align">Contact Number</td>
    <td><input type="text" name="Contact_Number" id="Contact_Number" size="15" value="<?php echo $Contact_Number; ?>" maxlength="20" autocomplete='off'/></td> 
    
    <td class="align">Email ID</td>
    <td  colspan="5" width="20"><input type="text" name="email_id" id="email_id" size="30" value="<?php echo $email_id; ?>" maxlength="30" autocomplete='off'/></td>
    </tr>

</table>
</fieldset>  
 
 <fieldset class="alignment">
 <legend><strong>Supervisor</strong></legend>
 <table width="100%"> 
    <tr height="60">
     <td class="align">ASM*</td>
     <td>
		<?php 
        $list=mysql_query("select * from  asm_sp order by DSRName  asc"); 
        ?>
        <select name="ASM" id="asm" onChange="return rsmcode();">
        <option value="">--- ASM ---</option>
		<?php 		
		while($row_list=mysql_fetch_assoc($list)){ 
		$id=$row_list['ASM'];
		?>
        <option value="<?php echo $row_list['id']; ?>" <?php if($row_list['id']==$ASM){ echo "selected"; } ?>><?php echo $row_list['DSRName']; ?></option>
        <?php  } ?>
        </select>         
          </td>
          
        <td class="align">RSM</td>
        <td>
         <input type="hidden" name="RSM" size="10" id="RSM" />
         <input type="text" name="rsmname" size="10" id="rsmname" value="<?php
            $sambr=mysql_query("select * from  rsm_sp where id = $RSM");
            $row=mysql_fetch_array($sambr);
            $rsmid=$row['id'];
            $rsmv=$row['DSRName'];
            if($RSM=$rsmid){echo $rsmv;}?>" autocomplete='off' maxlength="50"/></td>  
        
         <td>KD Code*</td>
         <td><select name="KD_Code" id="KD_Code" onchange="kdcode();">
        <option value="">--- Select ---</option>
        <?php 
        // Get records from database (table "name_list"). 
        $list=mysql_query("select * from kd order by KD_Name asc"); 
        
        // Show records by while loop. 
        while($row_list=mysql_fetch_assoc($list)){ 
        ?>
        <option value="<?php echo $row_list['KD_Code']; ?>" <?php if($row_list['KD_Code']==$KD_Code){ echo "selected"; } ?>><?php echo $row_list['KD_Code']; ?></option>
        <?php 
        // End while loop. 
        } 
        ?>
     </select></td> 
     <td>KD Name</td>
     <td><input type="text" name="KD_Name" id="kdname" value="<?php echo $KD_Name; ?>" autocomplete="off"/></td>

    </tr> 
</table>
</fieldset>

<table height="40">
    <tr height="70px"align="center">
    <td colspan="10">
    <input type="submit" name="submit" id="submit" class="buttons" value="Save"/>&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="reset" name="reset"  class="buttons" value="Clear" id="clear" onclick="window.location='dsr.php'" />&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/>&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="button" name="view" value="View" class="buttons" onclick="window.location='dsrview.php'"/>
     </td>
    </tr>
</table>
</form>
</div>
<div class="mcf"></div> 
<?php include("../include/error.php");?>
<div id="errormsgcol" style="display:none;clear:both;">
<h3 align="center" class="myaligncol"></h3><button id="closebutton">Close</button></div>
 </div>

<?php include('../include/footer.php'); ?>