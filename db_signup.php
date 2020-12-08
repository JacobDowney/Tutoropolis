<?php

// Check that the user got to the page the proper way
if (isset($_POST["submit"])) {
  $username     = $_POST['username'];
  $password     = $_POST['password'];
  $repassword   = $_POST['repassword'];
  $firstName    = $_POST['firstName'];
  $lastName     = $_POST['lastName'];
  $phoneNumber  = $_POST['phoneNumber'];
  $email        = $_POST['email'];
  $biography    = $_POST['biography'];

  require_once 'db_handler.php';
  require_once 'db_functions.php';

  // Checking for empty inputs
  $arr = array($username, $password, $repassword, $firstName, $lastName, $phoneNumber, $email, $biography);
  if (emptyInputs($arr) !== false) {
    header("location: welcome.php?error=emptyinput");
    exit();
  }
  // Checking for invalid username
  if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("location: welcome.php?error=invalidusername");
    exit();
  }
  // Checking for invalid email
  if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
    header("location: welcome.php?error=invalidemail");
    exit();
  }
  // Checking if passwords match
  if ($password !== $repassword) {
    header("location: welcome.php?error=passwordsdontmatch");
    exit();
  }
  // Checking if password is strong
  if (strlen($password) < 8) {
    header("location: welcome.php?error=passwordweak");
    exit();
  }
  // Checking if the username already exists
  if (usernameExists($conn, $username) !== false) {
    header("location: welcome.php?error=usernametaken");
    exit();
  }

  createUser($conn, $username, $password, $firstName, $lastName, $phoneNumber, $email, $biography);

}
else {
  header("location: welcome.php");
  exit();
}
