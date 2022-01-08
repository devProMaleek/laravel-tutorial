<?php
// Include config file
require_once("dbconnection.php");
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $usertype = $contactNo = $email = $deladdress = $city = "";
$username_err = $password_err = $confirm_password_err = $contactNo_err = $email_err = $deladdress_err = $city_err = "";

// Specify the Usertype to be user
$usertype="user";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
   
 
    // Validate username
   
    if(empty(trim($_POST["username"]))){
       
        $username_err = "Please enter a username.";
    }else{
        // Create a prepared statement
        $username = trim($_POST["username"]);

        //Initializing the statement
        $stmt = mysqli_stmt_init($con);

        //Select Statement
        $sql = "SELECT id FROM users_tbl WHERE UserName = ?";
            
        if(mysqli_stmt_prepare($stmt, $sql)){
            
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);
           
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                
                /* store result */
                $stm = mysqli_stmt_store_result($stmt);
               
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                }else{
                    $username = trim($_POST["username"]);
                }
                
            }else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 8){
        $password_err = "Password must have atleast 8 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["cpassword"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["cpassword"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate Phone Contact
    if(empty($_POST['phoneNo'])){
        $contactNo_err = "Please enter your phone contact.";
    }else{
        $contactNo = trim($_POST['phoneNo']);
    }

    // Validate Delivery address
    if(empty($_POST['DelAdd'])){
        $deladdress_err = "Please enter your Delivery address";
    }else{
        $deladdress = trim($_POST['DelAdd']);
    }

     // Validate city 
     if(empty($_POST['city'])){
        $city_err = "Please enter your city";
    }else{
        $city = trim($_POST['city']);
    }
   
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } else{
        // Create a prepared statement
        $email = trim($_POST["email"]);

        //Initializing the statement
        $stmt = mysqli_stmt_init($con);

        //Select Statement
        $sql = "SELECT id FROM users_tbl WHERE Email = ?";
            
        if(mysqli_stmt_prepare($stmt, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
            }
                
            if(mysqli_stmt_num_rows($stmt) == 1){
                $email_err = "This email has already been used.";
            
            }else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Check input errors before inserting in database.
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($contactNo_err) && empty($email_err) && empty($deladdress_err) && empty($city_err) ){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users_tbl (`UserName`,`Password`,`UserType`,`ContactNo`,`Email`,`DelAddress`,`City`) VALUES (?, ?, ?, ?, ?, ?, ?)";
  
        if($stmt = mysqli_prepare($con, $sql)){
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_usertype = $usertype;
            $param_contactNo = $contactNo;
            $param_email = $email;
            $param_deladdress = $deladdress;
            $param_city = $city;
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_username, $param_password, $param_usertype, $param_contactNo, $param_email, $param_deladdress, $param_city);
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
               
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
                

            // Close statement
            mysqli_stmt_close($stmt);
            echo "Hey";
                return;
            }
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
      <div class="row" style="height: 5%;  padding:40px;">
            <div class="col-12"></div>
      </div>
    <div class="row" style="height: 5%; color:#ffffff;">
        <div class="col-8"><h3>Cheth Online Food Order</h3></div>
        <div class="col-2"><a href="HomePage.php">Log In to Order</a></div>
        <div class="col-2"><a href="NewUser.php">Register as New User</a></div>
    </div>
    <div class="row" style="height: 10%; ">
        <div class="col-12"></div>
    </div>
    <span class="align-middle" >
        <div class="row">
            <div class="col"></div>
            <div class="colcol-lg-2">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="exampleInputName">User Name</label>
                        <input type="string" class="form-control" id="username" name="username" aria-describedby="emailHelp" placeholder="Enter Your Name">
                        <small id="emailHelp" class="form-text text-muted">Enter a User Name that your will remember.</small>
                        <span class="help-block"><?php echo $username_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
                        <small id="passwordHelp" class="form-text text-muted">Keep it cryptic as possible.</small>
                        <span><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Confirm Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Confirm Password" name="cpassword">
                        <span class="help-block"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPhone">Contact Number</label>
                        <input type="String" class="form-control" id="PhoneNo" placeholder=" Contact Number" name="phoneNo">
                        <span class="help-block"><?php echo $contactNo_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputemail">EmailID</label>
                        <input type="String" class="form-control" id="Email" placeholder=" Email ID" name="email">
                        <span class="help-block"><?php echo $email_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPhone">Delivery Address</label>
                        <input type="String" class="form-control" id="DelAdd" placeholder=" Delivery Adderess" name="DelAdd">
                        <span class="help-block"><?php echo $deladdress_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputemail">City</label>
                        <input type="String" class="form-control" id="city" placeholder=" City" name="city">
                        <span class="help-block"><?php echo $city_err; ?></span>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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