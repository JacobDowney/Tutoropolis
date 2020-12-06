<?php

// Check that the user got to the page the proper way
if (isset($_POST["submit"])) {
  $username     = $_POST['username'];
  $password     = $_POST['password'];
  $repassword     = $_POST['repassword'];
  $firstName    = $_POST['firstName'];
  $lastName     = $_POST['lastName'];
  $phoneNumber  = $_POST['phoneNumber'];
  $email        = $_POST['email'];
  $biography    = $_POST['biography'];

  require_once 'db_handler.php'
  require_once 'db_functions.php'

  // Checking for empty inputs
  if (emptyInputSignup($username, $password, $repassword, $firstName, $lastName, $phoneNumber, $email, $biography) !== false) {
    header("location: welcome.php?error=emptyinput");
    exit();
  }
  // Checking for invalid username
  if (emptyUsername($username) !== false) {
    header("location: welcome.php?error=invalidusername");
    exit();
  }
  // Checking for invalid email
  if (emptyUsername($email) !== false) {
    header("location: welcome.php?error=invalidemail");
    exit();
  }
  // Checking if passwords match
  if (passwordMatch($password, $repassword) !== false) {
    header("location: welcome.php?error=passwordsdontmatch");
    exit();
  }
  // Checking if password is strong
  if (strongPassword($password) !== false) {
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



if ($conn->connect_error) {
  die('Connection Failed : '.$conn->connect_error);
} else {
  $stmt = $conn->prepare("INSERT INTO USER(username, password, firstName, lastName, phoneNumber, email, biography)
      values(?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssssss", $username, $password, $firstName, $lastName, $phoneNumber, $email, $biography);
  $stmt->execute();
  echo "Created user successfully";
  $stmt->close();
  $conn->close();
}

?>
