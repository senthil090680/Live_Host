<?php
$conn = mysql_connect("localhost","root","root*123@");
mysql_select_db("sfa_retail",$conn);
mysql_select_db("sfa_tracker",$conn);


//customer master Insert

$querycus = "SELECT * from sfa_retail.customer inner join transaction_hdr ON sfa_retail.transaction_hdr.Customer_code=customer.customer_code"; 
$resultcus = mysql_query($querycus);
while($cus = mysql_fetch_array($resultcus)){
	 $company_code       	 = 'FMCL';
	 $KD_code	             = $cus['KD_Code'];
	 $customer_code 	 = $cus['customer_code'];
	 $customer_name 		 = $cus['Customer_Name'];
     $Address_line2 		 = $cus['AddressLine2'];
	 $Address_line1 		 = $cus['AddressLine1'];
	 $Address_line3 		 = $cus['AddressLine3'];
	 $Customer_Type 	     = $cus['customer_type'];
	 $city          		 = $cus['City'];
	 $branch_code            = $cus['branch_id'];
     $GPS                    = $cus['GPS'];
	 $str_explode            = explode(",",$GPS);
     $GPS_latitudegp         = $str_explode[0]; 
     $GPS_longitudegp        = $str_explode[1]; 
 
$checkcus =("SELECT * FROM sfa_tracker.customer_master WHERE customer_code = '$customer_code' AND KD_code='$KD_code'");
$count = mysql_num_rows($checkcus);

if(!$count){
    $insert = mysql_query("INSERT INTO sfa_tracker.customer_master(`company_code`,`branch_code`,`KD_code`,`customer_code`,`customer_name`,`Address_line1`,`Address_line2`,`Address_line3`,`city`,`GPS_latitude`,`GPS_longitude`,`Customer_Type`,`portal_flag`)
values('$company_code','$branch_code','$KD_code','$customer_code','$customer_name','$Address_line1','$Address_line2','$Address_line3','$city','$GPS_latitudegp','$GPS_longitudegp','$Customer_Type','No')");
}
else{
    $update = mysql_query("UPDATE sfa_tracker.customer_master SET 
			 company_code='$company_code',
			 branch_code ='$branch_code',
			 KD_code ='$KD_code',
			 customer_code ='$customer_code',
			 customer_name ='$customer_name',
			 Address_line1 ='$Address_line1',
			 Address_line2 ='$Address_line2',
			 Address_line3 ='$Address_line3',
			 city          ='$city',
			 GPS_latitude  ='$GPS_latitudegp',
			 GPS_longitude ='$GPS_longitudegp',
			 Customer_Type ='$Customer_Type',
		     portal_flag   ='No'
			WHERE customer_master.customer_code = '$customer_code' AND KD_code='$KD_code'");
 }
}



//Kdmaster Insert

$query = "select * from sfa_retail.kd";
$resultkd = mysql_query($query);
while ($kd = mysql_fetch_array($resultkd)) {
	 $KD_Code =$kd['KD_Code'];
     $KD_Name =$kd['KD_Name'];
	 $branch_id =$kd['branch_id'];
	 

$check = mysql_query("SELECT * FROM sfa_tracker.kd_master WHERE KD_code ='$KD_Code'");
$count = mysql_num_rows($check);

if(!$count){
    $insert = mysql_query("INSERT INTO sfa_tracker.kd_master(`branch_code`,`KD_Code`,`KD_name`,`portal_flag`)
						  values('$branch_id','$KD_Code','$KD_Name','')");
}
else{
    $update = mysql_query("UPDATE sfa_tracker.kd_master SET 
			 branch_code='$branch_id',
			 KD_code='$KD_Code',
			 KD_Name='$KD_Name',
			 portal_flag ='No' 
			 WHERE KD_code ='$KD_Code'");
}
}


//Brand Data Insert

$querybrand = "select * from sfa_retail.brand";
$resultbrand = mysql_query($querybrand);
while ($brand = mysql_fetch_array($resultbrand)) {
	 $brand_id = $brand['id'];
     $brand_name = $brand['brand'];
	 $principal = $brand['principal'];
	 
	 
$check_brand = mysql_query("SELECT * FROM sfa_tracker.brand_master WHERE brand_code ='$brand_id'");
$count = mysql_num_rows($check_brand);

if(!$count){
    $insert = mysql_query("INSERT INTO sfa_tracker.brand_master(`brand_code`,`brand_name`,`portal_flag`,`principal`)
						  values('$brand_id','$brand_name','','$principal')");
}
else{
    $update = mysql_query("UPDATE sfa_tracker.brand_master SET 
			 brand_code='$brand_id',
			 brand_name='$brand_name',
			 portal_flag ='No',
			 principal='$principal'
			 WHERE brand_code ='$brand_id'");
}
}


//Branch Data Insert

$querybranch = "select * from sfa_retail.branch";
$resultbranch = mysql_query($querybranch);
while ($bra = mysql_fetch_array($resultbranch)) {
	 $branch_id = $bra['id'];
     $branch_name = $bra['branch'];
		 
	 
$checkbranch = mysql_query("SELECT * FROM sfa_tracker.branch_master WHERE branch_code ='$branch_id'");
$count = mysql_num_rows($checkbranch);

if(!$count){
    $insert = mysql_query("INSERT INTO sfa_tracker.branch_master(`company_code`,`branch_code`,`branch_name`,`portal_flag`)
						  values('FMCL','$branch_id','$branch_name','No')");
}
else{
    $update = mysql_query("UPDATE sfa_tracker.branch_master SET 
			 company_code='',
			 branch_code='$branch_code',
			 branch_name ='$branch_name',
			 portal_flag='No'
			 WHERE branch_code ='$branch_id'");
}
}



//customerType Insert

$queryct = "select * from sfa_retail.customer_type";
$resultct = mysql_query($queryct);
while ($ct = mysql_fetch_array($resultct)) {
	 $seq_id = $ct['id'];
     $customer_type	 = $ct['customer_type'];
		 
	 
$checkct = mysql_query("SELECT * FROM sfa_tracker.customer_type WHERE SEQ_NUM ='$seq_id'");
$count = mysql_num_rows($checkbranch);

if(!$count){
    $insert = mysql_query("INSERT INTO sfa_tracker.customer_type(`SEQ_NUM`,`Customer_Type`,`portal_flag`)
						  values('$seq_id','$customer_type','No')");
}
else{
    $update = mysql_query("UPDATE sfa_tracker.customer_type SET 
			 SEQ_NUM='$seq_id',
			 Customer_Type ='$customer_type',
			 portal_flag='No'
			 WHERE SEQ_NUM ='$seq_id'");
}
}


//customerTypePOSM Insert

$queryctp = "select * from sfa_retail.customertype_product";
$resultctp = mysql_query($queryctp);
while ($ctp = mysql_fetch_array($resultctp)) {
	 $customer_type	 = $ctp['customer_type'];
	 $brand	 = $ctp['brand'];
     $posm	 = $ctp['Product_code'];
		 
	 
$checkctp = mysql_query("SELECT * FROM sfa_tracker.customer_type_posm WHERE portal_flag ='No'");
$count = mysql_num_rows($checkctp);

if(!$count){
    $insert = mysql_query("INSERT INTO sfa_tracker.customer_type_posm(`customer_type`,`brand`,`posm`,`portal_flag`)
						  values('$customer_type','$brand','$posm','No')");
}
else{
    $update = mysql_query("UPDATE sfa_tracker.customer_type_posm SET 
			 customer_type='$customer_type',
			 brand ='$brand',
			 posm='$posm'
			 WHERE portal_flag ='No'");
}
}


//Divisionmaster Insert

$querydiv = "select * from sfa_retail.division_master";
$resultdiv = mysql_query($querydiv);
while ($div = mysql_fetch_array($resultdiv)) {
	 $divid	 = $div['id'];
	 $division_name	 = $div['division'];
    		 
	 
$checkdiv = mysql_query("SELECT * FROM sfa_tracker.division_master WHERE division_code ='$divid'");
$count = mysql_num_rows($checkdiv);

if(!$count){
    $insert = mysql_query("INSERT INTO sfa_tracker.division_master(`division_code`,`division_name`,`portal_flag`)
						  values('$divid','$division_name','No')");
}
else{
    $update = mysql_query("UPDATE sfa_tracker.division_master SET 
			 division_code='$divid',
			 division_name ='$division_name',
		     portal_flag ='No'
			 WHERE division_code ='$divid'");
}
}


////Routeplan Insert
//
//$queryrou = "select * from sfa_retail.routemasterplan";
//$resultrou = mysql_query($queryrou);
//while($rou = mysql_fetch_array($resultrou)) {
//	 $journey_plan_id	 = $rou['id'];
//	 $company_code    	 = 'FMCL';
//	 branch_code	     = 1;
//	 KD_code             = $rou['KD_Code'];
//	 salesperson_code    = $rou['DSR_Code'];
//	 
//    		 
//	 
//$checkdiv = mysql_query("SELECT * FROM sfa_tracker.division_master WHERE division_code ='$divid'");
//$count = mysql_num_rows($checkdiv);
//
//if(!$count){
//    $insert = mysql_query("INSERT INTO sfa_tracker.division_master(`division_code`,`division_name`,`portal_flag`)
//						  values('$divid','$division_name','No')");
//}
//else{
//    $update = mysql_query("UPDATE sfa_tracker.division_master SET 
//			 division_code='$divid',
//			 division_name ='$division_name',
//		     portal_flag ='No'
//			 WHERE division_code ='$divid'");
//}
//}








//GPS Data Insert

$querygps = "select * from sfa_retail.transaction_hdr";
$resultgps = mysql_query($querygps);
while($gps = mysql_fetch_array($resultgps)) {
	 $branch_code = $gps['branch_id'];
	 $KD_code     = $gps['KD_Code'];
	 $DSR_Code    = $gps['DSR_Code'];
	 $GPS_Date	  = $gps['Date'];
	 $GPS_Time	  = $gps['Time'];
	 $GPS   	  = $gps['GPS'];
	 $str_explode = explode(",",$GPS);
     $GPS_latitudeg = $str_explode[0]; 
     $GPS_longitudeg = $str_explode[1]; 
	 

$checkgps = "SELECT * FROM sfa_tracker.gps_data WHERE salesperson_code = '$DSR_Code' AND KD_code = '$KD_code'";
if(mysql_num_rows($checkgps)>0){
	$update = mysql_query("UPDATE sfa_tracker.gps_data SET 
			 company_code='FMCL',
			 branch_code ='$branch_code',
			 KD_code ='$KD_code',
			 salesperson_code ='$DSR_Code',
			 GPS_Date ='$GPS_Date',
			 GPS_Time ='$GPS_Time',
			 GPS_latitude ='$GPS_latitudeg',
			 GPS_longitude ='$GPS_longitudeg',
		     portal_flag ='No'
			 WHERE salesperson_code = '$DSR_Code' AND KD_code = '$KD_code'");
    }
else{
  $insert = mysql_query("INSERT INTO sfa_tracker.gps_data(`company_code`,`branch_code`,`KD_code`,`salesperson_code`,`GPS_Date`,`GPS_Time`,`GPS_latitude`,`GPS_longitude`,`portal_flag`)
						  values('FMCL','$branch_code','$KD_code','$DSR_Code','$GPS_Date','$GPS_Time','$GPS_latitudeg','$GPS_longitudeg','No')");
}
}


//Principal Insert

$querydiv = "select * from sfa_retail.principal";
$resultdiv = mysql_query($querydiv);
while ($div = mysql_fetch_array($resultdiv)) {
	 $principal_code = $div['id'];
	 $principal_name = $div['principal'];
     $division_code = $div['division'];
    		 
	 
$checkdiv = mysql_query("SELECT * FROM sfa_tracker.principal_master WHERE principal_code ='$principal_code'");
$count = mysql_num_rows($checkdiv);

if(!$count){
    $insert = mysql_query("INSERT INTO sfa_tracker.principal_master(`principal_code`,`principal_name`,`division_code`,`portal_flag`)
						  values('$principal_code','$principal_name','$division_code','No')");
}
else{
    $update = mysql_query("UPDATE sfa_tracker.principal_master SET 
			 principal_code='$principal_code',
			 principal_name ='$principal_name',
			 division_code ='$division_code',
		     portal_flag ='No'
			 WHERE principal_code ='$principal_code'");
}
}


//Product Insert

$querypro = "select * from sfa_retail.product";
$resultpro = mysql_query($querypro);
while ($pro = mysql_fetch_array($resultpro)) {
	 $product_code	 = $pro['Product_code'];
	 $product_name = $pro['Product_description1'];
     $type = $pro['product_type'];
	 $brand = $pro['brand'];
	 
    		 
	 
$checkpro = mysql_query("SELECT * FROM sfa_tracker.principal_master WHERE product_code ='$product_code'");
$count = mysql_num_rows($checkpro);

if(!$count){
    $insert = mysql_query("INSERT INTO sfa_tracker.product_master(`product_code`,`product_name`,`type`,`brand`,`portal_flag`)
						  values('$product_code','$product_name','$type','$brand','No')");
}
else{
    $update = mysql_query("UPDATE sfa_tracker.product_master SET 
			 product_code='$product_code',
			 product_name ='$product_name',
			 type ='$type',
			 brand ='$brand',
		     portal_flag ='No'
			 WHERE product_code ='$product_code'");
}
}


//SR Insert

$querysr = "select * from sfa_retail.dsr";
$resultsr = mysql_query($querysr);
while ($sr = mysql_fetch_array($resultsr)) {
	 $KD_code	 = $sr['KD_Code'];
	 $company_code = 'FMCL';
     $sales_person_code	 = $sr['DSR_Code'];
	 $sales_person_name	 = $sr['SR_Name'];
	 $role = $sr['sperson'];
	 $supervisor = $sr['ASM'];
	 
$querybr = "select * from sfa_retail.branch";
$resultbr = mysql_query($querybr);
while ($br = mysql_fetch_array($resultbr)) { 	 
	 $branch_code = $br['branch'];		
			
	 
$checksr = mysql_query("SELECT * FROM sfa_tracker.sales_personnel WHERE sales_person_code ='$sales_person_code'");
$count = mysql_num_rows($checksr);

if($count==0){
    $insert = mysql_query("INSERT INTO sfa_tracker.sales_personnel(`company_code`,`branch_code`,`KD_code`,`sales_person_code`,`sales_person_name`,`role`,`supervisor`,`portal_flag`)
						  values('$company_code','$branch_code','$KD_code','$sales_person_code','$sales_person_name','$role','$supervisor','No')");
}
else{
    $update = mysql_query("UPDATE sfa_tracker.sales_personnel SET 
			 company_code='$company_code',
			 branch_code ='$branch_code',
			 KD_code ='$KD_code',
			 sales_person_code ='$sales_person_code',
			 sales_person_name ='$sales_person_name',
			 role ='$role',
			 supervisor ='$supervisor',
		     portal_flag ='No'
			 WHERE sales_person_code ='$sales_person_code'");
  
 }
}

 }

////posm_pic_data Data Insert
//$querypic = "select * from sfa_retail.transaction_hdr";
//$resultpic = mysql_query($querypic);
//while($pic = mysql_fetch_array($resultpic)) {
//	 $branch_code	     = $pic['branch_id'];
//	 $KD_code	         = $pic['KD_Code'];
//	 $customer_code	     = $pic['Customer_code'];
//	 $salesperson_codep	 = $pic['DSR_Code'];
//	 $Picture_Date	     = $pic['Date'];
//	 $Picture_Time	     = $pic['Time'];
//     $Picture_file_name  = $pic['Signature_Image'];
//	 $GPS   	         = $pic['GPS'];
//	 $str_explode        = explode(",",$GPS);
//     $GPS_latitudep       = $str_explode[0]; 
//     $GPS_longitudep      = $str_explode[1]; 
//	 
//
//$checkpic = mysql_query("SELECT * FROM sfa_tracker.posm_pic_data WHERE salesperson_code ='$salesperson_codep'");
//$count = mysql_num_rows($checkpic);
//
//if(!$count){
// $insert = mysql_query("INSERT INTO sfa_tracker.posm_pic_data   (`company_code`,`branch_code`,`KD_code`,`salesperson_code`,`Picture_Date`,`Picture_Time`,`customer_code`,`GPS_latitude`,`GPS_longitude`,`Picture_file_name`,`average_rating_score	`,`portal_flag`,`Comments`)
//values('FMCL','$branch_code','$KD_code','$salesperson_codep','$Picture_Date','$Picture_Time','$customer_code','$GPS_latitudep','$GPS_longitudep','$Picture_file_name','NULL','No','NULL')");
//}
//else{
//    $update = mysql_query("UPDATE sfa_tracker.posm_pic_data SET 
//			 company_code='FMCL',
//			 branch_code ='$branch_code',
//			 KD_code ='$KD_code',
//			 salesperson_code ='$salesperson_codep',
//			 Picture_Date ='$Picture_Date',
//			 Picture_Time ='$Picture_Time',
//			 customer_code = '$customer_code',
//			 GPS_latitude ='$GPS_latitudep',
//			 GPS_longitude ='$GPS_longitudep',
//		     Picture_file_name ='$Picture_file_name',
//			 average_rating_score ='NULL',
//		     portal_flag ='No',
//			 Comments='NULL'
//			 WHERE salesperson_code ='$salesperson_codep'");
//}
//}
//
//
//
////pic rating Data Insert
//$querypicr = "select * from sfa_retail.transaction_hdr";
//$resultpicr = mysql_query($querypicr);
//while($picr = mysql_fetch_array($resultpicr)) {
//	 $branch_code	     = $picr['branch_id'];
//	 $KD_code	         = $picr['KD_Code'];
//	 $customer_code	     = $picr['Customer_code'];
//	 $salesperson_coder	 = $picr['DSR_Code'];
//	 $Picture_Date	     = $picr['Date'];
//	 $Picture_Time	     = $picr['Time'];
//     $Picture_file_name  = $picr['Signature_Image'];
//	 $GPS   	         = $picr['GPS'];
//	 
//
//$checkpicr = mysql_query("SELECT * FROM sfa_tracker.pic_rating WHERE salesperson_code ='$salesperson_coder'");
//$count = mysql_num_rows($checkpicr);
//
//if(!$count){
// $insert = mysql_query("INSERT INTO sfa_tracker.pic_rating (`company_code`,`branch_code`,`KD_code`,`salesperson_code`,`Picture_Date`,`Picture_Time`,`Picture_file_name`,`rated_by`,`rating`,`Comments``portal_flag`)values('FMCL','$branch_code','$KD_code','$salesperson_coder','$Picture_Date','$Picture_Time','$Picture_file_name','NULL','NULL','NULL','No')");
//}
//else{
//    $update = mysql_query("UPDATE sfa_tracker.pic_rating SET 
//			 company_code='FMCL',
//			 branch_code ='$branch_code',
//			 KD_code ='$KD_code',
//			 salesperson_code ='$salesperson_coder',
//			 Picture_Date ='$Picture_Date',
//			 Picture_Time ='$Picture_Time',
//			 Picture_file_name ='$Picture_file_name',
//			 rated_by ='NULL',
//			 rating='NULL',
//			 Comments='NULL',
//		     portal_flag ='No',
//			 WHERE salesperson_code ='$salesperson_coder'");
//   }
//}

echo "Inserted";


?>