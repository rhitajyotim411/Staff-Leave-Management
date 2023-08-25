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
  die(header("Location: login.php"));
}
if ($_SESSION['type'] != 'staff') {
  die('<h2 style="color: red">Access Denied!!</h2><br>Not a staff');
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
    <br />

    <!--Duration-->
    <label for="from">From: </label>
    <input type="date" name="from" />
    <br />
    <label for="to">To: </label>
    <input type="date" name="to" />
    <br />

    <input type="submit" />
  </form>
</body>

</html>