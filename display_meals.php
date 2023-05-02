<?php
// Create connection to Oracle
putenv("ORACLE_HOME=/u01/app/oracle/product/11.2.0/xe/");
$conn = oci_connect("timmy", "timmy", "xe")
    or die("<br>Couldn't connect");

$query = "select *
    from user_mp u, meal_plan mp, meal_mp mmp, meal m
    where u.username = '$user' 
    and u.mp_id = mp.mp_id
    and mp.mp_id = mmp.mp_id
    and mmp.meal_id = m.meal_id
    ORDER BY CASE m.type
                     WHEN 'Breakfast' THEN 1
                     WHEN 'Lunch' THEN 2
                     WHEN 'Dinner' THEN 3
                   END";

$stid = oci_parse($conn, $query);
oci_execute($stid);

while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
    $meals[$row['TYPE']][] = $row;
}

oci_free_statement($stid);
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meal Plan</title>
    <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }

    .meal-section {
        padding: 1rem;
        background-color: #f3f3f3;
        margin-bottom: 2rem;
    }

    .meal-section h2 {
        margin-top: 0;
    }

    .meal {
        padding: 1rem;
        background-color: #ffffff;
        margin-bottom: 1rem;
    }

    .meal h3 {
        margin-top: 0;
    }

    .meal .description {
        display: none;
    }

    .toggle-button {
        appearance: button;
        backface-visibility: hidden;
        background-color: #636363;
        border-radius: 6px;
        border-width: 0;
        color: #fff;
        cursor: pointer;
        display: inline-block;
        font-family: -apple-system, system-ui, "Segoe UI", Roboto, "Helvetica Neue", Ubuntu, sans-serif;
        font-size: 100%;
        height: 25px;
        line-height: 1.15;
        outline: none;
        overflow: hidden;
        position: relative;
        text-align: center;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        width: 25px;
    }
    </style>
</head>

<body>
    <?php foreach ($meals as $mealType => $mealData): ?>
    <div class="meal-section">
        <h2>
            <?php echo $mealType; ?>
        </h2>
        <?php foreach ($mealData as $meal): ?>
        <div class="meal">
            <h3>
                <?php echo $meal['NAME']; ?>
            </h3>
            <p>
                <?php echo $meal['CALORIES']; ?> calories -
                <?php echo $meal['PROTEIN']; ?> g of protein
            </p>
            <button class="toggle-button">+</button>
            <p class="description">
                <?php echo $meal['DESCRIPTION']; ?>
            </p>
        </div>
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            var toggleButtons = document.querySelectorAll(".toggle-button");
            for (var i = 0; i < toggleButtons.length; i++) {
                toggleButtons[i].addEventListener("click", function() {
                    var description = this.parentNode.querySelector(".description");
                    if (description.style.display === "none") {
                        description.style.display = "block";
                        this.textContent = "-";
                    } else {
                        description.style.display = "none";
                        this.textContent = "+";
                    }
                });

                // Initialize button text and hide descriptions
                var description = toggleButtons[i].parentNode.querySelector(".description");
                description.style.display = "none";
                toggleButtons[i].textContent = "+";
            }
        });
        </script>




        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
</body>

</html>