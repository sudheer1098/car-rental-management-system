<?php $pagename = 'HOME'; ?>

<?php
require ('components/connection.php');
//to show stats of data in homepage
$customers = $con->query('SELECT COUNT(*) FROM customers')->fetchColumn();
$agency = $con->query('SELECT COUNT(*) FROM agency')->fetchColumn();
$cars = $con->query("SELECT COUNT(*) FROM cars")->fetchColumn();
$con = null;
?>


<!doctype html>
<html lang="en">

<head>
  <?php include 'components/head.html'; ?>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/egg.js/1.0/egg.min.js"></script>
  <title>Home</title>
</head>

<body>
  <?php include ('components/header.php'); ?>
  <div id="main-para" style="padding-left: 7%; padding-right: 7%;">
    <h2><b> Welcome!</b></h2>
    <ul>
      <li>This is a Car Rental Project.</li>      
      <li>You can use cards below to navigate or the navigation bar above.</li>
      <li>To rent a car, register as Customer.</li>
      <li>To add a car, register as Agency</li>
      <li>Click on rent car button to view list of available cars.</li><br>
    </ul>

    <!-- cards for various tasks -->
    <div class="row">
      <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><b>RENT CAR</b></h5>
            <p class="card-text">Rent a car today!!</p>
            <a href="display_cars.php" class="btn btn-primary">Explore</a>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><b>AGENCY REGISTER</b></h5>
            <p class="card-text">To lend cars</p>
            <a href="signup_agency.php" class="btn btn-primary">Signup</a>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><b>CUSTOMER REGISTER</b></h5>
            <p class="card-text">To rent cars</p>
            <a href="signup_customer.php" class="btn btn-primary">Signup</a>
          </div>
        </div>
      </div>
      
    </div>


  </div>


  <!-- boxes describing stats of the data in database -->
  <div class="container-fluid" id="container-stats">
    <div class="row">

      <div class="col stats-box">
        <div>
          <h3>Total Customers</h3>
        </div>
        <div>
          <h3><?php echo $customers ?></h3>
        </div>
      </div>

      <div class="col stats-box">
        <div>
          <h3>Total Agencies</h3>
        </div>
        <div>
          <h3><?php echo $agency ?></h3>
        </div>
      </div>

       <div class="col stats-box">
        <div>
          <h3>Total Cars</h3>
        </div>
        <div>
          <h3><?php echo $cars ?></h3>
        </div>
      </div>
     
    </div>
  </div>


  <?php include ('components/footer.html'); ?>


</body>

</html>