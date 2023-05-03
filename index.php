<!DOCTYPE html>

<html lang="en">  
  <!--once we figure out blocks on flask or php we use "extends header.html" here-->
  <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <meta charset="utf-8">
    <title>
      Iron Manor
    </title>
  <body>
    <div class="login-container"> 
        <h1>Iron Manor</h1>
        <h3 style="text-align: center;">Greatness Awaits</h3>
        <form>
            <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Username/Email</label>
            </div>
            <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn-lg btn-outline-warning" type="submit">Sign in</button>
            <button class="w-100 btn-lg btn-warning"  type="submit">Create Account</button>
        </form>
    </div>
  </body>