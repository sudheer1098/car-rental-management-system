<?php
session_start();
if (!isset($_SESSION["sess_email"]) || $_SESSION["sess_category"] != "agency") {
    header("location: ../login.php");
}
?>

<?php
// include database connection file
include "../components/connection.php";
if (isset($_POST["add"])) {
    
    $agency_id = $_SESSION["sess_id"];
    
    // values from form, sanitized string usingg fiter_var function
    $vehicle_number = filter_var($_POST["vehicle_number"], FILTER_SANITIZE_STRING);
    $model = filter_var($_POST["model"], FILTER_SANITIZE_STRING);
    $seating_capacity = filter_var($_POST["seating_capacity"], FILTER_SANITIZE_STRING);
    $rent = filter_var($_POST["rent"], FILTER_SANITIZE_STRING);

    try {
        // Query for Insertion into cars table
        $sql = "INSERT INTO cars(vehicle_number,model,seating_capacity,rent,agency_id) VALUES(:vehicle_number,:model,:seating_capacity,:rent,:agency_id)";

        //Prepare Query for Execution
        $query = $con->prepare($sql);
        // Bind the parameters
        $query->bindParam(":vehicle_number", $vehicle_number, PDO::PARAM_STR);
        $query->bindParam(":model", $model, PDO::PARAM_STR);
        $query->bindParam(":seating_capacity",$seating_capacity,PDO::PARAM_STR);
        $query->bindParam(":rent", $rent, PDO::PARAM_STR);
        $query->bindParam(":agency_id", $agency_id, PDO::PARAM_STR);
        // Query Execution
        $query->execute();
        // Message for successfull insertion
        echo "<script>alert('Car details added successfully!!');</script>";
        echo "<script>window.location.href='dashboard_agency.php'</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Something went wrong. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Car</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/dashboard.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel = "icon" href = "../img/favicon.png" type = "image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
</head>
<body>
    

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

    <div class="container"> 
        <div class="add-form" >
            <h3>Add new car details</h3><hr>
                <form action="add_car.php" method="post" id="fileForm" role="form">

                    <div class="form-group">   
                        <label for="title"><span class="req"></span>Vehicle number: </label>
                        <input class="form-control" type="text" name="vehicle_number" id = "vehicle_number" placeholder="e.g. UK07 BH xxxx" required />
                    </div><br>
                    <div class="form-group">   
                        <label for="title"><span class="req"></span>Model: </label>
                        <input class="form-control" type="text" name="model" id = "model" placeholder="e.g. Mahindra Bolero" required />
                    </div><br>

                    <div class="form-group">   
                        <label for="date"><span class="req"></span>Seating capacity: </label>
                        <input class="form-control" type="number" min="4" max="15" name="seating_capacity" id = "seating_capacity" placeholder="4-15" required />
                    </div><br>
                    <div class="form-group">   
                        <label for="date"><span class="req"></span>Rent (per day): </label>
                        <input class="form-control" type="number" name="rent" id = "rent" placeholder="in Rupees" required />
                    </div><br>                    

                    <div class="form-group">
                        <hr>
                        <input class="btn btn-success" type="submit" name="add" value="Add Car">
                    </div>
                </form>
            <hr>
        </div>
    </div> 
</div>
<?php include "../components/footer.html"; ?>
</body>
</html>