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
    echo "Please login to continue<br>";
    echo "Redirecting to login page...";
    die(header("refresh:2; URL=./login.php"));
}
if ($_SESSION['type'] != 'admin') {
    echo '<h2 style="color: red">Access Denied!!</h2>';
    echo 'Not an admin, Redirecting to dashboard...';
    die(header("refresh:2; URL=../staff/dashboard.php"));
}
?>

<body>
    <h2>Welcome,
        <?php echo $_SESSION['UID'] ?>
    </h2>

    <h3>Dashboard: - </h3>
    <ul>
        <li>
            <a href='./leave.php'>All staff leaves</a>
        </li>
        <li>
            <a href='./record.php'>All leaves record</a>
        </li>
        <li>
            <a href='./staff.php'>Get a staff leave record</a>
        </li>
        <li>
            <a href="../user/logout.php">Logout</a>
        </li>
    </ul>
</body>

</html>