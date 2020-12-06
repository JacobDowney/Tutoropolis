<?php

// Database connection
$dbServerName = "localhost";
$dbUsername   = "root";
$dbPassword   = ""; // Default no password
$dbName       = "tutoropolis"; // Name of database

// Connection for database
$conn = mysqli_connect($dbServerName, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
  die('Connection Failed: ' . mysqli_connect_error());
}

?>
