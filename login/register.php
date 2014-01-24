<?php 
ob_start();
include "../include/header.php";
//Error Message
if($_GET['no']!=''){
include "../include/config.php";
$error_sql="select * from  error_message where id=".$_GET['no'];
$error_exec=mysql_query($error_sql);
$error_fetch=mysql_fetch_array($error_exec);
}
if($_GET['no']==''||$_GET['no']=='9')
{
unset($_COOKIE['username_ret']);
unset($_COOKIE['email_ret']);
unset($_COOKIE['password_ret']);
unset($_COOKIE['confirmpassword_ret']);
}
?>
<div id="mainarea">
  <div class="clearfix"></div>
   
<div align="center" class="headingsSGNIN">SIGN IN</div>
<div class="mytableformreg" align="center">
  <form method="post" action="registerAction.php" name="register">
  <table  width="90%" height="100%" cellpadding="0" cellspacing="0" border="0" style="padding:10px 0 10px 0">
  <tr>
    <td>
	<fieldset class="alignmentregister_new">
	<legend><strong>User</strong></legend>
	<table>
	<tr height="25">
	<td width="60">Name*</td>
	<td><input type="text" name="username"  id="username" value="<?php echo $_COOKIE['username_ret'];?>" maxlength="20" autocomplete="off" size="20" onkeypress="return specialChar(event)"></td>
	</tr>
	<tr  height="25">
	<td>Email*</td>
	<td><input type="text" name="email" value="<?php echo $_COOKIE['email_ret'];?>" maxlength="50" autocomplete="off" size="20"></td>
	</tr>
	</table>
	</fieldset>
	</td>
    <td>
	<fieldset class="alignmentregister_new">
	<legend><strong>Password</strong></legend>
	<table>
	<tr height="25">
	<td width="60">Password*</td>
	<td><input type="password" name="password" value="<?php echo $_COOKIE['password_ret'];?>" maxlength="20" autocomplete="off" size="20"></td>
	</tr>
	<tr  height="25">
	<td  width="128">Confirm Password*</td>
	<td><input type="password" name="confirmpassword" value="<?php echo $_COOKIE['confirmpassword_ret'];?>" maxlength="20" autocomplete="off" size="20"></td>
	</tr>
	</table>
	</fieldset>
	</td>
  </tr>
</table>
<table width="102%"  cellpadding="0" cellspacing="0" border="0" align="left" style="padding-left:34px;">
  <tr>
    <td>	<fieldset class="alignmentregister_new">
	<legend><strong>Parameters</strong></legend>
	<table>
	<tr height="25">
	<td width="60">Access*</td>
	<td><input type="text" name="access" value="General" readonly disabled>&nbsp;&nbsp;</td>
	<!-- <td  width="128" style="padding-left:54px;">Verification*</td>
	<td>
	<table width="100%"  border="0"  cellpadding="0" cellspacing="0">
	<tr>
	<td><input type="text" name="verify" size="10" autocomplete="off">&nbsp;&nbsp;</td>
	<td valign="top"><img src="getimage.php" alt="" /></td>
	</tr>
	</table>
	</td> -->
	</tr>
	</table>
	</td>
	</tr>
	</table>
	</fieldset>
</td>
  </tr>
</table>
<table width="50%" style="clear:both">
<tr align="center" height="50px;">
<td><input type="submit" name="submit" value="Save" class="buttons"/>
&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="clear" value="Clear" id="clear" class="buttons" onclick="return valClear();" />&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" name="cancel" value="Cancel" class="buttons" onclick="window.location='../index.php'"/></td>
</tr>
</table> 

</form>
</div>
<div class="clearfix"></div>   
<!--Error Message -->  
<?php include("../include/error.php");?>

</div>
<!------------------------------- Footer ------------------------------------------------->

<div id="footer">
<div class="left"><a href="#">...a solution from TTS</a></div>
  <div class="right"><a href="#"><?php $time_now=mktime(date('g')+4,date('i')-30,date('s')); 
$time = date('d-M-Y / h:i A',$time_now); 
echo $time;
 ?></a></div>

</div>

<!------------------------------- Wrapper End ---------------------------------------->
</div>


</body>
</html>
