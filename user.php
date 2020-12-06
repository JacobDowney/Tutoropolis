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



  <div class="update-user-info-form">
    <h1>My user info (comes from sql query)</h1>
    <form>
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" value="SQL-USNM" />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="text" class="form-control" id="password" value="SQL-PSWD" />
      </div>
      <div class="form-group">
        <label for="firstName">First Name</label>
        <input type="text" class="form-control" id="firstName" value="SQL-FNM" />
      </div>
      <div class="form-group">
        <label for="lastName">Last Name</label>
        <input type="text" class="form-control" id="lastName" value="SQL-LNM" />
      </div>
      <div class="form-group">
        <label for="phoneNumber">Phone Number</label>
        <input type="text" class="form-control" id="phoneNumber" value="SQL-PNM" />
      </div>
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="text" class="form-control" id="email" value="SQL-EML" />
      </div>
      <div class="form-group">
        <label for="biography">Biography</label>
        <input type="text" class="form-control" id="biography" value="SQL-BIO" />
      </div>
      <input type="submit" class="submit-button">
    </form>
  </div>

</body>
