<!DOCTYPE html>
<html lang="en">
<?php require_once 'check_username.php'; ?>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <meta charset="utf-8">
    <title>Iron Manor - Sign Up</title>
    <style>
    body {
        background-image: url('/Screen Shot 2023-04-27 at 2.05.37 AM.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 100vh;
    }

    .signup-container {
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 10px;
        padding: 30px;
        max-width: 500px;
        margin: 50px auto 0;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    h1,
    h3 {
        text-align: center;
    }

    .form-floating {
        margin-bottom: 10px;
    }

    .btn {
        margin-bottom: 10px;
    }
    </style>
</head>

<body>
    <div class="signup-container">
        <h1>Iron Manor</h1>
        <h3>Sign Up</h3>
        <form action="signup.php" method="post">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $is_username_unique = is_username_unique($_POST['floatingUsername']);
                if (!$is_username_unique) {
                    echo "<div class='alert alert-danger'>Username already exists. Please choose a different username.</div>";
                } else {
                    include 'generate_meals.php';
                }
            }
            ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="floatingUsername" name="floatingUsername"
                            placeholder="Username">
                        <label for="floatingUsername">Username</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="password" class="form-control" id="floatingPassword" name="floatingPassword"
                            placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="floatingFirstName" name="floatingFirstName"
                            placeholder="First Name">
                        <label for="floatingFirstName">First Name</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="floatingLastName" name="floatingLastName"
                            placeholder="Last Name">
                        <label for="floatingLastName">Last Name</label>
                    </div>
                </div>
            </div>
            <h3>Goals</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="number" class="form-control" id="floatingHeight" name="floatingHeight"
                            placeholder="Height (in)" min="0">
                        <label for="floatingHeight">Height (in)</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="number" class="form-control" id="floatingWeight" name="floatingWeight"
                            placeholder="Weight (lbs)" min="0">
                        <label for="floatingWeight">Weight (lbs)</label>
                    </div>
                </div>
            </div>
            <div class="form-floating">
                <input type="number" class="form-control" id="floatingDays" name="floatingDays"
                    placeholder="Days per Week" min="3" max="7">
                <label for="floatingDays">How many days a week do you want to workout?</label>
            </div>
            <div class="form-floating">
                <select class="form-control" id="floatingGoal" name="floatingGoal" placeholder="Goal">
                    <option value="">Select your goal</option>
                    <option value="2">Gain Weight</option>
                    <option value="1">Maintain Weight</option>
                    <option value="0">Lose Weight</option>
                </select>
                <label for="floatingGoal">What do you want to do?</label>
            </div>
            <button type="submit" class="btn btn-warning">Create Account</button>
        </form>
        <a href="/" class="btn btn-secondary">Already have an account? Log in</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz4fnFO9gybB3S3Vz4yfRz8z/3U//AG6CNVlX9oxWb/7pIqz6lJ7gZOy3D" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>