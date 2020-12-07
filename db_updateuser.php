<?php

// Check that the user got to the page the proper way
if (isset($_POST["submit"])) {
  // Start session to get session data
  session_start();
  // Check if user is logged in and if not go to welcome page
  if (!isset($_SESSION["userID"]) || !isset($_SESSION["username"])) {
    header("location: welcome.php");
    exit();
  }

  $username     = $_POST['username'];
  $firstName    = $_POST['firstName'];
  $lastName     = $_POST['lastName'];
  $phoneNumber  = $_POST['phoneNumber'];
  $email        = $_POST['email'];
  $biography    = $_POST['biography'];

  require_once 'db_handler.php';
  require_once 'db_functions.php';

  // Checking for empty inputs
  $arr = array($username, $firstName, $lastName, $phoneNumber, $email, $biography);
  if (emptyInputs($arr) !== false) {
    header("location: user.php?error=emptyinput");
    exit();
  }
  // Checking for invalid username
  if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("location: user.php?error=invalidusername");
    exit();
  }
  // Checking for invalid email
  if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
    header("location: user.php?error=invalidemail");
    exit();
  }
  // Checking if the username already exists
  if (usernameExists($conn, $username) !== false) {
    header("location: welcome.php?error=usernametaken");
    exit();
  }

  updateUser($conn, $_SESSION['userID'], $username, $firstName, $lastName, $phoneNumber, $email, $biography);

}
else {
  header("location: user.php");
  exit();
}
