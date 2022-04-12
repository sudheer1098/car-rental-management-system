<?php
require "components/connection.php";

// the code here is for the filter form, the if condition checks whether the user has clicked clear filters button 
if (isset($_POST["clear"])) {
    $sql = "SELECT * from cars WHERE vehicle_number NOT IN (SELECT vehicle_number from rent)";
    $query = $con->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
} 

// the code here is for the filter form, if the user fills filter form then 6 conditions arises, each of them has different SQL query 
elseif (isset($_POST["submit"])) {
    $rent = $_POST["rent"];
    $seating_capacity = $_POST["seating_capacity"];
    if ($seating_capacity == null && $rent == "low") {
        $sql = "SELECT * from cars WHERE rent < 1000 && vehicle_number NOT IN (SELECT vehicle_number from rent)";
        $query = $con->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
    } elseif ($seating_capacity == null && $rent == "high") {
        $sql = "SELECT * from cars WHERE rent > 1000 && vehicle_number NOT IN (SELECT vehicle_number from rent)";
        $query = $con->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
    } elseif ($seating_capacity != null && $rent == "all") {
        $sql = "SELECT * from cars WHERE seating_capacity = :seating_capacity && vehicle_number NOT IN (SELECT vehicle_number from rent)";
        $query = $con->prepare($sql);
        $query->bindParam(
            "seating_capacity",
            $seating_capacity,
            PDO::PARAM_STR
        );
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
    } elseif ($seating_capacity != null && $rent == "low") {
        $sql = "SELECT * from cars WHERE seating_capacity = :seating_capacity && rent<1000 && vehicle_number NOT IN (SELECT vehicle_number from rent)";
        $query = $con->prepare($sql);
        $query->bindParam(
            "seating_capacity",
            $seating_capacity,
            PDO::PARAM_STR
        );
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
    } elseif ($seating_capacity != null && $rent == "high") {
        $sql = "SELECT * from cars WHERE seating_capacity = :seating_capacity && rent>1000 && vehicle_number NOT IN (SELECT vehicle_number from rent)";
        $query = $con->prepare($sql);
        $query->bindParam(
            "seating_capacity",
            $seating_capacity,
            PDO::PARAM_STR
        );
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
    }
    
    //$seating_capacity == null && $rent == "all"
    else {
        $sql = "SELECT * from cars WHERE vehicle_number NOT IN (SELECT vehicle_number from rent)";
        $query = $con->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
    }
} 

//this condition runs when the page loads for the first time without use of filters, the default SQL statemet to print all cars is used here
else {
    $sql = "SELECT * from cars WHERE vehicle_number NOT IN (SELECT vehicle_number from rent)";
    $query = $con->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Available cars</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- css -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/tableDisplay.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
    <!-- favicon link -->
    <link rel = "icon" href = "img/favicon.png" type = "image/x-icon">
  </head>
  <body>
    <!-- navigation bar -->
    <?php include "components/header.php"; ?>

    <!-- Below this is the code for filtering results -->
    <div class="search">
      <form name="display_cars" method="post" id="fileForm" role="form" class="row gy-2 gx-3 align-items-center" required>
        <div class="col-md-4 col-md-offset-2">
          <label class="visually-hidden" for="rent">Preference
          </label>
          <select name="rent" class="form-select" id="rent" required>
            <option value="all">Charges (ALL) 
            </option>
            <option value="low">Upto ₹1000
            </option>
            <option value="high">More than ₹1000
            </option>                                      
          </select>
        </div>
        <div class="col-md-4 col-md-offset-2">
          <input class="form-control" type="number" name="seating_capacity" id="seating_capacity" placeholder="Seating capacity (Leave blank for all)" value=null min="1" max="20">
        </div>  
        <div class="col-md-3 col-md-offset-2">
          <input class="btn btn-success" type="submit" name="submit" value="Search">
          <input class="btn btn-success" type="submit" name="clear" value="Clear">
        </div>
      </form>
    </div>

    <!-- till here is the filter results code -->

    <!-- now below here is the code for table diaplay  -->
    <br>
    <hr>
    <br>
    <div class="container">
      <div  class= "home_display">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h3>
                <b>Available Cars to Rent
                </b>
              </h3> 
              <hr />
              <div class="table-responsive">
                <br>               
                <table id="mytable" class="table table-bordred table-striped">                 
                  <thead>
                    <th>#</th>
                    <th>Vehicle Number</th>
                    <th>Model</th>
                    <th>Seating Capacity</th>
                    <th>Charges(per day)</th>
                    <th>Action</th>
                  </thead>
                  <tbody>
                    <?php
                    $cnt = 1;
                    if ($query->rowCount() > 0) {
                        //In case that the query returned at least one record, we can echo the records within a foreach loop
                        foreach ($results as $result) { ?>  
                    <tr>
                      <td><?php echo htmlentities($cnt); ?></td>
                      <td><?php echo htmlentities($result->vehicle_number); ?></td>
                      <td><?php echo htmlentities($result->model); ?></td>
                      <td><?php echo htmlentities($result->seating_capacity) . " people"; ?></td> 
                      <td><?php echo "₹ " . htmlentities($result->rent); ?></td>
                      <td style="text-align: center;"> 
                        <a href="customers/rent_car.php?vehicle_number=<?php echo htmlentities($result->vehicle_number); ?>">
                          <button type="button" class="btn btn-success btn-sm">Rent</button>
                        </a>
                      </td>
                    </tr>
                    <?php $cnt++;}
                    } else {
                        echo "<strong>No cars available!</strong><div>";
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
    <?php include "components/footer.html"; ?>  
  </body>
</html>
