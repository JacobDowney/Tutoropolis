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

  <div class="tutor-proposal-form">
    <h1>Post a tutoring service</h1>
    <form>
      <div class="form-group">
        <label for="subject">Subject</label>
        <input type="text" class="form-control" id="subject" />
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <input type="text" class="form-control" id="description" />
      </div>
      <input type="submit" class="submit-button"
    </form>
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
