<?php

// Checks for empty fields
function emptyInputs($fields) {
  $result = false;
  foreach ($element as $fields) {
    if (empty($element)) {
      $return = true;
      break;
    }
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
  $sql = "SELECT * FROM User U WHERE U.username = ?;";
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
    // For sign up this will make next return false.
    return $row;
  } else {
    // This is the result we want for sign up
    $result = false;
    return $result;
  }
  // Close the last statement
  mysqli_stmt_close($statement);
}

// Creates the user with the given information
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

// Gets the user information and then logs in that user and goes to home.php
// with a session started with user info with it.
function loginUser($conn, $username, $password) {
  // usernameExists will return either an error if there is something wrong,
  // false if there is no user with that username (which means we here should
  // say there is an error because we can't log in to no user), or the user data
  // that was selected from the sql database.
  $userExists = usernameExists($conn, $username);
  // Check if user doesn't exist
  if ($userExists === false) {
    header("location: welcome.php?error=wronglogin");
    exit();
  }
  // Associated aray is like a map
  $hashedPassword = $userExists["password"];
  $checkPassword = password_verify($password, $hashedPassword);
  // Check if the two passwords are different
  if ($checkPassword === false) {
    header("location: welcome.php?error=wrongpassword");
    exit();
  } else if ($checkPassword === true) {
    // Now we want to log the user into the website, start a session!
    session_start();
    // Store the user's id and username for the session
    $_SESSION["userID"] = $userExists["userID"];
    $_SESSION["username"] = $userExists["username"];
    // Log the user into the home of their website now that session is started
    header("location: home.php");
    exit();
  }
}

// Gets the subject data for a given subject
function getSubjectID($conn, $subject) {
  $sql = "SELECT * FROM Subject S WHERE S.subject = ?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: tutor.php?error=stmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "s", $subject);
  mysqli_stmt_execute($stmt);
  $resultData = mysqli_stmt_get_result($stmt);
  if ($row = mysqli_fetch_assoc($resultData)) {
    return $row;
  } else {
    $result = false;
    return $result;
  }
  mysqli_stmt_close($stmt);
}

// Creates a tutor proposal in the database and redirects to the tutor.php
// with no error if it worked.
function createTutorProposal($conn, $tutorUserID, $subjectID, $description) {
  $sql = "INSERT INTO
              TutoringProposal (tutorUserID, subjectID, description)
          VALUES
              (?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: tutor.php?error=stmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "iis", $tutorUserID, $subjectID, $description);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  header("location: tutor.php?error=none");
  exit();
}


?>
