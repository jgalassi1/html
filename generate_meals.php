<?php

$height = 69;
$weight = 170;
$type = 0;
// Get the list of meal IDs from the Python function

$python_script = 'meal_alg.py';
$cmd = "python3 meal_alg.py";

$data = shell_exec("python meal_alg.py $weight $height $type");

$parsed = explode(';', $data);

// parse data
$meal_ids = explode(',', $parsed[0]);
$calories = $parsed[1];
$protein = $parsed[2];

// Create connection to Oracle
putenv("ORACLE_HOME=/u01/app/oracle/product/11.2.0/xe/");

$conn = oci_connect("timmy", "timmy", "xe")
    or die("<br>Couldn't connect");

$name = "";

switch ($type) {
    case 0:
        $name = "Lose Weight";
        break;
    case 1:
        $name = "Maintain Weight";
        break;
    case 2:
        $name = "Gain Weight";
        break;
    default:
        $name = "Invalid type";
        break;
}
// Get the current meal plan counter
$sql = "SELECT counter FROM meal_plan_counter";
$stid = oci_parse($conn, $sql);
oci_execute($stid);
$row = oci_fetch_array($stid, OCI_ASSOC);
$counter = $row["COUNTER"];

// create new meal_plan
$sql = "INSERT INTO meal_plan VALUES ($counter, '$name', 'jgalassi', '$name', $calories, $protein)";
$stid = oci_parse($conn, $sql);
oci_execute($stid);

// Insert rows into meal_mp
foreach ($meal_ids as $meal_id) {
    $sql = "INSERT INTO meal_mp VALUES ($meal_id, $counter, 1)";
    $stid = oci_parse($conn, $sql);
    $res = oci_execute($stid);
    if ($res) {
        echo "New record created successfully<br>";
    } else {
        $e = oci_error($stid);
        echo "Error: " . htmlentities($e['message'], ENT_QUOTES);
    }
}

// assign meal plan to user
$sql = "INSERT into user_mp values ('$user', $counter)";
$stid = oci_parse($conn, $sql);
$res = oci_execute($stid);

// Update the meal plan counter
$new_counter = $counter + 1;
$sql = "UPDATE meal_plan_counter SET counter='$new_counter'";
$stid = oci_parse($conn, $sql);
$res = oci_execute($stid);
if ($res) {
    echo "Meal plan counter updated successfully<br>";
} else {
    $e = oci_error($stid);
    echo "Error updating meal plan counter: " . htmlentities($e['message'], ENT_QUOTES);
}


oci_commit($conn);
oci_close($conn);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


?>