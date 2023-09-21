<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CSS -->
    <link href="../style/main.css" rel="stylesheet">
</head>

<body>
    <?php require '../inc/header.php' ?>
    <div class="container-fluid text-center" style="height: 100vh;">
        <div class="row justify-content-center mt-5">
            <?php
            if (!isset($_SESSION['UID'])) {
                ?>
                <h5>
                    No user logged in <br>
                    Redirecting...
                </h5>
                <?php
                die(header("refresh:2; URL=../index.php"));
            }

            $uid = $_SESSION['UID'];
            try {
                // remove all session variables
                session_unset();
                // destroy the session
                session_destroy();
            } catch (\Throwable $th) {
                die("<h5>$uid cannot be logged out</h5>");
                // die("<br><a href=\"../{$_SESSION['type']}/dashboard.php\">Dashboard</a>");
            }
            ?>
            <h5>
                <?php echo $uid ?> successfully logged out <br>
                Redirecting to homepage...
            </h5>
            <?php header("refresh:2; URL=../index.php") ?>
        </div>
    </div>
</body>

</html>