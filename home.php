<?php
  // TODO: This should be in an include header.php

  // Start session to get session data
  session_start();
  // Check if user is logged in and if not go to welcome page
  if (!isset($_SESSION["userID"]) || !isset($_SESSION["username"])) {
    header("location: welcome.php");
    exit();
  }
?>

<!DOCTYPE html>

<html>

<head>
  <title>Home Page</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

  <h1>Tutoropolis</h1>

  <div class="menu-button">
    <a href="home.php">Home</a>
  </div>
  <div class="menu-button">
    <a href="tutor.php">Tutors</a>
  </div>
  <div class="menu-button">
    <a href="user.php">User</a>
  </div>
  <div class="menu-button">
    <a href="welcome.php?error=logout">Logout</a>
  </div>

  <div class="hello-message">
    <?php
      echo "<h2>Hello there " . $_SESSION["username"] . "</h2>";
    ?>
  </div>

  <h2>Sessions as Student</h2>
  <table border=1 class=\"student-session-table\">
    <tr class=\"student-session-table-labels\">
      <th>Student</th>
      <th colspan="5">Tutor</th>
      <th colspan="3">Admin</th>
      <th colspan="3">Session</th>
    </tr>
    <tr class=\"student-session-table-labels\">
      <th>Username</th>
      <th>Username</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Phone</th>
      <th>Email</th>
      <th>Username</th>
      <th>Phone</th>
      <th>Email</th>
      <th>Subject</th>
      <th>Description</th>
      <th>Active</th>
    </tr>
  <?php
    // Code for error checking for sessions
    // Code for error checking for sessions
    if (isset($_GET["error"])) {
      if ($_GET["error"] == "stmtfailed") {
        echo "<p>Something went wrong, try again!</p>";
      } else if ($_GET["error"] == "notutorinfo") {
        echo "<p>Failed to get tutor info!</p>";
      } else if ($_GET["error"] == "nosubject") {
        echo "<p>Failed to get subject info!</p>";
      } else if ($_GET["error"] == "notutorproposal") {
        echo "<p>Failed to get tutor proposal!</p>";
      } else if ($_GET["error"] == "noadmin") {
        echo "<p>Failed to get admin info</p>";
      }
    }

    require_once 'db_handler.php';
    require_once 'db_functions.php';

    $allSessionResults = getAllSessionsForUser($conn, $_SESSION['userID']);
    while ($session = mysqli_fetch_assoc($allSessionResults)) {
      $tutorProposal = getTutorProposal($conn, $session['tutorProposalID']);
      if ($tutorProposal === false) {
        header("location: home.php?error=notutorproposal");
        exit();
      }
      $subject = getSubjectInfo($conn, $tutorProposal['subjectID']);
      if ($subject === false) {
        header("location: home.php?error=nosubject");
        exit();
      }
      $tutorInfo = getUserInfo($conn, $tutorProposal['tutorUserID']);
      if ($tutorInfo === false) {
        header("location: home.php?error=notutorinfo");
        exit();
      }
      $admin = getUserInfo($conn, $subject['adminUserID']);
      if ($admin === false) {
        header("location: home.php?error=noadmin");
        exit();
      }

      echo "<tr class=\"tutor-proposal-table-labels\">";
      echo "<td>" . $_SESSION['username'] . "</td>";
      echo "<td>" . $tutorInfo['username'] . "</td>";
      echo "<td>" . $tutorInfo['firstName'] . "</td>";
      echo "<td>" . $tutorInfo['lastName'] . "</td>";
      echo "<td>" . $tutorInfo['phoneNumber'] . "</td>";
      echo "<td>" . $tutorInfo['email'] . "</td>";
      echo "<td>" . $admin['username'] . "</td>";
      echo "<td>" . $admin['phoneNumber'] . "</td>";
      echo "<td>" . $admin['email'] . "</td>";
      echo "<td>" . $subject['subject'] . "</td>";
      echo "<td>" . $tutorProposal['description'] . "</td>";

      $btnName = "active" . $session['sessionID'];
      if (isset($_POST[$btnName])) {
        updateActive($conn, $session['sessionID'], $session['active']);
      }
      $active = "NO";
      if ($session['active']) {
        $active = "YES";
      }
      echo "<td>
              <form method=\"post\">
                <button type=\"submit\" name=\"" . $btnName . "\">" . $active . "</button>
              </form>
            </td>";

      echo "</tr>";
    }
  ?>
  </table>

  <br><br>
  <h2>Sessions as Tutor</h2>
  <table border=1 class=\"student-session-table\">
    <tr class=\"tutor-session-table-labels\">
      <th>Tutor</th>
      <th colspan="5">Student</th>
      <th colspan="3">Admin</th>
      <th colspan="3">Session</th>
    </tr>
    <tr class=\"tutor-session-table-labels\">
      <th>Username</th>
      <th>Username</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Phone</th>
      <th>Email</th>
      <th>Username</th>
      <th>Phone</th>
      <th>Email</th>
      <th>Subject</th>
      <th>Description</th>
      <th>Active</th>
    </tr>
  <?php
    // Code for error checking for sessions
    if (isset($_GET["error"])) {
      if ($_GET["error"] == "lowstmtfailed") {
        echo "<p>Something went wrong, try again!</p>";
      } else if ($_GET["error"] == "lownotutorproposal") {
        echo "<p>Failed to get tutor proposal info!</p>";
      } else if ($_GET["error"] == "lownosubject") {
        echo "<p>Failed to get subject info!</p>";
      } else if ($_GET["error"] == "lownostudentinfo") {
        echo "<p>Failed to get student info!</p>";
      } else if ($_GET["error"] == "lownoadmin") {
        echo "<p>Failed to get admin info</p>";
      }
    }

    require_once 'db_handler.php';
    require_once 'db_functions.php';

    $allSessionResults = getAllSessions($conn);
    while ($session = mysqli_fetch_assoc($allSessionResults)) {
      $tutorProposal = getTutorProposal($conn, $session['tutorProposalID']);
      if ($tutorProposal === false) {
        header("location: home.php?error=lownotutorproposal");
        exit();
      }
      if ($tutorProposal['tutorUserID'] !== $_SESSION['userID']) {
        continue;
      }
      $subject = getSubjectInfo($conn, $tutorProposal['subjectID']);
      if ($subject === false) {
        header("location: home.php?error=lownosubject");
        exit();
      }
      $studentInfo = getUserInfo($conn, $session['studentUserID']);
      if ($studentInfo === false) {
        header("location: home.php?error=lownostudentinfo");
        exit();
      }
      $admin = getUserInfo($conn, $subject['adminUserID']);
      if ($admin === false) {
        header("location: home.php?error=lownoadmin");
        exit();
      }

      echo "<tr class=\"tutor-proposal-table-labels\">";
      echo "<td>" . $_SESSION['username'] . "</td>";
      echo "<td>" . $studentInfo['username'] . "</td>";
      echo "<td>" . $studentInfo['firstName'] . "</td>";
      echo "<td>" . $studentInfo['lastName'] . "</td>";
      echo "<td>" . $studentInfo['phoneNumber'] . "</td>";
      echo "<td>" . $studentInfo['email'] . "</td>";
      echo "<td>" . $admin['username'] . "</td>";
      echo "<td>" . $admin['phoneNumber'] . "</td>";
      echo "<td>" . $admin['email'] . "</td>";
      echo "<td>" . $subject['subject'] . "</td>";
      echo "<td>" . $tutorProposal['description'] . "</td>";

      $btnName = "active" . $session['sessionID'];
      if (isset($_POST[$btnName])) {
        updateActive($conn, $session['sessionID'], $session['active']);
      }
      $active = "NO";
      if ($session['active']) {
        $active = "YES";
      }
      echo "<td>
              <form method=\"post\">
                <button type=\"submit\" name=\"" . $btnName . "\">" . $active . "</button>
              </form>
            </td>";

      echo "</tr>";
    }
  ?>
  </table>

</body>
