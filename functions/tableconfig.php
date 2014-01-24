<?php
session_start();
ob_start();
include('../include/header.php');
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location:../index.php");
}

$tbName = $_GET['tb'];
$tbProcess = $_GET['process'];

$addProcess = $_GET['addProcess'];  //get value of ub

mysql_connect("localhost", "sfa", "SfaPwfBrA5w");
$query = "SHOW TABLES FROM sfa_retail";                                          //Need to change
$result = mysql_query($query);


$query = "select * from base_information";
$addprocessResult = mysql_query($query);
$dataProcess = mysql_fetch_assoc($addprocessResult);
//$ipProcess = $dataProcess['ip_address'];  //Get ip address from kd db

$baseip = $dataProcess['Base_IP']; 
$baseurl = $dataProcess['Base_Url']; 

$url = "http://" . $baseip ."/".$baseurl. "/functions/dataCall.php";

$cu = curl_init();
curl_setopt($cu, CURLOPT_URL, $url);
curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);
$listBase = curl_exec($cu);
curl_close($cu);

$listBase = rtrim($listBase, "1");

$listbaseArray = explode('*', $listBase);
count($listbaseArray); //Get Table count 

if ($tbProcess == "ub")

    $processState = "upload";
else
    $processState = "download";


if ($addProcess == "ub")

    $processState1 = "upload";
else
    $processState1 = "download";


$query = "select * from data_transfer_table where TRANSFER_NAME='" . $processState . "'";
$transferTables = mysql_query($query);

$query = "select * from data_transfer_table where TRANSFER_NAME='" . $processState1 . "'";
$transferTables1 = mysql_query($query);

if (!$tbName)
    $query = "select * from data_transfer_table LIMIT 0,1";
else
    $query = "select * from data_transfer_table where TABLE_NAME='" . $tbName . "'";
$transferTable = mysql_query($query);
$row = mysql_fetch_assoc($transferTable);

if ($row['TRANSFER_NAME'] == "upload")

    $updateTransfer = "ub";
else
    $updateTransfer = "db";
?>
<div id="mainarea">
    <style>
        fieldset{
            margin:3px;
            padding:10px;
        }

        td{
            padding:5px;
        }

        .buttons{

            width:90px;

        }

    </style>
    <div id="mainarea">
        <div class="mcf"></div>
        <div align="center" class="headingskdp">Add Table For Upload/Download</div>
        <div class="mytable3">
            <fieldset>
                <legend> Add New Table </legend>
                <span style="padding-left:10px;"> Upload/Download :</span>
                <select id="transfer" onChange="reload2();">
                    <option value="db">Download to base</option>
                    <option value="ub">Upload from Base </option>
                </select>

                </select>

                <span style="padding-left:10px;height:300px;"> System Tables : </span>
                <select id="tableName" multiple="multiple" style="height:150px">
<?php
if ($addProcess == "ub") {
	
	
    for ($i = 0; $i < sizeof($listbaseArray); $i++) {
		
        echo '<option value="' . $listbaseArray[$i] . '">' . $listbaseArray[$i] . '</option>';
		
    }
	
} else {
    while ($data = mysql_fetch_row($result)) {
        echo '<option value="' . $data[0] . '">' . $data[0] . '</option>';
    }
}
?>
                    
                    
                    <script>
                        
                        $("#tableName option[value='admin']").remove();
                        $("#tableName option[value='KD_']").remove();
						
                        
                        </script>

                    <input style="margin-left:10px; padding:5px; width:80px;" class="buttons" type="button" value="Add" onclick="load()" />
                    
                    <span style="padding-left:10px;"> Tables : </span>
                    
                    <select id="updatetableName1" onchange = "reload3()" class="updatetableName">
                    
                    <?php
                    while ($table = mysql_fetch_array($transferTables1))
					
                        echo '<option value="' . $table['TABLE_NAME'] . '">' . $table['TABLE_NAME'] . '</option>';
                    ?>
                    </select>
            </fieldset>

            <br />
            <fieldset>
                <legend>Update Table</legend>
                <span style="padding-left:10px;"> Upload/Download :</span>
                <select id="updatetransfer" onChange="reload1();">
                    <option <?php if ($processState != "upload") echo 'selected="selected"'; ?> value="db">Download to base</option>
                    <option <?php if ($processState == "upload") echo 'selected="selected"'; ?> value="ub">Upload from Base </option>
                </select>

                <span style="padding-left:10px;"> Tables : </span>
                <select id="updatetableName" onchange = "reload()" class="updatetableName">
<?php
while ($table = mysql_fetch_array($transferTables))
    echo '<option value="' . $table['TABLE_NAME'] . '">' . $table['TABLE_NAME'] . '</option>';
