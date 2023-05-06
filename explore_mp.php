<?php
// Create connection to Oracle
putenv("ORACLE_HOME=/u01/app/oracle/product/11.2.0/xe/");
$conn = oci_connect("timmy", "timmy", "xe")
    or die("<br>Couldn't connect");

$query = "
    SELECT mp_id, name
    FROM meal_plan
";

$stid = oci_parse($conn, $query);
oci_execute($stid);


while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
    $mealPlans[] = $row;
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
        <?php include('login.php'); ?>
        <h1>Meal Plans</h1>
        <div class="row">
            <?php foreach ($mealPlans as $mealPlan): ?>
            <div class="col-md-4 workout-plan-card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php

                                echo $mealPlan['NAME']; ?>
                        </h5>
                        <p class="card-text">
                            <?php
                                putenv("ORACLE_HOME=/u01/app/oracle/product/11.2.0/xe/");
                                $conn = oci_connect("timmy", "timmy", "xe")
                                    or die("<br>Couldn't connect");
                                $mp_id = $mealPlan['MP_ID'];
                                $query = "
                                select *
                                from meal_plan mp, meal_mp mmp, meal m
                                where mp.mp_id = mmp.mp_id
                                and mmp.meal_id = m.meal_id
                                and mp.mp_id = $mp_id
                                ORDER BY CASE m.type
                                                 WHEN 'Breakfast' THEN 1
                                                 WHEN 'Lunch' THEN 2
                                                 WHEN 'Dinner' THEN 3
                                               END
                            ";
                                $stid = oci_parse($conn, $query);
                                oci_execute($stid);
                                $prevType = null;
                                while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                                    $type = $row['TYPE'];

                                    if ($prevType !== $type) {
                                        $meal[$type] = array(); // Reset the $meal array when the 'TYPE' changes
                                        $prevType = $type;
                                    }

                                    $meal[$type][] = $row;
                                }
                                foreach ($meal as $mealType => $mealData): ?>
                        <h5>
                            <?php echo $mealType; ?>
                        </h5>
                        <?php foreach ($mealData as $m): ?>
                        <p>
                            <?php echo $m['NAME']; ?>
                        </p>


                        <?php endforeach; ?>
                        <?php endforeach; ?>

                        </p>
                        <a href="home_page.php">
                            <button type="button" class="btn btn-warning"
                                onclick="updateMealPlan(<?php echo $mealPlan['MP_ID']; ?>)">Use Meal Plan</button> </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <script>
            function updateMealPlan(mp_id) {
                // Create an AJAX request
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "update_mp.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Handle the server response here (e.g., display a success message)
                        console.log(xhr.responseText);
                    }
                };

                // Send the AJAX request with the mp_id parameter
                xhr.send("mp_id=" + mp_id);
            }
            </script>
        </div>
    </div>


</body>

</html>