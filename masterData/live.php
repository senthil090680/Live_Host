<?php
session_start();
ob_start();
include('../include/header.php');
include "../include/ps_pagination.php";
if(isset($_GET['logout'])){
session_destroy();
header("Location:../index.php");
}
<!------------------------------- Form -------------------------------------------------->
<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headingspr"  style="padding-right:10px;">Sales Personnel</div>
<div id="mytableproduct" align="center" style="padding-right:10px;">

if(isset[$_GET['edit'])){
	
	$column =$_GET['column'];
	$id = $_GET[['id'];
	$newvalue =$_GET['newvalue'];
	
	$sql = "UPDATE customer SET $column =:$value where
	
	
	
	
	
}


    </div>         
   </div>
</div>
<?php include('../include/footer.php'); ?>