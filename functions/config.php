<?php
session_start();
ob_start();
include('../include/header.php');
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location:../index.php");
}


//include 'cfg.php';

$query = "SELECT * FROM data_transfer_process ORDER BY PROCESS_ID DESC LIMIT 0,1";
$last = mysql_query($query);

while ($lastone = mysql_fetch_array($last)) {
    $lastProcess = $lastone["STATUS"];
    $lastTime = $lastone["START_DATE_TIME"];
}
$nextShedule = nextShedule();

function nextShedule() {
    $result = shell_Exec("schtasks/query /fo csv /nh");

    $result1 = explode(",", $result);
    $final = "";
    $count = 0;

    foreach ($result1 as $data) {
        $data1 = substr($data, 4, strlen($data) - 3);
        $data1 = trim($data1, '"');
        $count++;
        if ($data1 == "KD_cronDownload") {


            $final = $result1[$count] . $result1[++$count];
            $final = trim($final, '"');

            //$final = substr($final, 2, strlen($final) - 3);
            break;
        }
    }

    return $final;
}
?>
<style>
    fieldset {
        margin: 20px;
        padding: 10px;
    }
    td {
        padding: 5px;
    }
    .buttons {
        width: 90px;
    }
</style>
<script type="text/javascript">

    /**
     Weekly frequency uses day feature.
      
     */

    function update()
    {
        $("#loading").css("display", "block");
        var confirmed = confirm("Confirm Process");
        if (confirmed == true)
        {
            var option = document.getElementById("option");
            var process = document.getElementById("process");

            try {
                xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e)
            {
            }
            if (option.value == "ondemand")
            {
                if (process.value == "db")
                {
                    xmlhttp.open("GET", "schedule.php");
                }
                else
                {
                    xmlhttp.open("GET", "scheduleUpload.php");
                }
            }
            else
            {
                if (process.value == "db")
                {
                    xmlhttp.open("GET", "manual.php");
                }
            }
            xmlhttp.send("null");
            xmlhttp.onreadystatechange = function()
            {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                {
                    $("#loading").css("display", "none");
                    alert(xmlhttp.responseText);
                    window.location.href = "http://sfa.fmclgrp.com/RetailKd/Host/functions/config.php";
                }
            }
        }
        else {
              $("#loading").css("display", "none");
        }
    }

    function manual()
    {
        var option = document.getElementById("option");
        var manual = document.getElementById("manual");
        var process = document.getElementById("process");
        var str;
        if (process.val == "db")
            str = "Download To Base";
        else
            str = "Upload From Base";
        if (option.value == "ondemand")
        {
            manual.innerHTML = "On-Demand ";
            manual.style.display = 'block';
            $("#frequency").prop("disabled", true);
            $("#sd").prop("disabled", true);
            $("#st").prop("disabled", true);
            $("#frequency").val("");
        }
        else if (option.value == "manual")
        {
            if (process.value == "db")
            {
                manual.innerHTML = "Click for Manual update";
                manual.style.display = 'block';
                $("#frequency").prop("disabled", true);
                $("#frequency").val("");
                $("#sd").prop("disabled", true);
                $("#st").prop("disabled", true);
            }
            else {
                manual.style.display = 'none';
                $("#frequency").prop("disabled", true);
                $("#sd").prop("disabled", true);
                $("#st").prop("disabled", true);
                $("#frequency").val("");
            }
        }
        else
        {
            manual.style.display = "none";
            $("#frequency").prop("disabled", false);
            $("#frequency").val("Hourly");
            $("#sd").prop("disabled", false);
            $("#st").prop("disabled", false);
        }
    }

    function load()
    {
        var process = document.getElementById("process");
        var option = document.getElementById("option");
        var frequency = document.getElementById("frequency");
        var sd = document.getElementById("sd");
        var st = document.getElementById("st");

        var posting = $.post("save.php", {process: process.value, option: option.value, frequency: frequency.value, sd: sd.value, st: st.value});

        posting.done(function(data) {
            alert(data);
            window.location.href = "http://sfa.fmclgrp.com/RetailKd/Host/functions/config.php";
        });

    }


</script>
<style>
    .test
{
   
    position: absolute;
    left: 50%;
    top: 50%;
    background-color: white;
    z-index: 100;

    
    margin-top: -50px;

   
    margin-left: -120px;
}
    
