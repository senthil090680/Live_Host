<?php
include('../include/config.php');
$serializedData = $_REQUEST['serializedData'];
$arr = array();
parse_str($serializedData,$arr);
	 
//print_r($arr);

$KD_Name = $arr['KD_Code'];
$DSRName =$arr['DSR_Code'];
$Transaction_number = $arr['Transaction_number'];
$Customer_Stock_Check=$arr['Customer_Stock_Check'];
$Product_Scheme_Flag = $arr['Product_Scheme_Flag'];
$Transaction_type=$arr['Transaction_type'];
$line_number=$arr['line_number'];
$Focus_Flag=$arr['Focus_Flag'];
$POSM_Flag=$arr['POSM_Flag'];
$Scheme_Flag=$arr['Scheme_Flag'];
$Scheme_Code=$arr['Scheme_Code'];
$prodcnt=$arr['prodcnt'];


$sel="select DSR_Code,DSRName from dsr where DSRName = '$DSRName'"; 	
$res=mysql_query($sel);
while($val=mysql_fetch_array($res)){
$DSR_Code=$val['DSR_Code'];
}

$sel="select KD_Code,KD_Name from kd where KD_Name = '$KD_Name'"; 	
$res=mysql_query($sel);
while($val=mysql_fetch_array($res)){
$KD_Code=$val['KD_Code'];
}

for($k=1; $k <= $prodcnt; $k++) {
	
	$Product_code   =	$arr["pcode_".$k];	
	$UOM            =	$arr["UOM_".$k];
	$Order_quantity	=	$arr["Order_quantity_".$k];
	$Sold_quantity  =	$arr["Sold_quantity_".$k];
	$Price   	    =	$arr["Price_".$k];
	$Value   	    =	$arr["Value_".$k];
	$ins_val	    =	'';
	
	if($k == $prodcnt) {
				$ins_val.=	"('$KD_Code','$DSR_Code','$Transaction_type','$Transaction_number','$line_number','$Product_code','$UOM','$Focus_Flag','$POSM_Flag','$Customer_Stock_Check','$Customer_Stock_quantity','$Scheme_Flag','$Scheme_Code','$Product_Scheme_Flag','$Order_quantity','$Sold_quantity','$Price','$Value')";
				} else {
				$ins_val.=	"('$KD_Code','$DSR_Code','$Transaction_type','$Transaction_number','$line_number','$Product_code','$UOM','$Focus_Flag','$POSM_Flag','$Customer_Stock_Check','$Customer_Stock_quantity','$Scheme_Flag','$Scheme_Code','$Product_Scheme_Flag','$Order_quantity','$Sold_quantity','$Price','$Value')";
				}
				
				//echo $ins_val;
			    //exit;
			 $sql="INSERT INTO `transaction_line`( 	`KD_Code`,`DSR_Code`,`Transaction_type`,`Transaction_Number`,`Transaction_Line_Number`,`Product_code`,`UOM`,`Focus_Flag`,`POSM_Flag`,`Customer_Stock_Check`,`Customer_Stock_quantity`,`Scheme_Flag`,`Scheme_Code`,`Product_Scheme_Flag`,`Order_quantity`,`Sold_quantity`,`Price`,`Value`)values $ins_val";
			mysql_query($sql) or die(mysql_error());
			//header("location:transactionentry.php?no=1");	

}

//foreach( $unserializedData as $key => $val ) {
// 
//   echo $val."<br />";
//}


//if($_POST['submit']=='Confirm'){

	//pre($_REQUEST);
	////exit;
//		$sel="select * from transaction_line WHERE KD_Code ='$KD_Code'";
//		$sel_query=mysql_query($sel) or die(mysql_error());
//		if(mysql_num_rows($sel_query)=='0') {
			
			//$KD_Code=getKDCode();
//			$ins_val	=	'';
//			$prodcnt    = 1;
//			for($k=1; $k <= $prodcnt; $k++) { 
//		
//		        $Product_code	                =	$_POST["pcode_".$k];
//			    $UOM                        	=	$_POST["UOM_".$k];
//				$Order_quantity	               	=	$_POST["Order_quantity_".$k];
//				$Sold_quantity   	        	=	$_POST["Sold_quantity_".$k];
//                $Price   	                 	=	$_POST["Price_".$k];
//                $Value   	                 	=	$_POST["Value_".$k];
//									
//			
//
//				if($k == $prodcnt) {
//				$ins_val.=	"('$KD_Code','$DSR_Code','$Transaction_type','$Transaction_number','$Transaction_Line_Number','$Product_code','$UOM','$Focus_Flag','$POSM_Flag','$Customer_Stock_Check','$Customer_Stock_quantity','$Scheme_Flag','$Scheme_Code','$Product_Scheme_Flag','$Order_quantity','$Sold_quantity','$Price','$Value')";
//				} else {
//				$ins_val.=	"('$KD_Code','$DSR_Code','$Transaction_type','$Transaction_number','$Transaction_Line_Number','$Product_code','$UOM','$Focus_Flag','$POSM_Flag','$Customer_Stock_Check','$Customer_Stock_quantity','$Scheme_Flag','$Scheme_Code','$Product_Scheme_Flag','$Order_quantity','$Sold_quantity','$Price','$Value'),";
//				}
//			//}
//			//echo $ins_val;
//			//exit;
//
//			 $sql="INSERT INTO `transaction_line`(`KD_Code`,`DSR_Code`,`Transaction_type`,`Transaction_Number`,`Transaction_Line_Number`,`Product_code`,`UOM`,`Focus_Flag`,`POSM_Flag`,`Customer_Stock_Check`,`Customer_Stock_quantity`,`Scheme_Flag`,`Scheme_Code`,`Product_Scheme_Flag`,`Order_quantity`,`Sold_quantity`,`Price`,`Value`) values $ins_val";
//			mysql_query($sql) or die(mysql_error());
//			header("location:transactionentry.php?no=1");
//		}
//		else {
//			header("location:lineproduct.php?no=18");
//		}
//	}


?>