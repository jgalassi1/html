<?php

// Create connection to Oracle
putenv("ORACLE_HOME=/u01/app/oracle/product/11.2.0/xe/");

$conn = oci_connect("timmy", "timmy", "xe")
    or die("<br>Couldn't connect");

// Select all posts from the database
$query = "SELECT * FROM posts";
$stmt = oci_parse($conn, $query);
$success = oci_execute($stmt);

// Fetch all rows into an array
$posts = array();
while ($row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
    $posts[] = $row;
}

// Reverse the array
$posts = array_reverse($posts);

// Output the reversed array
foreach ($posts as $post) {
    ?>
<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">
            <b>
                <?php echo $post['OWNER']; ?>
            </b>
        </h5>
        <p class="card-text">
            <?php echo $post['CONTENT']; ?>
        </p>
    </div>
</div>
<?php
}

// Close the database connection
oci_close($conn);
?>