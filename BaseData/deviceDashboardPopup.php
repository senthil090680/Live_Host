<?php
//Connect to database from here
include "../include/config.php";
include "../include/ajax_pagination.php";
EXTRACT($_GET);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../css/editbox.css" type="text/css" />
<title>Host </title>
</head>
<body topmargin="0" onLoad="focus()">
       <form action="" method="post" name="passwordFrm">
       <div class="con3">
		<table width="100%" cellpadding="10" cellspacing="10" >
       	<thead>
		<tr>
			<th>Feedback Category</th>
			<th>Date</th>
			<th>Feedback</th>
		</tr>
		</tr>
		</thead>
		<?php
		$sel_lincnt		=	"SELECT * FROM `feedback` WHERE (Date >= '$fromdate' AND Date <= '$todate' AND KD_Code = '$KDCodeVal' AND DSR_Code = '$DSR_CodeVal')";
		$results_lincnt	=	mysql_query($sel_lincnt);
		$rowcnt_lincnt	=	mysql_num_rows($results_lincnt);				
		if($rowcnt_lincnt > 0) { // SECOND IF LOOP 
			while($row_lincnt	=	mysql_fetch_array($results_lincnt)) {   // SECOND WHILE LOOP  ?>     			
				<tr>
					<td><?php echo $row_lincnt['visit_Count'];?></td> 
					<td><?php echo $row_lincnt['Invoice_Count'];?></td>
					<td><?php echo $row_lincnt['Invoice_Line_Count'];?></td>
					<td><?php echo $row_lincnt['Drop_Size_Value'];?></td>
					<td><?php echo $row_lincnt['Basket_Size_Value'];?></td>
				</tr>
			<?php } // SECOND WHILE LOOP
		} // SECOND IF LOOP
		else { ?>
			<tr>
				<td align='center' colspan='5'><b>No records found</b></td>
				<td style="display:none;" >Cust Name</td>
				<td style="display:none;" >Add Line1</td>
				<td style="display:none;" >Add Line1</td>
				<td style="display:none;" >Add Line2</td>
			</tr>
		 <?php }
		/*$qry="SELECT * FROM `device_data_view`"; 
        $result=mysql_query($qry);
		$c=0;$cc=1;
		while($row = mysql_fetch_array($result)) {
		if($c % 2 == 0){ $cls =""; } else{ $cls =" class='odd'"; }
		?>
		<tbody>
		<tr>
		<td><?php echo $row['feedback_type'];?></td> 
       	<td><?php echo $row['feedback_date'];?></td>
       	<td><?php echo $row['feedback'];?></td>
  		</tr>
		<?php $c++; $cc++; } */
		?>
		</tbody>
		</table>
		</div>
		</div>
        </form>  </body>
</html>