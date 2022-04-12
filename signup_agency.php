<?php 
$pagename='SIGN UP'; 
require 'components/connection.php';
session_start();

    $msg1="";
    if(isset($_POST['submit']))
    {  

    // Remove all illegal characters from email
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Validate e-mail
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
      $msg="Invalid email address entered!";
    } 


    else if ($_POST['password'] !== $_POST['confirm_password'])
    {
        $msg='Passwords must match!';   
    }

    else {

    $_SESSION['name'] = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $_SESSION['email'] = $email;
    $_SESSION['password'] = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $_SESSION['contact_number'] = filter_var($_POST['contact_number'], FILTER_SANITIZE_STRING);
    $_SESSION['city'] = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
    $result = 0;
    

    $sql = "SELECT COUNT(*) FROM agency WHERE email = ?"; 
    $stmt = $con->prepare($sql); 
    $stmt->execute([$_SESSION['email']]); 
    $result = $stmt->fetchColumn();

    if($result>0)
    {
       $msg="This email is already registered!!";
    }
    else
    {
        $sql = "INSERT INTO agency (email, name, contact_number, city, password) VALUES (:email, :name,:contact_number,:city,:password)";
        //Prepare Query for Execution
        $query = $con->prepare($sql);
        // Bind the parameters
        $query->bindParam(':email',$_SESSION['email'],PDO::PARAM_STR);
        $query->bindParam(':name',$_SESSION['name'],PDO::PARAM_STR);
        $query->bindParam(':contact_number',$_SESSION['contact_number'],PDO::PARAM_STR);
        $query->bindParam(':city',$_SESSION['city'],PDO::PARAM_STR);
        $query->bindParam(':password',$_SESSION['password'],PDO::PARAM_STR);
        // Query Execution
        $query->execute();
        // Mesage after updation
        echo "<script>alert('Registered successfully, login to continue');</script>";
        // Code for redirection
        echo "<script>window.location.href='login.php'</script>";        
                
        
        }

    }
$con = null;
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include 'components/head.html' ?>
    <title>SignUp</title>
    <link rel="stylesheet" type="text/css" href="css/signup.css">
    <script src="js/signup_validation.js"></script>
</head>

<body>
    <div><?php include 'components/header.php' ?></div>

    <div class="container">

        <div class="signup-form">
            <h1>Agency Signup</h1>
            <h4>Already have an account? <span><a href="login.php">Login </a></span></h4>

            <strong><span class="loginMsg"><?php echo @$msg;?></span></strong>
            <hr>
            <form action="#" method="post" id="fileForm" role="form">

                <div class="form-group">
                    <label for="name"><span class="req"></span> Name: </label>
                    <input class="form-control" type="text" name="name" id="name" required placeholder="Your full name" />
                </div>

                <div class="form-group">
                    <label for="email"><span class="req"></span> Email Address: </label>
                    <input class="form-control" required type="text" name="email" id="email"
                        placeholder="Email ID" />
                    <div class="status" id="status"></div>
                </div>     
                <div class="form-group">
                    <label for="contact_number"><span class="req"></span> Contact Number: </label>
                    <input class="form-control" required type="text" name="contact_number" id="contact_number"
                        placeholder="+91-1234567890" />
                </div>   
                <div class="form-group">
                    <label for="city"><span class="req"></span> City: </label>
                    <input class="form-control" required type="text" name="city" id="city"
                        placeholder="e.g. Delhi" />
                </div>  
               

                <div class="form-group">
                    <label for="password"><span class="req"></span> Password: </label>
                    <input required name="password" type="password" class="form-control inputpass" minlength="4"
                        maxlength="16" id="pass1" placeholder="Must be between 4-16 characters" /> </p>

                    <label for="confirm_password"><span class="req"></span> Confirm Password: </label>
                    <input required name="confirm_password" type="password" class="form-control inputpass" minlength="4"
                        maxlength="16" placeholder="Re-enter to validate" id="pass2"
                        onkeyup="checkPass(); return false;" />
                    <span id="confirmMessage" class="confirmMessage"></span> </p>
                </div>

                <div class="form-group">
                    <hr>
                    <input class="btn btn-success" type="submit" name="submit" id="submit">
                </div>
            </form>
        </div>
    </div>


    <?php include 'components/footer.html'  ?>
</body>

</html>