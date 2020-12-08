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
  <style>
  h1   {color: black; height: 100px; line-height: 100px; text-align: center; font-size : 50px; background-color: #007cc7; border: 2px solid black; border-radius: 25px;}
  h2  { font-size : 30px}
  h3 {line-height : 50px; width : 1000px; font-size: 30px;vertical-align : middle; text-align : center; background-color: #007cc7; border : 2px solid black; border-radius: 5px;}
  h4   {color: black; text-align: left; font-size : 50px; margin-top : -10px}
  h5 {font-size : 20px}
  a {color : black}
 
  
  </style>
</head>

<body style="background-color : #A3BCB6">

<h1>Tutoropolis</h1>

<div style = "display : flex; flex-direction : row ; margin-top: -61px ">
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
  <div style="display : flex; flex-direction : row ; margin-top : -50px ">
    <div class="update-user-info-form" >
      <h2>User Profile</h2>
        <div style="width: 300px;background-color: #B0E0E6; border: 2px solid black; border-radius: 5px">
          <?php
            // Code for error checking
            
            // Require statements for conn and functions
            require_once 'db_handler.php';
            require_once 'db_functions.php';

            $userInfo = getUserInfo($conn, $_SESSION['userID']);
            if ($userInfo === false) {
              echo "<h2>Failed to find user info!</h2>";
            } else {
              echo "<form style=\"font-size: 20px;\" action=\"db_updateuser.php\" method=\"post\">";
              $properties = array("username" => "Username: ", "firstName" => "First Name: ",
                                  "lastName" => "Last Name: ", "phoneNumber" => "Zoom Number: ",
                                  "email" => "Email Address: ", "biography" => "Biography");
              foreach($properties as $key => $value) {
                echo "<div class=\"form-group\" >
                        <label  for=\"" . $key . "\">" . $value . "</label>
                        <input style=\"font-size: 20px\" type=\"text\"  class=\"form-control\" name=\"" . $key . "\" value=\"" . $userInfo[$key] . "\" />
                      </div>";
              }
              echo "<button style=\"margin-top: 10px; height : 30px ;background-color: white\" type=\"submit\" name=\"submit\" class=\"submit-button\">Update</button>";
              echo "</form>";
            }
            if (isset($_GET["error"])) {
              if ($_GET["error"] == "emptyinput") {
                echo "<p style=\"color : #990000\">Fill in all fields!</p>";
              } else if ($_GET["error"] == "invalidusername") {
                echo "<p style=\"color : #990000\">Invalid username!</p>";
              } else if ($_GET["error"] == "invalidemail") {
                echo "<p style=\"color : #990000\">Invalid email!</p>";
              } else if ($_GET["error"] == "usernametaken") {
                echo "<p style=\"color : #990000\">Username taken!</p>";
              } else if ($_GET["error"] == "stmtfailed") {
                echo "<p style=\"color : #990000\">Something went wrong, try again!</p>";
              } else if ($_GET["error"] == "none") {
                echo "<p style=\"color : #33FFCC\">You have updated your profile!</h5>";
              }
            }
          ?>
      </div>
    </div>

    <br style="width : 100px"></br>

    <div class ="change-password" style=" margin-left:auto; margin-right:0;">
      <h2>Change Password</h2>
      <div style="width: 300px;background-color: #B0E0E6; border: 2px solid black; border-radius: 5px">
        
        <form action="db_updatepassword.php" method="post">
          <div class="form-group">
            <label for="password" style="font-size : 20px">Password</label>
            <input type="text" class="form-control" name="password" style="font-size: 20px"/>
          </div>
          <div class="form-group">
            <label for="repassword" style="font-size : 20px">Password Again</label>
            <input type="text" class="form-control" name="repassword" style="font-size: 20px" />
          </div>
          <button style="margin-top: 10px; height : 30px ;background-color: white" type="submit" name="submit" class="submit-button">Reset Password</button>
        </form>
        <?php
        // Code for error checking
          if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyinput") {
              echo "<p style=\"color : #990000\">Fill in all fields!</p>";
            } else if ($_GET["error"] == "passwordsdontmatch") {
              echo "<p style=\"color : #990000\">Passwords don't match!</p>";
            } else if ($_GET["error"] == "passwordweak") {
              echo "<p style=\"color : #990000\">Password must be 8 characters long</p>";
            } else if ($_GET["error"] == "usernametaken") {
              echo "<p style=\"color : #990000\">Username taken!</p>";
            } else if ($_GET["error"] == "passstmtfailed") {
              echo "<p style=\"color : #990000\">Something went wrong, try again!</p>";
            } else if ($_GET["error"] == "none") {
              echo "<p style=\"color : #33FFCC\">You have updated your password!</p>";
            }
          }
        ?>
      </div>
    </div>
  </div>



</body>
