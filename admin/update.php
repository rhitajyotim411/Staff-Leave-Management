<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update leave</title>
</head>

<?php
if (!isset($_SESSION['UID'])) {
    echo "Please login to continue<br>";
    echo "Redirecting to login page...";
    die(header("refresh:3; URL=./login.php"));
}
if ($_SESSION['type'] != 'admin') {
    echo '<h2 style="color: red">Access Denied!!</h2>';
    echo 'Not an admin, Redirecting to dashboard...';
    die(header("refresh:3; URL=../staff/dashboard.php"));
}
?>

<body>
    <form>
        <label for="get_usr">Get User: </label>
        <input type="text" name="get_usr">
        <input type="submit">
    </form>
</body>

</html>