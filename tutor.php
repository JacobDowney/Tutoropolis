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
  <title>Tutor Page</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

  <h1 id='tt'>Tutoropolis</h1>

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

  <div class="tutor-proposal-form">
    <h1>Post a tutoring service</h1>
    <form action="db_tutorproposal.php" method="post">
      <div class="form-group">
        <label for="subject">Subject</label>
        <select name="subject" class="form-control">
          <option value="Computer Science">Computer Science</option>
          <option value="Math">Math</option>
          <option value="Engineering">Engineering</option>
          <option value="Physics">Physics</option>
          <option value="Biology">Biology</option>
          <option value="Chemistry">Chemistry</option>
          <option value="Business">Business</option>
          <option value="Writing">Writing</option>
          <option value="Languages">Languages</option>
          <option value="History">History</option>
          <option value="Art">Art</option>
        </select>
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <input type="text" class="form-control" name="description" />
      </div>
      <button type="submit" name="submit" class="submit-button">Post</button>
    </form>
    <?php
      // Code for error checking
      if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
          echo "<p>Fill in all fields!</p>";
        } else if ($_GET["error"] == "invalidsubject") {
          echo "<p>Invalid subject!</p>";
        } else if ($_GET["error"] == "stmtfailed") {
          echo "<p>Something went wrong, try again!</p>";
        } else if ($_GET["error"] == "none") {
          echo "<p>You have posted a Tutoring Proposal!</p>";
        }
      }
    ?>
  </div>

  <h2>Posts from tutors</h2>
  <p>Phone number and email will be shown once a session begins</p>

  <table border=1 class=\"tutor-proposal-table\">
    <tr class=\"tutor-proposal-table-labels\">
      <th>Username</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Subject</th>
      <th>Description</th>
      <th>Session</th>
    </tr>

  <?php
    // Code for error checking for sessions
    if (isset($_GET["error"])) {
      if ($_GET["error"] == "nonesession") {
        echo "<p>Created the session!</p>";
      } else if ($_GET["error"] == "idsmatch") {
        echo "<p>You can't tutor yourself!</p>";
      } else if ($_GET["error"] == "sessionstmtfailed") {
        echo "<p>Something went wrong, try again!</p>";
      }
    }

    require_once 'db_handler.php';
    require_once 'db_functions.php';

    $allTutoringProposalResults = getAllTutorProposals($conn);
    while ($tutoringProposal = mysqli_fetch_assoc($allTutoringProposalResults)) {
      $userInfo = getUserInfo($conn, $tutoringProposal['tutorUserID']);
      if ($userInfo === false) {
        continue;
      }
      $subjectInfo = getSubjectInfo($conn, $tutoringProposal['subjectID']);
      if ($subjectInfo === false) {
        continue;
      }
      echo "<tr class=\"tutor-proposal-table-labels\">";
      echo "<td>" . $userInfo['username'] . "</td>";
      echo "<td>" . $userInfo['firstName'] . "</td>";
      echo "<td>" . $userInfo['lastName'] . "</td>";
      echo "<td>" . $subjectInfo['subject'] . "</td>";
      echo "<td>" . $tutoringProposal['description'] . "</td>";
      echo "<td>";
      $tutorPropID = $tutoringProposal['tutoringProposalID'];
      $btnName = "tutorProdID" . $tutorPropID;
      if (isset($_POST[$btnName])) {
        // If they push the button for this tutorProposal, start session
        if ($_SESSION["userID"] === $userInfo['userID']) {
          header("location: tutor.php?error=idsmatch");
          exit();
        } else {
          createSession($conn, $_SESSION["userID"], $tutorPropID, 1);
        }
      }
      if (tutorSessionExists($conn, $_SESSION["userID"], $tutorPropID)) {
        echo "Session Active";
      } else {
        echo "<form method=\"post\">
                <button type=\"submit\" name=\"" . $btnName . "\">
                  Start session
                </button>
              </form>";
      }
      echo "</td>";
      echo "</tr>";
    }
  ?>

  </table>

</body>

</html>
