<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
</head>

<body>
  <?php
  if (isset($_SESSION['UID'])) {
    echo "{$_SESSION['UID']} already logged in<br>";
    echo "Redirecting to dashboard...";
    die(header("refresh:3; URL=./{$_SESSION['type']}/dashboard.php"));
  }
  ?>
  <p>Register as: - </p>
  <ul>
    <li>
      <a href="admin/register.php">Admin</a>
    </li>
    <li>
      <a href="staff/register.php">Staff</a>
    </li>
  </ul>

  Already an user? Login <a href="index.php">here</a>.
</body>

</html>