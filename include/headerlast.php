<?php
session_start();
include "../include/config.php";
if($_SESSION['user_id']!= $_GET['ID']) // If the user is viewing a page that does not match her ID
header("Location: ../index.php?ID=".$_SESSION['user_id']); // redirect to user's own page.
if($_REQUEST['no']!=''){
$error_sql="select * from  error_message where id=".$_REQUEST['no'];
$error_exec=mysql_query($error_sql);
$error_fetch=mysql_fetch_array($error_exec);
}
//echo $error_fetch[1].'<br>'.$error_fetch[2].'<br>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Host System</title>
<link rel="stylesheet" href="themes/base/jquery.ui.all.css">
<link rel="stylesheet" href="../css/style.css" type="text/css" />
<link rel="stylesheet" href="../css/menu.css" type="text/css" />
<link rel="stylesheet" href="../css/facebox.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.css" />
<link rel="stylesheet" href="../css/editbox.css" type="text/css" />
<script type="text/javascript" src="../js/jquery1.js"></script>
<script type="text/javascript" src="../js/jquery2.js"></script>
<script type="text/javascript" src="../js/facebox.js"></script>
<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
<script type="text/javascript" src="../js/validator.js"></script>
<script type="text/javascript" src="../js/jquery.tablesorter.js"></script> 
<script type="text/javascript" src="../js/jconfirmaction.jquery.js"></script>
</head>

<body>
<div id="wrapper">
 <div id="header">
    <div id="logo">
      <div class="left"><img src="../images/logo_fmcl.png" width=60 height="70"/></div>
      <div class="left">
      <h1 align="center">RETAIL OPERATIONS</h1>
      <h2 align="center">Host System</h2></div>
      <div class="left"><img src="../images/logo_tts.png" width="60" height="72" style="padding-left:295px;"/></div> 
      </div>
      <div id="menuleft">
<li><a href="#">Master Data</a>
       <ul>
           <li><a href="#">Value Sets </a>
          <ul>
            <li><a href="../valueSets/branch.php">Branch</a></li>
            <li><a href="../valueSets/province.php">Zone</a></li>
            <li><a href="../valueSets/state.php">State</a></li>
            <li><a href="../valueSets/city.php">City</a></li>
            <li><a href="../valueSets/lga.php">LGA</a></li>
            <li><a href="../valueSets/location.php">Location</a></li>
            <li><a href="#">KD Categories</a>
            <ul>
                <li><a href="../valueSets/kdCategory.php">KD Product & Price Category</a></li>
                <li><a href="../valueSets/kdanalysis.php">KD Analysis Category</a></li>
             </ul>    
             </li>
            <li><a href="#">Customer Category</a>  
            <ul> 
            <li><a href="../valueSets/customerCategory1.php">Customer Category1</a></li>
            <li><a href="../valueSets/customerCategory2.php">Customer Category2</a></li>
            <li><a href="../valueSets/customerCategory3.php">Customer Category3</a></li>
            </ul>
            </li>
            <li><a href="../valueSets/feedbackType.php">Customer Feedback Type</a></li>
            <li><a href="../valueSets/productType.php">Product Type</a></li>
            <li><a href="../valueSets/currency.php">Currency</a></li>
            <li><a href="../valueSets/CustomerType.php">Customer Type</a></li>
            <li><a href="../valueSets/productCategory.php">Product Category</a></li>
            <li><a href="../valueSets/principal.php">Principal</a></li>
            <li><a href="../valueSets/brand.php">Brand</a></li>
            
          </ul>
        </li>
	    <li><a href="../masterData/uomMaster.php" title="">UOM1</a></li>
        <li><a href="../masterData/uom2.php" title="">UOM2</a></li>
        <li><a href="../masterData/uomConversion.php" title="">UOM Conversion</a></li>
        <li><a href="../masterData/productMaster.php" title="">Product</a></li>
        <li><a href="../masterData/kd.php" title="">KD</a></li>
        <li><a href="../masterData/rsm.php" title="">RSM</a></li>
        <li><a href="../masterData/asm.php" title="">ASM</a></li>
        <li><a href="../masterData/sr.php" title="">SR</a></li>
        <li><a href="../masterData/dsr.php" title="">DSR</a></li>
        <li><a href="../masterData/kdProduct.php" title="">KD-Product</a></li>
        <li><a href="../masterData/scheme.php" title="">Scheme</a></li>
        <li><a href="../masterData/productscheme.php" title="">Product Scheme</a></li>
        <li><a href="../masterData/customertypeproduct.php" title="">CustomerType POSM</a></li>
		</ul>
