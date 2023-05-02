<!DOCTYPE html>

<html lang="en">
<!--once we figure out blocks on flask or php we use "extends header.html" here-->

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <meta charset="utf-8">
    <title>
        Iron Manor
    </title>
    <div class="navbar">
        <button type="button" class="btn-logo">
            <img src="Screen Shot 2023-04-27 at 2.04.07 AM.png" alt="homejpg" width=45px; height=40px; />
        </button>
        <button type="button" class="btn btn-warning">
            Feed
        </button>
        <button type="button" class="btn btn-warning">
            Explore Meal Plans
        </button>
        <button type="button" class="btn btn-warning">
            Explore Workout Plans
        </button>
        <button type="button" class="btn btn-outline-warning">
            Login
        </button>
        <!---Here We Could also do -->
    </div>
</head>
<hr>
<hr>
<hr>
<!--extends or somethings similar-->

<body>
    <?php include("login.php"); ?>
    <img src="Screen Shot 2023-04-27 at 2.05.37 AM.png" alt="welcomejpg" class="welcome" />
    <hr>
    <h1>
        Welcome to the House of Gainz
    </h1>
    <div class="columns-container">
        <div class="left-column">
            <h2>Feed</h2> <br>
            <?php include('feed.php'); ?>
        </div>
        <div class="center-column">
            <h2>Lifts</h2> <br>
        </div>
        <div class="right-column">
            <h2>Fuel</h2>
            <?php include('display_meals.php'); ?>
        </div>
    </div>


</body>

</html>