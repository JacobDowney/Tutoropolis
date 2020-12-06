<!DOCTYPE html>

<html>

<head>
  <title>Welcome Page</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

  <h1>Tutoropolis</h1>
  <h2>Helping Tutors & Students Connect</h2>

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
  </div>

</body>

</html>