</style>
<div id ="loading" class ="test" style="display:none">
    <img src ="img/load.gif" style="width:100px;" />
    <span>Please wait Loading . . </span>
</div>
<div id="mainarea2">
    <div class="dtable">
        <div class="mcf"></div>
        <div align="center" class="headingskdp">Download Upload Configuration</div>
        <div id="mytabledow">
            <?php
            $query = "select * from parameters";
            $result = mysql_query($query);
            while ($data = mysql_fetch_array($result)) {
                $freq = $data['Transfer_Frequency'];
                $sd = $data ['Start_time'];
                $st = $data ['End_time'];
            }
            ?>
            <div class="dleft">
                <fieldset>
                    <legend> Process </legend>
                    <table width="100%">
                        <tr>
                            <td><span>Process</span></td>
                            <td><select id="process">
                                    <option value="db">Download to Base </option>
                                    <option value="ub">Upload from Base </option>
                                </select></td>
                        </tr>
                        <tr>
                            <td><span>Option</span></td>
                            <td><select id="option" onchange="manual();" style="float:left;width:132px;">
                                    <option value="auto">Auto Schedule </option>
                                    <option value="ondemand">On-Demand </option>
                                    <option value="manual">Manual </option>
                                </select>
                                <div style="width:340px;"><a style="display:none;float:right;" onclick="update()" id="manual" href="#">ON-Demand update</a></div></td>
                        </tr>

                        <tr>
                            <td><span>Frequency</span></td>
                            <td><select  id="frequency" >
                                    <option value="Hourly">Hourly </option>
                                    <option value="2Hours" >2 Hours</option>
                                    <option value="4Hours" >4 Hours</option>
                                    <option value = "" ></option>
                                </select></td>
                        </tr>
                        <tr>
                            <td><span>Start Time </span></td>
                            <td><input  style="text-align:center;" type="text" value="00:00:00" id="sd" ></td>
                        </tr>
                        <tr>
                            <td><span>End Time </span></td>
                            <td><input style="text-align:center;"  type="text" value="00:00:00" id="st" ></td>
                        </tr>
                    </table>
                </fieldset>
            </div>   

            <div class="dright">
                <fieldset>
                    <legend>Status</legend>
                    <table>
                        <tr>
                            <td><span>Last Process</span></td>
                            <td><input style="text-align:center;" type="text" value="<?php echo $lastProcess; ?>" disabled></td>
                            <td><input  style="text-align:center;" type="text" value="<?php echo $lastTime; ?>" disabled></td>
                        </tr>
                        <tr>
                            <td><span>Current Process</span></td>
                            <td><input style="text-align:center;"  type="text" value="-" disabled></td>
                            <td><input style="text-align:center;" type="text" value="-" disabled></td>
                        </tr>
                        <tr>
                            <td><span>Next Shedule On </span></td>
                            <td><input style="text-align:center;" type="text" value="<?php echo $nextShedule; ?>" disabled></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>

                    </table>

                </fieldset>
                <div style="clear:both;"></div>
                <table>
                    <tr align="center">
                        <td>
                            <input type="button" class = "buttons" value="Save" onclick="load()" />
                        </td>
                    </tr>
                </table>
            </div>

            <div class="logfile">
                <fieldset>
                    <legend>KD Process Log</legend>

                    <span>KD List : </span>
                    <select id="lkd" onchange="logProgress()">
                        <?php
                        $query = "SELECT * FROM kd";
                        $result = mysql_query($query);
                        while ($data = mysql_fetch_array($result)) {
                            echo '<option value="' . $data['KD_Code'] . '">' . $data['KD_Code'] . '</option>';
                        }
                        ?>
                    </select>
                    <span style='margin-left:40px;'> Process : </span>
                    <select id="lprocess" onchange="logProgress()">
                        <option value="Download to Base">Download to Base</option>
                        <option value="Upload from Base">Upload from Base</option>
                    </select>
                    <div class="mcf"></div>
                    <div id="log"> </div>
                </fieldset>
                <script type="text/javascript">
         logProgress();
         function logProgress()
         {
             var process = $("#lprocess").val();

             var kd = $("#lkd").val();

             var posting = $.post("log.php", {process: process, kd:kd});

             posting.done(function(data) {
                 $("#log").html(data);
             });
         }

                </script>
            </div>

        </div>



    </div>

</div> 

<?php include('../include/footer.php'); ?>
