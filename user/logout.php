<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
</head>

<body>
    <?php
    if (!isset($_SESSION['UID'])) {
        echo "No user logged in<br>";
        echo "Redirecting...";
        die(header("refresh:2; URL=../index.php"));
    }

    $uid = $_SESSION['UID'];
    try {
        // remove all session variables
        session_unset();
        // destroy the session
        session_destroy();
    } catch (\Throwable $th) {
        echo "$uid cannot be logged out";
        die("<br><a href=\"../{$_SESSION['type']}/dashboard.php\">Dashboard</a>");
    }

    echo "$uid successfully logged out<br>";
    echo "Redirecting to homepage...";
    header("refresh:2; URL=../index.php");
    ?>
</body>

</html>