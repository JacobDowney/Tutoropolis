<!DOCTYPE html>

<html>

<head>
  <title>Welcome Page</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

  <h1>Tutoropolis</h1>
  <h2>Helping Tutors & Students Connect</h2>

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

  <div class="create-user-form">
    <h1>Sign up</h1>
    <form action="db_signup.php" method="post">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="text" class="form-control" name="password" />
      </div>
      <div class="form-group">
        <label for="repassword">Password Again</label>
        <input type="text" class="form-control" name="repassword" />
      </div>
      <div class="form-group">
        <label for="firstName">First Name</label>
        <input type="text" class="form-control" name="firstName" />
      </div>
      <div class="form-group">
        <label for="lastName">Last Name</label>
        <input type="text" class="form-control" name="lastName" />
      </div>
      <div class="form-group">
        <label for="phoneNumber">Phone Number</label>
        <input type="text" class="form-control" name="phoneNumber" />
      </div>
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="text" class="form-control" name="email" />
      </div>
      <div class="form-group">
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

  <div class="login-form">
    <h1>Login</h1>
    <form action="db_login.php" method="post">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="loginUsername" />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="text" class="form-control" name="loginPassword" />
      </div>
      <button type="submit" name="submit" class="submit-button">Log In</button>
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

</body>

</html>
