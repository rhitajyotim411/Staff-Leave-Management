<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Leave Application</title>
</head>

<?php
if (!isset($_SESSION['UID'])) {
  echo "Please login to continue<br>";
  echo "Redirecting to login page...";
  die(header("refresh:3; URL=./login.php"));
}
if ($_SESSION['type'] != 'staff') {
  echo '<h2 style="color: red">Access Denied!!</h2>';
  echo 'Not a staff, Redirecting to dashboard...';
  die(header("refresh:3; URL=../admin/dashboard.php"));
}
?>

<body>
  <form action="./leave_db.php" method="post">
    <!--Types of leave-->
    <label for="leave_type">Select type of leave:</label>
    <select name="leave_type">
      <option value="EL">Earned Leave (EL)</option>
      <option value="CL">Casual Leave (CL)</option>
      <option value="SL">Sick Leave (SL)</option>
      <option value="OP">Outdoor duty (OP)</option>
      <option value="LWP">Leave Without Pay (LWP)</option>
    </select>
    <br><br>

    <!--Duration-->
    <label for="from">From: </label>
    <input type="date" name="from" />
    <br><br>
    <label for="to">To: </label>
    <input type="date" name="to" />
    <br><br>

    <input type="submit" />
  </form><br>
  <a href='./dashboard.php'>Dashboard</a>
</body>

</html>