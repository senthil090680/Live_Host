<?php
ob_start();
include('header.php');
session_start();
if(!isset($_SESSION['username']))
{?>

<script type="text/javascript">
window.location.href = "http://localhost/LiveServerFiles/Host/index.php";
</script>
  
<?php } 
else
{

    $now = time(); // checking the time now when home page starts

    if($now > $_SESSION['expire'])
    {
        session_destroy();?>
        <script type="text/javascript">
        alert("Your Session has been Expired <?php echo $_SESSION['username']; ?> Please Login Again.");
        </script> 
        
<?php        
    }
    else
    { //starting this else one [else1]

?>
<!------------------------------- Form -------------------------------------------------->
<div id="mainarea">
<div  style="padding-top:20%;" class="mydiv">
<h3 align="center" class="sucmsg">
Welcome <?php echo $_SESSION['username']; }?>
</h3>
</div>
<?php } ?>
</div>
<?php include('footer.php'); ?>