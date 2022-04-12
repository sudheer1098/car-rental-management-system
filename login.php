<?php
include ("components/connection.php");
session_start();
if (isset($_SESSION['sess_email']) && $_SESSION['sess_category'] == 'customers') {
    header('location: customers/dashboard_customer.php');
} else if (isset($_SESSION['sess_email']) && $_SESSION['sess_category'] == 'agency') {
    header('location: agency/dashboard_agency.php');
}
?>

<?php
$msg = "";
if (isset($_POST['login'])) {

    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $category = trim($_POST['category']);

    //now selecting table name based on the selection of user
    ($category == 'agency') ? ($table_name = 'agency') : ($table_name = 'customers');

    if ($email != "" && $password != "") {
        try {

            $sql = "SELECT * from `" . $table_name . "` WHERE email = :email";
            $query = $con->prepare($sql);
            $query->bindParam('email', $email, PDO::PARAM_STR);
            $query->execute();
            $count = $query->rowCount();
            $row = $query->fetch(PDO::FETCH_ASSOC);


            if ($count == 1 && !empty($row)) { // checks if the user actually exists(true/false returned)
                if (password_verify($_POST['password'], $row['password'])) {
                    session_start();
                    $_SESSION['sess_category'] = $category;
                    $_SESSION['sess_email'] = $row['email'];
                    $_SESSION['sess_name'] = $row['name'];
                    $msg = "Successfully Login";
                    // for agency login transfer control to agency dashboard
                    if ($_SESSION['sess_category'] == 'agency') {
                        $_SESSION['sess_id'] = $row['agency_id'];
                        header('Location: agency/dashboard_agency.php');
                    }
                    
                    //else transfer control to customer dashboard
                    else {
                        $_SESSION['sess_id'] = $row['customer_id'];
                        header('Location: customers/dashboard_customer.php');
                    }
                    exit();
                } else {
                    $msg = "Incorrect password!";
                }
            } else {
                $msg = "Incorrect credentials.";
            }
        }
        catch(PDOException $e) {
            echo "Error : " . $e->getMessage();
        }
    } else {
        $msg = "Both fields are required!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
  <?php include 'components/head.html' ?>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="css/signup.css">
  <script src="js/signup_validation.js"></script>
</head>

<body>

  <?php include 'components/header.php'; ?>



  <div class="container">

    <div class="signup-form">
      <h1>Log In</h1>
      </p>
      <form action="login.php" method="post" id="fileForm" role="form">

        <div class="form-group">
          <label for="email"><span class="req"></span> Email Address: </label>
          <input class="form-control" required type="text" name="email" id="email"
            placeholder="sample@sample.com" onchange="email_validate(this.value);" />
          <div class="status" id="status"></div>
        </div>

        <div class="form-group">
          <label for="password"><span class="req"></span> Password: </label>
          <input required name="password" type="password" class="form-control inputpass" minlength="4" maxlength="16"
            id="password" /> </p>
        </div>
        <div class="form-group">
            <label for="category"> Type: </label>
                <select name="category" class="form-select" id="category">
                    <option value="agency">Agency</option>
                    <option selected value="customers">Customer</option>
                </select>
        </div>

        <div class="form-group">
          <hr>
          <input class="btn btn-success" type="submit" name="login" value="Login">
          
          <br><span class="loginMsg"><?php echo @$msg; ?></span>
        </div>

      </form>
      <hr>
    </div>
  </div>

<?php include 'components/footer.html'; ?>

</body>
</html>