<?php

function emptyInputSignup($username, $password, $repassword, $firstName,
                          $lastName, $phoneNumber, $email, $biography) {
  $result;
  // If any field is empty return true, else false
  if (empty($username) || empty($password) || empty($repassword)
      || empty($firstName) || empty($lastName) || empty($phoneNumber)
      || empty($email) || empty($biography)) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

// Checks to make sure the username has only a-z, A-Z, and 0-9 characters
function invalidUsername($username) {
  $result;
  // If there was an error matching the username, return true
  if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

// Makes sure the email is a proper email
function invalidEmail($email) {
  $result;
  if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

// Makes sure that the passwords match
function passwordMatch($password, $repassword) {
  $result;
  // If they are not equal, there should be an error, true
  if ($password !== $repassword) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

// Checks that the password is longer than 8 characters, to be strong
function strongPassword($password) {
  $result;
  if (strlen($password) < 8) {
    $result = true;
  } else {
    $result = false;
  }
  return $result;
}

// Queries the sql database to see if the username exists
function usernameExists($conn, $username) {
  // Use a prepare statement to protect from sql injection
  $sql = "SELECT * FROM User U WHERE U.userID = ?;";
  // Initialize the sql statement
  $statement = mysqli_stmt_init($conn);
  // Check for mistake in sql statement
  if (!mysqli_stmt_prepare($statement, $sql)) {
    header("location: welcome.php?error=stmtfailed");
    exit();
  }
  // Bound data from user to statment (? fill in)
  mysqli_stmt_bind_param($statement, "s", $username);
  // Execute the command
  mysqli_stmt_execute($statement);
  // Get the results from the sql command
  $resultData = mysqli_stmt_get_result($statement);
  // Check if there is a result from the statement
  if ($row = mysqli_fetch_assoc($resultData)) {
    // This would be used for the login, this would return the user data
    return $row;
  } else {
    // This is the result we want for sign up
    $result = false;
    return $result;
  }
  // Close the last statement
  mysqli_stmt_close($statement);
}

function createUser($conn, $username, $password, $firstName, $lastName,
                    $phoneNumber, $email, $biography) {
  // Use a prepare statement to protect from sql injection
  $sql = "INSERT INTO
              User (username, password, firstName, lastName, phoneNumber, email,
                    biography)
          VALUES
              (?, ?, ?, ?, ?, ?, ?);";
  // Initialize the sql statement
  $statement = mysqli_stmt_init($conn);
  // Check for mistake in sql statement
  if (!mysqli_stmt_prepare($statement, $sql)) {
    header("location: welcome.php?error=stmtfailed");
    exit();
  }
  // Hash the password
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  // Bound data from user to statment (? fill in)
  mysqli_stmt_bind_param($statement, "sssssss", $username, $hashedPassword,
                          $firstName, $lastName, $phoneNumber, $email,
                          $biography);
  // Execute the command
  mysqli_stmt_execute($statement);
  // Close the last statement
  mysqli_stmt_close($statement);
  header("location: welcome.php?error=none");
  exit();
}


?>
