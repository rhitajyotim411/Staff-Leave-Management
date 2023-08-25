<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>

<?php
if (!isset($_SESSION['UID'])) {
    die(header("Location: login.php"));
}
if ($_SESSION['type'] != 'admin') {
    die('<h2 style="color: red">Access Denied!!</h2><br>Not an admin');
}
?>

<body>
    <a href='./update.php'>Update leave</a>
</body>

</html>