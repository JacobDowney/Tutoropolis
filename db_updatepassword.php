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

  $password   = $_POST['password'];
  $repassword = $_POST['repassword'];

  require_once 'db_handler.php';
  require_once 'db_functions.php';

  $arr = array($password, $repassword);
  if (emptyInputs($arr) !== false) {
    header("location: user.php?error=emptyinput");
    exit();
  }
  // Checking if passwords match
  if ($password !== $repassword) {
    header("location: user.php?error=passwordsdontmatch");
    exit();
  }
  // Checking if password is strong
  if (strlen($password) < 8) {
    header("location: user.php?error=passwordweak");
    exit();
  }

  updatePassword($conn, $_SESSION["userID"], $password);
}
else {
  header("location: user.php");
  exit();
}
