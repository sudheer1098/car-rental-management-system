<!-- <heading block -->
<div class="container-fluid" id="headings">
   <h1 style="font-family: "Lucida Console";"><strong>CARZZ</strong></h1>
   <h3 style="color: #1e1f1f;">Rent a car online</h3>
   <h4>Choose from a range of categories and prices</h4>
</div>


<!-- navigation bar -->

<nav class="navbar navbar-expand-lg navbar-light" style="background: linear-gradient(to right, #c9d6ff, #e2e2e2);">
   <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
               <a class="nav-link active" aria-current="page" href="index.php"><b>HOME</b></a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="display_cars.php">Available Cars</a>
            </li>
            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
               Register
               </a>
               <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="signup_customer.php">as Customer</a></li>
                  <li><a class="dropdown-item" href="signup_agency.php">as Agency</a></li>
               </ul>
            </li>            
         </ul>
         <li class="d-flex">
            <a href="login.php"><button class="btn btn-outline-success me-2" type="submit">LogIn</button></a>
         </li>
      </div>
   </div>
</nav>