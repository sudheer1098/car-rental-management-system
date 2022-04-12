<?php
session_start();
if (
    !isset($_SESSION["sess_email"]) ||
    $_SESSION["sess_category"] != "customers"
) {
    header("location: ../login.php");
}
?>


<?php
// include database connection file
include "../components/connection.php";
$sql =
    "SELECT * from cars WHERE vehicle_number NOT IN (SELECT vehicle_number from rent)";
$query = $con->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
     <!-- Optional JavaScript; choose one of the two! -->
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://getbootstrap.com/dist/js/bootstrap.min.js"></script>
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
        <h1>Car Records Management System</h1>
        <h3 style="color: #1e1f1f;">Project</h3>
    </div><hr>

    <div  class= "home_display">
        <div class="container">
            <div class="container">
            <h1><b> Welcome <?php echo $_SESSION["sess_name"]; ?>!</b></h1>
            <p>To add caar, select the type from the left sidebar and then click Add.</p>
        </div>
            <div class="row">
                <div class="col-md-12">


                    <h3>Available Cars</h3> <hr />
                    <!-- <a href="add_car.php"><button class="btn btn-primary">Add car</button></a> -->
                <div class="table-responsive"><br>               
                <table id="mytable" class="table table-bordred table-striped">                 
                    <thead>
                        <th>#</th>
                        <th>Vehicle Number</th>
                        <th>Model</th>
                        <th>Seating Capacity</th>
                        <th>Per day Rate</th>
                        <th>Action</th>
                    </thead>

                    <tbody>
    
                <?php
                $cnt = 1;

                if ($query->rowCount() > 0) {
                    //In case that the query returned at least one record, we can echo the records within a foreach loop:
                    foreach ($results as $result) { ?>  
                <tr>
                    <td><?php echo htmlentities($cnt); ?></td>
                    <td><?php echo htmlentities(
                        $result->vehicle_number
                    ); ?></td>
                    <td><?php echo htmlentities($result->model); ?></td>
                    <td><?php echo htmlentities(
                        $result->seating_capacity
                    ); ?></td>
                    <td><?php echo "₹ " . htmlentities($result->rent); ?></td>
                    <td style="text-align: center;"><a href="rent_car.php?vehicle_number=<?php echo htmlentities(
                        $result->vehicle_number
                    ); ?>"><button type="button" class="btn btn-success btn-sm">Rent</button></a></td>
                    
                </tr>
                <?php $cnt++;}
                } else {
                    echo "<strong>No results!</strong><div>";
                }
                ?>
                </tbody>     
            </table>
            
            </div> 
            </div>
        </div>
    </div>
</div>
</div>
<?php include "../components/footer.html"; ?>
</body>
</html>
