<?php
include "../include/config.php";
$process = $_POST['process'];
$kd = $_POST['kd'];

if ($process == "Download to Base") {
    $string = "DESTINATION='" . $kd . "'";
} else {
    $string = "SOURCE='" . $kd . "'";
}

 // DB Connection

$query = "select * from data_transfer_transaction_hdr where " . $string;
$result = mysql_query( $query);
?>
<style>
td {
	padding: 3px;
}
</style>
<div class="conscroll">
<table width="100%">
  <thead>
    <tr>
      <th>Process Id</th>
      <th>Table Name</th>
      <th>Start Time</th>
      <th>End Time</th>
      <th>Status</th>
    </tr>
  </thead>
  <?php
    while ($data = mysql_fetch_array($result)) {
        $processId = $data['PROCESS_ID'];
        $query = "select * from data_transfer_transaction where TRANSFER_HDR_ID ='" . $data['TRANSFER_HDR_ID'] . "'";
        $result_list = mysql_query( $query);
        while ( $data_list = mysql_fetch_array($result_list)) {
            echo "<tr>";
            echo "<td>" . $processId . "</td> <td>" . $data_list['TABLE_NAME'] . "</td> <td>" . $data_list['CREATION_DATE'] . "</td> <td>" . $data_list['CREATION_DATE'] . "</td> <td>" . $data_list['STATUS'] . "</td>";
            echo "</tr>";
        }
    }
    ?>
</table>
</div>
