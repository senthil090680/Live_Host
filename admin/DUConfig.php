<?php
session_start();
ob_start();
include('../include/header.php');
if(isset($_GET['logout'])){
session_destroy();
header("Location:../index.php");
}
?>
<!------------------------------- Form -------------------------------------------------->
<div id="mainarea">
<div class="mcf"></div>
<div align="center" class="headings">Download / Upload Configuration</div>
<div class="mytableCP" align="center">
	            <table width="100%" align="center">
            <tr>
            <td width="120" height="35"><h4>Download / Upload*</h4></td>
            <td width="120"><select name="uploaddownload" id="uploaddownload" class="required" onChange="return DUConfig();">
			<option value="">--- Select ---</option>
			<option value="Download">Download</option>
			<option value="Upload">Upload</option>
			</select></td>
            </tr>
            
            <tr>
            <td width="120" height="35"><h4>Server Name*</h4></td>
            <td width="120"> <input type="text" name="servername" id="servername" class="servername" value="" /></td>
            </tr>
            
            <tr>
            <td width="120" height="35"><h4>User Name</h4></td>
            <td width="120"><input type="text" name="username" id="username" class="username" value="" /></td>
            </tr>
            <tr >
			<td width="120" height="35"><h4>Password</h4></td>
			<td width="120"><input type="password" name="password" id="password" class="password" value="" /></td>	 
			</tr>
			<tr >
			<td width="120" height="35"><h4>Folder Name</h4></td>
			<td width="120"><input type="text" name="folderName" id="folderName" class="folderName" value="" /></td>	 
			</tr>
			<tr>
			<td width="120" height="35"><h4>Frequency</h4></td>
			<td width="120"><input type="text" name="frequency" id="frequency" class="frequency" value="Daily" /></td>	 
			</tr>

            </table>

</div>
</div>
<?php include('../include/footer.php'); ?>