?>
                </select>
                <span style="padding-left:10px;" > KD specific : </span>

                <input type="checkbox" id="updatekdSpecific" <?php if ($row['KD_SPECIFIC'] == "Y") echo "checked"; ?>/>
                <span style="padding-left:10px;"> Active : </span>
                <input type="checkbox" id="updateaod" <?php if ($row['ACTIVE_FLAG'] == "Y") echo "checked"; ?>/>

                <span style="padding-left:10px;"> Access :</span>
                <select id="updateaccess" onChange="updatesuccess()">
                    <option value="full">Full</option>
                    <option value="slu">Since last update</option>
                </select>
                </br>
                </br>


                <script>
                    $('.updatetableName').val('<?php echo $tbName; ?>');
                    $('#updateaccess').val('<?php echo $row['TYPE'] ?>');
                    $('#transfer').val('<?php echo $addProcess; ?>');

                    //$('#updatetransfer').val('<?php echo $updateTransfer ?>');
                </script>
                <span style="padding-left:10px;" > </span>
                <input type="button" value="Update" class ="buttons" onclick="update()" />
                <span style="padding-left:10px;" > </span>
                <input type="button" value="Delete"  class="buttons" onclick="tabledelete()"/>
                <br />


                <div class="con3" style="width:300px;margin-top:20px;padding:2px;" id="listtable" >
                    <table id="sort" style="width:300px;" >
<?php
$query = "DESCRIBE host." . $row['TABLE_NAME'];
$columns = mysql_query($query);
while ($column = mysql_fetch_array($columns)) {
    ?>

                            <tr>
                                <td>
    <?php echo $column["Field"]; ?>
                                </td>

                                <td>
                                    <input type="checkbox"  value ="<?php echo $column["Field"]; ?>" name="checkboxlist"/>
                                </td>

                            </tr>
                        <?php } ?>
                    </table>
                </div>

            </fieldset>

        </div> 
    </div>	


    <script type="text/javascript" >


                    function updatesuccess() {

                        if ($("#updateaccess").val() != "update")
                            $("#listtable").css("display", "none");
                        else
                            $("#listtable").css("display", "block");
                    }

                    updatesuccess();
					
                    function load()
                    {
                        var transfer = $("#transfer").val();
                        var access = "full";
                        var aod = "Y";
                        var kdSpecific = "N";

                            

                        var tableName = $("#tableName").val()
                        

                        var posting = $.post("transfertablesave.php", {transfer: transfer, tableName: tableName, access: access, aod: aod, kdSpecific: kdSpecific});

                        posting.done(function(data) {
                            alert(data);
                            window.location.href = "tableconfig.php";
                        });

                    }

                    function tabledelete()
                    {
                        var confirmed = confirm("Do you really want to Delete?");

                        if (confirmed == true)
                        {
                            var tableName = $("#updatetableName").val();
                            var process = $("#updatetransfer").val();
                            var action = $.post("tabledelete.php", {tableName: tableName, process: process});

                            action.done(function(data) {

                                alert(data);
                                window.location.href = "tableconfig.php";
                            });
                        }
                    }
                    function reload()

                    {
                        
					    var temp = $("#updatetableName").val();
                        var process = $("#updatetransfer").val();


                        $(".updatetableName").val(temp);
						//alert("Table exists");
                        window.location.href = "tableconfig.php?tb=" + $("#updatetableName").val() + "&process=" + process;
                    }
					
					
                    function reload1()

                    {
					
                        window.location.href = "tableconfig.php?process=" + $("#updatetransfer").val();
                    }


                    function reload2()
                    {
						window.location.href = "tableconfig.php?addProcess=" + $("#transfer").val();
                    }

                    function reload3()
                    {
                        var temp = $("#updatetableName1").val();
                        var process = $("#transfer").val();
                      alert(temp);
                        $(".updatetableName").val(temp);
                        window.location.href = "tableconfig.php?tb=" + $("#updatetableName").val() + "&process=" + process;
                    }

                    function update()
                    {

                        var transfer = $("#updatetransfer").val();
                        var access = $("#updateaccess").val()

                        if ($("#updateaod").is(':checked') == false) {
                            var aod = "false";
                        }
                        else {
                            var aod = "true";
                        }

                        if ($("#updatekdSpecific").is(':checked') == false) {
                            var kdSpecific = "false";
                        }
                        else {
                            var kdSpecific = "true";
                        }



                        var tableName = $("#updatetableName").val()
                        var action = $.post("tableupdate.php", {transfer: transfer, access: access, aod: aod, tableName: tableName, kdSpecific: kdSpecific});
                        action.done(function(data) {
                            alert(data);
                            window.location.href = "tableconfig.php";
                        });

                    }


    </script>

</div>
<?php include('../include/footer.php'); ?>