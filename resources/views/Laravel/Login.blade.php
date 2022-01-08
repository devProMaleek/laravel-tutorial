<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && ($_SESSION["loggedin"] === true)){
    header("location: dashboard.php");
    exit;
}
 
// Include database file
require_once("dbconnection.php");
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter your username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
   
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users_tbl WHERE username = ?";
        
        if($stmt = mysqli_prepare($con, $sql)){
             // Set parameters
             $param_username = $username;

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        $val = password_verify($password, $hashed_password);
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $param_username;  
                            // Redirect user to welcome page
                            header("location: dashboard.php");
                            exit();
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($con);
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        const rmCheck = document.getElementById("rememberMe"),
        usernameInput = document.getElementById("username");

        if (localStorage.checkbox && localStorage.checkbox !== "") {
            rmCheck.setAttribute("checked", "checked");
            usernameInput.value = localStorage.username;
        }else{
            rmCheck.removeAttribute("checked");
            usernameInput.value = "";
        }

        function lsRememberMe() {
            if (rmCheck.checked && usernameInput.value !== "") {
                localStorage.username = usernameInput.value;
                localStorage.checkbox = rmCheck.value;
            }else{
                localStorage.username = "";
                localStorage.checkbox = "";
            }
        }
    </script>
</head>
<style>
    body{
        background-image:url(mealordering.jpg);
        background-size:cover; 
        background-repeat:no-repeat;
    }
  
    .colcol-lg-2{
        background-color:#ffffff; 
        margin-top:50px; 
        padding:40px; 
        border-color:#230237; 
        border-style:solid;
        border-width:thin;
        border-radius:8px;
    }
</style>
<body>
<div class="container">
    <div class="row" style="height: 10%; padding:30px;">
        <div class="col-12"></div>
     
    </div>
    <div class="row" style="height: 10%; color:#ffffff;">
        <div class="col-8"><h3>Cheth Online Meal Order</h3></div>
        <div class="col-2"><a href="HomePage.php">Log In to Order</a></div>
        <div class="col-2"><a href="adminlogin.php">Admin Login</a></div>
    </div>
    <div class="row" style="height: 20%; ">
        <div class="col-12"></div>
     
    </div>
    <span class="align-middle" >
        <div class="row">
            <div class="col"></div>
       
            <div class="colcol-lg-2">
                <form method="POST" action="" >
                    <div class="form-group">
                        <label for="exampleInputName">User Name</label>
                        <input type="string" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter Your Name" name="username">
                        <small id="emailHelp" class="form-text text-muted">Enter a User Name that you will remember.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
                        <small id="passwordHelp" class="form-text text-muted">Keep it cryptic as possible.</small>
                    </div>
                    <input type="checkbox" value="lsRememberMe" id="rememberMe"> <label for="rememberMe">Remember me</label><br>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a class="btn btn-primary" data-toggle="collapse" href="NewUser.php" role="button" aria-expanded="false" aria-controls="collapseExample">New User</a>
                </form>
            </div>
            <div class="col -md-auto"></div>
        </div>
    </span>
    <div class="row" style="height: 20%; ">
        <div class="col-12"></div>
     
    </div>
</div>
</body>
</html>