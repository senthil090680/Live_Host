<?php
session_start();
ob_start();
include('../include/header.php');
if(isset($_GET['logout'])){
session_destroy();
header("Location:../index.php");
}
$stat = stat($_SERVER['DOCUMENT_ROOT']."/meena/Host_new/DownloadfromBase/");
$stat1 = stat($_SERVER['DOCUMENT_ROOT']."/meena/Host_new/UploadtoBase/");

?>
<!------------------------------- Form -------------------------------------------------->
<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headings">Download / Upload Status</div>
<div class="mytableFP" align="center">
	                       <table width="100%" align="center">
            <tr>
            <td width="120" height="35"><h4>Download*</h4></td>
            <td width="120"><input type="text" name="status" id="status" class="status" value="<?php echo date('d/m/Y H:i:s',$stat['mtime']);?>"/></td>
            </tr>
            
            <tr>
            <td width="120" height="35"><h4>Upload</h4></td>
            <td width="120"><input type="text" name="status" id="status" class="status" value="<?php echo date('d/m/Y H:i:s',$stat1['mtime']);?>" /></td>
            </tr>
            </table>

</div>
</div>
<?php include('../include/footer.php'); ?>