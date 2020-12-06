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

  <h2>Table of tutor info (comes from sql query)</h2>

  <table class="tutor-proposal-table">
    <tr class="tutor-proposal-table-labels">
      <th>Username</th>
      <th>First Name</th>
    </tr>

    <tbody id="tutor-proposal-table-items">
    </tbody>

  </table>

  <script>
    document.getElementById('tt').style.color = "red";
    var testArray = [
      {'username':'jacobdowney', 'firstName':'jacob'}
    ]
    buildTable(testArray)
    // <th>Last Name</th>
    // <th>Subject</th>
    // <th>Description</th>
    // <th>Phone Number</th>
    // <th>Email</th>
    // <th>Session</th>
    function buildTable(data) {
      var table = document.getElementById('tutor-proposal-table-items')
      for (var i = 0; i < data.length; i++) {
        var row = '<tr>
                      <td>${data[i].username}</td>
                      <td>${data[i].firstName}</td>
                  </tr>'
        table.innerHTML += row
      }
    }
  </script>

</body>

</html>
