<?php

// Check that the user got to the page the proper way
if (isset($_POST["submit"])) {
  // Start session to get session data
  session_start();
  // Check if user is logged in and if not go to welcome page
  if (!isset($_SESSION["userID"]) || !isset($_SESSION["username"])) {
    header("location: welcome.php");
    exit();
  }

  // Get variables posted from form
  $subject      = $_POST['subject'];
  $description  = $_POST['description'];

  require_once 'db_handler.php';
  require_once 'db_functions.php';

  // Checking for empty inputs
  $arr = array($subject, $description);
  if (emptyInputs($arr) !== false) {
    header("location: tutor.php?error=emptyinput");
    exit();
  }

  // Get subjectID for subject
  $subjectData = getSubjectID($conn, $subject);
  if ($subjectData === false) {
    header("location tutor.php?error=invalidsubject");
    exit();
  }

  createTutorProposal($conn, $_SESSION["userID"], $subjectData['subjectID'], $description);

} else {
  header("location: tutor.php");
  exit();
}
