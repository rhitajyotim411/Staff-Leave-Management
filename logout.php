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
    $uid = $_SESSION['UID'];
    try {
        // remove all session variables
        session_unset();

        // destroy the session
        session_destroy();
    } catch (\Throwable $th) {
        echo "$UID cannot be logged out";
    }

    echo "$uid successfully logged out";
    ?>
</body>

</html>