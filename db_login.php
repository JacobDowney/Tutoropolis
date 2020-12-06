<?php


  // Check that the user got to the page the proper way
  if (isset($_POST["submit"])) {
    $username     = $_POST['loginUsername'];
    $password     = $_POST['loginPassword'];

    require_once 'db_handler.php'
    require_once 'db_functions.php'
    
  } else {
    header("location: welcome.php");
  }



  $stmt = $conn->prepare('INSERT INTO User(username, password, firstName, lastName, phoneNumber, email, biography)
      values(?, ?, ?, ?, ?, ?, ?)');
  $stmt->bind_param("sssssss", $username, $password, $firstName, $lastName, $phoneNumber, $email, $biography);
  $stmt->execute();
  echo "Created user successfully";
  $stmt->close();
  $conn->close();

?>
