<?php

// Check that the user got to the page the proper way
if (isset($_POST["submit"])) {
  $username     = $_POST['loginUsername'];
  $password     = $_POST['loginPassword'];

  require_once 'db_handler.php';
  require_once 'db_functions.php';

  // Checking for empty inputs
  $arr = array($username, $password);
  if (emptyInputs($arr) !== false) {
    header("location: welcome.php?error=emptyinput");
    exit();
  }

  loginUser($conn, $username, $password);

} else {
  header("location: welcome.php");
  exit();
}
