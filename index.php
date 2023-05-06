<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <meta charset="utf-8">
    <title>Iron Manor</title>
    <style>
    body {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 100vh;
    }

    .login-container {
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 10px;
        padding: 30px;
        max-width: 400px;
        margin: 100px auto 0;
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
    <div class="login-container">
        <h1>Iron Manor</h1>
        <h3>Greatness Awaits</h3>
        <form action="index.php" method="post">
            <div class="form-floating mb-3">
                <input class="form-control" id="floatingInput" name="floatingInput" placeholder="Username" required>
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" name="floatingPassword"
                    placeholder="Password" required>
                <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn-lg btn-outline-warning my-3" type="submit">Sign in</button>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['floatingInput'];
            $password = $_POST['floatingPassword'];

            putenv("ORACLE_HOME=/u01/app/oracle/product/11.2.0/xe/");

            $conn = oci_connect("timmy", "timmy", "xe")
                or die("<br>Couldn't connect");

            // Check if the username and password match any entry in the database
            $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
            $stmt = oci_parse($conn, $sql);
            oci_execute($stmt);

            if ($row = oci_fetch_assoc($stmt)) {
                // Start a session and pass the username into a variable called `user`
                session_start();
                $_SESSION['user'] = $username;

                // Redirect to the home_page.php
                header("Location: home_page.php");
                exit;
            } else {
                // Display an error message
                echo "<p class='text-danger text-center'>Invalid username or password.</p>";
            }

            oci_free_statement($stmt);
            oci_close($conn);
        }
        ?>
        <a href="signup.php" class="w-100 btn-lg btn-warning">Create Account</a>
    </div>
</body>

</html>