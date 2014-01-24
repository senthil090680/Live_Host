<?php
//Connect to database from here
include "../include/config.php";
EXTRACT($_POST);
$sel="select * from  customer where customer_code='".$_REQUEST['customer_code']."'";
$sel_query=mysql_query($sel);
$fetch=mysql_fetch_array($sel_query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Host </title>
<script type="text/javascript">
	$(function(){
		$('#pop_printOut').click(function(e){
			e.preventDefault();
			var w = window.open();
			var pop_printOne = $('.pop_contentToPrint').html();
			//alert(printOne);
			w.document.write('<html><head><title></title></head><body><h1></h1>' + pop_printOne) + '</body></html>';
			w.window.print();
			w.document.close();
			return false;
		});
	});
</script>

</head>
<body topmargin="0">
<h2 align="center">Customer </h2>
<div  class="pop_contentToPrint">
<table>
       	<thead>
		<tr>
	    <th scope="col" class="bgc">Customer</th>
        <th scope="col" class="bgc">Complaint Type</th>
		</tr>
		</tr>
		</thead>
		<?php
		$qry="SELECT * FROM `device_data`"; 
        $result=mysql_query($qry);
		if(!empty($num_rows)){
		$c=0;$cc=1;
		while($row = mysql_fetch_array($result)) {
		if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }
		 $customer_code=$row['customer_code'];
		 $Complaint_type=$row['complaint_type'];

		?>
		<tbody>
		<tr>
		<td><?php echo $customer_code;?></td>
       	<td><?php echo $Complaint_type;?></td>
  		</tr>
		<?php $c++; $cc++; }		 
		}else{  echo "<tr><td align='center' colspan='13'><b>No records found</b></td></tr>";}  ?>
		</tbody>
		</table></div>
<div>&nbsp;</div>
<div class="pop_contentSection">
<a href="#" id="pop_printOut"><img src="../images/print_icon.png" width="85" height="24" /></a>
</div>
</body>
</html>


