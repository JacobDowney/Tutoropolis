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
  <title>User Page</title>
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

  <div class="update-user-info-form">
    <h2>User Profile</h2>
    <?php
      // Code for error checking
      if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
          echo "<p>Fill in all fields!</p>";
        } else if ($_GET["error"] == "invalidusername") {
          echo "<p>Invalid username!</p>";
        } else if ($_GET["error"] == "invalidemail") {
          echo "<p>Invalid email!</p>";
        } else if ($_GET["error"] == "usernametaken") {
          echo "<p>Username taken!</p>";
        } else if ($_GET["error"] == "stmtfailed") {
          echo "<p>Something went wrong, try again!</p>";
        } else if ($_GET["error"] == "none") {
          echo "<p>You have updated your profile!</p>";
        }
      }
      // Require statements for conn and functions
      require_once 'db_handler.php';
      require_once 'db_functions.php';

      $userInfo = getUserInfo($conn, $_SESSION['userID']);
      if ($userInfo === false) {
        echo "<h2>Failed to find user info!</h2>";
      } else {
        echo "<form action=\"db_updateuser.php\" method=\"post\">";
        $properties = array("username" => "Username: ", "firstName" => "First Name: ",
                            "lastName" => "Last Name: ", "phoneNumber" => "Phone Number: ",
                            "email" => "Email Address: ", "biography" => "Biography");
        foreach($properties as $key => $value) {
          echo "<div class=\"form-group\">
                  <label for=\"" . $key . "\">" . $value . "</label>
                  <input type=\"text\" class=\"form-control\" name=\"" . $key . "\" value=\"" . $userInfo[$key] . "\" />
                </div>";
        }
        echo "<button type=\"submit\" name=\"submit\" class=\"submit-button\">Update</button>";
        echo "</form>";
      }
    ?>

    <br><br>

    <h2>Change Password</h2>
    <?php
    // Code for error checking
      if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
          echo "<p>Fill in all fields!</p>";
        } else if ($_GET["error"] == "passwordsdontmatch") {
          echo "<p>Passwords don't match!</p>";
        } else if ($_GET["error"] == "passwordweak") {
          echo "<p>Password must be 8 characters long</p>";
        } else if ($_GET["error"] == "usernametaken") {
          echo "<p>Username taken!</p>";
        } else if ($_GET["error"] == "passstmtfailed") {
          echo "<p>Something went wrong, try again!</p>";
        } else if ($_GET["error"] == "none") {
          echo "<p>You have updated your password!</p>";
        }
      }
    ?>
    <form action="db_updatepassword.php" method="post">
      <div class="form-group">
        <label for="password">Password</label>
        <input type="text" class="form-control" name="password" />
      </div>
      <div class="form-group">
        <label for="repassword">Password Again</label>
        <input type="text" class="form-control" name="repassword" />
      </div>
      <button type="submit" name="submit" class="submit-button">Reset Password</button>
    </form>

  </div>

</body>
