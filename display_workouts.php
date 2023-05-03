<?php
// Create connection to Oracle
putenv("ORACLE_HOME=/u01/app/oracle/product/11.2.0/xe/");
$conn = oci_connect("timmy", "timmy", "xe")
    or die("<br>Couldn't connect");


$day = date('l');

$query = "
    SELECT w.workout_id, w.name, w.location_id, w.description, wwp.w_day, l.name as location_name
    FROM workout w, workout_plan wp, w_wpnew wwp, user_wp u, location l
    WHERE w.workout_id = wwp.workout_id
    AND wp.wp_id = wwp.wp_id
    AND u.wp_id = wp.wp_id
    AND l.location_id = w.location_id
    AND u.username = '$user'
    AND wwp.w_day = '$day'
";
$stid = oci_parse($conn, $query);
oci_execute($stid);

while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
    $workouts[] = $row;
}

oci_free_statement($stid);
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Plan</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 1rem;
    }

    h1 {
        font-size: 24px;
        margin-bottom: 0.5rem;
    }

    .workout {
        background-color: #f3f3f3;
        border-radius: 5px;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .workout h2 {
        margin-top: 0;
    }

    .workout-location {
        font-style: italic;
        font-size: 22px;
    }

    .workout-description {
        margin-top: 0.5rem;
        font-size: 16px;
        line-height: 1.5;
    }
    </style>
</head>

<body>
    <?php foreach ($workouts as $workout): ?>
    <div class="workout">
        <h2>
            <?php echo $day; ?> -
            <?php echo $workout['NAME']; ?>
        </h2>
        <div class="workout-location">Location:
            <?php echo $workout['LOCATION_NAME']; ?>
        </div>
        <p class="workout-description">
            <?php
                $i = 1;
                $each_lift = explode(',', $workout['DESCRIPTION']); foreach ($each_lift as $lift) {
                    echo "$i. ";
                    echo $lift;
                    echo "<br>";
                    $i = $i + 1;
                }
                ?>
        </p>
    </div>
    <?php endforeach; ?>

</body>

</html>