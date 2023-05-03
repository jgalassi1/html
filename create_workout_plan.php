<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
function getDayOfWeek($days, $dayIndex)
{
    $dayMap = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    $dayOffsets = array();
    $dayOffsets[3] = array(0, 3, 5);
    $dayOffsets[4] = array(0, 2, 4, 6);
    $dayOffsets[5] = array(0, 1, 2, 4, 5);
    $dayOffsets[6] = array(0, 1, 2, 4, 5, 6);
    $dayOffsets[7] = array(0, 1, 2, 3, 4, 5, 6);
    $offsets = $dayOffsets[$days];
    return $dayMap[$offsets[$dayIndex]];
    ;
}

$username = 'jgalassi';
$days = 5;

putenv("ORACLE_HOME=/u01/app/oracle/product/11.2.0/xe/");
$conn = oci_connect("timmy", "timmy", "xe")
    or die("<br>Couldn't connect");

// Get the current workout plan counter
$sql = "SELECT counter FROM workout_plan_counter";
$stid = oci_parse($conn, $sql);
oci_execute($stid);
$row = oci_fetch_array($stid, OCI_ASSOC);
$counter = $row["COUNTER"];

// create new workout_plan
$sql = "INSERT INTO workout_plan VALUES ($counter, '$username', '$days days', '$days')";
$stid = oci_parse($conn, $sql);
oci_execute($stid);

$query = "SELECT t.workout_id FROM TABLE(workout_plan_pkg.get_workout_plan($days)) t";
$stid = oci_parse($conn, $query);
oci_execute($stid);
$i = 0;
$sqlQueries = array();
while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
    $w_id = $row['WORKOUT_ID'];
    $day = getDayOfWeek($days, $i);
    $sql = "INSERT INTO w_wpNEW VALUES ($w_id,$counter,'$day')";
    $sqlQueries[] = $sql;
    $i = $i + 1;
}
foreach ($sqlQueries as $sql) {
    $stid = oci_parse($conn, $sql);
    oci_execute($stid);
}
$new_counter = $counter + 1;
$sql = "UPDATE workout_plan_counter SET counter='$new_counter'";
$stid = oci_parse($conn, $sql);
$res = oci_execute($stid);

// assign meal plan to user
$sql = "INSERT into user_wp values ('$username', $counter)";
$stid = oci_parse($conn, $sql);
$res = oci_execute($stid);

oci_commit($conn);
oci_close($conn);
?>