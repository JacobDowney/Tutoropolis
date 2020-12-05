<?php
  $username     = $_POST['username'];
  $password     = $_POST['password'];
  $firstName    = $_POST['firstName'];
  $lastName     = $_POST['lastName'];
  $phoneNumber  = $_POST['phoneNumber'];
  $email        = $_POST['email'];
  $biography    = $_POST['biography'];

  // Database connection
  $conn = new mysqli('localhost', 'root', '', 'test');
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
