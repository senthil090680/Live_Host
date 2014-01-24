<?php
session_start();
ob_start();
include('../include/header.php');
if(isset($_GET['logout'])){
session_destroy();
header("Location:../index.php");
}

EXTRACT($_POST);
$page=intval($_GET['page']);
$id=$_REQUEST['id'];
if($_GET['id']!=''){
if($_POST['submit']=='Save'){
$sql=("UPDATE kd SET 
          KD_Code= '$KD_Code', 
          KD_Name='$KD_Name', 
          Address_Line_1='$Address_Line_1',
		  Address_Line_2='$Address_Line_2',
		  Address_Line_3='$Address_Line_3',
		  City='$City',
		  lga='$lga',
		  branch_id='$branch_id',
		  Pin='$Pin',
		  Contact_Person='$Contact_Person',
		  Contact_Number='$Contact_Number',
		  Email_ID='$Email_ID',
		  kd_category='$kd_category',
		  kd_analysis='$kd_analysis',
		  miscellaneous_caption='$miscellaneous_caption',
		  miscellaneous_data='$miscellaneous_data'
		  WHERE id = $id");
mysql_query( $sql);
header("location:kdview.php?no=2&page=$page");
}
}
elseif($_POST['submit']=='Save'){?>
<form action="" method="post" id="resubmitform">
<input type="hidden" name="KD_Code" value="<?php echo $KD_Code; ?>" />
<input type="hidden" name="KD_Name" value="<?php echo $KD_Name; ?>" />
<input type="hidden" name="Address_Line_1" value="<?php echo $Address_Line_1; ?>" />
<input type="hidden" name="Address_Line_2" value="<?php echo $Address_Line_2; ?>" />
<input type="hidden" name="Address_Line_3" value="<?php echo $Address_Line_3; ?>" />
<input type="hidden" name="City" value="<?php echo $City; ?>" />
<input type="hidden" name="City" value="<?php echo $lga; ?>" />
<input type="hidden" name="City" value="<?php echo $branch_id; ?>" />
<input type="hidden" name="Pin" value="<?php echo $Pin; ?>" />
<input type="hidden" name="Contact_Person" value="<?php echo $Contact_Person; ?>" />
<input type="hidden" name="Contact_Number" value="<?php echo $Contact_Number; ?>" />
<input type="hidden" name="Email_ID" value="<?php echo $Email_ID; ?>" />
<input type="hidden" name="kd_category" value="<?php echo $kd_category; ?>" />
<input type="hidden" name="kd_analysis" value="<?php echo $kd_analysis; ?>" />
<input type="hidden" name=" miscellaneous_caption" value="<?php echo $miscellaneous_caption; ?>" />
<input type="hidden" name="miscellaneous_data" value="<?php echo $miscellaneous_data; ?>" />
<input type="hidden" name="no" value="9" />
 
</form>
<form action="" method="post" id="dataexists">
<input type="hidden" name="KD_Code" value="<?php echo $KD_Code; ?>" />
<input type="hidden" name="KD_Name" value="<?php echo $KD_Name; ?>" />
<input type="hidden" name="Address_Line_1" value="<?php echo $Address_Line_1; ?>" />
<input type="hidden" name="Address_Line_2" value="<?php echo $Address_Line_2; ?>" />
<input type="hidden" name="Address_Line_3" value="<?php echo $Address_Line_3; ?>" />
<input type="hidden" name="City" value="<?php echo $City; ?>" />
<input type="hidden" name="City" value="<?php echo $lga; ?>" />
<input type="hidden" name="City" value="<?php echo $branch_id; ?>" />
<input type="hidden" name="Pin" value="<?php echo $Pin; ?>" />
<input type="hidden" name="Contact_Person" value="<?php echo $Contact_Person; ?>" />
<input type="hidden" name="Contact_Number" value="<?php echo $Contact_Number; ?>" />
<input type="hidden" name="Email_ID" value="<?php echo $Email_ID; ?>" />
<input type="hidden" name="kd_category" value="<?php echo $kd_category; ?>" />
<input type="hidden" name="kd_analysis" value="<?php echo $kd_analysis; ?>" />
<input type="hidden" name=" miscellaneous_caption" value="<?php echo $miscellaneous_caption; ?>" />
<input type="hidden" name="miscellaneous_data" value="<?php echo $miscellaneous_data; ?>" />
<input type="hidden" name="no" value="18" />
<input type="hidden" name="page" value="<?php echo $page; ?>" />
</form>

<?php
	
if($KD_Name=='' || $KD_Code==''  || $Contact_Person=='' || $Contact_Number==''|| $Email_ID==''|| $City==''|| $kd_category=='' || $miscellaneous_caption=='' ||  $miscellaneous_data=='')
{?>
<script type="text/javascript">
document.forms['resubmitform'].submit();
</script>
<?php }
 else{
$sel="select * from kd where KD_Name ='$KD_Name'";
$sel_query=mysql_query($sel);
		if(mysql_num_rows($sel_query)=='0') {
$sql="INSERT INTO `kd`
(`KD_Code`,`KD_Name`,`Address_Line_1`,`Address_Line_2`,`Address_Line_3`,`City`,`lga`,`branch_id`,`Pin`,`Contact_Person`,`Contact_Number`,`Email_ID`,`kd_category`,`kd_analysis`,`miscellaneous_caption`,`miscellaneous_data`)
values('$KD_Code','$KD_Name','$Address_Line_1','$Address_Line_2','$Address_Line_3','$City','$lga','$branch_id','$Pin','$Contact_Person','$Contact_Number','$Email_ID','$kd_category','$kd_analysis','$miscellaneous_caption','$miscellaneous_data')";
mysql_query( $sql);
        header("location:kdview.php?no=1&page=$page");
		}
		else { ?>
        <script type="text/javascript">
		document.forms['dataexists'].submit();
		</script>
		<?php
        }
   }
}


$id=$_GET['id'];
$list=mysql_query("select * from kd where id= '$id'"); 
while($row = mysql_fetch_array($list)){ 
	$KD_Code = $row['KD_Code'];
	$KD_Name = $row['KD_Name'];
	$Address_Line_1 = $row['Address_Line_1'];
	$Address_Line_2 = $row['Address_Line_2'];
	$Address_Line_3 = $row['Address_Line_3'];
	$City = $row['City'];
 	$lga = $row['lga'];
	$branch_id = $row['branch_id'];
	$Pin = $row['Pin'];
	$Contact_Person = $row['Contact_Person'];
	$Contact_Number = $row['Contact_Number'];
	$Email_ID = $row['Email_ID'];
	$kd_category = $row['kd_category'];
	$kd_analysis = $row['kd_analysis'];
	$miscellaneous_caption = $row['miscellaneous_caption'];
	$miscellaneous_data = $row['miscellaneous_data'];
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
 
#mainareakd {
	width:100%;
	height:500px;
	background:#ebebeb;
}

#mytablekd {
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

function kdvalidate() {
	var KDName				=	$('#KD_Name').val();
	var ContactPerson		=	$('#Contact_Person').val();
	var EmailID			    =	$('#Email_ID').val();
	var Contactnumber       =   $('#Contact_Number').val();
	var kdcategory          =   $('#kd_category').val();
	var City                =   $('#City').val();
	var miscaption          =	$('#miscellaneous_caption').val();
	var miscdata        	=	$('#miscellaneous_data').val();
	var amtpat	= /^[0-9.]+$/;
	
	
	if(KDName == ''){
		$('.myaligncol').html('ERR : Enter KD Name');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}
	
	if(ContactPerson == ''){
		$('.myaligncol').html('ERR : Enter Contact Person');
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
		
if (EmailID !== "") {  // If something was entered
    if (!isValidEmailAddress(EmailID)) {
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
	
			
  if(City == ''){
		$('.myaligncol').html('ERR : Select City');
		$('#errormsgcol').css('display','block');
		setTimeout(function() {
		$('#errormsgcol').hide();
		},5000);
		return false;
	}	
	
	if(kdcategory == ''){
     $('.myaligncol').html('ERR : Select KD Category');
	 $('#errormsgcol').css('display','block');
	 setTimeout(function() {
	  $('#errormsgcol').hide();
		 },5000);
		 return false;
		}
	
	if(miscaption == ''){
     $('.myaligncol').html('ERR : Enter Miscellaneous Caption');
	 $('#errormsgcol').css('display','block');
	 setTimeout(function() {
	  $('#errormsgcol').hide();
		 },5000);
		 return false;
		}
		
	if(miscdata == ''){
     $('.myaligncol').html('ERR : Enter Miscellaneous Data');
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
<div align="center" class="headingsgr">Key Distributor</div>
<div id="mytablekd" align="center">
<form action="" method="post" onsubmit="return kdvalidate()">
<div style="float:left;width:50%">
 <fieldset class="alignment">
  <legend><strong>KD</strong></legend>
  <table>
  <tr height="25">
    <td width="110" class="pclr">KD Name*</td>
    <td><input type="text" name="KD_Name" id="KD_Name" size="30" value="<?php echo $KD_Name; ?>" autocomplete='off' maxlength="50"/></td>
    </tr>
    <tr  height="25">
    <td  width="110">KD Code*</td>
    	<?php
		 if(!isset($_GET[id]) && $_GET[id] == '') {
			$kdid					=	"SELECT KD_Code	FROM kd ORDER BY id DESC";			
			$kdold					=	mysql_query($kdid) or die(mysql_error());
			$kdcnt					=	mysql_num_rows($kdold);
			//$kdcnt					=	0; // comment if live
			if($kdcnt > 0) {
				$row_kd					  =	 mysql_fetch_array($kdold);
				$kdnumber	  =	$row_kd['KD_Code'];

				$getkdno						=	abs(str_replace("KD",'',strstr($kdnumber,"KD")));
				$getkdno++;
				if($getkdno < 10) {
					$createdcode	=	"00".$getkdno;
				} else if($getkdno < 100) {
					$createdcode	=	"0".$getkdno;
				} else {
					$createdcode	=	$getkdno;
				}

				$KD_Code				=	"KD".$createdcode;
			} else {
				$KD_Code			=	"KD001";
			}
		}
	?>
    <td><input type="text" name="KD_Code" size="10"  readonly="readonly" value="<?php echo $KD_Code; ?>" autocomplete='off' maxlength="10"/></td>
    </tr>
   </table>
 </fieldset>
 
 
 <fieldset class="alignment">
 <legend><strong>Contact</strong></legend>
  <table>
  <tr  height="35">
    <td width="100%">Contact Person*</td>
    <td><input type="text" name="Contact_Person"  id="Contact_Person" size="30" value="<?php echo $Contact_Person; ?>" autocomplete='off' maxlength="50"/></td>
    </tr>
    <tr  height="35">
    <td  width="100%">Contact Number</td>
    <td><input type="text" name="Contact_Number" id="Contact_Number" size="30" value="<?php echo $Contact_Number; ?>" autocomplete='off' maxlength="20"/></td>
    </tr>
    <tr  height="35">
    <td width="100%">Email ID</td>
    <td><input type="text" name="Email_ID"  id="Email_ID" size="30" value="<?php echo $Email_ID; ?>" autocomplete='off' maxlength="50"/></td>
    </tr>
    
    <tr  height="35">
     <td width="100%">Branch*</td>
       <td>
		<?php
        $list=mysql_query("select * from host_information");
        ?>
        <select name="branch_id" id="branch_id">
        <option value="">--- Select ---</option>
		<?php
		while($row_list=mysql_fetch_assoc($list)){
		$branch_id=$row_list['branch_id'];
		?>
        <option value="<?php echo $row_list['branch_id']; ?>" <?php if($row_list['branch_id']==$branch_id){ echo "selected"; } ?>><?php $sambr=mysql_query("select * from  branch where id = '$branch_id'");
        $row=mysql_fetch_array($sambr);
        $branid=$row['id'];
		$branchv=$row['branch'];
		if($branid=$branch_id){echo $branchv;} ?></option>
        <?php  } ?>
        </select>
         </td>
         </tr>
   </table>
 </fieldset>
</div>

<div style="float:right;width:50%">
   <fieldset class="alignment">
  <legend><strong>Address</strong></legend>
  <table>
  <tr height="25">
     <td>Line1</td>
     <td><input type="text" name="Address_Line_1" size="30" value="<?php echo $Address_Line_1; ?>" autocomplete='off' maxlength="50"/></td>
     </tr>
     <tr height="25">
     <td>Line2</td>
      <td><input type="text" name="Address_Line_2" size="30" value="<?php echo $Address_Line_2; ?>" autocomplete='off' maxlength="50"/></td>
      </tr>
      <tr height="25">
      <td>Line3</td>
     <td><input type="text" name="Address_Line_3" size="30" value="<?php echo $Address_Line_3; ?>" autocomplete='off' maxlength="50"/></td>
     </tr>
     
     <tr>
     <td width="100">PostCode</td>
    <td><input type="text" name="Pin" size="10" value="<?php echo $Pin; ?>" autocomplete='off' maxlength="10"/></td>
     
     </tr>
     <tr  height="25">
     <td>City*</td>
     <td>
		<?php 
	    $list=mysql_query("select * from city order by city asc"); 
        // Show records by while loop. 
	    // End while loop. 
        ?>
        <select name="City" id="City">
        <option value="">--- Select ---</option>
		<?php 		
		while($row_list=mysql_fetch_assoc($list)){ 
		$id=$row_list['city'];
		?>
        <option value="<?php echo $row_list['id']; ?>" <?php if($row_list['id']== $City){ echo "selected"; } ?>><?php echo $row_list['city']; ?></option>
        <?php  } ?>
        </select>         
          </td>
  </tr>
  
  <tr>        
      <td>LGA*</td>
      <td>
		<?php 
	    $list=mysql_query("select * from lga order by lga asc"); 
        // Show records by while loop. 
	    // End while loop. 
        ?>
        <select name="lga" id="lga">
        <option value="">--- Select ---</option>
		<?php 		
		while($row_list=mysql_fetch_assoc($list)){ 
		$id=$row_list['lga'];
		?>
        <option value="<?php echo $row_list['id']; ?>" <?php if($row_list['id']== $lga){ echo "selected"; } ?>><?php echo $row_list['lga']; ?></option>
        <?php  } ?>
        </select>         
          </td> 

 
  </tr>
   </table>
 </fieldset>
 
 <fieldset class="alignment">
<legend><strong>Category</strong></legend>
  <table>
  <tr height="25">
     <td width="210">KD Product & Price Catgory*</td>
     <td><select name="kd_category" id="kd_category">
        <option value="">--- Select ---</option>
        <?php 
       // Get records from database (table "name_list"). 
        $list=mysql_query("select * from kd_category order by kd_category asc"); 
        
        // Show records by while loop. 
        while($row_list=mysql_fetch_assoc($list)){ 
        ?>
        <option value="<?php echo $row_list['id']; ?>" <?php if($row_list['id']==$kd_category){ echo "selected"; } ?>><?php echo $row_list['kd_category']; ?></option>
        <?php 
        // End while loop. 
        } 
        ?>
     </select></td>
    </tr>
    
    <tr height="25">
     <td width="210">Analysis Category</td>
     <td><select name="kd_analysis" id="kd_analysis">
        <option value="">--- Select ---</option>
        <?php 
          // Get records from database (table "name_list"). 
        $list=mysql_query("select * from kdanalysis order by kdanalysis asc"); 
        
        // Show records by while loop. 
        while($row_list=mysql_fetch_assoc($list)){ 
        ?>
        <option value="<?php echo $row_list['id']; ?>" <?php if($row_list['id']==$kd_analysis){ echo "selected"; } ?>><?php echo $row_list['kdanalysis']; ?></option>
        <?php 
        // End while loop. 
        } 
        ?>
     </select></td>
    </tr>
   </table>
 </fieldset>
</div>
<div style="clear:both"></div>

<div style="width:100%">
 <fieldset class="alignment">
 <legend><strong>Miscellaneous Datas</strong></legend>
<table width="100%" style="clear:both;" height="50">
 <tr>
  <td>Miscellaneous Caption*</td>
  <td><input type="text" name="miscellaneous_caption"  id="miscellaneous_caption" size="20" value="<?php echo $miscellaneous_caption; ?>" autocomplete='off' maxlength="20"/></td>
  <td>Miscellaneous Data*</td>
  <td><input type="text" name="miscellaneous_data" id="miscellaneous_data" size="20" value="<?php echo $miscellaneous_data	; ?>" autocomplete='off' maxlength="20"/></td>
  </tr>
</table>  
</fieldset>
</div>   
<table width="50%" style="clear:both">
      <tr align="center" height="50px;">
      <td><input type="submit" name="submit" id="submit" class="buttons" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="reset" name="reset" id="Clear"  class="buttons" value="Clear" onclick="return kd()";/>&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../include/empty.php'"/>&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="button" name="view" value="View" class="buttons" onclick="window.location='kdview.php'"/>
      </td>
      </tr>
 </table>     
</form>
</div>
<?php include("../include/error.php");?>
<div id="errormsgcol" style="display:none;clear:both;">
<h3 align="center" class="myaligncol"></h3><button id="closebutton">Close</button></div>
</div>
<?php include('../include/footer.php'); ?>