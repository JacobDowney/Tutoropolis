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

// Queries the sql database to see if the username exists
function usernameExists($conn, $username) {
  $sql = "SELECT * FROM User U WHERE U.username = ?;";
  $statement = mysqli_stmt_init($conn); // Initialize statment
  if (!mysqli_stmt_prepare($statement, $sql)) { // Make sure statement is valid
    header("location: welcome.php?error=stmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($statement, "s", $username); // Fill in ?'s'
  mysqli_stmt_execute($statement);
  $resultData = mysqli_stmt_get_result($statement);
  if ($row = mysqli_fetch_assoc($resultData)) {
    // This would be used for the login, this would return the user data
    // For sign up this will make next return false.
    return $row;
  } else {
    // This is the result we want for sign up
    $result = false;
    return $result;
  }
  mysqli_stmt_close($statement);
}

// Creates the user with the given information
function createUser($conn, $username, $password, $firstName, $lastName,
                    $phoneNumber, $email, $biography) {
  $sql = "INSERT INTO
              User (username, password, firstName, lastName, phoneNumber, email,
                    biography)
          VALUES
              (?, ?, ?, ?, ?, ?, ?);";
  $statement = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($statement, $sql)) {
    header("location: welcome.php?error=stmtfailed");
    exit();
  }
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  mysqli_stmt_bind_param($statement, "sssssss", $username, $hashedPassword,
                          $firstName, $lastName, $phoneNumber, $email,
                          $biography);
  mysqli_stmt_execute($statement);
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

// Gets all tutor proposals
function getAllTutorProposals($conn) {
  $sql = "SELECT * FROM TutoringProposal";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: tutor.php?error=sessionstmtfailed");
    exit();
  }
  mysqli_stmt_execute($stmt);
  $resultData = mysqli_stmt_get_result($stmt);
  return mysqli_fetch_all($resultData, MYSQLI_ASSOC);
  mysqli_stmt_close($stmt);
}

function getUserInfo($conn, $userID) {
  $sql = "SELECT * FROM User U WHERE U.userID = ?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: tutor.php?error=sessionstmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "i", $userID);
  mysqli_stmt_execute($stmt);
  $resultData = mysqli_stmt_get_result($stmt);
  if ($row = mysqli_fetch_assoc($resultData)) {
    return $row;
  } else {
    return false;
  }
  mysqli_stmt_close($stmt);
}

function getSubjectInfo($conn, $subjectID) {
  $sql = "SELECT * FROM Subject S WHERE S.subjectID = ?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: tutor.php?error=sessionstmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "i", $subjectID);
  mysqli_stmt_execute($stmt);
  $resultData = mysqli_stmt_get_result($stmt);
  if ($row = mysqli_fetch_assoc($resultData)) {
    return $row;
  } else {
    return false;
  }
  mysqli_stmt_close($stmt);
}

function tutorSessionExists($conn, $userID, $tutorPropID) {
  $sql = "SELECT * FROM TutoringSession ts WHERE
            ts.studentUserID = ? AND ts.tutorProposalID = ? AND ts.active = 1;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: tutor.php?error=sessionstmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "ii", $userID, $tutorPropID);
  mysqli_stmt_execute($stmt);
  $resultData = mysqli_stmt_get_result($stmt);
  if ($row = mysqli_fetch_assoc($resultData)) {
    return true;
  } else {
    return false;
  }
  mysqli_stmt_close($stmt);
}

function createTutorSession($conn, $studentUserID, $tutorProposalID, $active) {
  $sql = "INSERT INTO
              TutoringSession (studentUserID, tutorProposalID, active)
          VALUES
              (?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: tutor.php?error=sessionstmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "iii", $studentUserID, $tutorProposalID, $active);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  header("location: tutor.php?error=nonesession");
  exit();
}

?>
