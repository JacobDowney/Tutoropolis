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
              TutoringProposal (tutorUserID, subjectID, description, active)
          VALUES
              (?, ?, ?, 0);";
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
  return mysqli_stmt_get_result($stmt);
  //return mysqli_fetch_all($resultData, MYSQLI_ASSOC);
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
  $sql = "SELECT * FROM Session s WHERE
            s.studentUserID = ? AND s.tutorProposalID = ?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: tutor.php?error=sessionstmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "ii", $userID, $tutorPropID);
  mysqli_stmt_execute($stmt);
  $resultData = mysqli_stmt_get_result($stmt);
  if ($row = mysqli_fetch_assoc($resultData)) {
    return 1;
  } else {
    return 0;
  }
  mysqli_stmt_close($stmt);
}

function createSession($conn, $studentUserID, $tutorProposalID) {
  $sql = "INSERT INTO
              Session (studentUserID, tutorProposalID)
          VALUES
              (?, ?);";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: tutor.php?error=sessionstmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "ii", $studentUserID, $tutorProposalID);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  header("location: tutor.php?error=nonesession");
  exit();
}

// Updates the user information
function updateUser($conn, $userID, $username, $firstName, $lastName,
                    $phoneNumber, $email, $biography) {
  $sql = "UPDATE User
          SET
              username = ?, firstName = ?, lastName = ?, phoneNumber = ?,
              email = ?, biography = ?
          WHERE
              userID = ?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: user.php?error=stmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "ssssssi", $username, $firstName, $lastName,
                          $phoneNumber, $email, $biography, $userID);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  session_start();
  $_SESSION["username"] = $username;
  header("location: user.php?error=none");
  exit();
}

// Updates the user password
function updatePassword($conn, $userID, $password) {
  $sql = "UPDATE User
          SET
              password = ?
          WHERE
              userID = ?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: user.php?error=passstmtfailed");
    exit();
  }
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  mysqli_stmt_bind_param($stmt, "si", $hashedPassword, $userID);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  header("location: user.php?error=none");
  exit();
}

function getAllSessionsForUser($conn, $userID) {
  $sql = "SELECT * FROM Session s WHERE s.studentUserID = ? ORDER BY s.sessionID ASC;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: home.php?error=stmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "i", $userID);
  mysqli_stmt_execute($stmt);
  return mysqli_stmt_get_result($stmt);
  mysqli_stmt_close($stmt);
}

function getTutorProposal($conn, $tutorProposalID) {
  $sql = "SELECT * FROM TutoringProposal tp WHERE tp.tutoringProposalID = ?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: home.php?error=stmtfailedyo");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "i", $tutorProposalID);
  mysqli_stmt_execute($stmt);
  $resultData = mysqli_stmt_get_result($stmt);
  if ($row = mysqli_fetch_assoc($resultData)) {
    return $row;
  } else {
    return false;
  }
  mysqli_stmt_close($stmt);
}

function updateActive($conn, $tutorProposalID, $active) {
  if ($active === 1) {
    $active = 0;
  } else {
    $active = 1;
  }
  $sql = "UPDATE TutoringProposal
          SET
              active = ?
          WHERE
              tutoringProposalID = ?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: home.php?error=stmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "ii", $active, $tutorProposalID);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  header("location: home.php?error=none");
  exit();
}

function getAllSessions($conn) {
  $sql = "SELECT * FROM Session s ORDER BY s.studentUserID DESC;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: home.php?error=lowstmtfailed");
    exit();
  }
  mysqli_stmt_execute($stmt);
  return mysqli_stmt_get_result($stmt);
  mysqli_stmt_close($stmt);
}

?>
