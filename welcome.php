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
    <form action="signup.php" method="post">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="text" class="form-control" id="password" />
      </div>
      <div class="form-group">
        <label for="firstName">First Name</label>
        <input type="text" class="form-control" id="firstName" />
      </div>
      <div class="form-group">
        <label for="lastName">Last Name</label>
        <input type="text" class="form-control" id="lastName" />
      </div>
      <div class="form-group">
        <label for="phoneNumber">Phone Number</label>
        <input type="text" class="form-control" id="phoneNumber" />
      </div>
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="text" class="form-control" id="email" />
      </div>
      <div class="form-group">
        <label for="biography">Biography</label>
        <input type="text" class="form-control" id="biography" />
      </div>
      <input type="submit" class="submit-button">
    </form>
  </div>

  <div class="login-form">
    <h1>Login</h1>
    <form action="login.php" method="post">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="text" class="form-control" id="password" />
      </div>
      <input type="submit" class="submit-button">
    </form>
  </div>

</body>

</html>
