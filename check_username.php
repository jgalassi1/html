<?php
function is_username_unique($username)
{
    putenv("ORACLE_HOME=/u01/app/oracle/product/11.2.0/xe/");
    $conn = oci_connect("timmy", "timmy", "xe")
        or die("<br>Couldn't connect");

    $sql = "SELECT COUNT(*) AS count FROM users WHERE username = :username";
    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid, ':username', $username);
    oci_execute($stid);
    $row = oci_fetch_array($stid, OCI_ASSOC);
    oci_close($conn);

    return ($row['COUNT'] == 0);
}
?>