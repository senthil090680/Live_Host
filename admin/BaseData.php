<?php
//Connect to database from here
include "../include/config.php";
$path="/opt/lampp/htdocs/meena/Host_new/DownloadfromCP/";
$tables = array("device_master.csv","route_master.csv","vehicle_master.csv","dealer_sales_rep_master.csv","customer_master.csv");
for ($key_Number = 0; $key_Number <= 4; $key_Number++) {
  $file = $path.$tables[$key_Number];
  if (file_exists($file))
  {
	  $handle = fopen($file,"r"); 
		//loop through the csv file and insert into database
		 while (($data = fgetcsv($handle, 100000, ",")) !== FALSE)
		 {
			$myQuery="select * from device_master where KD_Code='".addslashes($data[0])."' AND Date= '".addslashes($data[1])."' AND device_id='".addslashes($data[2])."'AND device_desc='".addslashes($data[3])."' AND device_spec='".addslashes($data[4])."' AND device_call_no='".addslashes($data[5])."'";
			$result = mysql_query($myQuery) ;		
			$dev_num_row=mysql_num_rows($result);
			if($dev_num_row=='0')
			{
				if(basename($file)=='device_master.csv')
				{
					mysql_query("INSERT INTO device_master(id,KD_Code,Date,device_id,device_desc,device_spec,device_call_no) VALUES
								(
									'',
									'".addslashes($data[0])."',
									'".addslashes($data[1])."',
									'".addslashes($data[2])."',
									'".addslashes($data[3])."',
									'".addslashes($data[4])."',
									'".addslashes($data[5])."'
								)
							");
					// echo "Import Done";
				}
			
			}
			else
			{
			$filename = 'error.txt';
			$contents  = "This Data Already Exists ". date("D M j G:i:s T Y",time());
			file_put_contents($filename, $contents);
			}
		//Route Master
			$route="select * from route_master where KD_Code='".addslashes($data[0])."' AND Date= '".addslashes($data[1])."'AND route_id='".addslashes($data[2])."'AND route_desc='".addslashes($data[3])."' AND Location='".addslashes($data[4])."' ";
			$resultRoute = mysql_query($route) ;		
			$route_num_row=mysql_num_rows($resultRoute);
			if($route_num_row=='0')
			{
			if(basename($file)=='route_master.csv'){
				mysql_query("INSERT INTO route_master(id,KD_Code,Date,route_id,route_desc,Location) VALUES
					(
						'',
						'".addslashes($data[0])."',
						'".addslashes($data[1])."',
						'".addslashes($data[2])."',
						'".addslashes($data[3])."',
						'".addslashes($data[4])."'

					)
				
				");
			}
			}
			else
			{
			$filename = 'error.txt';
			$contents  = "This Route Master Data Already Exists ". date("D M j G:i:s T Y",time());
			file_put_contents($filename, $contents);
			}
			
			//Vehicle Master
			$vehicle="select * from vehicle_master where KD_Code='".addslashes($data[0])."' AND Date= '".addslashes($data[1])."'AND Vehicle_id='".addslashes($data[2])."'AND Registration_number='".addslashes($data[3])."' AND vehicle_desc='".addslashes($data[4])."' AND Stock_point_flag='".addslashes($data[5])."' ";
			$resultvehicle = mysql_query($vehicle) ;		
			$vehicle_num_row=mysql_num_rows($resultvehicle);
			if($vehicle_num_row=='0')
			{
			if(basename($file)=='vehicle_master.csv'){
				mysql_query("INSERT INTO vehicle_master(id,KD_Code,Date,Vehicle_id,Registration_number,vehicle_desc,Stock_point_flag) VALUES
					(
						'',
						'".addslashes($data[0])."',
						'".addslashes($data[1])."',
						'".addslashes($data[2])."',
						'".addslashes($data[3])."'

					)
				
				");
			}
			}
			else
			{
			$filename = 'error.txt';
			$contents  = "This Vehicle Master Data Already Exists ". date("D M j G:i:s T Y",time());
			file_put_contents($filename, $contents);
			}
			
			//DSR Master
			$DSR="select * from dsr where  KD_Code='".addslashes($data[0])."'AND Date='".addslashes($data[1])."' AND Dsr_id='".addslashes($data[2])."'AND Salesrep_name='".addslashes($data[3])."' AND Salesrep_contact_num='".addslashes($data[4])."' AND Salesrep_addr_line1='".addslashes($data[5])."' AND Salesrep_addr_line2='".addslashes($data[6])."'AND Salesrep_addr_line3='".addslashes($data[7])."'AND City='".addslashes($data[8])."' AND State='".addslashes($data[9])."' AND Alternate_cont_num='".addslashes($data[10])."'AND Salesperson_id='".addslashes($data[11])."'";
			$resultDSR = mysql_query($DSR) ;		
			$DSR_num_row=mysql_num_rows($resultDSR);
			if($DSR_num_row=='0')
			{
			if(basename($file)=='dsr.csv'){
				mysql_query("INSERT INTO dsr(KD_Code,Date,Dsr_id,Salesrep_name,Salesrep_contact_num,Salesrep_addr_line1,Salesrep_addr_line2,Salesrep_addr_line3,City,State,Alternate_cont_num,Salesperson_id) VALUES
					(
						'".addslashes($data[0])."'
						'".addslashes($data[1])."',
						'".addslashes($data[2])."',
						'".addslashes($data[4])."',
						'".addslashes($data[5])."',
						'".addslashes($data[6])."'
						'".addslashes($data[7])."',
						'".addslashes($data[8])."',
						'".addslashes($data[9])."'
						'".addslashes($data[10])."'
						'".addslashes($data[11])."'
					)
				
				");
			}
			}
			else
			{
			$filename = 'error.txt';
			$contents  = "This DSR Master Data Already Exists ". date("D M j G:i:s T Y",time());
			file_put_contents($filename, $contents);
			}
			
			//Customer Master
			$customer="select * from customer where KD_Code='".addslashes($data[0])."'AND Date='".addslashes($data[1])."' 
			AND customer_id='".addslashes($data[2])."'AND Customer_Name='".addslashes($data[3])."' 
			AND AddressLine1='".addslashes($data[4])."' AND AddressLine2='".addslashes($data[5])."'
			AND AddressLine3='".addslashes($data[6])."'AND City='".addslashes($data[7])."'
			 AND State='".addslashes($data[8])."' AND Province='".addslashes($data[9])."' AND Lga='".addslashes($data[10])."'
			 AND Pin='".addslashes($data[11])."'AND GPS='".addslashes($data[12])."' AND contactperson1='".addslashes($data[13])."'
			 AND Pin='".addslashes($data[14])."'AND Province='".addslashes($data[15])."' AND Lga='".addslashes($data[16])."'
			 AND contactnumber1='".addslashes($data[17])."'AND contactperson2='".addslashes($data[18])."' AND contactnumber2='".addslashes($data[19])."'
			 AND route1='".addslashes($data[11])."'AND route2='".addslashes($data[9])."' AND DSR_Id='".addslashes($data[10])."'
			 AND category1='".addslashes($data[20])."'AND category2='".addslashes($data[21])."' AND category3='".addslashes($data[22])."'
			 AND Total_sale_value='".addslashes($data[23])."'AND Total_Collection_Value='".addslashes($data[24])."'AND Total_returned_value='".addslashes($data[25])."'
			 AND Total_paid_value='".addslashes($data[26])."'AND current_outstanding='".addslashes($data[27])."'AND Discount='".addslashes($data[28])."'
			 AND Max_Discount='".addslashes($data[29])."'";
			$resultcustomer = mysql_query($customer) ;		
			$customer_num_row=mysql_num_rows($resultcustomer);
			if($customer_num_row=='0')
			{
			if(basename($file)=='customer_master.csv'){
				mysql_query("INSERT INTO customer_master(KD_Code,Date,`customer_id`, `Customer_Name`, `AddressLine1`, `AddressLine2`, `AddressLine3`, `City`, `State`, `Province`, `Lga`, `Pin`, `GPS`, `contactperson1`, `contactnumber1`, `contactperson2`, `contactnumber2`, `route1`, `route2`, `DSR_Id`, `category1`, `category2`, `category3`, `Total_sale_value`, `Total_Collection_Value`, `Total_returned_value`, `Total_paid_value`, `current_outstanding`, `Discount`, `Max_Discount`) VALUES
					(
						'".addslashes($data[0])."',
						'".addslashes($data[1])."',
						'".addslashes($data[2])."',
						'".addslashes($data[3])."',
						'".addslashes($data[4])."',
						'".addslashes($data[5])."',
						'".addslashes($data[6])."',
						'".addslashes($data[7])."'
						'".addslashes($data[8])."',
						'".addslashes($data[9])."',
						'".addslashes($data[10])."',
						'".addslashes($data[11])."',
						'".addslashes($data[12])."',
						'".addslashes($data[13])."',
						'".addslashes($data[14])."',
						'".addslashes($data[15])."'
						'".addslashes($data[16])."',
						'".addslashes($data[17])."',
						'".addslashes($data[18])."',
						'".addslashes($data[19])."',
						'".addslashes($data[20])."',
						'".addslashes($data[21])."',
						'".addslashes($data[22])."',
						'".addslashes($data[23])."'
						'".addslashes($data[24])."',
						'".addslashes($data[25])."',
						'".addslashes($data[26])."',
						'".addslashes($data[27])."',
						'".addslashes($data[28])."',
						'".addslashes($data[29])."'
					)
				
				");
			}
			}
			else
			{
			$filename = 'error.txt';
			$contents  = "This Customer Master Data Already Exists ". date("D M j G:i:s T Y",time());
			file_put_contents($filename, $contents);
			}
				
    	} 
	fclose($handle);
   
   }
   
}//End For LOOP
?>
