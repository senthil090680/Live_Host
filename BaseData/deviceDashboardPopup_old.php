<?php
//Connect to database from here
include "../include/config.php";
EXTRACT($_POST);
	$sel="select editmasterpwd from parameters";
	$sel_query=mysql_query($sel);
	$row=mysql_fetch_array($sel_query);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/admin.css" rel="stylesheet" type="text/css" />
<title>Host </title>
<script langauge="javascript">
function feedback()
{
var feedbacktxt=$('.feedbacktxt').val();
var feedback_type=$('.feedback_type').val();

if(feedback_type=='')
{
	alert("Please Enter The Feedback Category");
	return false;
}
if(feedbacktxt=='')
{
	alert("Please Enter The Feedback");
	return false;
}
else
{
	if(editmasterpwd==pwdval)
	{
	//alert("Password Match");
	document.passwordFrm.submit();
	//return false;
	}
}

}
</script>
</head>
<body topmargin="0" onLoad="focus()">
       <form action="" method="post" name="passwordFrm">
		<table width="43%">
		<tr><td colspan="2"><h2 align="center">Enter FeedBack</h2>
		</td></tr>
		<tr><td colspan="2">&nbsp;
		</td></tr>
		<tr height="25" >
		<td width="24%">Feedback Category* </td>
		<td width="76%"><select  name="feedback_type" id="feedback_type" autocomplete="off" autofocus class="feedback_type" value="">
		<option value="">--- Select ---</option>
		<?php 
		$list=mysql_query("select * from  feedback_type"); 
		while($row=mysql_fetch_assoc($list)){
		?>
		<option value='<?php echo $row['feedback_type']; ?>' <?php  if($_COOKIE['feedback_type']==$row['feedback_type']){ echo 'selected'; } ?>> <?php echo $row['feedback_type']; ?></option>
		<?php 
		// End while loop. 
		} 
		?>
		</select></td>
		</tr>
		<tr  height="25">
		<td>Date</td>
		<td><input type="text" name="date" value="" class="datepicker"/></td>
		</tr>
		<tr height="25">
		<td>Feedback*</td>
		<td><input type="text" name="feedbacktxt" value="" class="feedbacktxt"/></td>
		</tr>
		</table>
		<table width="50%" style="clear:both">
		<tr align="center" height="50px;">
		<td><input type="submit" name="save" id="submit" class="buttons" value="Save" onclick="return feedback();"/>&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="button" name="clear" value="Clear" id="clear" class="buttons" />&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="../include/menu.php" style="text-decoration:none">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="cancel" id="cancel"  class="buttons" value="Cancel"/></a></td>
		</tr>
		</table> 
        </form>  </body>
</html>


