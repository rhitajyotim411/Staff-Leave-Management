<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CSS -->
    <link href="../style/main.css" rel="stylesheet">
</head>

<?php
if (!isset($_SESSION['UID'])) {
    echo "Please login to continue<br>";
    echo "Redirecting to login page...";
    die(header("refresh:2; URL=./login.php"));
}
if ($_SESSION['type'] != 'staff') {
    echo '<h2 style="color: red">Access Denied!!</h2>';
    echo 'Not a staff, Redirecting to dashboard...';
    die(header("refresh:2; URL=../admin/dashboard.php"));
}
?>

<body>
    <?php require '../inc/header.php' ?>
    <h2>Welcome,
        <?php echo $_SESSION['UID'] ?>
    </h2>

    <h3>Dashboard: - </h3>
    <ul>
        <li>
            <a href="./leave.php">Apply for leave</a>
        </li>
        <li>
            <a href="./record.php">Get leave record</a>
        </li>
        <li>
            <a href="../user/logout.php">Logout</a>
        </li>
    </ul>
</body>

</html>