<?php
//**************************************
//     Page load dropdown results     //
//**************************************
function getdsrcode()
{
	$result = mysql_query("SELECT DISTINCT KD_Code,KD_Name FROM customer") 
	or die(mysql_error());

	  while($tier = mysql_fetch_array($result)) 
  
		{
		   echo '<option value="'.$tier['KD_Code'].'">'.$tier['KD_Name'].'</option>';
		}

}

//**************************************
//     First selection results     //
//**************************************
if($_GET['func'] == "KD_Code" && isset($_GET['func'])) { 
   KD_Code($_GET['KD_Code']); 
}

function KD_Code($KD_Code)
{  
    include('../include/config.php');
	$result = mysql_query("SELECT DISTINCT DSR_Code,DSRName FROM dsr WHERE KD_Code='$KD_Code'") 
	or die(mysql_error());
	
	echo '<select name="DSR_Code" id="DSR_Code">
	      <option value=" " selected="selected">Choose DSR</option>';

		   while($drop_2 = mysql_fetch_array($result)) 
			{
			  echo '<option value="'.$drop_2['DSR_Code'].'">'.$drop_2['DSRName'].'</option>';
			}
	
	echo '</select>';

}


//**************************************
//     Second selection results     //
//**************************************


if($_GET['func'] == "DSR_Code" && isset($_GET['func'])) { 
   DSR_Code($_GET['DSR_Code']); 
}

function DSR_Code($DSR_Code)
{  
    include('../include/config.php');
	$results = mysql_query("SELECT DISTINCT Device_Code FROM dsr_metrics WHERE DSR_Code='$DSR_Code'") 
	or die(mysql_error());
	
	echo '<select name="Device_Code" id="Device_Code">
	      <option value=" " selected="selected">Choose Device</option>';

		   while($row = mysql_fetch_array($results)) 
			{
			  echo '<option value="'.$row['Device_Code'].'">'.$row['Device_Code'].'</option>';
			}
	
	echo '</select> ';

}



//**************************************
//     customer selection results     //
//**************************************


if($_GET['func'] == "cuscode" && isset($_GET['func'])) { 
   cuscode($_GET['DSR_Code']); 
}

function cuscode($DSR_Code)
{  
    include('../include/config.php');
	$results = mysql_query("SELECT DISTINCT customer_code,Customer_Name FROM customer WHERE DSR_Code='$DSR_Code'") 
	or die(mysql_error());
	
	echo '<select name="Customer_code" id="Customer_code">
	      <option value=" " selected="selected">Choose Customer</option>';

		   while($row = mysql_fetch_array($results)) 
			{
			  echo '<option value="'.$row['customer_code'].'">'.$row['Customer_Name'].'</option>';
			}
	
	echo '</select> ';

}

//**************************************
//     Third selection results     //
//**************************************


if($_GET['func'] == "dsrcode" && isset($_GET['func'])) { 
   dsrcode($_GET['DSR_Code']); 
}

function dsrcode($DSR_Code)
{  
    include('../include/config.php');
	$results = mysql_query("SELECT DISTINCT RSM,RSMName FROM dsr WHERE DSR_Code='$DSR_Code'") 
	or die(mysql_error());
	echo '<select name="RSM" id="RSM">
	      <option value=" " selected="selected">Choose RSM</option>';

		   while($row = mysql_fetch_array($results)) 
			{
    		 echo '<option value="'.$row['RSM'].'">'.$row['RSMName'].'</option>';
			}
	
	echo '</select> ';

}



?>