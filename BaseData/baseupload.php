<?php

//Multiple Db Connection
$conn = mysql_connect("localhost","root","root*123@");
mysql_select_db('sfa_retail',$conn);
mysql_select_db('sfa_d2r',$conn);
mysql_select_db('sfa_vve',$conn);
mysql_select_db('sfa_dav',$conn);
mysql_select_db('sfa_sniz',$conn);


//Truncate Tables query
$tr_op = mysql_query("TRUNCATE sfa_retail.opening_stock_update");
$tr_vhstock = mysql_query("TRUNCATE sfa_retail.vehicle_stock");
$tr_trh = mysql_query("TRUNCATE sfa_retail.transaction_hdr");
$tr_trln = mysql_query("TRUNCATE sfa_retail.transaction_line");
$tr_cus = mysql_query("TRUNCATE sfa_retail.customer");
$tr_cts = mysql_query("TRUNCATE sfa_retail.coverage_target_setting");
$tr_co = mysql_query("TRUNCATE sfa_retail.customer_outstanding");
$tr_cvt = mysql_query("TRUNCATE sfa_retail.customer_visit_tracking");
$tr_cf = mysql_query("TRUNCATE sfa_retail.cycle_flag");
$tr_dm = mysql_query("TRUNCATE sfa_retail.device_master");
$tr_dsc = mysql_query("TRUNCATE sfa_retail.dsr_collection");
$tr_dsm = mysql_query("TRUNCATE sfa_retail.dsr_metrics");
$tr_feed = mysql_query("TRUNCATE sfa_retail.feedback");
$tr_posmtar = mysql_query("TRUNCATE sfa_retail.posmtarget");
$tr_roumas = mysql_query("TRUNCATE sfa_retail.routemasterplan");
$tr_roumon = mysql_query("TRUNCATE sfa_retail.routemonthplan");
$tr_roumas = mysql_query("TRUNCATE sfa_retail.route_master");
$tr_salelist = mysql_query("TRUNCATE sfa_retail.sales_list");
$tr_salecoll = mysql_query("TRUNCATE sfa_retail.sale_and_collection");
$tr_srbran = mysql_query("TRUNCATE sfa_retail.srbrand_incentive");
$tr_srinc = mysql_query("TRUNCATE sfa_retail.sr_incentive");
$tr_vhm = mysql_query("TRUNCATE sfa_retail.vehicle_master");
$tr_ave = mysql_query("TRUNCATE sfa_retail.ave_suggested_sales");
$tr_str = mysql_query("TRUNCATE sfa_retail.stock_receipts");

   


    $query2 = "SELECT * FROM sfa_retail.kd";
	$res=mysql_query($query2);
	while($row=mysql_fetch_array($res)){
		
		 $KD_Code = $row['KD_Code'];
		 

//Insert Opening stock Data

//1.Vinvalvico Enterprises
$insert_op1=mysql_query("INSERT INTO sfa_retail.opening_stock_update (KD_Code,Product_code,Product_description,UOM1,TransactionType,TransactionNo,TransactionQty,BalanceQty,Date,StockDateTime,UpdatedDateTime,AddedFirstTime,AUDIT_DATE_TIME) SELECT KD_Code,Product_code,Product_description,UOM1,TransactionType,TransactionNo,TransactionQty,BalanceQty,Date,StockDateTime,UpdatedDateTime,AddedFirstTime,AUDIT_DATE_TIME FROM sfa_vve.opening_stock_update where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_op2=mysql_query("INSERT INTO sfa_retail.opening_stock_update (KD_Code,Product_code,Product_description,UOM1,TransactionType,TransactionNo,TransactionQty,BalanceQty,Date,StockDateTime,UpdatedDateTime,AddedFirstTime,AUDIT_DATE_TIME) SELECT KD_Code,Product_code,Product_description,UOM1,TransactionType,TransactionNo,TransactionQty,BalanceQty,Date,StockDateTime,UpdatedDateTime,AddedFirstTime,AUDIT_DATE_TIME FROM sfa_d2r.opening_stock_update where KD_Code ='$KD_Code'");


//3.Sniz
$insert_op2=mysql_query("INSERT INTO sfa_retail.opening_stock_update (KD_Code,Product_code,Product_description,UOM1,TransactionType,TransactionNo,TransactionQty,BalanceQty,Date,StockDateTime,UpdatedDateTime,AddedFirstTime,AUDIT_DATE_TIME) SELECT KD_Code,Product_code,Product_description,UOM1,TransactionType,TransactionNo,TransactionQty,BalanceQty,Date,StockDateTime,UpdatedDateTime,AddedFirstTime,AUDIT_DATE_TIME FROM sfa_sniz.opening_stock_update where KD_Code ='$KD_Code'");

//4.Da-Ande Ventures
$insert_op2=mysql_query("INSERT INTO sfa_retail.opening_stock_update (KD_Code,Product_code,Product_description,UOM1,TransactionType,TransactionNo,TransactionQty,BalanceQty,Date,StockDateTime,UpdatedDateTime,AddedFirstTime,AUDIT_DATE_TIME) SELECT KD_Code,Product_code,Product_description,UOM1,TransactionType,TransactionNo,TransactionQty,BalanceQty,Date,StockDateTime,UpdatedDateTime,AddedFirstTime,AUDIT_DATE_TIME FROM sfa_dav.opening_stock_update where KD_Code ='$KD_Code'");




//Insert vehiclestock Data

//1.Vinvalvico Enterprises
$insert_vh1=mysql_query("INSERT INTO sfa_retail.vehicle_stock (KD_Code,DSR_Code,Device_Code,Vehicle_Code,Date,Cycle_Start_Flag,Product_Code,UOM,Loaded_quantity,Sold_quantity,Return_quantity,Stock_quantity,AUDIT_DATE_TIME)SELECT KD_Code,DSR_Code,Device_Code,Vehicle_Code,Date,Cycle_Start_Flag,Product_Code,UOM,Loaded_quantity,Sold_quantity,Return_quantity,Stock_quantity,AUDIT_DATE_TIME FROM sfa_vve.vehicle_stock where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_vh2=mysql_query("INSERT INTO sfa_retail.vehicle_stock (KD_Code,DSR_Code,Device_Code,Vehicle_Code,Date,Cycle_Start_Flag,Product_Code,UOM,Loaded_quantity,Sold_quantity,Return_quantity,Stock_quantity,AUDIT_DATE_TIME)SELECT    KD_Code,DSR_Code,Device_Code,Vehicle_Code,Date,Cycle_Start_Flag,Product_Code,UOM,Loaded_quantity,Sold_quantity,Return_quantity,Stock_quantity,AUDIT_DATE_TIME FROM sfa_d2r.vehicle_stock where KD_Code ='$KD_Code'");


//3.Sniz
$insert_vh2=mysql_query("INSERT INTO sfa_retail.vehicle_stock (KD_Code,DSR_Code,Device_Code,Vehicle_Code,Date,Cycle_Start_Flag,Product_Code,UOM,Loaded_quantity,Sold_quantity,Return_quantity,Stock_quantity,AUDIT_DATE_TIME)SELECT    KD_Code,DSR_Code,Device_Code,Vehicle_Code,Date,Cycle_Start_Flag,Product_Code,UOM,Loaded_quantity,Sold_quantity,Return_quantity,Stock_quantity,AUDIT_DATE_TIME FROM sfa_sniz.vehicle_stock where KD_Code ='$KD_Code'");


//4.Da-Ande-Ventures
$insert_vh2=mysql_query("INSERT INTO sfa_retail.vehicle_stock (KD_Code,DSR_Code,Device_Code,Vehicle_Code,Date,Cycle_Start_Flag,Product_Code,UOM,Loaded_quantity,Sold_quantity,Return_quantity,Stock_quantity,AUDIT_DATE_TIME)SELECT    KD_Code,DSR_Code,Device_Code,Vehicle_Code,Date,Cycle_Start_Flag,Product_Code,UOM,Loaded_quantity,Sold_quantity,Return_quantity,Stock_quantity,AUDIT_DATE_TIME FROM sfa_dav.vehicle_stock where KD_Code ='$KD_Code'");





//Insert Transaction Hdr Data

//1.Vinvalvico Enterprises
$insert_trh1=mysql_query("INSERT INTO sfa_retail.transaction_hdr (KD_Code,DSR_Code,device_code,Date,Time,GPS,Customer_code,Transaction_type,Transaction_Number,transaction_Reference_Number,currency,Product_Line_count,Transaction_Value,Discount,Discount_Value,Net_Sale_value,Collection_Value,Balance_Due_Value,Shop_Image,Image_Capture,Signature_Image,return_reason,RSM,branch_id,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,device_code,Date,Time,GPS,Customer_code,Transaction_type,Transaction_Number,transaction_Reference_Number,currency,Product_Line_count,Transaction_Value,Discount,Discount_Value,Net_Sale_value,Collection_Value,Balance_Due_Value,Shop_Image,Image_Capture,Signature_Image,return_reason,RSM,branch_id,AUDIT_DATE_TIME FROM sfa_vve.transaction_hdr where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_trh2=mysql_query("INSERT INTO sfa_retail.transaction_hdr (KD_Code,DSR_Code,device_code,Date,Time,GPS,Customer_code,Transaction_type,Transaction_Number,transaction_Reference_Number,currency,Product_Line_count,Transaction_Value,Discount,Discount_Value,Net_Sale_value,Collection_Value,Balance_Due_Value,Shop_Image,Image_Capture,Signature_Image,return_reason,RSM,branch_id,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,device_code,Date,Time,GPS,Customer_code,Transaction_type,Transaction_Number,transaction_Reference_Number,currency,Product_Line_count,Transaction_Value,Discount,Discount_Value,Net_Sale_value,Collection_Value,Balance_Due_Value,Shop_Image,Image_Capture,Signature_Image,return_reason,RSM,branch_id,AUDIT_DATE_TIME FROM sfa_d2r.transaction_hdr where KD_Code ='$KD_Code'"); 


//3.Sniz
$insert_trh2=mysql_query("INSERT INTO sfa_retail.transaction_hdr (KD_Code,DSR_Code,device_code,Date,Time,GPS,Customer_code,Transaction_type,Transaction_Number,transaction_Reference_Number,currency,Product_Line_count,Transaction_Value,Discount,Discount_Value,Net_Sale_value,Collection_Value,Balance_Due_Value,Shop_Image,Image_Capture,Signature_Image,return_reason,RSM,branch_id,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,device_code,Date,Time,GPS,Customer_code,Transaction_type,Transaction_Number,transaction_Reference_Number,currency,Product_Line_count,Transaction_Value,Discount,Discount_Value,Net_Sale_value,Collection_Value,Balance_Due_Value,Shop_Image,Image_Capture,Signature_Image,return_reason,RSM,branch_id,AUDIT_DATE_TIME FROM sfa_sniz.transaction_hdr where KD_Code ='$KD_Code'"); 


//4.Da-Ande-Ventures
$insert_trh2=mysql_query("INSERT INTO sfa_retail.transaction_hdr (KD_Code,DSR_Code,device_code,Date,Time,GPS,Customer_code,Transaction_type,Transaction_Number,transaction_Reference_Number,currency,Product_Line_count,Transaction_Value,Discount,Discount_Value,Net_Sale_value,Collection_Value,Balance_Due_Value,Shop_Image,Image_Capture,Signature_Image,return_reason,RSM,branch_id,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,device_code,Date,Time,GPS,Customer_code,Transaction_type,Transaction_Number,transaction_Reference_Number,currency,Product_Line_count,Transaction_Value,Discount,Discount_Value,Net_Sale_value,Collection_Value,Balance_Due_Value,Shop_Image,Image_Capture,Signature_Image,return_reason,RSM,branch_id,AUDIT_DATE_TIME FROM sfa_dav.transaction_hdr where KD_Code ='$KD_Code'"); 


//Insert Transaction Line Data

//1.Vinvalvico Enterprises
$insert_tl1=mysql_query("INSERT INTO sfa_retail.transaction_line (KD_Code,DSR_Code,Transaction_type,Transaction_Number,Transaction_Line_Number,Product_code,UOM,Focus_Flag,POSM_Flag,Customer_Stock_Check,Customer_Stock_quantity,Scheme_Flag,Scheme_Code,Product_Scheme_Flag,Order_quantity,Sold_quantity,Price,Value,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,Transaction_type,Transaction_Number,Transaction_Line_Number,Product_code,UOM,Focus_Flag,POSM_Flag,Customer_Stock_Check,Customer_Stock_quantity,Scheme_Flag,Scheme_Code,Product_Scheme_Flag,Order_quantity,Sold_quantity,Price,Value,AUDIT_DATE_TIME FROM sfa_vve.transaction_line where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_tl2=mysql_query("INSERT INTO sfa_retail.transaction_line (KD_Code,DSR_Code,Transaction_type,Transaction_Number,Transaction_Line_Number,Product_code,UOM,Focus_Flag,POSM_Flag,Customer_Stock_Check,Customer_Stock_quantity,Scheme_Flag,Scheme_Code,Product_Scheme_Flag,Order_quantity,Sold_quantity,Price,Value,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,Transaction_type,Transaction_Number,Transaction_Line_Number,Product_code,UOM,Focus_Flag,POSM_Flag,Customer_Stock_Check,Customer_Stock_quantity,Scheme_Flag,Scheme_Code,Product_Scheme_Flag,Order_quantity,Sold_quantity,Price,Value,AUDIT_DATE_TIME FROM sfa_d2r.transaction_line where KD_Code ='$KD_Code'"); 


//3.Sniz
$insert_tl2=mysql_query("INSERT INTO sfa_retail.transaction_line (KD_Code,DSR_Code,Transaction_type,Transaction_Number,Transaction_Line_Number,Product_code,UOM,Focus_Flag,POSM_Flag,Customer_Stock_Check,Customer_Stock_quantity,Scheme_Flag,Scheme_Code,Product_Scheme_Flag,Order_quantity,Sold_quantity,Price,Value,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,Transaction_type,Transaction_Number,Transaction_Line_Number,Product_code,UOM,Focus_Flag,POSM_Flag,Customer_Stock_Check,Customer_Stock_quantity,Scheme_Flag,Scheme_Code,Product_Scheme_Flag,Order_quantity,Sold_quantity,Price,Value,AUDIT_DATE_TIME FROM sfa_sniz.transaction_line where KD_Code ='$KD_Code'"); 


//4.Da-Ande-Ventures
$insert_tl2=mysql_query("INSERT INTO sfa_retail.transaction_line (KD_Code,DSR_Code,Transaction_type,Transaction_Number,Transaction_Line_Number,Product_code,UOM,Focus_Flag,POSM_Flag,Customer_Stock_Check,Customer_Stock_quantity,Scheme_Flag,Scheme_Code,Product_Scheme_Flag,Order_quantity,Sold_quantity,Price,Value,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,Transaction_type,Transaction_Number,Transaction_Line_Number,Product_code,UOM,Focus_Flag,POSM_Flag,Customer_Stock_Check,Customer_Stock_quantity,Scheme_Flag,Scheme_Code,Product_Scheme_Flag,Order_quantity,Sold_quantity,Price,Value,AUDIT_DATE_TIME FROM sfa_dav.transaction_line where KD_Code ='$KD_Code'"); 


//Insert Customer Data

//1.Vinvalvico Enterprises
$insert_cus1=mysql_query("INSERT INTO sfa_retail.customer (KD_Code,KD_Name,customer_code,Customer_Name,AddressLine1,AddressLine2,AddressLine3,City,State,province,location,lga,PostCode,GPS,contactperson,contactnumber,Alternatecontactperson,Alternatecontactnumber,route,Alternateroute,DSR_Code,DSRName,category1,category2,category3,miscellaneous_caption,miscellaneous_data,customer_type,DiscountEligibility,Max_Discount,sequence_number,AUDIT_DATE_TIME) SELECT KD_Code,KD_Name,customer_code,Customer_Name,AddressLine1,AddressLine2,AddressLine3,City,State,province,location,lga,PostCode,GPS,contactperson,contactnumber,Alternatecontactperson,Alternatecontactnumber,route,Alternateroute,DSR_Code,DSRName,category1,category2,category3,miscellaneous_caption,miscellaneous_data,customer_type,DiscountEligibility,Max_Discount,sequence_number,AUDIT_DATE_TIME FROM sfa_vve.customer where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_cus2=mysql_query("INSERT INTO sfa_retail.customer (KD_Code,KD_Name,customer_code,Customer_Name,AddressLine1,AddressLine2,AddressLine3,City,State,province,location,lga,PostCode,GPS,contactperson,contactnumber,Alternatecontactperson,Alternatecontactnumber,route,Alternateroute,DSR_Code,DSRName,category1,category2,category3,miscellaneous_caption,miscellaneous_data,customer_type,DiscountEligibility,Max_Discount,sequence_number,AUDIT_DATE_TIME) SELECT KD_Code,KD_Name,customer_code,Customer_Name,AddressLine1,AddressLine2,AddressLine3,City,State,province,location,lga,PostCode,GPS,contactperson,contactnumber,Alternatecontactperson,Alternatecontactnumber,route,Alternateroute,DSR_Code,DSRName,category1,category2,category3,miscellaneous_caption,miscellaneous_data,customer_type,DiscountEligibility,Max_Discount,sequence_number,AUDIT_DATE_TIME FROM sfa_d2r.customer where KD_Code ='$KD_Code'"); 

//3.Sniz
$insert_cus2=mysql_query("INSERT INTO sfa_retail.customer (KD_Code,KD_Name,customer_code,Customer_Name,AddressLine1,AddressLine2,AddressLine3,City,State,province,location,lga,PostCode,GPS,contactperson,contactnumber,Alternatecontactperson,Alternatecontactnumber,route,Alternateroute,DSR_Code,DSRName,category1,category2,category3,miscellaneous_caption,miscellaneous_data,customer_type,DiscountEligibility,Max_Discount,sequence_number,AUDIT_DATE_TIME) SELECT KD_Code,KD_Name,customer_code,Customer_Name,AddressLine1,AddressLine2,AddressLine3,City,State,province,location,lga,PostCode,GPS,contactperson,contactnumber,Alternatecontactperson,Alternatecontactnumber,route,Alternateroute,DSR_Code,DSRName,category1,category2,category3,miscellaneous_caption,miscellaneous_data,customer_type,DiscountEligibility,Max_Discount,sequence_number,AUDIT_DATE_TIME FROM sfa_sniz.customer where KD_Code ='$KD_Code'"); 


//4.Da-Ande-Ventures
$insert_cus2=mysql_query("INSERT INTO sfa_retail.customer (KD_Code,KD_Name,customer_code,Customer_Name,AddressLine1,AddressLine2,AddressLine3,City,State,province,location,lga,PostCode,GPS,contactperson,contactnumber,Alternatecontactperson,Alternatecontactnumber,route,Alternateroute,DSR_Code,DSRName,category1,category2,category3,miscellaneous_caption,miscellaneous_data,customer_type,DiscountEligibility,Max_Discount,sequence_number,AUDIT_DATE_TIME) SELECT KD_Code,KD_Name,customer_code,Customer_Name,AddressLine1,AddressLine2,AddressLine3,City,State,province,location,lga,PostCode,GPS,contactperson,contactnumber,Alternatecontactperson,Alternatecontactnumber,route,Alternateroute,DSR_Code,DSRName,category1,category2,category3,miscellaneous_caption,miscellaneous_data,customer_type,DiscountEligibility,Max_Discount,sequence_number,AUDIT_DATE_TIME FROM sfa_dav.customer where KD_Code ='$KD_Code'"); 




//Insert coverage Target Setting Data

//1.Vinvalvico Enterprises
$insert_cts1=mysql_query("INSERT INTO sfa_retail.coverage_target_setting (KD_Code,SR_Code,coverage_percent,effective_percent,productive_percent,cov_visit,prod_visit,eff_visit,cov_status,prod_status,eff_status,monthval,yearval,tgtTypeCov,tgtTypeProd,tgtTypeEff,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,SR_Code,coverage_percent,effective_percent,productive_percent,cov_visit,prod_visit,eff_visit,cov_status,prod_status,eff_status,monthval,yearval,tgtTypeCov,tgtTypeProd,tgtTypeEff,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_vve.coverage_target_setting where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_cts2=mysql_query("INSERT INTO sfa_retail.coverage_target_setting (KD_Code,SR_Code,coverage_percent,effective_percent,productive_percent,cov_visit,prod_visit,eff_visit,cov_status,prod_status,eff_status,monthval,yearval,tgtTypeCov,tgtTypeProd,tgtTypeEff,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,SR_Code,coverage_percent,effective_percent,productive_percent,cov_visit,prod_visit,eff_visit,cov_status,prod_status,eff_status,monthval,yearval,tgtTypeCov,tgtTypeProd,tgtTypeEff,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_d2r.coverage_target_setting where KD_Code ='$KD_Code'"); 

//3.Sniz
$insert_cts2=mysql_query("INSERT INTO sfa_retail.coverage_target_setting (KD_Code,SR_Code,coverage_percent,effective_percent,productive_percent,cov_visit,prod_visit,eff_visit,cov_status,prod_status,eff_status,monthval,yearval,tgtTypeCov,tgtTypeProd,tgtTypeEff,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,SR_Code,coverage_percent,effective_percent,productive_percent,cov_visit,prod_visit,eff_visit,cov_status,prod_status,eff_status,monthval,yearval,tgtTypeCov,tgtTypeProd,tgtTypeEff,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_sniz.coverage_target_setting where KD_Code ='$KD_Code'"); 


//4.Da-Ande-Ventures
$insert_cts2=mysql_query("INSERT INTO sfa_retail.coverage_target_setting (KD_Code,SR_Code,coverage_percent,effective_percent,productive_percent,cov_visit,prod_visit,eff_visit,cov_status,prod_status,eff_status,monthval,yearval,tgtTypeCov,tgtTypeProd,tgtTypeEff,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,SR_Code,coverage_percent,effective_percent,productive_percent,cov_visit,prod_visit,eff_visit,cov_status,prod_status,eff_status,monthval,yearval,tgtTypeCov,tgtTypeProd,tgtTypeEff,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_dav.coverage_target_setting where KD_Code ='$KD_Code'"); 



//Insert customer Outstanding Data

//1.Vinvalvico Enterprises
$insert_co1=mysql_query("INSERT INTO sfa_retail.customer_outstanding(KD_Code,DSR_Code,customer_id,DateValue,monthval,yearval,total_due,insertdatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,customer_id,DateValue,monthval,yearval,total_due,insertdatetime,AUDIT_DATE_TIME FROM sfa_vve.customer_outstanding where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_co2=mysql_query("INSERT INTO sfa_retail.customer_outstanding(KD_Code,DSR_Code,customer_id,DateValue,monthval,yearval,total_due,insertdatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,customer_id,DateValue,monthval,yearval,total_due,insertdatetime,AUDIT_DATE_TIME FROM sfa_d2r.customer_outstanding where KD_Code ='$KD_Code'"); 

//3.Sniz
$insert_co2=mysql_query("INSERT INTO sfa_retail.customer_outstanding(KD_Code,DSR_Code,customer_id,DateValue,monthval,yearval,total_due,insertdatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,customer_id,DateValue,monthval,yearval,total_due,insertdatetime,AUDIT_DATE_TIME FROM sfa_sniz.customer_outstanding where KD_Code ='$KD_Code'"); 


//4.Da-Ande-Ventures
$insert_co2=mysql_query("INSERT INTO sfa_retail.customer_outstanding(KD_Code,DSR_Code,customer_id,DateValue,monthval,yearval,total_due,insertdatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,customer_id,DateValue,monthval,yearval,total_due,insertdatetime,AUDIT_DATE_TIME FROM sfa_dav.customer_outstanding where KD_Code ='$KD_Code'"); 


//Insert Customer Visit tracking Data

//1.Vinvalvico Enterprises
$insert_cvt1=mysql_query("INSERT INTO sfa_retail.customer_visit_tracking
(KD_Code,DSR_Code,Date,Sequence_Number,Customer_Code,Check_In_time,Checkin_GPS,Check_Out_time,Checkout_GPS,check_out_id,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,Date,Sequence_Number,Customer_Code,Check_In_time,Checkin_GPS,Check_Out_time,Checkout_GPS,check_out_id,AUDIT_DATE_TIME FROM sfa_vve.customer_visit_tracking where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_cvt2=mysql_query("INSERT INTO sfa_retail.customer_visit_tracking
(KD_Code,DSR_Code,Date,Sequence_Number,Customer_Code,Check_In_time,Checkin_GPS,Check_Out_time,Checkout_GPS,check_out_id,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,Date,Sequence_Number,Customer_Code,Check_In_time,Checkin_GPS,Check_Out_time,Checkout_GPS,check_out_id,AUDIT_DATE_TIME FROM sfa_d2r.customer_visit_tracking where KD_Code ='$KD_Code'"); 

//3.Sniz
$insert_cvt2=mysql_query("INSERT INTO sfa_retail.customer_visit_tracking
(KD_Code,DSR_Code,Date,Sequence_Number,Customer_Code,Check_In_time,Checkin_GPS,Check_Out_time,Checkout_GPS,check_out_id,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,Date,Sequence_Number,Customer_Code,Check_In_time,Checkin_GPS,Check_Out_time,Checkout_GPS,check_out_id,AUDIT_DATE_TIME FROM sfa_sniz.customer_visit_tracking where KD_Code ='$KD_Code'"); 

//4.Da-Ande-Ventures
$insert_cvt2=mysql_query("INSERT INTO sfa_retail.customer_visit_tracking
(KD_Code,DSR_Code,Date,Sequence_Number,Customer_Code,Check_In_time,Checkin_GPS,Check_Out_time,Checkout_GPS,check_out_id,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,Date,Sequence_Number,Customer_Code,Check_In_time,Checkin_GPS,Check_Out_time,Checkout_GPS,check_out_id,AUDIT_DATE_TIME FROM sfa_dav.customer_visit_tracking where KD_Code ='$KD_Code'"); 



//Insert Cycle Flag Data

//1.Vinvalvico Enterprises
$insert_cf1=mysql_query("INSERT INTO sfa_retail.cycle_flag(KD_Code,dsr_id,cycle_start_flag,cycle_start_date,cycle_end_flag,cycle_end_date,AUDIT_DATE_TIME) SELECT KD_Code,dsr_id,cycle_start_flag,cycle_start_date,cycle_end_flag,cycle_end_date,AUDIT_DATE_TIME FROM sfa_vve.cycle_flag where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_cf2=mysql_query("INSERT INTO sfa_retail.cycle_flag(KD_Code,dsr_id,cycle_start_flag,cycle_start_date,cycle_end_flag,cycle_end_date,AUDIT_DATE_TIME) SELECT KD_Code,dsr_id,cycle_start_flag,cycle_start_date,cycle_end_flag,cycle_end_date,AUDIT_DATE_TIME FROM sfa_d2r.cycle_flag where KD_Code ='$KD_Code'");


//3.Sniz
$insert_cf2=mysql_query("INSERT INTO sfa_retail.cycle_flag(KD_Code,dsr_id,cycle_start_flag,cycle_start_date,cycle_end_flag,cycle_end_date,AUDIT_DATE_TIME) SELECT KD_Code,dsr_id,cycle_start_flag,cycle_start_date,cycle_end_flag,cycle_end_date,AUDIT_DATE_TIME FROM sfa_sniz.cycle_flag where KD_Code ='$KD_Code'");


//4.Da-Ande-Ventures
$insert_cf2=mysql_query("INSERT INTO sfa_retail.cycle_flag(KD_Code,dsr_id,cycle_start_flag,cycle_start_date,cycle_end_flag,cycle_end_date,AUDIT_DATE_TIME) SELECT KD_Code,dsr_id,cycle_start_flag,cycle_start_date,cycle_end_flag,cycle_end_date,AUDIT_DATE_TIME FROM sfa_dav.cycle_flag where KD_Code ='$KD_Code'");



//Insert Device master Data

//1.Vinvalvico Enterprises
$insert_dm1=mysql_query("INSERT INTO sfa_retail.device_master(KD_Code,KD_Name,device_code,device_description,device_serial_number,device_call_no,AUDIT_DATE_TIME) SELECT KD_Code,KD_Name,device_code,device_description,device_serial_number,device_call_no,AUDIT_DATE_TIME FROM sfa_vve.device_master where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_dm2=mysql_query("INSERT INTO sfa_retail.device_master(KD_Code,KD_Name,device_code,device_description,device_serial_number,device_call_no,AUDIT_DATE_TIME) SELECT KD_Code,KD_Name,device_code,device_description,device_serial_number,device_call_no,AUDIT_DATE_TIME FROM sfa_d2r.device_master where KD_Code ='$KD_Code'");


//3.Sniz
$insert_dm2=mysql_query("INSERT INTO sfa_retail.device_master(KD_Code,KD_Name,device_code,device_description,device_serial_number,device_call_no,AUDIT_DATE_TIME) SELECT KD_Code,KD_Name,device_code,device_description,device_serial_number,device_call_no,AUDIT_DATE_TIME FROM sfa_sniz.device_master where KD_Code ='$KD_Code'");


//4.Da-Ande-Ventures
$insert_dm2=mysql_query("INSERT INTO sfa_retail.device_master(KD_Code,KD_Name,device_code,device_description,device_serial_number,device_call_no,AUDIT_DATE_TIME) SELECT KD_Code,KD_Name,device_code,device_description,device_serial_number,device_call_no,AUDIT_DATE_TIME FROM sfa_dav.device_master where KD_Code ='$KD_Code'");


//Insert DSR Collection Data

//1.Vinvalvico Enterprises
$insert_dsc1=mysql_query("INSERT INTO sfa_retail.dsr_collection (KD_Code,Date,Transaction_number,DSR_Code,Deposit_transaction_number,Total_Amount,Serial_Number,Bank_Name,Challan_Number,Challan_Date,Currency,Amount_Deposited,AUDIT_DATE_TIME) SELECT KD_Code,Date,Transaction_number,DSR_Code,Deposit_transaction_number,Total_Amount,Serial_Number,Bank_Name,Challan_Number,Challan_Date,Currency,Amount_Deposited,AUDIT_DATE_TIME FROM sfa_vve.dsr_collection where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_dsc2=mysql_query("INSERT INTO sfa_retail.dsr_collection (KD_Code,Date,Transaction_number,DSR_Code,Deposit_transaction_number,Total_Amount,Serial_Number,Bank_Name,Challan_Number,Challan_Date,Currency,Amount_Deposited,AUDIT_DATE_TIME) SELECT KD_Code,Date,Transaction_number,DSR_Code,Deposit_transaction_number,Total_Amount,Serial_Number,Bank_Name,Challan_Number,Challan_Date,Currency,Amount_Deposited,AUDIT_DATE_TIME FROM sfa_d2r.dsr_collection where KD_Code ='$KD_Code'");


//3.Sniz
$insert_dsc2=mysql_query("INSERT INTO sfa_retail.dsr_collection (KD_Code,Date,Transaction_number,DSR_Code,Deposit_transaction_number,Total_Amount,Serial_Number,Bank_Name,Challan_Number,Challan_Date,Currency,Amount_Deposited,AUDIT_DATE_TIME) SELECT KD_Code,Date,Transaction_number,DSR_Code,Deposit_transaction_number,Total_Amount,Serial_Number,Bank_Name,Challan_Number,Challan_Date,Currency,Amount_Deposited,AUDIT_DATE_TIME FROM sfa_sniz.dsr_collection where KD_Code ='$KD_Code'");


//4.Da-Ande-Ventures
$insert_dsc2=mysql_query("INSERT INTO sfa_retail.dsr_collection (KD_Code,Date,Transaction_number,DSR_Code,Deposit_transaction_number,Total_Amount,Serial_Number,Bank_Name,Challan_Number,Challan_Date,Currency,Amount_Deposited,AUDIT_DATE_TIME) SELECT KD_Code,Date,Transaction_number,DSR_Code,Deposit_transaction_number,Total_Amount,Serial_Number,Bank_Name,Challan_Number,Challan_Date,Currency,Amount_Deposited,AUDIT_DATE_TIME FROM sfa_dav.dsr_collection where KD_Code ='$KD_Code'");




//Insert DSR Collection Data

//1.Vinvalvico Enterprises
$insert_dsm1=mysql_query("INSERT INTO sfa_retail.dsr_metrics (KD_Code,DSR_Code,Device_Code,Date,visit_Count,Invoice_Count,effective_count,productive_count,Invoice_Line_Count,Currency,Total_Sale_Value,Drop_Size_Value,Basket_Size_Value,targetSales,achievementPercent,prodIncentive,effIncentive,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,Device_Code,Date,visit_Count,Invoice_Count,effective_count,productive_count,Invoice_Line_Count,Currency,Total_Sale_Value,Drop_Size_Value,Basket_Size_Value,targetSales,achievementPercent,prodIncentive,effIncentive,AUDIT_DATE_TIME FROM sfa_vve.dsr_metrics where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_dsm2=mysql_query("INSERT INTO sfa_retail.dsr_metrics (KD_Code,DSR_Code,Device_Code,Date,visit_Count,Invoice_Count,effective_count,productive_count,Invoice_Line_Count,Currency,Total_Sale_Value,Drop_Size_Value,Basket_Size_Value,targetSales,achievementPercent,prodIncentive,effIncentive,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,Device_Code,Date,visit_Count,Invoice_Count,effective_count,productive_count,Invoice_Line_Count,Currency,Total_Sale_Value,Drop_Size_Value,Basket_Size_Value,targetSales,achievementPercent,prodIncentive,effIncentive,AUDIT_DATE_TIME FROM sfa_d2r.dsr_metrics where KD_Code ='$KD_Code'");


//3.Sniz
$insert_dsm2=mysql_query("INSERT INTO sfa_retail.dsr_metrics (KD_Code,DSR_Code,Device_Code,Date,visit_Count,Invoice_Count,effective_count,productive_count,Invoice_Line_Count,Currency,Total_Sale_Value,Drop_Size_Value,Basket_Size_Value,targetSales,achievementPercent,prodIncentive,effIncentive,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,Device_Code,Date,visit_Count,Invoice_Count,effective_count,productive_count,Invoice_Line_Count,Currency,Total_Sale_Value,Drop_Size_Value,Basket_Size_Value,targetSales,achievementPercent,prodIncentive,effIncentive,AUDIT_DATE_TIME FROM sfa_sniz.dsr_metrics where KD_Code ='$KD_Code'");



//4.Da-Ande-Ventures
$insert_dsm2=mysql_query("INSERT INTO sfa_retail.dsr_metrics (KD_Code,DSR_Code,Device_Code,Date,visit_Count,Invoice_Count,effective_count,productive_count,Invoice_Line_Count,Currency,Total_Sale_Value,Drop_Size_Value,Basket_Size_Value,targetSales,achievementPercent,prodIncentive,effIncentive,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,Device_Code,Date,visit_Count,Invoice_Count,effective_count,productive_count,Invoice_Line_Count,Currency,Total_Sale_Value,Drop_Size_Value,Basket_Size_Value,targetSales,achievementPercent,prodIncentive,effIncentive,AUDIT_DATE_TIME FROM sfa_dav.dsr_metrics where KD_Code ='$KD_Code'");

//Insert Feedback Data

//1.Vinvalvico Enterprises
$insert_feed1=mysql_query("INSERT INTO sfa_retail.feedback(KD_Code,DSR_Code,Date,Transaction_Number,Feedback_type,Feedback_Serial,Feedback,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,Date,Transaction_Number,Feedback_type,Feedback_Serial,Feedback,AUDIT_DATE_TIME FROM sfa_vve.feedback where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_feed2=mysql_query("INSERT INTO sfa_retail.feedback(KD_Code,DSR_Code,Date,Transaction_Number,Feedback_type,Feedback_Serial,Feedback,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,Date,Transaction_Number,Feedback_type,Feedback_Serial,Feedback,AUDIT_DATE_TIME FROM sfa_d2r.feedback where KD_Code ='$KD_Code'");

//3.Sniz
$insert_feed2=mysql_query("INSERT INTO sfa_retail.feedback(KD_Code,DSR_Code,Date,Transaction_Number,Feedback_type,Feedback_Serial,Feedback,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,Date,Transaction_Number,Feedback_type,Feedback_Serial,Feedback,AUDIT_DATE_TIME FROM sfa_sniz.feedback where KD_Code ='$KD_Code'");


//4.Da-Ande-Ventures
$insert_feed2=mysql_query("INSERT INTO sfa_retail.feedback(KD_Code,DSR_Code,Date,Transaction_Number,Feedback_type,Feedback_Serial,Feedback,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,Date,Transaction_Number,Feedback_type,Feedback_Serial,Feedback,AUDIT_DATE_TIME FROM sfa_dav.feedback where KD_Code ='$KD_Code'");



//Insert posmtarget Data

//1.Vinvalvico Enterprises
$insert_posm1=mysql_query("INSERT INTO sfa_retail.posmtarget
(KD_Code,principalId,brandId,productId,custypeId,noofcus,unitval,monthval,yearval,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,principalId,brandId,productId,custypeId,noofcus,unitval,monthval,yearval,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_vve.posmtarget where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_posm2=mysql_query("INSERT INTO sfa_retail.posmtarget
(KD_Code,principalId,brandId,productId,custypeId,noofcus,unitval,monthval,yearval,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,principalId,brandId,productId,custypeId,noofcus,unitval,monthval,yearval,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_d2r.posmtarget where KD_Code ='$KD_Code'");

//3.Sniz
$insert_posm2=mysql_query("INSERT INTO sfa_retail.posmtarget
(KD_Code,principalId,brandId,productId,custypeId,noofcus,unitval,monthval,yearval,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,principalId,brandId,productId,custypeId,noofcus,unitval,monthval,yearval,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_sniz.posmtarget where KD_Code ='$KD_Code'");


//4.Da-Ande-Ventures
$insert_posm2=mysql_query("INSERT INTO sfa_retail.posmtarget
(KD_Code,principalId,brandId,productId,custypeId,noofcus,unitval,monthval,yearval,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,principalId,brandId,productId,custypeId,noofcus,unitval,monthval,yearval,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_dav.posmtarget where KD_Code ='$KD_Code'");



//Insert routemasterplan Data

//1.Vinvalvico Enterprises
$insert_roum1=mysql_query("INSERT INTO sfa_retail.routemasterplan
(KD_Code,DSR_Code,route_mon,route_tue,route_wed,route_thu,route_fri,route_sat,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,route_mon,route_tue,route_wed,route_thu,route_fri,route_sat,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_vve.routemasterplan where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_roum1=mysql_query("INSERT INTO sfa_retail.routemasterplan
(KD_Code,DSR_Code,route_mon,route_tue,route_wed,route_thu,route_fri,route_sat,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,route_mon,route_tue,route_wed,route_thu,route_fri,route_sat,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_d2r.routemasterplan where KD_Code ='$KD_Code'");


//3.Sniz
$insert_roum1=mysql_query("INSERT INTO sfa_retail.routemasterplan
(KD_Code,DSR_Code,route_mon,route_tue,route_wed,route_thu,route_fri,route_sat,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,route_mon,route_tue,route_wed,route_thu,route_fri,route_sat,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_sniz.routemasterplan where KD_Code ='$KD_Code'");


//4.Da-Ande-Ventures
$insert_roum1=mysql_query("INSERT INTO sfa_retail.routemasterplan
(KD_Code,DSR_Code,route_mon,route_tue,route_wed,route_thu,route_fri,route_sat,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,route_mon,route_tue,route_wed,route_thu,route_fri,route_sat,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_dav.routemasterplan where KD_Code ='$KD_Code'");


//Insert routemonthplan Data

//1.Vinvalvico Enterprises
$insert_roumo1=mysql_query("INSERT INTO sfa_retail.routemonthplan
(KD_Code,DSR_Code,day1,day2,day3,day4,day5,day6,day7,day8,day9,day10,day11,day12,day13,day14,day15,day16,day17,day18,day19,day20,day21,day22,day23,day24,day25,day26,day27,day28,day29,day30,day31,copiedfrom,route_mon,route_tue,route_wed,route_thu,route_fri,route_sat,routemonth,routeyear,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,day1,day2,day3,day4,day5,day6,day7,day8,day9,day10,day11,day12,day13,day14,day15,day16,day17,day18,day19,day20,day21,day22,day23,day24,day25,day26,day27,day28,day29,day30,day31,copiedfrom,route_mon,route_tue,route_wed,route_thu,route_fri,route_sat,routemonth,routeyear,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_vve.routemonthplan where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_roumo1=mysql_query("INSERT INTO sfa_retail.routemonthplan
(KD_Code,DSR_Code,day1,day2,day3,day4,day5,day6,day7,day8,day9,day10,day11,day12,day13,day14,day15,day16,day17,day18,day19,day20,day21,day22,day23,day24,day25,day26,day27,day28,day29,day30,day31,copiedfrom,route_mon,route_tue,route_wed,route_thu,route_fri,route_sat,routemonth,routeyear,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,day1,day2,day3,day4,day5,day6,day7,day8,day9,day10,day11,day12,day13,day14,day15,day16,day17,day18,day19,day20,day21,day22,day23,day24,day25,day26,day27,day28,day29,day30,day31,copiedfrom,route_mon,route_tue,route_wed,route_thu,route_fri,route_sat,routemonth,routeyear,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_d2r.routemonthplan where KD_Code ='$KD_Code'");

//3.Sniz
$insert_roumo1=mysql_query("INSERT INTO sfa_retail.routemonthplan
(KD_Code,DSR_Code,day1,day2,day3,day4,day5,day6,day7,day8,day9,day10,day11,day12,day13,day14,day15,day16,day17,day18,day19,day20,day21,day22,day23,day24,day25,day26,day27,day28,day29,day30,day31,copiedfrom,route_mon,route_tue,route_wed,route_thu,route_fri,route_sat,routemonth,routeyear,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,day1,day2,day3,day4,day5,day6,day7,day8,day9,day10,day11,day12,day13,day14,day15,day16,day17,day18,day19,day20,day21,day22,day23,day24,day25,day26,day27,day28,day29,day30,day31,copiedfrom,route_mon,route_tue,route_wed,route_thu,route_fri,route_sat,routemonth,routeyear,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_sniz.routemonthplan where KD_Code ='$KD_Code'");


//4.Da-Ande-Ventures
$insert_roumo1=mysql_query("INSERT INTO sfa_retail.routemonthplan
(KD_Code,DSR_Code,day1,day2,day3,day4,day5,day6,day7,day8,day9,day10,day11,day12,day13,day14,day15,day16,day17,day18,day19,day20,day21,day22,day23,day24,day25,day26,day27,day28,day29,day30,day31,copiedfrom,route_mon,route_tue,route_wed,route_thu,route_fri,route_sat,routemonth,routeyear,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,day1,day2,day3,day4,day5,day6,day7,day8,day9,day10,day11,day12,day13,day14,day15,day16,day17,day18,day19,day20,day21,day22,day23,day24,day25,day26,day27,day28,day29,day30,day31,copiedfrom,route_mon,route_tue,route_wed,route_thu,route_fri,route_sat,routemonth,routeyear,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_dav.routemonthplan where KD_Code ='$KD_Code'");


//Insert routemaster Data

//1.Vinvalvico Enterprises
$insert_rouma1=mysql_query("INSERT INTO sfa_retail.route_master(KD_Code,KD_Name,route_code,route_desc,location,route_distance,AUDIT_DATE_TIME) SELECT KD_Code,KD_Name,route_code,route_desc,location,route_distance,AUDIT_DATE_TIME FROM sfa_vve.route_master where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_rouma2=mysql_query("INSERT INTO sfa_retail.route_master(KD_Code,KD_Name,route_code,route_desc,location,route_distance,AUDIT_DATE_TIME) SELECT KD_Code,KD_Name,route_code,route_desc,location,route_distance,AUDIT_DATE_TIME FROM sfa_d2r.route_master where KD_Code ='$KD_Code'");

//3.Sniz
$insert_rouma2=mysql_query("INSERT INTO sfa_retail.route_master(KD_Code,KD_Name,route_code,route_desc,location,route_distance,AUDIT_DATE_TIME) SELECT KD_Code,KD_Name,route_code,route_desc,location,route_distance,AUDIT_DATE_TIME FROM sfa_sniz.route_master where KD_Code ='$KD_Code'");


//4.Da-Ande-Ventureas
$insert_rouma2=mysql_query("INSERT INTO sfa_retail.route_master(KD_Code,KD_Name,route_code,route_desc,location,route_distance,AUDIT_DATE_TIME) SELECT KD_Code,KD_Name,route_code,route_desc,location,route_distance,AUDIT_DATE_TIME FROM sfa_dav.route_master where KD_Code ='$KD_Code'");




//Insert Salelist Data

//1.Vinvalvico Enterprises
$insert_sallist1=mysql_query("INSERT INTO sfa_retail.sales_list(KD_Code,DSR_Code,DateValue,monthyear,route_id,customer_id,Product_code,quantity,rateval,valueval,transtype,insertdatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,DateValue,monthyear,route_id,customer_id,Product_code,quantity,rateval,valueval,transtype,insertdatetime,AUDIT_DATE_TIME FROM sfa_vve.sales_list where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_sallist2=mysql_query("INSERT INTO sfa_retail.sales_list(KD_Code,DSR_Code,DateValue,monthyear,route_id,customer_id,Product_code,quantity,rateval,valueval,transtype,insertdatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,DateValue,monthyear,route_id,customer_id,Product_code,quantity,rateval,valueval,transtype,insertdatetime,AUDIT_DATE_TIME FROM sfa_d2r.sales_list where KD_Code ='$KD_Code'");

//3.Sniz
$insert_sallist2=mysql_query("INSERT INTO sfa_retail.sales_list(KD_Code,DSR_Code,DateValue,monthyear,route_id,customer_id,Product_code,quantity,rateval,valueval,transtype,insertdatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,DateValue,monthyear,route_id,customer_id,Product_code,quantity,rateval,valueval,transtype,insertdatetime,AUDIT_DATE_TIME FROM sfa_sniz.sales_list where KD_Code ='$KD_Code'");

//4.Da-Ande-Ventures
$insert_sallist2=mysql_query("INSERT INTO sfa_retail.sales_list(KD_Code,DSR_Code,DateValue,monthyear,route_id,customer_id,Product_code,quantity,rateval,valueval,transtype,insertdatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,DateValue,monthyear,route_id,customer_id,Product_code,quantity,rateval,valueval,transtype,insertdatetime,AUDIT_DATE_TIME FROM sfa_dav.sales_list where KD_Code ='$KD_Code'");


//Insert Sale And Collection Data

//1.Vinvalvico Enterprises
$insert_salcoll1=mysql_query("INSERT INTO sfa_retail.sale_and_collection(KD_Code,DSR_Code,device_code,Vehicle_Code,Date,cycle_start_flag,currency,total_sale_value,total_collection_value,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,device_code,Vehicle_Code,Date,cycle_start_flag,currency,total_sale_value,total_collection_value,AUDIT_DATE_TIME FROM sfa_vve.sale_and_collection where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_salcoll1=mysql_query("INSERT INTO sfa_retail.sale_and_collection(KD_Code,DSR_Code,device_code,Vehicle_Code,Date,cycle_start_flag,currency,total_sale_value,total_collection_value,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,device_code,Vehicle_Code,Date,cycle_start_flag,currency,total_sale_value,total_collection_value,AUDIT_DATE_TIME FROM sfa_d2r.sale_and_collection where KD_Code ='$KD_Code'");

//3.Sniz
$insert_salcoll1=mysql_query("INSERT INTO sfa_retail.sale_and_collection(KD_Code,DSR_Code,device_code,Vehicle_Code,Date,cycle_start_flag,currency,total_sale_value,total_collection_value,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,device_code,Vehicle_Code,Date,cycle_start_flag,currency,total_sale_value,total_collection_value,AUDIT_DATE_TIME FROM sfa_sniz.sale_and_collection where KD_Code ='$KD_Code'");


//4.Da-Ande-Ventures
$insert_salcoll1=mysql_query("INSERT INTO sfa_retail.sale_and_collection(KD_Code,DSR_Code,device_code,Vehicle_Code,Date,cycle_start_flag,currency,total_sale_value,total_collection_value,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,device_code,Vehicle_Code,Date,cycle_start_flag,currency,total_sale_value,total_collection_value,AUDIT_DATE_TIME FROM sfa_dav.sale_and_collection where KD_Code ='$KD_Code'");



//Insert SR Brand Incentive Data

//1.Vinvalvico Enterprises
$insert_srbran1=mysql_query("INSERT INTO sfa_retail.srbrand_incentive(KD_Code,DSR_Code,monthval,yearval,Brand_id,target_units,target_naira,targetFlag,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,monthval,yearval,Brand_id,target_units,target_naira,targetFlag,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_vve.srbrand_incentive where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_srbran2=mysql_query("INSERT INTO sfa_retail.srbrand_incentive(KD_Code,DSR_Code,monthval,yearval,Brand_id,target_units,target_naira,targetFlag,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,monthval,yearval,Brand_id,target_units,target_naira,targetFlag,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_d2r.srbrand_incentive where KD_Code ='$KD_Code'");

//3.Sniz
$insert_srbran2=mysql_query("INSERT INTO sfa_retail.srbrand_incentive(KD_Code,DSR_Code,monthval,yearval,Brand_id,target_units,target_naira,targetFlag,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,monthval,yearval,Brand_id,target_units,target_naira,targetFlag,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_sniz.srbrand_incentive where KD_Code ='$KD_Code'");


//4.Da-Ande-Ventures
$insert_srbran2=mysql_query("INSERT INTO sfa_retail.srbrand_incentive(KD_Code,DSR_Code,monthval,yearval,Brand_id,target_units,target_naira,targetFlag,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,monthval,yearval,Brand_id,target_units,target_naira,targetFlag,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_dav.srbrand_incentive where KD_Code ='$KD_Code'");


//Insert SR Incentive Data

//1.Vinvalvico Enterprises
$insert_srbran1=mysql_query("INSERT INTO sfa_retail.sr_incentive(KD_Code,DSR_Code,monthval,yearval,Product_id,target_units,target_naira,targetFlag,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,monthval,yearval,Product_id,target_units,target_naira,targetFlag,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_vve.sr_incentive where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_srbran2=mysql_query("INSERT INTO sfa_retail.sr_incentive(KD_Code,DSR_Code,monthval,yearval,Product_id,target_units,target_naira,targetFlag,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,monthval,yearval,Product_id,target_units,target_naira,targetFlag,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_d2r.sr_incentive where KD_Code ='$KD_Code'");

//3.Sniz
$insert_srbran2=mysql_query("INSERT INTO sfa_retail.sr_incentive(KD_Code,DSR_Code,monthval,yearval,Product_id,target_units,target_naira,targetFlag,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,monthval,yearval,Product_id,target_units,target_naira,targetFlag,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_sniz.sr_incentive where KD_Code ='$KD_Code'");


//4.Da-Ande-Ventures
$insert_srbran2=mysql_query("INSERT INTO sfa_retail.sr_incentive(KD_Code,DSR_Code,monthval,yearval,Product_id,target_units,target_naira,targetFlag,insertdatetime,updatedatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,monthval,yearval,Product_id,target_units,target_naira,targetFlag,insertdatetime,updatedatetime,AUDIT_DATE_TIME FROM sfa_dav.sr_incentive where KD_Code ='$KD_Code'");


//Insert Vehicle Master Data

//1.Vinvalvico Enterprises
$insert_vhm1=mysql_query("INSERT INTO sfa_retail.vehicle_master(KD_Code,KD_Name,vehicle_code,vehicle_desc,vehicle_reg_no,AUDIT_DATE_TIME) SELECT KD_Code,KD_Name,vehicle_code,vehicle_desc,vehicle_reg_no,AUDIT_DATE_TIME FROM sfa_vve.vehicle_master where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_vhm2=mysql_query("INSERT INTO sfa_retail.vehicle_master(KD_Code,KD_Name,vehicle_code,vehicle_desc,vehicle_reg_no,AUDIT_DATE_TIME) SELECT KD_Code,KD_Name,vehicle_code,vehicle_desc,vehicle_reg_no,AUDIT_DATE_TIME FROM sfa_d2r.vehicle_master where KD_Code ='$KD_Code'");


//3.Sniz
$insert_vhm2=mysql_query("INSERT INTO sfa_retail.vehicle_master(KD_Code,KD_Name,vehicle_code,vehicle_desc,vehicle_reg_no,AUDIT_DATE_TIME) SELECT KD_Code,KD_Name,vehicle_code,vehicle_desc,vehicle_reg_no,AUDIT_DATE_TIME FROM sfa_sniz.vehicle_master where KD_Code ='$KD_Code'");


//4.Da-Ande-Ventures
$insert_vhm2=mysql_query("INSERT INTO sfa_retail.vehicle_master(KD_Code,KD_Name,vehicle_code,vehicle_desc,vehicle_reg_no,AUDIT_DATE_TIME) SELECT KD_Code,KD_Name,vehicle_code,vehicle_desc,vehicle_reg_no,AUDIT_DATE_TIME FROM sfa_dav.vehicle_master where KD_Code ='$KD_Code'");


//Insert Average Suggested Sales Data

//1.Vinvalvico Enterprises
$insert_ave1=mysql_query("INSERT INTO sfa_retail.ave_suggested_sales(KD_Code,DSR_Code,route_id,Product_code,LM,LMOne,LMTwo,Average_Sales,insertdatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,route_id,Product_code,LM,LMOne,LMTwo,Average_Sales,insertdatetime,AUDIT_DATE_TIME FROM sfa_vve.ave_suggested_sales where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_ave2=mysql_query("INSERT INTO sfa_retail.ave_suggested_sales(KD_Code,DSR_Code,route_id,Product_code,LM,LMOne,LMTwo,Average_Sales,insertdatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,route_id,Product_code,LM,LMOne,LMTwo,Average_Sales,insertdatetime,AUDIT_DATE_TIME FROM sfa_d2r.ave_suggested_sales where KD_Code ='$KD_Code'");

//3.Sniz
$insert_ave2=mysql_query("INSERT INTO sfa_retail.ave_suggested_sales(KD_Code,DSR_Code,route_id,Product_code,LM,LMOne,LMTwo,Average_Sales,insertdatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,route_id,Product_code,LM,LMOne,LMTwo,Average_Sales,insertdatetime,AUDIT_DATE_TIME FROM sfa_sniz.ave_suggested_sales where KD_Code ='$KD_Code'");


//4.Da-Ande-Ventures
$insert_ave2=mysql_query("INSERT INTO sfa_retail.ave_suggested_sales(KD_Code,DSR_Code,route_id,Product_code,LM,LMOne,LMTwo,Average_Sales,insertdatetime,AUDIT_DATE_TIME) SELECT KD_Code,DSR_Code,route_id,Product_code,LM,LMOne,LMTwo,Average_Sales,insertdatetime,AUDIT_DATE_TIME FROM sfa_dav.ave_suggested_sales where KD_Code ='$KD_Code'");



//Insert Stock Receipts Data

//1.Vinvalvico Enterprises
$insert_str1=mysql_query("INSERT INTO sfa_retail.stock_receipts(Date,KD_Code,Transaction_number,supplier_inv_no,supplier_category,supplier_name,line_number,Product_code,Product_name,UOM,quantity,opening_id,AUDIT_DATE_TIME) SELECT Date,KD_Code,Transaction_number,supplier_inv_no,supplier_category,supplier_name,line_number,Product_code,Product_name,UOM,quantity,opening_id,AUDIT_DATE_TIME FROM sfa_vve.stock_receipts where KD_Code ='$KD_Code'");

//2.Direct to Retail
$insert_str1=mysql_query("INSERT INTO sfa_retail.stock_receipts(Date,KD_Code,Transaction_number,supplier_inv_no,supplier_category,supplier_name,line_number,Product_code,Product_name,UOM,quantity,opening_id,AUDIT_DATE_TIME) SELECT Date,KD_Code,Transaction_number,supplier_inv_no,supplier_category,supplier_name,line_number,Product_code,Product_name,UOM,quantity,opening_id,AUDIT_DATE_TIME FROM sfa_d2r.stock_receipts where KD_Code ='$KD_Code'");

//3.Sniz
$insert_str1=mysql_query("INSERT INTO sfa_retail.stock_receipts(Date,KD_Code,Transaction_number,supplier_inv_no,supplier_category,supplier_name,line_number,Product_code,Product_name,UOM,quantity,opening_id,AUDIT_DATE_TIME) SELECT Date,KD_Code,Transaction_number,supplier_inv_no,supplier_category,supplier_name,line_number,Product_code,Product_name,UOM,quantity,opening_id,AUDIT_DATE_TIME FROM sfa_sniz.stock_receipts where KD_Code ='$KD_Code'");


//4.Da-Ande-Ventures
$insert_str1=mysql_query("INSERT INTO sfa_retail.stock_receipts(Date,KD_Code,Transaction_number,supplier_inv_no,supplier_category,supplier_name,line_number,Product_code,Product_name,UOM,quantity,opening_id,AUDIT_DATE_TIME) SELECT Date,KD_Code,Transaction_number,supplier_inv_no,supplier_category,supplier_name,line_number,Product_code,Product_name,UOM,quantity,opening_id,AUDIT_DATE_TIME FROM sfa_dav.stock_receipts where KD_Code ='$KD_Code'");



}	

 echo 'Insert data';
	
?>	