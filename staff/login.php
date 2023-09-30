<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CSS -->
    <link href="../style/main.css" rel="stylesheet">
</head>

<?php
if (isset($_SESSION['UID'])) {
    echo "{$_SESSION['UID']} already logged in<br>";
    echo "Redirecting to dashboard...";
    die(header("refresh:2; URL=../{$_SESSION['type']}/dashboard.php"));
}

$vrf = '';

// If user has given a captcha!
if (isset($_POST['captcha']) && isset($_POST['submit']) && $_POST['captcha'] != '')
    // If the captcha is valid
    if ($_POST['captcha'] == $_SESSION['captcha']) {
        $_SESSION["post"] = $_POST;
        die(header("Location: ./login_db.php"));
    } else {
        $vrf = '<span style="color:red">CAPTCHA FAILED!!!</span>';
    }

$uid = $passwd = "";

if (isset($_POST['uid']))
    $uid = $_POST['uid'];
if (isset($_POST['passwd']))
    $passwd = $_POST['passwd'];
?>

<body>
    <?php require '../inc/header.php' ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <label for="uid">Staff ID: </label>
        <input name="uid" type="text" length="10" maxlength="10" value="<?php echo $uid ?>"><br><br>
        <label for="passwd">Password: </label>
        <input name="passwd" type="password" length="100" maxlength="255" value="<?php echo $passwd ?>"><br><br>
        <img id="captch" src="../inc/captcha.php">&emsp;
        <input type="submit" value="Refresh"><br><br>
        <label for="captcha" name="captcha">Captcha: </label>
        <input type="text" name="captcha" autocomplete="off" />&emsp;
        <?php echo $vrf; ?><br><br>
        <input type="submit" name="submit" value="Verify">
    </form>
</body>

</html>