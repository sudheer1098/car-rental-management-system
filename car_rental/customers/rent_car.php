<?php
session_start();
if (
    !isset($_SESSION["sess_email"]) ||
    $_SESSION["sess_category"] != "customers"
) {
    echo "<script>alert('Login as Customer to continue.');</script>";
    echo "<script>window.location.href='../login.php'</script>";
}
?>


<?php
// include database connection file
include "../components/connection.php";

$vehicle_number = $_GET["vehicle_number"];
if (!isset($vehicle_number)) {
    echo "wrong methis";
    header("location: dashboard_customer.php");
}

if (isset($_POST["rent"])) {
    $customer_id = $_SESSION["sess_id"];
    $vehicle_number = $_GET["vehicle_number"];

    $days = $_POST["days"];
    $start_date = $_POST["start_date"];

    // Query for Query for Updation
    $sql =
        "INSERT INTO rent (vehicle_number,customer_id,days,start_date) VALUES(:vehicle_number,:customer_id,:days,:start_date)";
    //Prepare Query for Execution
    $query = $con->prepare($sql);
    // Bind the parameters
    $query->bindParam(":vehicle_number", $vehicle_number, PDO::PARAM_STR);
    $query->bindParam(":customer_id", $customer_id, PDO::PARAM_STR);
    $query->bindParam(":days", $days, PDO::PARAM_STR);
    $query->bindParam(":start_date", $start_date, PDO::PARAM_STR);

    // Query Execution
    $query->execute();
    // Mesage after updation
    echo "<script>alert('Rented Successfully! Payment has to be done at time of delivery.');</script>";
    // Code for redirection
    echo "<script>window.location.href='dashboard_customer.php'</script>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent car</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
     <!-- Optional JavaScript; choose one of the two! -->
     <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script> -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script> -->
    <link rel = "icon" href = "../img/favicon.png" type = "image/x-icon">
    <link rel="stylesheet" type="text/css" href="../css/dashboard.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
</head>
<body>
    
    <!-- Side navigation -->

<!-- The sidebar -->
<div class="sidebar">
  <a href="../index.php">HOMEPAGE</a>
  <a class="active" href="dashboard_customer.php">Dashboard</a>
  <a href="../logout.php">Logout</a>
</div>

<!-- Page content -->
<div class="content">
    <div class="header">
        <h1>Car Rental System</h1>
        <h3 style="color: #1e1f1f;">Project</h3>
    </div><hr>
        <?php
        // Get the project_id
        $vehicle_number = $_GET["vehicle_number"];
        $sql = "SELECT * from cars where vehicle_number=:vehicle_number";
        //Prepare the query:
        $query = $con->prepare($sql);
        //Bind the parameters
        $query->bindParam(":vehicle_number", $vehicle_number, PDO::PARAM_STR);
        //Execute the query:
        $query->execute();
        //Assign the data which you pulled from the database (in the preceding step) to a variable.
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        // For serial number initialization
        $cnt = 1;
        if ($query->rowCount() > 0) {
            //In case that the query returned at least one record, we can echo the records within a foreach loop:
            foreach ($results as $result) { ?>


            <div class="add-form" >
            <div class="container"> 
            
            <h3>Rent <?php echo htmlentities($result->model); ?></h3><hr>
                <form name="update_record" method="post" id="fileForm" role="form">


                    <div class="form-group">   
                        <label for="title"><span class="req"></span> <b>Vehicle number:</b> <?php echo htmlentities(
                            $result->vehicle_number); ?> </label>
                    </div><br>
                    <div class="form-group">   
                        <label for="title"><span class="req"></span> <b>Model:</b> <?php echo htmlentities(
                            $result->model); ?></label>
                    </div><br>

                    <div class="form-group">   
                        <label for="date"><span class="req"></span> <b>Seating capacity:</b> <?php echo htmlentities(
                            $result->seating_capacity); ?> </label>
                    </div><br>
                    <div class="form-group">   
                        <label for="date"><span class="req"></span> <b>Per day Cost:</b> <?php echo htmlentities(
                            $result->rent); ?> </label>
                    </div><br>
                    <br>
                    <div class="form-group">
                        <label for="days"> Days to rent: </label>
                        <select name="days" class="form-select" id="days">
                            <option selected value="1">1</option>
                            <option value="2">2</option>
                            <option value="2">3</option>
                            <option value="2">4</option>
                            <option value="2">5</option>
                            <option value="2">6</option>
                            <option value="2">7</option>
                        </select>
                    </div><br>
                    <div class="form-group">   
                        <label for="title"><span class="req"></span> Start Date: </label>
                        <input class="form-control" value="<?php echo htmlentities(
                            $result->model
                        ); ?>" type="date" name="start_date" id = "start_date" required />
                    </div><br>                   
                                                           
                    <div class="form-group">
                        <hr>
                        <input class="btn btn-success" type="submit" name="rent" value="Rent Now">
                    </div>
                </form>
            <hr>
        </div>
        
    <?php }
        }
        ?>

        </div>
 </div>
<?php include "../components/footer.html"; ?>
</body>
</html>



