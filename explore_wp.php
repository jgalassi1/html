<?php
// Create connection to Oracle
putenv("ORACLE_HOME=/u01/app/oracle/product/11.2.0/xe/");
$conn = oci_connect("timmy", "timmy", "xe")
    or die("<br>Couldn't connect");

$query = "
    SELECT wp_id, split_name
    FROM workout_plan
";

$stid = oci_parse($conn, $query);
oci_execute($stid);


while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
    $workoutPlans[] = $row;
}

oci_free_statement($stid);
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Workout Plans</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        crossorigin="anonymous">
    <style>
    .container {
        margin-top: 2rem;
    }

    .workout-plan-card {
        margin-bottom: 1rem;
    }

    .btn {
        margin-left: 1rem;
    }
    </style>
</head>

<body>
    <br>
    <button type="button" class="btn btn-warning" onclick="location.href='home_page.php'">Back to Home</button>
    <div class="container">
        <h1>Workout Plans</h1>
        <div class="row">
            <?php foreach ($workoutPlans as $workoutPlan): ?>
            <div class="col-md-4 workout-plan-card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php

                                echo $workoutPlan['SPLIT_NAME']; ?>
                        </h5>
                        <p class="card-text">
                            <?php
                                putenv("ORACLE_HOME=/u01/app/oracle/product/11.2.0/xe/");
                                $conn = oci_connect("timmy", "timmy", "xe")
                                    or die("<br>Couldn't connect");
                                $wp_id = $workoutPlan['WP_ID'];
                                $query = "
                                select name, w_day
                                from workout w, workout_plan wp, w_wpnew wwp
                                where w.workout_id = wwp.workout_id
                                and wp.wp_id = wwp.wp_id
                                and wp.wp_id = $wp_id
                            ";
                                $stid = oci_parse($conn, $query);
                                oci_execute($stid);


                                while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                                    echo $row['W_DAY'];
                                    echo ": ";
                                    echo $row['NAME'];
                                    echo '<br>';
                                }
                                ?>
                        </p>
                        <a href="home_page.php">
                            <button type="button" class="btn btn-warning"
                                onclick="updateWorkoutPlan(<?php echo $workoutPlan['WP_ID']; ?>)">Use Workout
                                Plan</button> </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <script>
            function updateWorkoutPlan(wp_id) {
                // Create an AJAX request
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "update_wp.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Handle the server response here (e.g., display a success message)
                        console.log(xhr.responseText);
                    }
                };

                // Send the AJAX request with the wp_id parameter
                xhr.send("wp_id=" + wp_id);
            }
            </script>
        </div>
    </div>


</body>

</html>