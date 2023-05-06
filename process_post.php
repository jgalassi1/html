<?php
header("Content-Type: text/plain");

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$user = $_SESSION['user'];

if (isset($_POST['text'])) {
    $postText = $_POST['text'];
    putenv("ORACLE_HOME=/u01/app/oracle/product/11.2.0/xe/");

    $conn = oci_connect("timmy", "timmy", "xe")
        or die("<br>Couldn't connect");

    $query = "insert into posts values ('$user', 2, '$postText')";
    $stmt = oci_parse($conn, $query);

    if (!$stmt) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    $success = oci_execute($stmt);
    if (!$success) {
        $e = oci_error($stmt);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    oci_commit($conn);
    oci_close($conn);

    echo "Post successfully inserted";
} else {
    echo "No text parameter received";
}
?>