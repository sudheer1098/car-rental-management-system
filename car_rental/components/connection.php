<?php
 $servername = "localhost";
 $username = "root";
 $password = "";
/* Attempt to connect to MySQL database */
try{
    $con = new PDO("mysql:host=$servername;dbname=car_rental", $username, $password);
    // Set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>