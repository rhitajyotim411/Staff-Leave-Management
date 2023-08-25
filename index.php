<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Homepage</title>
</head>

<body>
  <?php
  if (isset($_SESSION['UID'])) {
    die("{$_SESSION['UID']} already logged in");
  }
  ?>
  <p>Log in to: - </p>
  <ul>
    <li>
      <a href="admin/login.php">Admin</a>
    </li>
    <li>
      <a href="staff/login.php">Staff</a>
    </li>
  </ul>

  Not a user? Register <a href="register.php">here</a>.
</body>

</html>