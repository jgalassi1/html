<?php
session_start();
$user = $_SESSION['user'];
if (isset($_POST['wp_id'])) {
    putenv("ORACLE_HOME=/u01/app/oracle/product/11.2.0/xe/");
    $conn = oci_connect("timmy", "timmy", "xe") or die("<br>Couldn't connect");

    $id = intval($_POST['wp_id']);
    $query = "UPDATE user_wp SET wp_id = $id WHERE username = '$user'";
    $stid = oci_parse($conn, $query);
    oci_execute($stid);
    oci_commit($conn);
    oci_close($conn);

    echo "Workout plan updated successfully.";
}
?>