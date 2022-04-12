<?php
session_start();
if (!isset($_SESSION["sess_email"]) || $_SESSION["sess_category"] != "agency") {
    header("location: ../login.php");
}
?>


<?php
// include database connection file
include "../components/connection.php";
if (isset($_POST["update"])) {
    //update form is below on same file
    $agency_id = $_SESSION["sess_id"];
    $vehicle_number = filter_var($_POST["vehicle_number"], FILTER_SANITIZE_STRING);
    $model = filter_var($_POST["model"], FILTER_SANITIZE_STRING);
    $seating_capacity = filter_var($_POST["seating_capacity"], FILTER_SANITIZE_STRING);
    $rent = filter_var($_POST["rent"], FILTER_SANITIZE_STRING);
    // Query for Query for Updation
    $sql = "UPDATE cars SET model=:model,seating_capacity=:seating_capacity,rent=:rent WHERE vehicle_number=:vehicle_number";
    //Prepare Query for Execution
    $query = $con->prepare($sql);
    // Bind the parameters
    $query->bindParam(":model", $model, PDO::PARAM_STR);
    $query->bindParam(":vehicle_number", $vehicle_number, PDO::PARAM_STR);
    $query->bindParam(":seating_capacity", $seating_capacity, PDO::PARAM_STR);
    $query->bindParam(":rent", $rent, PDO::PARAM_STR);
    // Query Execution
    $query->execute();
    // Mesage after updation
    echo "<script>alert('Record successfully updated!');</script>";
    // Code for redirection
    echo "<script>window.location.href='dashboard_agency.php'</script>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update CAr details</title>
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
  <a class="active" href="dashboard_agency.php">HOME</a>
  <a href="add_car.php">Add Car</a>
  <a href="booked_cars.php">Booked Cars</a>
  <a href="../logout.php">Logout</a>
</div>

<!-- Page content -->
<div class="content">
    <div class="header">
        <h1>Car Rental System</h1>
        <h3 style="color: #1e1f1f;">Project</h3>
    </div><hr>
        <?php
            
            $vehicle_number = $_GET["vehicle_number"];  // Get the vehicle_id
            $sql = "SELECT * from cars where vehicle_number=:vehicle_number";
            
            $query = $con->prepare($sql);   //Prepare the query            
            $query->bindParam(":vehicle_number", $vehicle_number, PDO::PARAM_STR);  //Bind the parameters            
            $query->execute();  //Execute the query            
            $results = $query->fetchAll(PDO::FETCH_OBJ);        //Assign the data which we pulled from the database to a variable.
            
            $cnt = 1;   // For serial number initialization
if ($query->rowCount() > 0) {
    //In case that the query returned at least one record, we can echo the records within a foreach loop
    foreach ($results as $result) { ?>


            <div class="add-form" >
            <div class="container"> 
            
            <h3>Update car</h3><hr>
                <form name="update_record" method="post" id="fileForm" role="form">


                    <div class="form-group">   
                        <label for="title"><span class="req"></span> vehicle number: </label>
                        <input readonly class="form-control" type="text" value="<?php echo htmlentities($result->vehicle_number); ?>" name="vehicle_number" id = "vehicle_number" required />
                    </div><br>
                    <div class="form-group">   
                        <label for="title"><span class="req"></span> model: </label>
                        <input class="form-control" value="<?php echo htmlentities($result->model); ?>" type="text" name="model" id = "model" required />
                    </div><br>

                    <div class="form-group">   
                        <label for="date"><span class="req"></span> capacity: </label>
                        <input class="form-control" value="<?php echo htmlentities($result->seating_capacity); ?>" type="number" min="4" max="15" name="seating_capacity" id = "seating_capacity" required />
                    </div><br>
                    <div class="form-group">   
                        <label for="date"><span class="req"></span> rent in rupee: </label>
                        <input class="form-control" type="number" value="<?php echo htmlentities($result->rent); ?>" name="rent" id = "rent" required />
                    </div><br>
                    <br>
                    
                                                           
                    <div class="form-group">
                        <hr>
                        <input class="btn btn-success" type="submit" name="update" value="Update">
                    </div>
                </form>
            <hr>
        </div>
        
    <?php
    }
}
?>

        </div>
 </div>
<?php include "../components/footer.html"; ?>
</body>
</html>



