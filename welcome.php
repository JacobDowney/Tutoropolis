<!DOCTYPE html>

<html>

<head>
  <title>Welcome Page</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <style>
  h1   {color: black; text-align: center; font-size : 50px}
  h2   {color: black; text-align: center; font-size : 30px}
  h3 {line-height : 50px; width : 1000px; font-size: 30px;vertical-align : middle; text-align : center; background-color: #007cc7; border : 2px solid black; border-radius: 5px;}
  label {font-size : 20px;display: inline-block;
    float: left;
    clear: left;
    width: 200px;
    text-align: right; }
  input {text-align : left}
  </style>
</head>

<body style="background-color:#A3BCB6">
  <div style="background-color:#007cc7; border : 2px solid black;

  border-radius: 25px;">
  <h1>Tutoropolis</h1>
  <h2>Helping Tutors & Students Connect</h2>
  </div>
  <?php
    // Code for checking if user logged out
    if (isset($_GET["error"])) {
      if ($_GET["error"] == "logout") {
        // We can't delete session without starting it
        session_start();
        // Delete any session variables we have
        session_unset();
        // Destroy the session.
        session_destroy();
        echo "<h2>You have successfully logged out!</h2>";
      }
    }
  ?>

  
<div style="display : flex; flex-direction : row ;">
  <h3 >Sign up</h3>
  <h3 >Login</h3>
</div>

<div style="display : flex; flex-direction : row">

  <div class="create-user-form" style ="line-height : 50px; width : 1000px; font-size: 30px;vertical-align : middle; text-align : center; background-color: #007cc7; border : 2px solid black; border-radius: 25px; ">
    <form action="db_signup.php" method="post" >
        <div class="form-group" style="margin-bottom : 20px; text-align: center">
          <label for="username" >Username</label>
          <input type="text" class="form-control" name="username" />
        </div>
        <div class="form-group" style="margin-bottom : 20px; text-align: center">
          <label for="password">Password</label>
          <input type="text" class="form-control" name="password" />
        </div>
        <div class="form-group" style="margin-bottom : 20px; text-align: center">
          <label for="repassword">Password Again</label>
          <input type="text" class="form-control" name="repassword" />
        </div>
        <div class="form-group" style="margin-bottom : 20px; text-align: center">
          <label for="firstName">First Name</label>
          <input type="text" class="form-control" name="firstName" />
        </div>
        <div class="form-group" style="margin-bottom : 20px; text-align: center">
          <label for="lastName">Last Name</label>
          <input type="text" class="form-control" name="lastName" />
        </div>
        <div class="form-group" style="margin-bottom : 20px; text-align: center">
          <label for="phoneNumber">Zoom Number</label>
          <input type="text" class="form-control" name="phoneNumber" />
        </div>
        <div class="form-group" style="margin-bottom : 20px; text-align: center">
          <label for="email">Email Address</label>
          <input type="text" class="form-control" name="email" />
        </div>
        <div class="form-group" style="margin-bottom : 20px; text-align: center">
          <label for="biography">Biography</label>
          <input type="text" class="form-control" name="biography" />
        </div>
        <button type="submit" name="submit" class="submit-button">Sign Up</button>
      </form>
      <?php
        // Code for error checking
        if (isset($_GET["error"])) {
          if ($_GET["error"] == "emptyinput") {
            echo "<p>Fill in all fields!</p>";
          } else if ($_GET["error"] == "invalidusername") {
            echo "<p>Choose a proper username!</p>";
          } else if ($_GET["error"] == "invalidemail") {
            echo "<p>Choose a proper email!</p>";
          } else if ($_GET["error"] == "passwordsdontmatch") {
            echo "<p>Passwords don't match!</p>";
          } else if ($_GET["error"] == "passwordweak") {
            echo "<p>Password must be 8 characters long!</p>";
          } else if ($_GET["error"] == "stmtfailed") {
            echo "<p>Something went wrong, try again!</p>";
          } else if ($_GET["error"] == "usernametaken") {
            echo "<p>Username taken, choose another username!</p>";
          } else if ($_GET["error"] == "none") {
            echo "<p>You have signed up! Please Log In!</p>";
          }
        }
      ?>
    </div>

    <!-- LOGIN PART -->


    <div class="login-form" style ="line-height : 50px; width : 1000px; font-size: 30px;vertical-align : middle; text-align : center; background-color: #007cc7; border : 2px solid black; border-radius: 25px; "">
    
      <form action="db_login.php" method="post" >
        <div class="form-group" style="margin-bottom : 20px; text-align: center">
          <label for="username">Username</label>
          <input type="text" class="form-control" name="loginUsername" />
        </div>
        <div class="form-group" style="margin-bottom : 20px; text-align: center">
          <label for="password">Password</label>
          <input type="text" class="form-control" name="loginPassword" />
        </div>
        <button type="submit" name="submit" class="submit-button" style="margin-left : 100px">Log In</button>
      </form>
      <?php
        // Code for error checking
        if (isset($_GET["error"])) {
          if ($_GET["error"] == "emptyinput") {
            echo "<p>Fill in all fields!</p>";
          } else if ($_GET["error"] == "wronglogin") {
            echo "<p>Failed to find user from username!</p>";
          } else if ($_GET["error"] == "wrongpassword") {
            echo "<p>Username and password don't match!</p>";
          }
        }
      ?>
    </div>
  
  </div >
  
    
    
  
      
 

</body>

</html>
