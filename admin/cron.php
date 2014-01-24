<?php
$path="/opt/lampp/htdocs/meena/Host_new/DownloadfromCP/";
$destination="/opt/lampp/htdocs/meena/base/DownloadfromCP/";
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