<?php 
session_start();
if(!isset($_SESSION['sess_email']) || $_SESSION['sess_category'] != 'agency') 
{
    header('location: ../login.php');
} 
?>


<?php
// include database connection file
include("../components/connection.php");

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booked Cars</title>
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

    <div  class= "home_display">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <h3>Booked Cars</h3> <hr />
                <div class="table-responsive"><br>              
                <table id="mytable" class="table table-bordred table-striped">                 
                    <thead>
                        <th>#</th>
                        <th>Number</th>
                        <th>Model</th>
                        <th>Seating Capacity</th>
                        <th>Rent</th>
                        <th>Days</th>
                        <th>Start DAte</th>
                        <th>Customer ID</th>
                        <th>Customer name</th>
                    </thead>

                    <tbody>
    
                        <?php 
                            $agency_id=$_SESSION['sess_id'];
                            $sql = "select cars.vehicle_number, cars.model,cars.seating_capacity,cars.rent, rent.days, rent.start_date, customers.customer_id, customers.name from cars INNER JOIN rent on rent.vehicle_number = cars.vehicle_number INNER JOIN customers on rent.customer_id = customers.customer_id WHERE cars.agency_id=:agency_id;";

                            // $sql = "SELECT * from cars where agency_id=:agency_id";
                           
                            $query = $con->prepare($sql);    //Prepare the query:
                            $query->bindParam('agency_id', $agency_id, PDO::PARAM_STR); 
                            
                            $query->execute();  //Execute the query                            
                            $results=$query->fetchAll(PDO::FETCH_OBJ); //Assign the data which we pulled from the database to a variable.  
                           
                            $cnt=1;     // For serial number initialization
                            if($query->rowCount() > 0)
                            {
                            //In case that the query returned at least one record, we can echo the records within a foreach loop:
                            foreach($results as $result)
                            {               
                        ?>  
                    <tr>
                        <td><?php echo htmlentities($cnt);?></td>
                        <td><?php echo htmlentities($result->vehicle_number);?></td>
                        <td><?php echo htmlentities($result->model);?></td>
                        <td><?php echo htmlentities($result->seating_capacity);?></td>
                        <td><?php echo htmlentities($result->rent);?></td>
                        <td><?php echo htmlentities($result->days);?></td>
                        <td><?php echo htmlentities($result->start_date);?></td>
                        <td><?php echo htmlentities($result->customer_id);?></td>
                        <td><?php echo htmlentities($result->name);?></td>
                        
                    </tr>
                <?php 
                // for serial number increment
                $cnt++;
                }} ?>
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
