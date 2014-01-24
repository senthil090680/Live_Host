<?php
session_start();
include('../include/header.php');
if(isset($_GET['logout'])){
session_destroy();
header("Location:../index.php");
}
$filename = 'error.txt';
$sql="select * from device_master";
if(!mysql_query($sql))
{
$contents  = mysql_error()." This error occurred on ". date("D M j G:i:s T Y",time());
$handle = fopen($filename, 'a');
fwrite($handle, $content);
fclose($handle);
} 
$path=$_SERVER['DOCUMENT_ROOT']."/meena/Host_new/DownloadfromBase/";
$tables = array("device_master.csv","route_master.csv","vehicle_master.csv","dealer_sales_rep_master.csv","customer_master.csv");
for ($key_Number = 0; $key_Number <= 4; $key_Number++) {

  $file = $path.$tables[$key_Number];
  $handle = fopen($file,"r"); 
  $data =0;
    //loop through the csv file and insert into database
    do {
		if(basename($file)=='device_master.csv'){ 
		mysql_query("INSERT INTO device_master(device_id,device_desc,device_spec,device_call_no) VALUES
					(
						'".addslashes($data[0])."',
						'".addslashes($data[1])."',
						'".addslashes($data[2])."',
						'".addslashes($data[3])."'
					)
				
				");
				
			}
			if(basename($file)=='route_master.csv'){
				mysql_query("INSERT INTO route_master(route_id,route_desc,Location) VALUES
					(
						'".addslashes($data[0])."',
						'".addslashes($data[1])."',
						'".addslashes($data[2])."'
					)
				
				");
			}
			if(basename($file)=='vehicle_master.csv'){
				mysql_query("INSERT INTO vehicle_master(Vehicle_id,Registration_number,vehicle_desc,Stock_point_flag) VALUES
					(
						'".addslashes($data[0])."',
						'".addslashes($data[1])."',
						'".addslashes($data[2])."',
						'".addslashes($data[3])."'

					)
				
				");
			}
			if(basename($file)=='dealer_sales_rep_master.csv'){
				mysql_query("INSERT INTO dealer_sales_rep_master(Dsr_id,Salesrep_name,Salesrep_contact_num,Salesrep_addr_line1,Salesrep_addr_line2,Salesrep_addr_line3,City,State,Alternate_cont_num,Salesperson_id) VALUES
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

					)
				
				");
			}
			
			if(basename($file)=='customer_master.csv'){
				mysql_query("INSERT INTO customer_master(`customer_id`, `Customer_Name`, `AddressLine1`, `AddressLine2`, `AddressLine3`, `City`, `State`, `Province`, `Lga`, `Pin`, `GPS`, `contactperson1`, `contactnumber1`, `contactperson2`, `contactnumber2`, `route1`, `route2`, `DSR_Id`, `category1`, `category2`, `category3`, `Total_sale_value`, `Total_Collection_Value`, `Total_returned_value`, `Total_paid_value`, `current_outstanding`, `Discount`, `Max_Discount`) VALUES
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
						'".addslashes($data[27])."'
					)
				
				");
			}

    } while ($data = fgetcsv($handle,1000,",","'"));
    //
    //redirect 
   // header('Location:cron_upload.php?success=1'); die;


}
?>
<!------------------------------- Form -------------------------------------------------->

<div id="mainarea">

<br>
<br>
</div>
<?php include('../include/footer.php'); ?>