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
  <style>
  h1   {color: black; height: 100px; line-height: 100px; text-align: center; font-size : 50px; background-color: #007cc7; border: 2px solid black; border-radius: 25px;}
  h2  { font-size : 30px}
  h3 {line-height : 50px; width : 1000px; font-size: 30px;vertical-align : middle; text-align : center; background-color: #007cc7; border : 2px solid black; border-radius: 5px;}
  h4   {color: black; text-align: left; font-size : 50px; margin-top : -10px}
  h5 {font-size : 30px ; background-color: #B0E0E6; border : 2px solid black; border-radius: 5px}
  a {color : black}
  label {font-size : 25px ; margin-right: 10px}
 select{margin-right: 10px}
  
  </style>
</head>

<body style="background-color : #A3BCB6">

  <h1 id='tt'>Tutoropolis</h1>
  <div style="display : flex; flex-direction : row ; margin-top: -61px ">
    <h3 class="menu-button">
      <a href="home.php">Home</a>
    </h3>
    <h3 class="menu-button">
      <a href="tutor.php">Tutors</a>
    </h3>
    <h3 class="menu-button">
      <a href="user.php">User</a>
    </h3>
    <h3 class="menu-button">
      <a href="welcome.php?error=logout">Logout</a>
    </h3>
  </div>

  <div class="hello-message">
    <?php
      echo "<h4>Hello There, " . $_SESSION["username"] . "</h4>";
    ?>
  </div>

  <div class="tutor-proposal-form">
    <h5>Post a tutoring service
    <form action="db_tutorproposal.php" method="post" style="display : flex ; flex-direction: row;">
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
        <input type="text" class="form-control" name="description"style="width : 250px;" />
      </div>
      <button type="submit" name="submit" class="submit-button">Post</button>
    </form>
    </h5>
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

  <h5>Posts from tutors
  <p style="font-size : 15px">Phone number and email will be shown once a session begins</p>
  

  <table border=1 class=\"tutor-proposal-table\">
    <tr class=\"tutor-proposal-table-labels\">
      <th>Username</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Subject</th>
      <th>Description</th>
      <th>Session</th>
    </tr>
    </h5>
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
      $isActive = tutorSessionExists($conn, $_SESSION["userID"], $tutorPropID);
      if (isset($_POST[$btnName])) {
        // If they push the button for this tutorProposal, start session
        if ($_SESSION["userID"] === $userInfo['userID']) {
          header("location: tutor.php?error=idsmatch");
          exit();
        } else if ($isActive === 0) {
          createSession($conn, $_SESSION["userID"], $tutorPropID);
        } else {
          updateSession($conn, $_SESSION["userID"], $tutorPropID);
        }
      }
      if ($isActive === 2) {
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
