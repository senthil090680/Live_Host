<?php
session_start();
include('../include/header.php');
if(isset($_GET['logout'])){
session_destroy();
header("Location:../index.php");
}
$path=$_SERVER['DOCUMENT_ROOT']."/meena/Host_new/DownloadfromCP/";
$destination = $_SERVER['DOCUMENT_ROOT']."/meena/Base/DownloadfromCP/";
//Copy the folder to another folder
 function recurse_copy($path,$destination) { 
    $dir = opendir($path); 
    @mkdir($destination); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($path . '/' . $file) ) { 
			recurse_copy($path . '/' . $file,$destination . '/' . $file); 
            } 
            else { 
                copy($path . '/' . $file,$destination . '/' . $file); 
//				unlink($path . '/' .$file); 
            } 
        } 
    } 
    closedir($dir); 
	
} 
//Calling the function 
$ar1=recurse_copy($path,$destination);
?>
<!------------------------------- Form -------------------------------------------------->

<div id="mainarea">
<!-- Progress bar holder -->
<div id="progress" style="width:500px;border:2px solid #000;">
</div>
<!-- Progress information -->
<div id="information" style="width"></div>
<!-- Cancel -->
<div id="cancel" style="width"></div>

<?php
//Showing Total Files
$ite=new RecursiveDirectoryIterator($path);
$bytestotal=0;
$nbfiles=0;
foreach (new RecursiveIteratorIterator($ite) as $filename=>$cur) {
    $filesize=$cur->getSize();
    $bytestotal+=$filesize;
    $nbfiles++;
   // echo "$filename => $filesize\n";
}
$bytestotal=number_format($bytestotal);
//echo "Total: $nbfiles files";


for($i=1; $i<=$nbfiles; $i++){
   $percent = intval($i/$nbfiles * 100)."%"; 
  // Javascript for updating the progress bar and information
    echo '<script language="javascript">
    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#54C0EB;\">&nbsp;</div>";
    document.getElementById("information").innerHTML="'.$nbfiles.' file(s) Transfered.";
    document.getElementById("cancel").innerHTML="<form action=cron.php name=cron><input type=submit name=submit value=Cancel onclick=return getDirectorySize($path,$destination)();></form>";
    </script>';
    // This is for the buffer achieve the minimum size in order to flush data
    echo str_repeat(' ',1024*64);
 
    // Send output to browser immediately
    flush();
 
    // Sleep one second so we can see the delay
    sleep(1);

}
$ite=new RecursiveDirectoryIterator($path);

$bytestotal=0;
$nbfiles=0;
foreach (new RecursiveIteratorIterator($ite) as $filename=>$cur) {
    $filesize=$cur->getSize();
    $bytestotal+=$filesize;
    $nbfiles++;
    echo $nbfiles.'.'.basename($filename)."<br>";
	//echo "Total: $nbfiles files Downloaded";
}
?>
<br>
<br>
<?php 

// Tell user that the process is completed
echo '<script language="javascript">document.getElementById("information").innerHTML="Process completed"</script>';
?>

</div>
<?php include('../include/footer.php'); ?>