</li>

  
 <li><a href="#">Base Data</a>
     <ul>
					<li><a href="#" title="" class="sub1">Masters</a>
                      <ul>
                           <li><a href="../BaseData/deviceMaster.php">Device</a></li>
                             <li><a href="../BaseData/routeMaster.php">Route</a></li>
                               <li><a href="../BaseData/vehicleMaster.php">Vehicle</a></li>
                                 <li><a href="../BaseData/customerMaster.php">Customer</a></li>
                              </ul>
                                </li>
                    <!--<li><a href="../BaseData/productStock.php">Stock</a></li>-->
					<li><a href="../BaseData/deviceTransactions.php">Device Transactions</a></li>
					<li><a href="../BaseData/device.php">Device Dashboard</a></li>
				</ul>
  
  </li>
                  	<li><a href="#">Reports</a>
					<ul>
					<li><a href="../allReports/kdsalesperform.php" title="">KD Sales Performance</a></li>
					<li><a href="../allReports/kdsalelist.php" title="">KD Sales List</a></li>
					<li><a href="../allReports/kdsalesfocusperform.php" title="">KD Focus Products Performance</a></li>
					<li><a href="../allReports/kdcoverage.php" title="">KD COVERAGE</a></li>
					<li><a href="../allReports/kdcustomeroutstanding.php" title="">KD CUSTOMER O/S</a></li>
					<li><a href="../allReports/transactionlist.php" title="">Transaction List</a></li>
  	          		<li><a href="../allReports/Kdstockledger.php" title="">KD Stock Ledger</a></li>
		             <li><a href="../allReports/vehiclestockledger.php" title="">Vehicle Stock Ledger</a></li>
					</ul>
					
					</li>
					<li style="float:right;padding-right:80px;"><a href="../index.php?logout=logout"><strong><?php echo $_SESSION['username'];?></strong></a>
					<ul>
                  	<?php
                    $now = time(); // checking the time now when home page starts
                    if($now > $_SESSION['expire'])
                    {
                    session_destroy();?>
                    <script type="text/javascript">
                    alert("Your Session has been Expired <?php echo $_SESSION['username']; ?> Please Login Again.");
					window.location.href='../index.php';
                    </script> 
                    <?php }?>  
					<li style="float:right"><a href="../index.php?logout=logout">Logout</a></li>
					</ul>
					</li>
                    <?php 		
					$UN=strtolower($_SESSION['username']); 
					$now = time(); 
					if($UN=='sfafmcl'){ ?>
					<li style="float:right"><a href="#">Admin</a>
					<ul>
                    <li style="float:right"><a href="">Administration</a>
                    <ul>
                    <li style="float:right"><a href="../login/register.php">User Registration</a></li>
                    <li style="float:right"><a href="../admin/userchangePassword.php">User Administration</a></li>
                    </ul>
                    </li>
                    <li style="float:right"><a href="#">System Administration</a>
					<ul>
					<li><a href="../admin/setupParam.php?id=1">Setup Parameters</a></li>
                    <li><a href="../masterData/base_register.php">Base Information</a></li>
                    <li><a href="../admin/hostsetup.php?id=1">Host Information</a></li>
					<li><a href="../functions/tableconfig.php">Add Download/ Upload Table</a></li>
					<li><a href="../functions/config.php">Download/ Upload Config</a></li>
					</ul>
					</li>
					</ul>
					</li>
                    <?php }
					elseif($now > $_SESSION['expire']){
					session_destroy();?>
                    <script type="text/javascript">
				    alert("Your Session has been Expired <?php echo $_SESSION['username']; ?> Please Login Again.");
					window.location.href='../index.php';
                    </script>
					<?php }else{?>
					<li style="float:right;pading-left:30px;"><a href="../admin/changePassword.php">Change Password</a> </li>
					<?php }?> 
					</ul>
</div>